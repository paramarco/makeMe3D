<?php
//define('INCLUDE_CHECK',true);
//require 'connect.php';

class Assignements {
    function getLessSolicited($material) {           
		//Check if there is any artist available today for this request
		$accountPayPal_Artist;		
		switch($material) {
			            case 1 :  // hyper realistic
			            	$sql_query = "SELECT id, email, name, fotoPath, website, accountPayPal
											FROM availability A, tz_members M
											WHERE M.id = A.idMember
											AND A.lastDay > NOW() 
											AND M.workWith3D = 1";
			          		
			                break;
			            case 2 :  //  artistic wood
			            	$sql_query = "SELECT id, email, name, fotoPath, website, accountPayPal
											FROM availability A, tz_members M
											WHERE M.id = A.idMember
											AND A.lastDay > NOW( ) 
											AND M.workWithWood = 1";
			               
			                break;
			            case 3 :   //  artistic silver
			          		$sql_query = "SELECT id, email, name, fotoPath, website, accountPayPal
											FROM availability A, tz_members M
											WHERE M.id = A.idMember
											AND A.lastDay > NOW( ) 
											AND M.workWithCeramics = 1";
			                
			                break;
			            default :			                
			                break;
			        }

		$row_member = mysql_fetch_assoc(mysql_query($sql_query));
		
		return $row_member;
    }
    
    function getLessSolicited_2($material) {           
		//Check if there is any artist available today for this request
		$accountPayPal_Artist;		
		switch($material) {
			            case 1 :  // hyper realistic
			            	$sql_query = "SELECT id, email, name, fotoPath, website, accountPayPal
											FROM availability A, tz_members M
											WHERE M.id = A.idMember
											AND A.lastDay > NOW() 
											AND M.workWith3D = 1";
			          		
			                break;
			            case 2 :  //  artistic wood
			            	$sql_query = "SELECT id, email, name, fotoPath, website, accountPayPal
											FROM availability A, tz_members M
											WHERE M.id = A.idMember
											AND A.lastDay > NOW( ) 
											AND M.workWithWood = 1";
			               
			                break;
			            case 3 :   //  artistic silver
			          		$sql_query = "SELECT id, email, name, fotoPath, website, accountPayPal
											FROM availability A, tz_members M
											WHERE M.id = A.idMember
											AND A.lastDay > NOW( ) 
											AND M.workWithCeramics = 1";
			                
			                break;
			            default :			                
			                break;
			        }

		$row_member = mysql_fetch_assoc(mysql_query($sql_query));
		
		return $row_member;
    }

}
?>