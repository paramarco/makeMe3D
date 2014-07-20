<?php

define('INCLUDE_CHECK',true);

require 'connect.php';
require 'functions.php';

session_name('tzLogin');
session_set_cookie_params(200*7*24*60*60);
session_start();
?>

<?php

if (isset($_POST['submit']) && $_POST['submit'] == "modifyProfile")
{
	$err_resitered = array();
	$count_checks = 0;
	
	if(strlen($_POST['name'])<4 || strlen($_POST['name'])>60)
		{	$err_resitered[]='Your username must be between 3 and 60 characters!';}		
	else 
		{	$_SESSION['name'] = $_POST['name'];		}
	
	if(!preg_match('/^\d+$/', $_POST['telephone']))
		{		$err_resitered[]='Your telephone must contain only numbers, without blank spaces or any other character !';		}
	else 
		{		$_SESSION['telephone'] = $_POST['telephone'];	}
	
	if(!checkEmail($_POST['accountPayPal']))
		{	$err_resitered[]='Your email-accountPayPal is not valid!';	}
	else
		{$_SESSION['accountPayPal'] = $_POST['accountPayPal'];}

	if(strlen($_POST['website'])<4 || strlen($_POST['website'])>260)
		{	$err_resitered[]='Your website address must have between 3 and 200 characters!';}		
	else 
		{	$_SESSION['website'] = $_POST['website'];		}

	if (isset($_POST['workWith3D']) && $_POST['workWith3D'] == TRUE) 
		{	$_SESSION['workWith3D'] = 1 ; $count_checks = $count_checks + 1;}
	else 
		{	$_SESSION['workWith3D'] = 0 ; }
		
	if (isset($_POST['workWithCeramics']) && $_POST['workWithCeramics'] == TRUE) 
		{	$_SESSION['workWithCeramics'] = 1 ; $count_checks = $count_checks + 1;}
	else 
		{	$_SESSION['workWithCeramics'] = 0 ; }
		
	if (isset($_POST['workWithWood']) && $_POST['workWithWood'] == TRUE) 
		{	$_SESSION['workWithWood'] = 1 ; $count_checks = $count_checks + 1;}
	else 
		{	$_SESSION['workWithWood'] = 0 ; }  
	
	if($count_checks  == 0)	{	$err_resitered[]='You must choose at least one working style';	}

	if ($_FILES["file"]["error"] > 0 || !isset($_FILES["file"]["name"]) || $_FILES["file"]["name"] == "" || $_FILES["file"]["name"] == null)
	{	 $err_resitered[]='You must upload your image';		}
	else
	{  move_uploaded_file($_FILES["file"]["tmp_name"],  "artists/" . $_FILES["file"]["name"]);	  $_SESSION['fotoPath']="artists/" . $_FILES["file"]["name"] ;	}


	
	if(!count($err_resitered))
	{
	
		mysql_query(" UPDATE tz_members SET name="."'".$_SESSION['name']."'".
										", telephone=".$_SESSION['telephone'].
										", accountPayPal="."'".$_SESSION['accountPayPal']."'".
										", workWith3D=".$_SESSION['workWith3D'].
										", workWithCeramics=".$_SESSION['workWithCeramics'].
										", workWithWood=".$_SESSION['workWithWood'].
										", fotoPath='".mysql_real_escape_string($_SESSION['fotoPath'])."'".
										", website='".mysql_real_escape_string($_SESSION['website'])."'".
																				
										" WHERE id='".$_SESSION['id']."'");

		$_SESSION['msg_resigistered_ok'] ='your Profile has been successfully modified!';
		
	}	
	
	if(count($err_resitered))	{	$_SESSION['msg_resigistered'] = implode('<br />',$err_resitered);	}	
	
}

