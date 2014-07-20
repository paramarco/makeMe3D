/*
 * Licensed to the Apache Software Foundation (ASF) under one
 * or more contributor license agreements.  See the NOTICE file
 * distributed with this work for additional information
 * regarding copyright ownership.  The ASF licenses this file
 * to you under the Apache License, Version 2.0 (the
 * "License"); you may not use this file except in compliance
 * with the License.  You may obtain a copy of the License at
 *
 * http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing,
 * software distributed under the License is distributed on an
 * "AS IS" BASIS, WITHOUT WARRANTIES OR CONDITIONS OF ANY
 * KIND, either express or implied.  See the License for the
 * specific language governing permissions and limitations
 * under the License.
 */



function setupVideo(videoName) {
	var v = document.getElementById("video1");
	v.setAttribute("src", videoName);
	v.load();
	setTimeout(function(){	v.play();	},2000);
	
}

String.prototype.fileExists = function() {
    filename = this.trim();

    var response = jQuery.ajax({
        url: filename,
        type: 'HEAD',
        async: false
    }).status;  

    return (response != "200") ? false : true;
};

function reset_language(value)
{
	var language = {  value: ""};

 	switch (value) {
		            case 1 :  
		            	language.value = "Deutsch";
		                break;
		            case 2 :  
		                language.value = "English";
		                break;
		            case 3 :
		            	language.value = "espa\u00f1ol";		                
		                break;
		            case 4 :  
		            	language.value = "fran\u00e7ais";
		                break;
		            case 5 :  
		                language.value = "italiano";
		                break;
		            case 6 :  
		                language.value = "portugu\u00EAs";
		                break;    
		            default :
		                console.log("DEBUG :: Unhandled languge :: ");
		                
		                break;
		        }
	
	set_language(language);	        
	Lungo.Router.section("step1");
	
}

function captureSuccess(mediaFiles) {    
	    
	app.current_mediaFile = mediaFiles[0];      
   	
	if (app.current_mediaFile.size > 56000000) // aprox 2min de grabacion
    {	navigator.notification.alert(GLOBALS.Literals.error_message_capture, null, 'Uh oh!');	}
 	else
 	{ 		
 		budget(); 	 	 	
	 	app.db.transaction(insertDB, errorCB, function() {});
	 	setupVideo(app.current_mediaFile.fullPath);	
	 	Lungo.Router.article("step3","sculpture_setings");
 	}       
}

// Called if something bad happens.
// 
function captureError(error) {
    Lungo.Router.article("step1","tutorial");
}

// A button will call this function
//
function captureVideo() {
	for (var i = 0; i < timeouts.length; i++) {
	    clearTimeout(timeouts[i]);
	}  
	$("video").each(function(){
								$(this).get(0).pause();
								});
    navigator.device.capture.captureVideo(captureSuccess, captureError, {limit: 1 , duration:130});      
}

// Upload files to server
function uploadFile(mediaFile) {
	var ft = new FileTransfer(),
        path = mediaFile.fullPath,
        name = mediaFile.name;        
        
    var options = new FileUploadOptions();
	options.fileKey = "file";
	options.fileName = mediaFile.name;
	options.chunkedMode = false;
	
	var params = {};
	params.ID = encodeURIComponent(app.current_transaction_ID);
	params.NAME = encodeURIComponent(mediaFile.name);
	
	options.params = params;

    ft.upload(path,
        "http://www.instaltic.com/carga.php",
        function(result) {     
        	
            $('#artist_email').html(app.artist_email);
            $('#artist_name').html(app.artist_name);
            $('#artist_fotoPath').attr("src","http://www.instaltic.com/" + app.artist_fotoPath);
            $('#transactionID').html("ref. " + app.current_transaction_ID);
           
			$("#now_file_uploading").hide("slow");
			$("#loading-img").hide("slow"); 
            
            $("#orange-tick").slideDown("slow");
            $("#now_file_uploaded").slideDown("slow");
            $('#website').slideDown("slow");
            $("#now_file_uploaded_thank").slideDown("slow");         
            $("#artist_profile").slideDown("slow");
			
			},
        fail_upload,
        options);
}


