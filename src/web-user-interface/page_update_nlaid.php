
<?php // Page Template version 3.3

/*******************************************************************************
 * Australian National University Metadata Store
 * Copyright (C) 2013  The Australian National University
 * 
 * This file is part of Australian National University Metadata Store.
 * 
 * Australian National University Metadatastore is free software: you
 * can redistribute it and/or modify it under the terms of the GNU
 * General Public License as published by the Free Software Foundation,
 * either version 3 of the License, or (at your option) any later
 * version.
 * 
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 * 
 * You should have received a copy of the GNU General Public License
 * along with this program.  If not, see <http://www.gnu.org/licenses/>.
 ******************************************************************************/

/*
 Australian National University Metadata Store

 Update the NLA ID to a server
 
 Version 	Date		Developer
 1.0        30-04-2013      Irwan Krisna  (IK) Initial 


*/


// PLEASE UPDATE THESE VALUES FOR EVERY PAGE
// -----------------------------------------------------------------------------
$title			= 'NLA ID Provisioning';
$description	= 'National Library of Australia ID Mint';
$subject		= 'Research, Website';

// Include configuration file & begin the XHTML response
// -----------------------------------------------------------------------------
include ($_SERVER['DOCUMENT_ROOT'] .'/anu_template/config.php');

echo $DocType; 
echo $Head; 
// insert additional header statements here //
echo $Body;
echo $Banner; 
include $Menu3;


// BEGIN: Page Content
// =============================================================================
?>




	<div class=narrow">
		<h1><?php echo $title; ?></h1>
	
	</div>	
<html>    
<head>
	<meta name="author" content="Vladimir Carrer">
	<link rel="stylesheet" href="form.css" type="text/css">
	<!--[if gt IE 5]>
	<!--link rel="stylesheet" href="ie.css" type="text/css">
	<!--[endif]-->
</head>
	
	

<body>
    
<fieldset>

<style>
#labelx	 
	{ float:left; width:20em; display:block; clear:left; margin-right:1em; text-align:left;  cursor:hand; }
</style>    
    
<?php



$con = mysql_connect("localhost","irwan","");
if (!$con)
  {
  die('Could not connect: ' . mysql_error());
  }


mysql_select_db("oaidb", $con);


//get the university ID 
$deidentified_staffid= $_GET[deidentified_staffid];

//MySQL Query: To get list of people records whose NLA-IDs need to be sent to the Java Service
$result = mysql_query("SELECT  b.staffnumber staffid,nla_id from oai_records a,useraccount b  where nla_id is not null and a.ori_id = b.id_org and b.id_org = '$deidentified_staffid'  ; ") or die('Test Data: ' . mysql_error);


/*
Result of the MySQL: 
 - List all returned records from the MySQL query above
 - Update the Java Service with the NLA ID information of each researcher 
*/


while($row = mysql_fetch_array($result)){
        extract($_POST);
        $nla_id = $row['nla_id'];
        if($row['nla_id']!=""){
          echo "Update Successful!","<br>";
          echo "<br>";
          echo "NLA ID: ",$row['nla_id'],"<br>";
          echo "<br>";
          echo "Records content:","<br>";
        }        
        else{
          echo "Update Unsuccessful","<br>";
          
        }
        //set POST variables
        $url = 'http://dc7-dev2.anu.edu.au:9080/services/rest/person/update/'.$row['staffid'];
        //echo $url;
        $fields = array(
        	'nla-id'=>urlencode($nla_id)
	);

	//url-ify the data for the POST
	foreach($fields as $key=>$value) { $fields_string .= $key.'='.$value.'&'; }
	rtrim($fields_string,'&');
      
	//open connection
	$ch = curl_init();
	curl_setopt($ch,CURLOPT_URL,$url);
	curl_setopt($ch,CURLOPT_POST,count($fields));
	curl_setopt($ch,CURLOPT_POSTFIELDS,$fields_string);
	//execute post
	$result = curl_exec($ch);
	
	
}
curl_close($ch);


        
        
			
//}
echo "<br>";
echo "<br>";  

?>
</fieldset>
</form>
</body>
</html>	

<!-- END MAIN PAGE CONTENT -->
<?php 
// =============================================================================
// END: Page Content


// Complete the XHTML response
// -----------------------------------------------------------------------------
echo $Update; 
echo $Analytics;
echo $Footer; 

?>