if (isset($_POST['submit']) && $_POST['submit'] == "modifyAvailability")
{
	$timestamp =  strtotime($_POST['from']);	
	$_SESSION['from'] = date('Y-m-d', $timestamp);		
	
	$timestamp_2 =  strtotime($_POST['to']);	
	$_SESSION['to'] = date('Y-m-d', $timestamp_2);
	
	mysql_query("	INSERT INTO availability ( idMember , initDay, lastDay )
						VALUES( {$_SESSION['id']},	'{$_SESSION['from']}' , '{$_SESSION['to']}' )
				");
					
}

if (isset($_POST['submit']) && $_POST['submit'] == "removeSkedule")
{
	
	$timestamp =  strtotime($_POST['from']);
	$delete_from = date('Y-m-d', $timestamp);	
	
	$timestamp_2 =  strtotime($_POST['to']);	
	$delete_to= date('Y-m-d', $timestamp_2);	
		
	mysql_query("	DELETE FROM availability 
					WHERE idMember = {$_SESSION['id']} AND initDay = '{$delete_from}' AND lastDay = '{$delete_to}' 
				");
					
}




?>


<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="viewport" content="width=device-width, initial-scale=1">

<title>Registered Artist </title>
    
	<link rel="stylesheet" type="text/css" href="demo.css" media="screen" />    
	<link rel="stylesheet" href="http://code.jquery.com/ui/1.10.3/themes/smoothness/jquery-ui.css" />
	
	<script src="http://code.jquery.com/jquery-1.9.1.js"></script>
	<script src="http://code.jquery.com/ui/1.10.3/jquery-ui.js"></script>	
	<script src="login_panel/js/slide.js" type="text/javascript"></script>
	<script src="ajaxupload.3.6.js" type="text/javascript"></script>
	
	
	<link rel="stylesheet" href="http://yui.yahooapis.com/pure/0.3.0/pure-min.css">	
	<link rel="stylesheet" href="http://yui.yahooapis.com/pure/0.3.0/forms-min.css">
	<link rel="stylesheet" href="http://purecss.io/combo/1.6.5?/css/layouts/blog.css">
		<link rel="stylesheet" href="http://yui.yahooapis.com/pure/0.3.0/buttons-min.css">

	
	
	<script type="text/javascript">
	  $(function() {
	    $( "#from" ).datepicker({
								defaultDate: "+1w",
								changeMonth: true,
								numberOfMonths: 2,
								showOn: "button",
								buttonImage: "login_panel/images/calendar.gif",
								buttonImageOnly: true,
								//dateFormat: "DD, d MM, yy",
								dateFormat: "yy-mm-dd",
								altField: ".date_alternate",
       							altFormat: "yy-mm-dd",
								onClose: function( selectedDate ) {	$( "#to" ).datepicker( "option", "minDate", selectedDate );	}	
      							});
	    $( "#to" ).datepicker({
								defaultDate: "+1w",
								changeMonth: true,
								numberOfMonths: 2,
								showOn: "button",
								buttonImage: "login_panel/images/calendar.gif",
								buttonImageOnly: true,
								//dateFormat: "DD, d MM, yy",
								dateFormat: "yy-mm-dd",
								altField: ".date_alternate",
       							altFormat: "yy-mm-dd",
								onClose: function( selectedDate ) {	$( "#from" ).datepicker( "option", "maxDate", selectedDate ); }
	    					});
	   
	    
	    $( "#datepicker_1" ).datepicker({ minDate: "+1m", maxDate: "+4m +1w" });
	    
	    $( "#datepicker_2" ).datepicker({numberOfMonths: 3, minDate: "+1m", maxDate: "+1m +1w" });
	    
	    $("#edit_profile").click(function(){
				//prompt "checking your schedule....."
				//get values from $( "#from" ).datepicker and $( "#to" ).datepicker
				//HTTP POST to checkavailability.php
				//if request OK then  get the number of divs inside "div_availability" and appendChild with the from/to datepicker, prompt "your schedule has been updated....."
				//else prompt "please choose another dates, the skedule you are proposing overlaps one of your periods of availability....."
				
					});
						    		
	  });
	  
  function removeAvailability(idOfDatePicker)
  {
  		//prompt "removing....."
		//get values from $( idOfDatePicker).datepicker 
		//HTTP POST to removeavailability.php idMember,initDay,lastDay,
		//if request is OK then remove "p_+'idOfDatePicker'" from DOM, prompt "succesfully removed....."
		//else prompt "there was an system error trying to remove the skedule, try it later please"
  				  	
  }
  
	function thereIsaJob(){
		$(window).scrollTop($('#jobs').offset().top);
		  
		$('#jobs').animate({opacity:'0.1'},"slow");
		$('#jobs').animate({opacity:'1'},"slow");
		$('#jobs').animate({opacity:'0.1'},"slow");
		$('#jobs').animate({opacity:'1'},"slow");
		$('#jobs').animate({opacity:'0.1'},"slow");
		$('#jobs').animate({opacity:'1'},"slow");
	}
	
	function openProfile()
	{
		$(window).scrollTop($('#container_profile').offset().top);
		//$("#container_profile").slideDown("slow");
		$("#container_profile").show();
	}
	
	function openAvailability()
	{
		$(window).scrollTop($('#div_availability').offset().top);		
	}
	
	function openremoveSkedule()
	{
		$(window).scrollTop($('#div_availability').offset().top);		
	}
	
	
	document.getElementById("uploadBtn").onchange = function () {    document.getElementById("uploadFile").value = this.value;	};
	
function submitReceipt(jobId){   
    var button = $('#' + jobId), interval;
    new AjaxUpload(button,{	action: 'http://www.instaltic.com/loadReceipt.php',
        					data : {	'jobId' : jobId	},
        					name: jobId 	,
        					onSubmit : function(file, ext){},
        					onComplete: function(file, response){} }
					);
					alert (jobId);
};

</script>
</head>

<body <?php 	if ($_POST['submit'] == "modifyProfile")			{	echo 'onload="openProfile();"';			} 
				elseif ($_POST['submit'] == "modifyAvailability") 	{	echo 'onload="openAvailability();"';	}
				elseif ($_POST['submit'] == "removeSkedule") 		{	echo 'onload="openremoveSkedule();"';	}
					else 										{	echo 'onload="thereIsaJob();"';	}		?>	>

<div id="main">
    <div class="container">
    
    <?php
	if($_SESSION['id'])
	{
		echo '<h1>Hello, '.$_SESSION['usr'].'! </h1>';
		echo "
			<a id='edit_profile' href='#'>
			<p>
				<img src='login_panel/images/edit_profile.jpg' style='float:left;margin:0 5px 0 0; height: 20px; width:20px;' /> Edit your profile    
			</p>
			</a>";
	} 
	else echo '<h1>Please, <a href="artist.php">login</a> before you check your skedule!</h1>';
    ?>
        <div id="container_profile"class="container" style="display: none">
        	 <img class="post-avatar" alt="photo" 
        	 				src= <?php if($_SESSION['fotoPath'] != null) { echo "'{$_SESSION['fotoPath']}'";  } else { echo  "'login_panel/images/delete.jpg'"; } ?>
                            height="150" width="150">
        	
        	<p align="center">
        	<?php						
				if($_SESSION['msg_resigistered'])
				{					
					echo '<font color="red">'.$_SESSION['msg_resigistered'].'</font>';
					unset($_SESSION['msg_resigistered']);
				}

				if($_SESSION['msg_resigistered_ok'])
				{					
					echo "<font color='green'>{$_SESSION['msg_resigistered_ok']}</font>";
					unset($_SESSION['msg_resigistered_ok']);
				}
			?>		
			</p>
			
			<form class="pure-form pure-form-aligned" method="post" action="http://instaltic.com/registered.php" enctype="multipart/form-data">
			    <fieldset>
			        <div class="pure-control-group">
			            <label for="name">Name</label>
			            <input id="name" name="name"  type="text" size="60" 
			            	placeholder="your name and surname"  
			            	value = <?php if($_SESSION['name'] != null) { echo "'".$_SESSION['name']."'";  } ?> 	>
			        </div>
			
			        <div class="pure-control-group">
			            <label for="telephone">telephone</label>
			            <input id="telephone" name="telephone" type="text" size="14" 
			            	placeholder="telephone number"	
			            	value = <?php if($_SESSION['telephone'] != null) { echo "'".$_SESSION['telephone']."'";  } ?>      	>
			        </div>
		
			        <div class="pure-control-group">
			            <label for="Paypal">Paypal Account</label>
			            <input id="accountPayPal" name="accountPayPal" type="email" size="60" 
			            	placeholder="your PayPal Account"	
			            	value = <?php if($_SESSION['accountPayPal'] != null) { echo "'".$_SESSION['accountPayPal']."'";  } ?>      	>
			        </div>
			        
			        <div class="pure-control-group">
			            <label for="website">Your Website</label>
			            <input id="website" name="website" type="text" size="60" 
			            	placeholder="paste your URL"	
			            	value = <?php if($_SESSION['website'] != null) { echo "'".$_SESSION['website']."'";  } ?>      	>
	            	</div>
			
					<div class="pure-controls">
						<label for="option-3dmodel" class="pure-checkbox">
					        <input id="workWith3D" name="workWith3D" type="checkbox" 
					        <?php if($_POST['workWith3D']== TRUE || $_SESSION['workWith3D']== TRUE ) { echo "value='on' checked "; } ?>       >
					        I make a 3D model and print it
					    </label>
						<label for="option-ceramic" class="pure-checkbox">
					        <input id="workWithCeramics" name="workWithCeramics" type="checkbox" 
					        <?php if($_POST['workWithCeramics']== TRUE || $_SESSION['workWithCeramics']== TRUE ) { echo "value='on' checked "; } ?>  >
					        I work on Ceramics
					    </label>
						<label for="option-wood" class="pure-checkbox">
					        <input id="workWithWood" name="workWithWood" type="checkbox" 
					        <?php if($_POST['workWithWood']== TRUE || $_SESSION['workWithWood']== TRUE) { echo "value='on' checked "; } ?> >
					        I work on wood
					    </label>
			        </div>
			        
			        <br>			
			        <div class="pure-control-group">			
					 	<div class="file-upload btn btn-primary">  
					 		<span class="">&nbsp; Upload your image &nbsp;&nbsp;&nbsp;</span> 
					 		<input id="file" name="file" type="file" class="upload">
						 </div>					
					</div>    
					
					
			        <div class="pure-controls">
			            <label for="cb" class="pure-checkbox">
			                <input id="cb" name="cb" type="checkbox" checked> I've read the terms and conditions
			            </label>
			
			            <button type="submit" name="submit" value="modifyProfile" class="pure-button pure-button-primary">Update</button>
			        </div>
			        
			        <p align="center">
			        	<?php if($_SESSION['confirmed'] == TRUE) {	echo "<font color='Green'> your account is confirmed ;-) </font>";  } 
			        		 else 	{ 	echo "<font color='red'>your account has not been verifed yet</font>"; 	}
		        		 ?>   
			        </p>
			    </fieldset>
			</form>			    

	
        </div>
    </div>
    <div class="container">
 <!--      class="open" --> 
 		<form id="myform" name="myform" method="post" action="http://instaltic.com/registered.php">	
    	<p>  	 <button type="submit" name="submit" value="modifyAvailability" class="pure-button pure-button-primary">Add</button> new period of availability
    	</p> 
    		  			
	    	<label for="from">From</label>
			<input type="text" id="from" name="from" size=30 readonly/>
			<label for="to">to</label>
			<input type="text" id="to" name="to" size=30 readonly/>			
		</form>	
	</div>
    
    <div id="div_availability" class="container">   
      
    	<h1> your availability  <br></h1>
		 			
		
        	<?php
				$transactions = mysql_query("SELECT * FROM availability WHERE idMember={$_SESSION['id']}");
				while ($row = mysql_fetch_assoc($transactions)) {
					
						$dateTime = new DateTime($row["initDay"]);
						$from_date = $dateTime->format("l jS F Y");
						
						$dateTime_2 = new DateTime($row["lastDay"]);
						$to_date = $dateTime_2->format("l jS F Y");
						
						$now = new DateTime();
						
						if ($now > $dateTime_2 ) { // skip 
						        continue;
						}	
							  			        
				?>
				        <form method="post" action="http://instaltic.com/registered.php">
				    
				        <p>	<button type="submit" name="submit" value="removeSkedule" class="pure-button pure-button-primary">Remove</button> this skedule </p>
						<input type="hidden" name="id" value="<?php echo $_SESSION['id']; ?>"/>
						<input type="hidden" name="from" value="<?php echo $row["initDay"]; ?>"/>
						<input type="hidden" name="to" value="<?php echo $row["lastDay"]; ?>"/>
						<p>
							<?php echo "Since : {$from_date}" ?>
							<br>  
							<?php echo "Until : {$to_date} " ?>  
						</p>
						
						
						</form>
				<?php
				}
				?> 	
		
    </div>
    
    <div id="jobs" class="container">       
    	<h1> Jobs  </h1>
		<br>
		
		
		<?php
				$assignments = mysql_query("SELECT * FROM Assignments WHERE idMember={$_SESSION['id']}");
				while ($rowAssignments = mysql_fetch_assoc($assignments)) {
						$jobId = $rowAssignments["jobId"];
						$order = mysql_query("SELECT * FROM jobs WHERE jobId='{$jobId}'");
						$rowJobs = mysql_fetch_assoc($order);
						$deliveryAddress = $rowJobs["deliveryAddress"];
						$size = $rowJobs["size"]."x".$rowJobs["size"]."x".$rowJobs["size"]."cm3";
						$material = $rowJobs["material"];
						$numberofCopies = $rowJobs["numberofCopies"];
						$link2video = "http://www.instaltic.com/".$rowJobs["pathOfVideo"] ;
						
						switch($material) {
				            case 1 :  // hyper realistic
				          		$ItemMaterial =  "3D printed";
				                break;
				            case 2 :  //  artistic wood
				                $ItemMaterial =  "artistic wood";
				                break;
				            case 3 :   //  artistic silver
				               $ItemMaterial =  "Ceramics";								
				                break;
				            default :				                
				                break;
				        }
						if (false) { // skip finished
						        continue;
						}	
							  			        
				?>		
		<p>
		<b>Job ID: <?php echo $jobId  ?></b>
		</p>    	 
		<p>
			<img src="login_panel/images/house.jpg" style="float:left;margin:0 5px 0 0; height: 20px; width:20px;" /> <?php echo utf8_encode($deliveryAddress);?>    
		</p>
		<p>			
			<a id="" href="<?php echo $link2video ?>">
				<img src="login_panel/images/download.jpg" style="float:left;margin:0 5px 0 0; height: 20px; width:20px;" /> download customer's petition
			</a>
			
				 &nbsp;  <?php echo $size  ?>, <?php echo $ItemMaterial  ?>, <?php echo $numberofCopies  ?> copies &nbsp;  <a id="<?php echo $jobId  ?>" onclick="submitReceipt('<?php echo $jobId  ?>')"><img src="login_panel/images/upload.jpg" style="height: 20px; width:20px;" /> 	send Delivery Receipt	</a> 			
		</p>
		
		<br>
		<?php
				}
		?> 
		
			
			
		
		
    </div>
    
    
  <div class="container tutorial-info">
  	<h1>Take into account:</h1> 
  	<p>the system will assign you a job only within your availability, check it periodically </p>
  	<h1>keep in mind: </h1>
  	<p>once a job is given to you , You become responsible for delivering it.</p>
  </div>
</div>


</body>
</html>