function fail_upload(error) {
            alert("Are you connected to Internet?, the system detects no connectivity ");           
            setTimeout(function(){	uploadFile(app.current_mediaFile);		},5000);            
        }

function openArtistWebSite()
{
	var URL = app.artist_link ;
	iabRefArtist = window.open(URL, '_system', 'location=no');
	iabRefArtist.addEventListener('exit', refCloseArtistWebSite);
	
}
function refCloseArtistWebSite (event)	{
	iabRefArtist.removeEventListener('exit', refCloseArtistWebSite);
	iabRefArtist.close();	
	router_to_gallery();
}

function open_pay_pal(){
	
	Lungo.Router.article("step3","checkout");
	
	var size = parseInt($("#sculpture_size").val());
	var material = parseInt($("#sculpture_material").val()); 
	var numberOfCopies = parseInt($("#number_copies").val()); 
	
	var jqxhr = $.post( 
						"http://www.instaltic.com/process.php", 
							{	"size":  			parseInt($("#sculpture_size").val()) ,
								"material":  		parseInt($("#sculpture_material").val()) ,
								"numberOfCopies": 	parseInt($("#number_copies").val()),
								"number_figures": 	parseInt($("#number_figures").val()),
								"language": 		GLOBALS.Literals.locale_paypal 
							}							
		
							, function() { }
							, "text"
					);
							
	jqxhr.done(function(result) {
									console.log("DEBUG  Devuelve de internet: " + decodeURIComponent(result)); 
									
									if (decodeURIComponent(result) != "noArtistAvailable")
									{
										app.token = decodeURIComponent(result);
										var URL = "https://www.sandbox.paypal.com/cgi-bin/webscr?cmd=_express-checkout-mobile&token=" + app.token ;
										iabRef = window.open(URL, '_blank', 'location=no');
										iabRef.addEventListener('loadstop', refLoadMobile_close);
										iabRef.addEventListener('exit', refClose);
										
									}
									else
									{											
										navigator.notification.alert(GLOBALS.Literals.label_noArtistAvailable, null, 'Uh oh!');
										Lungo.Router.back();
									}
								}
				);
	jqxhr.fail(function() {
						navigator.notification.alert("Are you connected to Internet?, the system does not detect connectivity", null, 'Uh oh!');
						Lungo.Router.back();
						});
	jqxhr.always(function() {});		
}			

function refClose (event)	{
    Lungo.Router.article("step2","gallery");        
	iabRef.removeEventListener('loadstop', refLoadMobile_close);																		         
	iabRef.removeEventListener('exit', refClose);	
}

function getParameterByName( name,href )
{
  name = name.replace(/[\[]/,"\\\[").replace(/[\]]/,"\\\]");
  var regexS = "[\\?&]"+name+"=([^&#]*)";
  var regex = new RegExp( regexS );
  var results = regex.exec( href );
  if( results == null )
    return "";
  else
    return decodeURIComponent(results[1].replace(/\+/g, " "));
}

function refLoadMobile_close(event) {
	
	console.log("DEBUG :: caza el evento:: " );
	
    if (event.url.match("mobile/close") !== null) {
    	iabRef.removeEventListener('exit', refClose);
		iabRef.removeEventListener('loadstop', refLoadMobile_close);
		
		app.current_transaction_ID = decodeURI(getParameterByName("transactionID",event.url));
		app.artist_email = decodeURI(getParameterByName("accountPayPal",event.url));
		app.artist_name = decodeURI(getParameterByName("name",event.url));
		app.artist_fotoPath = decodeURI(getParameterByName("fotoPath",event.url));
		app.artist_link = decodeURI(getParameterByName("link",event.url));
		
		console.log("DEBUG :: llega de internet  :: " + app.artist_email);
		
		uploadFile(app.current_mediaFile);		
				
        Lungo.Router.article("step3","uploading");    
                
        iabRef.close();
    }    
    if (event.url.match("cancel_url.php") !== null) {
    	
    	iabRef.removeEventListener('exit', refClose);
		iabRef.removeEventListener('loadstop', refLoadMobile_close);
    	
    	router_to_gallery();
    	navigator.notification.alert("the Payment was cancelled :-(", null, 'Uh oh!');	
    	
    	iabRef.close();
    }
        
}

