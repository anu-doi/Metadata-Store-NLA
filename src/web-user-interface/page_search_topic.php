<?php session_start(); 
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

 A page to Search a Topic
 
 Version 	Date		Developer
 1.0        30-04-2013      Irwan Krisna  (IK) Initial 


*/ 


?>



<?php // Page Template version 3.3

// PLEASE UPDATE THESE VALUES FOR EVERY PAGE
// -----------------------------------------------------------------------------
$title			= 'Researcher Profile';
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
include $Menu5;



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
	{ float:left; width:10em; display:block; clear:left; margin-right:1em; text-align:left;  cursor:hand; }
    
#labely	 
	{ float:left; width:14em; clear:left; margin-right:1em; text-align:left;cursor:hand;  }    
    
    
</style>    





    
<?php




$con = mysql_connect("localhost","irwan","");

if (!$con)
  {
  die('Could not connect: ' . mysql_error());
  }



mysql_select_db("oaidb", $con);


if (!$con)
  {
  die('Could not connect: ' . mysql_error());
  }



//echo "<br>","TEST",$_POST[pubidnext],"</br>";
if(($result === FALSE) or ($result2 === FALSE)) {
    die(mysql_error()); // TODO: better error handling
}
//echo "<br/>";
//echo "<br/>";

echo $_POST[mydropdown];
if ($_SESSION['logged_in']){
	$result = mysql_query("SELECT topic_id,REPLACE(topic_area,' ','-') topic_area,sum(publication_count) count  FROM author_topic where topic_area like '%$_POST[searchkeyword]%' group by topic_id,topic_area order by count desc  limit 20 ; ") or die('Test Data: ' . mysql_error());
}

else 
{
	echo "Please go back to previous page";
}


while($row3 = mysql_fetch_array($result3)){
	$nlaid = $row3['nla_id'];
}


echo "<html>";
echo "<body>";
echo '<form action="page_search_topic.php" method="post" >';
echo "Search Function:";
echo "<br>";
echo "<br>";

//echo "First Name:","<input type='text' name='searchfname' id='searchfname'  maxlength='50' />","</br>";
//echo "<label id='labelx' name='searchfname'>","First Name:","</label>","<br>";

echo "<label id='labelx' for='searchkeyword'>","Keyword:","</label>",
"<INPUT TYPE = 'Text' NAME ='searchkeyword' id = 'searchkeyword' size='30'>","<br/>";

echo "<br>";
/*
echo "or","<br>";
echo "<br>";


echo "<label id='labelx' for='searchfname'>","First Name:","</label>",
"<INPUT TYPE = 'Text' NAME ='fname' id = 'fname' size='30'>","<br/>";
echo "<br>";

echo "<br>";
echo "or","<br>";
echo "<br>";

echo "<label id='labelx' for='searchsurname'>","last Name:","</label>",
"<INPUT TYPE = 'Text' NAME ='lname' id = 'lname' size='30'>","<br/>";
echo "<br>";

echo "<br>";
echo "or";
echo "<br/>";

echo "<label id='labelx' for='college'>","College:","</label>",
"<div align='left'>";
echo "<select name='mydropdown'>";
echo "<option value=''>------------------------------------------------</option>";
echo "<option value='CPMS'>College of Physical and Mathematical Science</option>";
echo "<option value='CBE'>College of Business and Economics</option>";
echo "<option value='CMBE'>College of Medical and Biology</option>";
echo "<option value='CASS'>College of Social Science</option>";
echo "<option value='CAP'>College of Asia Pacific</option>";
echo "<option value='CECS'>College of Engineering and Computer Sciences</option>";
echo "</select>";
echo "</div>";
*/


echo "</br>";
//echo '<input type="radio" name="pubidnext" value=',$uid_post,' checked="checked">',"Please tick to confirm",'<br>';
echo "<br/>";




//echo "<input type='submit' name='Submit' value='Submit' />";
$uid_post = $_SESSION['username'];

echo '<input type="hidden" name="pubidnext" value=',$uid_post,' checked="checked", ','<br>';
echo "<br/>";
echo '<input id="MyConfirm" onclick="sayHello()" type="Submit" value="Confirm" name="IncludePubs"><br/>';


echo "<br>";
echo "</body>";
echo "</html>"; 
	//echo "</div>";

echo "<br>";
echo "<br>","Search Result:","<br>";
echo "<br>";
echo "<html>";
echo "<body>";
echo "<table border='1'>";
echo "<tr>";
//echo "<th>Include ?</th>";
echo "<th>Topic ID</th>";
echo "<th>Topic Area</th>";
echo "<th>View Topic</th>";
echo "</tr>";
//echo '<form action="http://dc7-dev2.anu.edu.au/oai/oai2.php?verb=ListRecords&metadataPrefix=rif" method="post">';
while($row = mysql_fetch_array($result))
  {

	
	//Checkbox = C $row2['pubid'];
	$topic_id = $row['topic_id'];
	echo "<tr>";
	//echo "<td>",'<input type="checkbox" name="pubidcheck[]" value=',$valuetextbox,'>',"</td>";    	
	echo "<td>",$row['topic_id'],"</td>";
	echo "<td>",$row['topic_area'],"</td>"; 
	echo "<td>","<font size=3>","<a href=\"page_topic_specific_result.php?topic_id=".$topic_id."\">","view","</a></font>","</td>";
	
	echo "</tr/>";	
  }
echo "</table>";
echo "<br>";




//echo '<input type="submit" value="Finalize Profile" name="FinalizeProfile"><br/>';



?>
</fieldset>
			
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
