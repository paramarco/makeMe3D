<?php
session_start();
include_once("config_paypal.php");
include_once("MyPayPal.php");
include_once("Assignements.php");

define('INCLUDE_CHECK',true);

require 'connect.php';
require 'functions.php';

if($_POST) //Post Data received from product list page.
{    
	$size = intval($_POST["size"]);
	$material =  intval($_POST["material"]);
	$numberOfCopies =  intval($_POST["numberOfCopies"]);
	$language = $_POST["language"];
	$numberOfFigures = intval($_POST["number_figures"]);
	$price = 0;
	
	switch($material) {
        case 1 :  // hyper realistic
        	switch($size) {
    			case 7 :
	            	if ($numberOfFigures == 1) {	$price = 380; }		          		 	
	          		else  { $price = 400; }  
	                $price = $price * (0.8 * ($numberOfCopies - 1) + 1);  
                	break;
                case 11 :
	            	if ($numberOfFigures == 1) {	$price = 400; }		          		 	
	          		else  { $price = 420; }  
	                $price = $price * (0.8 * ($numberOfCopies - 1) + 1);  
                	break;
                case 15 :
	            	if ($numberOfFigures == 1) {	$price = 430; }		          		 	
	          		else  { $price = 450; }  
	                $price = $price * (0.8 * ($numberOfCopies - 1) + 1);  
                	break;
                default :
            		echo '<div style="color:red"><b>Error :DEFAULT </b></div>';
            		break;
            	}
        	break;		                	
        case 2 :  //  artistic wood
        	switch($size) {
        		case 20 :
	            	if ($numberOfFigures == 1) {	$price = 490; }		          		 	
	          		else  { $price = 590; }  
	                $price = $price * (0.8 * ($numberOfCopies - 1) + 1);  
                	break;
                case 30 :
	            	if ($numberOfFigures == 1) {	$price = 594; }		          		 	
	          		else  { $price = 694; }  
	                $price = $price * (0.8 * ($numberOfCopies - 1) + 1);  
                	break;
                case 40 :
	            	if ($numberOfFigures == 1) {	$price = 700; }		          		 	
	          		else  { $price = 800; }  
	                $price = $price * (0.8 * ($numberOfCopies - 1) + 1);  
                	break;
                default :
            		echo '<div style="color:red"><b>Error :DEFAULT </b></div>';
					break;
        		}
            break;
        case 3 :   //  artistic ceramik
            switch($size) {
        		case 7 :
	            	if ($numberOfFigures == 1) {	$price = 230; }		          		 	
	          		else  { $price = 260; }  
	                $price = $price * (0.8 * ($numberOfCopies - 1) + 1);  
                	break;
                case 11 :
	            	if ($numberOfFigures == 1) {	$price = 270; }		          		 	
	          		else  { $price = 280; }  
	                $price = $price * (0.8 * ($numberOfCopies - 1) + 1);  
                	break;
                case 15 :
	            	if ($numberOfFigures == 1) {	$price = 280; }		          		 	
	          		else  { $price = 300; }  
	                $price = $price * (0.8 * ($numberOfCopies - 1) + 1);  
                	break;
                default :
            		echo '<div style="color:red"><b>Error :DEFAULT </b></div>';
            		break;
        		}
            break;
            default :
                echo '<div style="color:red"><b>Error :DEFAULT </b></div>';
                break;
        }
		 
		// switch($size) {
            // case 20 :
                // switch($material) {
		            // case 1 :  // hyper realistic
		          		// $price = 300;  	    
		                // $price = $price * (0.8 * ($numberOfCopies - 1) + 1); 
						// $ItemName =  "hyper realistic 20x20x20cm, sculpture x " .$numberOfCopies ;
		                // break;
		            // case 2 :  //  artistic wood
		                // $price = 330;  	    
		                // $price = $price * (0.8 * ($numberOfCopies - 1) + 1);
						// $ItemName =  "artistic wood 20x20x20cm, sculpture x " .$numberOfCopies ;
		                // break;
		            // case 3 :   //  artistic silver
		                // $price = 250;  	    
		                // $price = $price * (0.8 * ($numberOfCopies - 1) + 1);
						// $ItemName =  "artistic ceramics 20x20x20cm, sculpture x " .$numberOfCopies ;
		                // break;
		            // default :
// 		                
		                // break;
		        // }
//                 
                // break;
            // case 30 :
                // switch($material) {
		            // case 1 :  // hyper realistic
		          		// $price = 330;  	    
		                // $price = $price * (0.8 * ($numberOfCopies - 1) + 1);
						// $ItemName =  "hyper realistic 30x30x30cm, sculpture x " .$numberOfCopies ;
		                // break;
		            // case 2 :  //  artistic wood
		                // $price = 340;  	    
		                // $price = $price * (0.8 * ($numberOfCopies - 1) + 1);
						// $ItemName =  "artistic wood 30x30x30cm, sculpture x " .$numberOfCopies ;
		                // break;
		            // case 3 :   //  artistic silver
		                // $price = 260;  	    
		                // $price = $price * (0.8 * ($numberOfCopies - 1) + 1);
						// $ItemName =  "artistic ceramics 30x30x30cm, sculpture x " .$numberOfCopies ;
		                // break;
		            // default :
		                // break;
		        // }
//                 
                // break;
            // case 40 :
                // switch($material) {
		            // case 1 :  // hyper realistic
		          		// $price = 360;  	    
		                // $price = $price * (0.8 * ($numberOfCopies - 1) + 1);  
						// $ItemName =  "hyper realistic 40x40x40cm, sculpture x " .$numberOfCopies ;
		                // break;
		            // case 2 :  //  artistic wood
		                // $price = 350;  	    
		                // $price = $price * (0.8 * ($numberOfCopies - 1) + 1);
						// $ItemName =  "artistic wood 40x40x40cm, sculpture x " .$numberOfCopies ;
		                // break;
		            // case 3 :   //  artistic silver
		                // $price = 280;  	    
		                // $price = $price * (0.8 * ($numberOfCopies - 1) + 1);
						// $ItemName =  "artistic ceramics 40x40x40cm, sculpture x " .$numberOfCopies ;
		                // break;
		            // default :
		                // break;
		        // }
                // break;
            // default :
                // echo '<div style="color:red"><b>Error :DEFAULT </b></div>';
                // break;
        // } 
		 
		$commision = 70;
		$ItemInstalTIC = $commision * 0.78;
		$ItemTaxInstalTIC = $commision * 0.21;
		$ItemTotalInstalTIC = $ItemInstalTIC + $ItemTaxInstalTIC; 
		 
		$price = $price + $commision;  
		$ItemPrice = $price * 0.78; 
		$ShippingPrice = 30; 		
		$ItemTax = $price * 0.21;
		$ItemTotalPrice = $ItemTax + $ItemPrice + $ShippingPrice ;
		
  
		
	//Check if there is any artist available today for this request
	$assignements = new Assignements();
	$row_member = $assignements->getLessSolicited($material);
	
	$accountPayPal_Artist = $row_member["accountPayPal"];
	
	$noArtistAvailable = FALSE;
	if ($accountPayPal_Artist== NULL || $accountPayPal_Artist == "")	{	$noArtistAvailable = TRUE;	}
	if ($noArtistAvailable == TRUE)	{	echo "noArtistAvailable";	}
	else{
			//Data to be sent to paypal	
	   $padata =   

	                '&PAYMENTREQUEST_0_PAYMENTACTION=Sale'.
	                '&ALLOWNOTE=1'.
	                
	                '&PAYMENTREQUEST_0_CURRENCYCODE='.urlencode($PayPalCurrencyCode).
	                
	                '&PAYMENTREQUEST_0_AMT='.$ItemTotalPrice.
	                '&PAYMENTREQUEST_0_ITEMAMT='.$ItemPrice.
				   	'&PAYMENTREQUEST_0_SHIPPINGAMT='.$ShippingPrice.
	               	'&PAYMENTREQUEST_0_TAXAMT='.$ItemTax.          
	                
		           
	              '&L_PAYMENTREQUEST_0_AMT0='.$ItemPrice.
	              '&L_PAYMENTREQUEST_0_NAME0='.urlencode($ItemName).
	          	
	                '&RETURNURL='.urlencode($PayPalReturnURL ).
	                '&CANCELURL='.urlencode($PayPalCancelURL).
	                
					'&LOCALECODE='.$language;
		               
		               
	           /*     
	       $padata =   
                '&RETURNURL='.urlencode($PayPalReturnURL ).
                '&CANCELURL='.urlencode($PayPalCancelURL).
                '&PAYMENTREQUEST_0_AMT='.$ItemTotalInstalTIC.
                '&PAYMENTREQUEST_0_ITEMAMT='.$ItemInstalTIC.
                '&PAYMENTREQUEST_0_TAXAMT='.$ItemTaxInstalTIC.
				'&PAYMENTREQUEST_0_DESC=FEE-PAYMENTX'.
                '&PAYMENTREQUEST_0_PAYMENTACTION=Sale'.
                '&PAYMENTREQUEST_0_PAYMENTREQUESTID=FEE-PAYMENTX'.
                '&PAYMENTREQUEST_0_SELLERPAYPALACCOUNTID=instaltic_seller@instaltic.com'.  
                '&PAYMENTREQUEST_1_CURRENCYCODE='.urlencode($PayPalCurrencyCode).
                '&PAYMENTREQUEST_1_AMT='.urlencode($ItemTotalPrice).
                '&PAYMENTREQUEST_1_ITEMAMT='.urlencode($ItemPrice).
                '&PAYMENTREQUEST_1_TAXAMT='.urlencode($ItemTax).
                '&PAYMENTREQUEST_1_SHIPPINGAMT='.urlencode($ShippingPrice).
				'&PAYMENTREQUEST_1_DESC=SCULPTURE-PAYMENTX'.
                '&PAYMENTREQUEST_1_PAYMENTACTION=Sale'.
                '&PAYMENTREQUEST_1_PAYMENTREQUESTID=SCULPTURE-PAYMENTX'.
                '&PAYMENTREQUEST_1_SELLERPAYPALACCOUNTID='.urlencode($accountPayPal_Artist).
                '&PAYMENTREQUEST_0_CURRENCYCODE='.urlencode($PayPalCurrencyCode).                  
              	'&LOCALECODE='.$language;		  			  
	   */ 
	
	        //We need to execute the "SetExpressCheckOut" method to obtain paypal token
	        $paypal= new MyPayPal();
	        $httpParsedResponseAr = $paypal->PPHttpPost('SetExpressCheckout', $padata, $PayPalApiUsername, $PayPalApiPassword, $PayPalApiSignature, $PayPalMode);
	
	        //Respond according to message we receive from Paypal
	        if("SUCCESS" == strtoupper($httpParsedResponseAr["ACK"]) || "SUCCESSWITHWARNING" == strtoupper($httpParsedResponseAr["ACK"]))
	        {
	                if($PayPalMode=='sandbox')	{	$paypalmode     =   '.sandbox';	}
	                else 						{	$paypalmode     =   '';         }                
					
	                if ($noArtistAvailable == TRUE)	{	echo "noArtistAvailable";	}
	                else {
	                	$token4Insert = urldecode($httpParsedResponseAr["TOKEN"]);
	                	mysql_query("	INSERT INTO jobs ( token, size,material,numberofCopies)
										VALUES('{$token4Insert}','{$size}','{$material}', {$numberOfCopies}	)");
	                    echo $httpParsedResponseAr["TOKEN"];
	                }
					
	        }else{
	            //Show error message
	            echo '<div style="color:red"><b>Error : </b>'.urldecode($httpParsedResponseAr["L_LONGMESSAGE0"]).'</div>';
	            echo '<pre>';
	            print_r($httpParsedResponseAr);
	            echo '</pre>';
	        }
    }
}

//Paypal redirects back to this page using ReturnURL, We should receive TOKEN and Payer ID
if(isset($_GET["token"]) )
{
    //we will be using these two variables to execute the "DoExpressCheckoutPayment"
    //Note: we haven't received any payment yet.
    $token = $_GET["token"];
    $playerid = $_GET["PayerID"];
    $padata =   '&TOKEN='.urlencode($token);
	$token4Update = urlencode($token);
    
    $paypal_object = new MyPayPal();
    $httpParsedResponseGetDetails = $paypal_object->PPHttpPost('GetExpressCheckoutDetails', $padata, $PayPalApiUsername, $PayPalApiPassword, $PayPalApiSignature, $PayPalMode);
      
	$payment_request = urldecode($httpParsedResponseGetDetails['PAYMENTREQUEST_0_AMT']);
	$payment_request_1 = urldecode($httpParsedResponseGetDetails['PAYMENTREQUEST_1_AMT']);	
	$SellerPayPalAccountID = urldecode($httpParsedResponseGetDetails['PAYMENTREQUEST_0_SELLERPAYPALACCOUNTID']);
	
	$payment_data = urldecode($httpParsedResponseGetDetails['FIRSTNAME']);
	if ($payment_data == "" || $payment_data == null) {	$FIRSTNAME = "";	}	else	{$FIRSTNAME = $payment_data;}
	$payment_data = urldecode($httpParsedResponseGetDetails['LASTNAME']);
	if ($payment_data == "" || $payment_data == null) {	$LASTNAME = "";	}	else	{$LASTNAME = $payment_data;}
	$payment_data = urldecode($httpParsedResponseGetDetails['EMAIL']);
	if ($payment_data == "" || $payment_data == null) {	$EMAIL = "";	}	else	{$EMAIL = $payment_data;}
	$payment_data = urldecode($httpParsedResponseGetDetails['PAYMENTREQUEST_0_SHIPTOSTREET']);
	if ($payment_data == "" || $payment_data == null) {	$PAYMENTREQUEST_0_SHIPTOSTREET = "";	}	else	{$PAYMENTREQUEST_0_SHIPTOSTREET = $payment_data;}
	$payment_data = urldecode($httpParsedResponseGetDetails['PAYMENTREQUEST_0_SHIPTOCITY']);
	if ($payment_data == "" || $payment_data == null) {	$PAYMENTREQUEST_0_SHIPTOCITY = "";	}	else	{$PAYMENTREQUEST_0_SHIPTOCITY = $payment_data;}
	$payment_data = urldecode($httpParsedResponseGetDetails['PAYMENTREQUEST_0_SHIPTOCOUNTRYCODE']);
	if ($payment_data == "" || $payment_data == null) {	$PAYMENTREQUEST_0_SHIPTOCOUNTRYCODE = "";	}	else	{$PAYMENTREQUEST_0_SHIPTOCOUNTRYCODE = $payment_data;}
	
	$deliveryAddress = $PAYMENTREQUEST_0_SHIPTOSTREET.", ".$PAYMENTREQUEST_0_SHIPTOCITY.", ".$PAYMENTREQUEST_0_SHIPTOCOUNTRYCODE;
	
	$nameReceiver = $FIRSTNAME.", ".$LASTNAME;	
	
	mysql_query(" UPDATE jobs SET deliveryAddress = '{$deliveryAddress}', emailClient = '{$EMAIL}', nameReceiver = '{$nameReceiver}'
					WHERE token='{$token4Update}' ");	
	
	
	$padata =	'&TOKEN='.urlencode($token).
              	'&PAYMENTACTION='.urlencode("SALE").
             	'&PAYERID='.urlencode($playerid).
			/*  '&PAYMENTREQUEST_1_AMT='.urlencode($payment_request_1).
			  	'&PAYMENTREQUEST_1_CURRENCYCODE=EUR'.
			  	'&PAYMENTREQUEST_1_SELLERPAYPALACCOUNTID='.urlencode($SellerPayPalAccountID).
			  	'&PAYMENTREQUEST_1_PAYMENTREQUESTID=SCULPTURE-PAYMENTX'. */
				'&PAYMENTREQUEST_0_AMT='.urlencode($payment_request).
			  	'&PAYMENTREQUEST_0_CURRENCYCODE=EUR'.   
				'&PAYMENTREQUEST_0_SELLERPAYPALACCOUNTID=instaltic_seller@instaltic.com'.
			  	'&PAYMENTREQUEST_0_PAYMENTREQUESTID=FEE-PAYMENTX';                      
                         
      //We need to execute the "DoExpressCheckoutPayment" at this point to Receive payment from user.
      $paypal= new MyPayPal();
      $httpParsedResponseAr = $paypal->PPHttpPost('DoExpressCheckoutPayment', $padata, $PayPalApiUsername, $PayPalApiPassword, $PayPalApiSignature, $PayPalMode);
	  
	  //Check if everything went OK..
      if("SUCCESS" == strtoupper($httpParsedResponseAr["ACK"]) || "SUCCESSWITHWARNING" == strtoupper($httpParsedResponseAr["ACK"]))
      {
			$transactionID = urlencode($httpParsedResponseAr['PAYMENTINFO_0_TRANSACTIONID']);
			
			mysql_query(" UPDATE jobs SET jobId = '{$transactionID}'	WHERE token='{$token4Update}' ");
			
			$row = mysql_fetch_assoc(mysql_query("SELECT * FROM jobs WHERE token='{$token4Update}' "));
			$material_bought = 	$row["material"];
			
			$assignements = new Assignements();
			$row = $assignements->getLessSolicited($material_bought);	
					
			$nvpStr = "&TRANSACTIONID=".$transactionID;
			$paypal= new MyPayPal();
			$httpParsedResponseAr = $paypal->PPHttpPost('GetTransactionDetails', $nvpStr, $PayPalApiUsername, $PayPalApiPassword, $PayPalApiSignature, $PayPalMode);  
  
 												
		if("SUCCESS" == strtoupper($httpParsedResponseAr["ACK"]) || "SUCCESSWITHWARNING" == strtoupper($httpParsedResponseAr["ACK"])) 
          {
          	//back to the mobile app UX
      		$data2send = array(
							'transactionID'=> $transactionID,
							'accountPayPal'=> $row["accountPayPal"],
							'name'=> $row["name"],
							'fotoPath'=> $row["fotoPath"] ,
							'link' => $row["website"]  );
							
			header( "Location: http://www.instaltic.com/mobile/close/blanck_page.html?".http_build_query($data2send) ) ;
	/*		echo "	<html>
						<head>
						<script>
						function closeBrowser(){
							window.location.href = '/mobile/close/?".http_build_query($data2send)."';							
						}
						</script>
						</head>
						 <body onload='closeBrowser();'>					 		
						 </body>
					</html>
			";	
	 * 
	 */		
			//association jobid <--> artistid
			mysql_query("	INSERT INTO Assignments (idMember, jobId)
									VALUES({$row["id"]},'{$transactionID}')	");	
			
			//notify to artist and admin
			$paymentStatus = $httpParsedResponseAr["PAYMENTSTATUS"];			
			
			//email to customer	
			$email2customer = '<html><body>';
			$email2customer .= "<p>Hi {$nameReceiver} !!!</p>";	
			$email2customer .= "<p>your sculpture request is sent, with ID:  {$transactionID}</p> <p></p>";
			$email2customer .= '<table rules="all" centered style="border-color: #666;" cellpadding="10">';
			$email2customer .= "<tr style='background: #eee;'><td><strong> JobID:</strong> </td><td>" . $transactionID . "</td></tr>";
			$email2customer .= "<tr><td><strong>address:</strong> </td><td>" . $deliveryAddress . "</td></tr>";
			$email2customer .= "<tr><td><strong>receiver:</strong> </td><td>" . $nameReceiver . "</td></tr>";
			$email2customer .= "<tr><td><strong>email:</strong> </td><td>" . $EMAIL . "</td></tr>";	
			$email2customer .= "<tr><td><strong>payment status:</strong> </td><td>" . $paymentStatus . "</td></tr>";	
			$email2customer .= "<tr><td><strong>Artist's website:</strong> </td><td>" . $row["website"]. "</td></tr>";	
			$email2customer .= "<tr><td><strong>Artist's email:</strong> </td><td>" . $row["accountPayPal"]. "</td></tr>";	
			$email2customer .= "</table>";					
			$email2customer .= "<p>Regards, </p>";
			$email2customer .= "<p>Make it! platform </p>";			
			$email2customer .= "</body></html>";
			
		
			send_mail(	'makeit_customers@instaltic.com',
						$EMAIL. ", makeit_customers@instaltic.com",
						"MAKE IT 3D ! :: your sculture request is sent, with ID:  {$transactionID}",
						$email2customer);
						
				
			$email2artist = '<html><body>';
			$email2artist .= "<p>Hi {$row["name"]} !!!</p>";	
			$email2artist .= "<p>there is a new sculpture request for you with ID:  {$transactionID}</p>";	
			$email2artist .= "<p>now please go to your <a href='http://www.instaltic.com/artist.php' > jobs page  </a> to download the video</p>";						
			$email2artist .= '<table rules="all" centered style="border-color: #666;" cellpadding="10">';
			$email2artist .= "<tr style='background: #eee;'><td><strong> JobID:</strong> </td><td>" . $transactionID . "</td></tr>";
			$email2artist .= "<tr><td><strong>address:</strong> </td><td>" . $deliveryAddress . "</td></tr>";
			$email2artist .= "<tr><td><strong>receiver:</strong> </td><td>" . $nameReceiver . "</td></tr>";
			$email2artist .= "<tr><td><strong>email:</strong> </td><td>" . $EMAIL . "</td></tr>";	
			$email2artist .= "<tr><td><strong>payment status:</strong> </td><td>" . $paymentStatus . "</td></tr>";		
			$email2artist .= "</table>";		
			$email2artist .= "<p>Once you finish and after sending the package, don't forget to upload the receipt!! </p>";	
			$email2artist .= "<p>Regards, </p>";
			$email2artist .= "<p>Make it! platform </p>";			
			$email2artist .= "</body></html>";
			
		
			send_mail(	'makeit@instaltic.com',
						$row["email"]. ", makeit@instaltic.com",
						"MAKE IT 3D ! :: There is a new sculture request for you,  ID:  {$transactionID}",
						$email2artist);
						
          } else  {
              echo '<div style="color:red"><b>GetTransactionDetails failed:</b>'.urldecode($httpParsedResponseAr["L_LONGMESSAGE0"]).'</div>';
              echo '<pre>';
              print_r($httpParsedResponseAr);
              echo '</pre>';  
                  }        
    }else{
            echo '<div style="color:red"><b>Error : </b>'.urldecode($httpParsedResponseAr["L_LONGMESSAGE0"]).'</div>';
            echo '<pre>';
            print_r($httpParsedResponseAr);
            echo '</pre>';
    }
}
?>