function update_isPaid()
{  	
    app.db.transaction(query_for_update_isPaid,function(){},function(){});		       
}

function query_for_update_isPaid(tx)
{		
	tx.executeSql('UPDATE MAKE_IT_GALLERY SET isPaid=1 WHERE name="' + app.current_mediaFile.name + '";');
	console.log("DEBUG : query_for_update_isPaid set to 1");              
}

function todoBien()
{
	console.log("DEBUG : todo bien"); 
}
function todoMal(err) {
        alert("Error processing SQL: "+err);
}


function update_isUploaded()
{  	
app.db.transaction(query_for_isUploaded,function(){}, function(){});		       
}

function query_for_isUploaded(tx)
{
	tx.executeSql('UPDATE MAKE_IT_GALLERY SET isUploaded=1 WHERE name="' + app.current_mediaFile.name + '";');             
}

//set up the texts depending on the language
function set_language(language) {

	if ( GLOBALS.AvailableLiterals.hasOwnProperty(language.value) )	  
			{  console.log('DEBUG : setting language: ' + language.value + '\n');	  }
	else 	{
	  		console.log('DEBUG : LANGUAGE NOT FOUND IN DICTIONARY:  ' + language.value +' \n');	  	
	  		console.log('DEBUG : USING DEFAULT LANGUAGE AS ENGLISH\n');
	  		language.value = "English" ;
	  }
		
	GLOBALS.Literals = GLOBALS.AvailableLiterals[language.value].value;
		 
	document.getElementById('step1_label_1').innerHTML=GLOBALS.Literals.step1_label_1;
	document.getElementById('step1_label_3').innerHTML=GLOBALS.Literals.step1_label_3;
	document.getElementById('step1_label_4').innerHTML=GLOBALS.Literals.step1_label_4;
	document.getElementById('step1_label_5').innerHTML=GLOBALS.Literals.step1_label_5;
	document.getElementById('step1_label_6').innerHTML=GLOBALS.Literals.step1_label_6;
	document.getElementById('step1_label_8').innerHTML=GLOBALS.Literals.step1_label_8;
	document.getElementById('step1_label_9').innerHTML=GLOBALS.Literals.step1_label_9;
	document.getElementById('step1_label_10').innerHTML=GLOBALS.Literals.step1_label_10;	
	$('#label_choose_size').html(GLOBALS.Literals.label_choose_size);
	$('#label_sculpture_material').html(GLOBALS.Literals.label_sculpture_material);
	$('#sculpture_material_1').html(GLOBALS.Literals.sculpture_material_1);
	$('#sculpture_material_2').html(GLOBALS.Literals.sculpture_material_2);
	$('#sculpture_material_3').html(GLOBALS.Literals.sculpture_material_3);
	$('#price_label').html(GLOBALS.Literals.price_label);
	$('#label_number_copies').html(GLOBALS.Literals.label_number_copies);
	$('#label_Resume_Options').html(GLOBALS.Literals.label_Resume_Options);
	$('#label_About_Make_it').html(GLOBALS.Literals.label_About_Make_it);
	$('#label_Close_application').html(GLOBALS.Literals.label_Close_application);
	$('#menu_about').html(GLOBALS.Literals.menu_about);
	$('#menu_sculpture_settings').html( GLOBALS.Literals.menu_sculpture_settings);
	$('#menu_gallery').html(GLOBALS.Literals.menu_gallery);	
	$('#label_change_language').html(GLOBALS.Literals.label_change_language);
	$('#menu_change_language').html(GLOBALS.Literals.label_change_language);	
	$('#label_choose_Settings').html(GLOBALS.Literals.label_choose_Settings);
	$('#label_Sculpture_Settings').html(GLOBALS.Literals.label_Sculpture_Settings); 	
	$('#boton_paypal').attr("src", GLOBALS.Literals.paypal_button);	
	$('#label_accept_terms').html(GLOBALS.Literals.label_accept_terms); 		
	$('#now_conecting_Paypal').html(GLOBALS.Literals.now_conecting_Paypal);
	$('#now_file_uploading').html(GLOBALS.Literals.now_file_uploading);	
	$('#now_file_uploaded').html(GLOBALS.Literals.now_file_uploaded);
	$('#now_file_uploaded_thank_text').html(GLOBALS.Literals.now_file_uploaded_thank_text );	
	$('#label_noArtistAvailable').html(GLOBALS.Literals.label_noArtistAvailable);	
   	$('#label_your_artist').html(GLOBALS.Literals.label_your_artist);
	$('#label_your_artist').html(GLOBALS.Literals.label_your_artist); 
	$('#website').html(GLOBALS.Literals.artist_website);	
	document.getElementById('tutorial_1').innerHTML=GLOBALS.Literals.tutorial_1;
	document.getElementById('tutorial_2').innerHTML=GLOBALS.Literals.tutorial_2;
	document.getElementById('tutorial_3').innerHTML=GLOBALS.Literals.tutorial_3;
	document.getElementById('tutorial_4').innerHTML=GLOBALS.Literals.tutorial_4;
	document.getElementById('tutorial_5').innerHTML=GLOBALS.Literals.tutorial_5;
	document.getElementById('tutorial_6').innerHTML=GLOBALS.Literals.tutorial_6;
	document.getElementById('tutorial_7').innerHTML=GLOBALS.Literals.tutorial_7;	
	document.getElementById('label_number_figures').innerHTML=GLOBALS.Literals.label_number_figures;
	document.getElementById('label_option_number_figures_1_or_2').innerHTML=GLOBALS.Literals.label_option_number_figures_1_or_2;
	document.getElementById('label_option_number_figures_group').innerHTML=GLOBALS.Literals.label_option_number_figures_group;	
	
}

// Populate the database 
//
function createDB(tx) {    
    tx.executeSql('CREATE TABLE IF NOT EXISTS "MAKE_IT_GALLERY" ("id" INTEGER PRIMARY KEY  AUTOINCREMENT  NOT NULL  UNIQUE,"fullPath", "name", "date")');
}

// Populate the database     
function insertDB(tx) {
     tx.executeSql(
         	'INSERT INTO MAKE_IT_GALLERY (fullPath, name, date ) VALUES ("' 
         	+ app.current_mediaFile.fullPath + '","' +  app.current_mediaFile.name + '","' +  app.get_current_time() + '")' );
}
// Query the database
//
function queryDB(tx) {
    tx.executeSql('SELECT * FROM MAKE_IT_GALLERY', [], querySuccess, errorCB);
}

// Query the success callback
//
function querySuccess(tx, results) {
    var len = results.rows.length;
    var listOfFiles = new Array();  

 	for  (var i=0; i<len; i++)
    {		
    	var file = new Object();
		file.id = results.rows.item(i).id ;
		file.fullPath = results.rows.item(i).fullPath;
		file.date = results.rows.item(i).date;
		listOfFiles.push(file);	
   	} 
   	    
	if (listOfFiles.length > 0 )  
		document.getElementById('list_gallery').innerHTML ='<li class="dark">	<strong >' + GLOBALS.Literals.label_gallery + '</strong>';
	else
		document.getElementById('list_gallery').innerHTML ='<li class="dark">	<strong >' +  GLOBALS.Literals.label_gallery_empty + '</strong>';	
 
    for (var i=0; i<listOfFiles.length; i++){
		
		var newFriend = document.createElement('li');
		newFriend.id = 'friend' + i;			
		newFriend.setAttribute('class','thumb selectable arrow');
		newFriend.setAttribute('onclick','router_to_sculpture_settings(' + listOfFiles[i].id + ');');

		 
		var newFriend_img = document.createElement('img');
		newFriend_img.id = 'friend_img' + i;
		newFriend_img.src = "img/play.png";
	
		var newFriend_small = document.createElement('small');
		newFriend_small.id = 'friend_small' + i;
		newFriend_small.innerHTML = listOfFiles[i].date;
		
		var newFriend_strong = document.createElement('strong');
		newFriend_strong.id = 'friend_strong' + i;
		newFriend_strong.innerHTML = GLOBALS.Literals.recorded_on ;
		
		
		document.getElementById('list_gallery').appendChild(newFriend);
		document.getElementById(newFriend.id).appendChild(newFriend_img);
    	document.getElementById(newFriend.id).appendChild(newFriend_strong);
		document.getElementById(newFriend.id).appendChild(newFriend_small);
    	
    }
    
    Lungo.Router.article("step2","gallery"); 
    
}

function router_to_gallery()
{
	app.db.transaction(queryDB, errorCB , function(){});
    $("video").each(function(){
							$(this).get(0).pause();
							});
	Lungo.Router.article("step2","gallery");		
}


function router_to_sculpture_settings (id)
{  	
	app.current_selected_object_id = id;
	budget();
    app.db.transaction(query_for_retreive, errorCBIn_router_to_sculpture_settings,function() {} );		       
}
function errorCBIn_router_to_sculpture_settings()
{
	console.log("DEBUG:  dentro de errorCBIn_router_to_sculpture_settings:  ");
}

function query_for_retreive(tx)
{
	tx.executeSql('SELECT * FROM MAKE_IT_GALLERY WHERE id=' + app.current_selected_object_id, [], go_to_sculpture_settings, errorCB);             
}
function go_to_sculpture_settings (tx,results)
{   	
	app.current_mediaFile = { name : results.rows.item(0).name , fullPath : results.rows.item(0).fullPath }; 
	Lungo.Router.article("step3","sculpture_setings");
	budget();
	setupVideo(app.current_mediaFile.fullPath) ;

}

// Transaction error callback
//
function errorCB(err) {
    console.log("DEBUG: Error processing SQL: " + err.code);
}
  
// Transaction success callback
//
function successCB() {
    //var db = window.openDatabase("Make_it_Database", "1.0", "Make_it_Database", 200000);
    app.db.transaction(queryDB, errorCB, function(){});
}

// exit    
function exitFromApp(buttonIndex) {	if (buttonIndex==2){  navigator.app.exitApp();	}}
// exit  		
function tap_on_exit(){
	navigator.notification.confirm(
								    GLOBALS.Literals.label_want_to_exit,  // message
								    exitFromApp,              // callback to invoke with index of button pressed
								    GLOBALS.Literals.label_exit,            // title
								    GLOBALS.Literals.label_Cancel_Ok         // buttonLabels
								    );
}



// 
function onMaterialChange() {
		
	var material = parseInt($("#sculpture_material").val());
	
	var option = document.getElementById('sculpture_size_value_1st');
	document.getElementById('sculpture_size').removeChild(option);
	var option2 = document.getElementById('sculpture_size_value_2nd');
	document.getElementById('sculpture_size').removeChild(option2);
	var option3 = document.getElementById('sculpture_size_value_3rd');
	document.getElementById('sculpture_size').removeChild(option3);
	
	var sculpture_size_value_1st = document.createElement('option');
	var sculpture_size_value_2nd = document.createElement('option');
	var sculpture_size_value_3rd = document.createElement('option');
	
	
	switch(material) {
                    case 1 :  // hyper realistic
		            	sculpture_size_value_1st.id = 'sculpture_size_value_1st';
						sculpture_size_value_1st.innerHTML = "7x7x7 cm3";
						sculpture_size_value_1st.setAttribute('value','7');
						sculpture_size_value_2nd.id = 'sculpture_size_value_2nd';
						sculpture_size_value_2nd.innerHTML = "11x11x11 cm3";
						sculpture_size_value_2nd.setAttribute('value','11');
						sculpture_size_value_3rd.id = 'sculpture_size_value_3rd';
						sculpture_size_value_3rd.innerHTML = "15x15x15 cm3" ;
						sculpture_size_value_3rd.setAttribute('value','15'); 
		                break;
		            case 2 :  //  artistic wood
		                sculpture_size_value_1st.id = 'sculpture_size_value_1st';
						sculpture_size_value_1st.innerHTML = "20x20x20 cm3";
						sculpture_size_value_1st.setAttribute('value','20');
						sculpture_size_value_2nd.id = 'sculpture_size_value_2nd';
						sculpture_size_value_2nd.innerHTML = "30x30x30 cm3";
						sculpture_size_value_2nd.setAttribute('value','30');
						sculpture_size_value_3rd.id = 'sculpture_size_value_3rd';
						sculpture_size_value_3rd.innerHTML = "40x40x40 cm3" ;
						sculpture_size_value_3rd.setAttribute('value','40'); 		                
		                break;
		            case 3 :   //  clay
		                sculpture_size_value_1st.id = 'sculpture_size_value_1st';
						sculpture_size_value_1st.innerHTML = "7x7x7 cm3";
						sculpture_size_value_1st.setAttribute('value','7');
						sculpture_size_value_2nd.id = 'sculpture_size_value_2nd';
						sculpture_size_value_2nd.innerHTML = "11x11x11 cm3";
						sculpture_size_value_2nd.setAttribute('value','11');
						sculpture_size_value_3rd.id = 'sculpture_size_value_3rd';
						sculpture_size_value_3rd.innerHTML = "15x15x15 cm3" ;
						sculpture_size_value_3rd.setAttribute('value','15'); 
		                break;
		            default :
		                console.log("DEBUG :: Unhandled election... :: ");		                
		                break;
	}
	
	document.getElementById("sculpture_size").appendChild(sculpture_size_value_1st);
	document.getElementById("sculpture_size").appendChild(sculpture_size_value_2nd);
	document.getElementById("sculpture_size").appendChild(sculpture_size_value_3rd);
	
	budget();
}

// 
function budget() {	
	var price;
	var size = parseInt($("#sculpture_size").val());
	var material = parseInt($("#sculpture_material").val()); 
	var numberOfCopies = parseInt($("#number_copies").val()); 
	var numberOfFigures = parseInt($("#number_figures").val());
	

    switch(material) {
        case 1 :  // hyper realistic
        	switch(size) {
    			case 7 :
	            	if (numberOfFigures == 1) {	price = 380; }		          		 	
	          		else  { price = 400; }  
	                price = price * (0.8 * (numberOfCopies - 1) + 1);  
                	break;
                case 11 :
	            	if (numberOfFigures == 1) {	price = 400; }		          		 	
	          		else  { price = 420; }  
	                price = price * (0.8 * (numberOfCopies - 1) + 1);  
                	break;
                case 15 :
	            	if (numberOfFigures == 1) {	price = 430; }		          		 	
	          		else  { price = 450; }  
	                price = price * (0.8 * (numberOfCopies - 1) + 1);  
                	break;
                default :
            		console.log("DEBUG :: Unhandled budget :: ");
            		break;
            	}
        	break;		                	
        case 2 :  //  artistic wood
        	switch(size) {
        		case 20 :
	            	if (numberOfFigures == 1) {	price = 490; }		          		 	
	          		else  { price = 590; }  
	                price = price * (0.8 * (numberOfCopies - 1) + 1);  
                	break;
                case 30 :
	            	if (numberOfFigures == 1) {	price = 594; }		          		 	
	          		else  { price = 694; }  
	                price = price * (0.8 * (numberOfCopies - 1) + 1);  
                	break;
                case 40 :
	            	if (numberOfFigures == 1) {	price = 700; }		          		 	
	          		else  { price = 800; }  
	                price = price * (0.8 * (numberOfCopies - 1) + 1);  
                	break;
                default :
            		console.log("DEBUG :: Unhandled budget :: ");
            		break;
        		}
            break;
        case 3 :   //  artistic ceramik
            switch(size) {
        		case 7 :
	            	if (numberOfFigures == 1) {	price = 230; }		          		 	
	          		else  { price = 260; }  
	                price = price * (0.8 * (numberOfCopies - 1) + 1);  
                	break;
                case 11 :
	            	if (numberOfFigures == 1) {	price = 270; }		          		 	
	          		else  { price = 280; }  
	                price = price * (0.8 * (numberOfCopies - 1) + 1);  
                	break;
                case 15 :
	            	if (numberOfFigures == 1) {	price = 280; }		          		 	
	          		else  { price = 300; }  
	                price = price * (0.8 * (numberOfCopies - 1) + 1);  
                	break;
                default :
            		console.log("DEBUG :: Unhandled budget :: ");
            		break;
        		}
            break;
        default :
            console.log("DEBUG :: Unhandled budget :: ");		                
            break;
    }
                
     
        
        $('#price_amount').html(Math.floor(price) + "\u20AC");
        	
}


function setup_database() {	
	app.db = window.openDatabase("Make_it_Database", "1.0", "Make_it_Database", 200000);
	app.db.transaction(createDB, errorCB, function(){});
}

//Global Variables

 var iabRef = null;	
 var iabRefArtist= null;	
 

var app = {
    // Application Constructor
    initialize: function() {
        this.bindEvents();
    },
    
    // Application attributes    
    current_mediaFile: function() {},
    
    current_time: function() {},
    
    current_service_token: function() {},
    
    current_transaction_ID : function() {},
    
    token : function() {},
    
    artist_name : function() {},
    artist_email: function() {},
    artist_fotoPath: function() {},
    
    artist_link: function() {},
    
	current_mediaFile_is_payed : function() {},
	current_mediaFile_is_uploaded : function() {},

    db : function(){},    
    
    get_current_time:  function() {
    	navigator.globalization.dateToString(
        new Date(),
        function (date) {	app.current_time = date.value;  	},
        function () 	{	console.log('DEBUG : Error getting dateString\n'); },
         {formatLength:'short', selector:'date and time'}
      );
     return app.current_time;	
    }    , 
       
    current_selected_object_id :  function() {},
    
    // Bind Event Listeners
    bindEvents: function() {
        document.addEventListener('deviceready', this.onDeviceReady, false);
    
        //document.addEventListener('backbutton', tap_on_exit, false);
        document.addEventListener('menubutton', function(){Lungo.View.Aside.toggle("#features");} , false);
        document.addEventListener('searchbutton', function(){}, false);
        document.addEventListener('startcallbutton', tap_on_exit, false);
        document.addEventListener('endcallbutton', tap_on_exit, false);
        //document.addEventListener("pause", tap_on_exit, false);
        
        document.addEventListener('backbutton', function(){ 	Lungo.View.Aside.hide("#features"); }, false);
    },
    
    // deviceready Event Handler 
    onDeviceReady: function() {
        app.receivedEvent();
    },
    // Update DOM on a Received Event
    receivedEvent: function() {
       // Now safe to use the Cordova API
		try{
			//get the language of the Device			
			navigator.globalization.getPreferredLanguage(
				set_language , 
				function () {}
			);
			
			//setup database
			setup_database();		

			//launch HMI				 
			Lungo.Router.section("main"); 
				   			
			setTimeout(function() { 
					Lungo.Router.section("step1");
					run_text_Of_tutorial();		
					run_video_Of_tutorial();				
				}, 5000);
						
	     }
	     catch(err)
	     {
	     	console.log("DEBUG: cazó el error dentro de receivedEvent:  " + err.message + '\n');
	     }	
    }    
};