<?php 
session_start();

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

 A page describing a topic
 
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
	{ float:left; width:20em; display:block; clear:left; margin-right:1em; text-align:left;  cursor:hand; }
    
#labely	 
	{ float:left; width:14em; clear:left; margin-right:1em; text-align:left;cursor:hand;  }    

* {
  margin:  0;
  padding: 0;
}
div.ex
{
position:relative;
top:5px;
right:15px;
margin-left:10em;
text-align:left;
clear:left;
cursor:hand; 
float:right;
width:420px;
padding:10px;
border:5px solid gray;
margin:0px;
}

div#mytagcloud {
  width: 225px;
}
ul.tagcloud-list {
  border: 1px solid #000;
  font-size: 100%;
  font-weight: bold;
  font-family: "Arial", "sans-self";
  padding: 12px;
  margin: 30px;
}
li.tagcloud-base {
  font-size: 24px;
  display: inline;
}
a.tagcloud-anchor {
  text-decoration: none;
}
a.tagcloud-ealiest {
  color: #ccc;
}
a.tagcloud-earlier {
  color: #99c;
}
a.tagcloud-later {
  color: #99f;
}
a.tagcloud-latest {
  color: #00f;
}    
    
    
</style>    





    
<?php



$search_item = $_GET['topic_id'];
//echo "irwan";
//echo $search_item,"</br>";
$con = mysql_connect("localhost","irwan","");



if (!$con)
  {
  die('Could not connect: ' . mysql_error());
  }



mysql_select_db("oaidb", $con);
$uniid= $_SESSION['universityid'];

// Create connection to the PostGreSQL:



	


// get the details using the UID:


//echo "<br>","TEST",$_POST[pubidnext],"</br>";
if(($result === FALSE) or ($result2 === FALSE)) {
    die(mysql_error()); // TODO: better error handling
}
//echo "<br/>";
//echo "<br/>";
echo "<html>";
echo "<body>";





while($row3 = mysql_fetch_array($result3)){
	$nlaid = $row3['nla_id'];
}

echo "<script type='text/javascript' src='http://tagcloud.googlecode.com/svn/trunk/lib/tagcloud.js'></script>";
echo "<script type='text/javascript'>" ;
echo "var tc = TagCloud.create()";
echo "</script>";
$count = 1; 
//$dbhpg = pg_connect("host=localhost port=9432 dbname=mapappdb user=mapappuser") or die("Could not connect" . pg_last_error());

//$querypg = "SELECT topic_areas,univ_id,surname,firstname,sum(publication_count) all_sum  FROM author_topic where topic_id = '$search_item' group by topic_areas,univ_id,surname,firstname order by all_sum desc";
//$querypgtopic = "SELECT DISTINCT topic_areas FROM author_topic where topic_id = '$search_item'";

//$result = mysql_query("SELECT topic_area,deidentified_staffid,family_name,first_name,sum(publication_count) all_sum  FROM author_topic where topic_id = '$search_item' group by topic_area,deidentified_staffid,family_name,first_name order by all_sum desc;") or die('Test Data: ' . mysql_error());
$result = mysql_query("SELECT a.topic_area,a.deidentified_staffid,a.publication_count,b.title,b.first_name,b.family_name,b.address from author_topic a, useraccount b where a.deidentified_staffid = b.id_org and a.topic_id = '$search_item' order by a.publication_count desc limit 10 ;") or die('Test Data: ' . mysql_error());
$result2 = mysql_query("SELECT DISTINCT REPLACE(topic_area,' ',', ') topic_area FROM author_topic where topic_id = '$search_item'")  or die('Test Data: ' . mysql_error()) ;
$result3 = mysql_query("SELECT DISTINCT a.pub_id,b.title, b.yearpublished,b.source  FROM pub_topic_astra a,publication b  where a.topic_id = '$search_item' and a.pub_id = b.pubid order by b.yearpublished  desc limit  20;")  or die('Test Data: ' . mysql_error()) ;
$result4 = mysql_query("SELECT DISTINCT topic_id,for_code,for_desc,ROUND((topic_for_frequency * 100),2) pct,IF(ROUND((topic_for_frequency * 100),2) > 75, 'Very High',IF(ROUND((topic_for_frequency * 100),2) between 50 and 75, 'High',IF(ROUND((topic_for_frequency * 100),2) between 25 and 50, 'Medium','Low'))) relevance FROM topic_to_for where topic_id = '$search_item'") or die('Test Data: ' . mysql_error()) ;
$result5 = mysql_query("SELECT count(a.pub_id) count_pubs  FROM pub_topic_astra a,publication b  where a.topic_id = '$search_item' and a.pub_id = b.pubid;")  or die('Test Data: ' . mysql_error()) ;
$result6 = mysql_query("SELECT count( distinct a.deidentified_staffid) from author_topic a, useraccount b where a.deidentified_staffid = b.id_org and a.topic_id = '$search_item'  ;") or die('Test Data: ' . mysql_error());                                                                                                                                                    


//$resultpg = pg_query($querypg) or die('Query failed: ' . pg_last_error());
//$resultpg2 =  pg_query($querypgtopic) or die('Query failed: ' . pg_last_error());
//$linepg2 = pg_fetch_array($resultpg2, null, PGSQL_ASSOC);

while($row2 = mysql_fetch_array($result2)){
         
        $topic_area = $row2['topic_area'];
}
        

echo "<html>";
echo "<body>";
echo '<form action="page_topic_result.php" method="post" >';
//echo "Search Topic:","<input type='text' name='search1' id='search1'  maxlength='50' />","</br>";
//echo "</br>";
//echo "<input type='submit' name='Submit' value='Submit' />";
echo "<br>";
echo "<br>";
echo "<font size=3>","Topic ID: ", $search_item,"</a></font>";
echo "<br>";
echo "<br>";
echo "<table border='1'>";
echo "<tr>";
echo "<th>Topic Name</th>";
echo "</tr>";
echo "<td>",$topic_area,"</td>";
echo "</tr/>";
echo "</table>";
echo "<br>";
echo "<br>";


echo "Relevant FoR Codes:";
echo "<table border='1'>";
echo "<tr>";
echo "<th>FoR Code</th>";
echo "<th>FoR Description</th>";
echo "</tr>";
echo "<br>";
echo "<br>";
while ($row4 = mysql_fetch_array($result4)) {
        echo "<td>",$row4["for_code"],"</td>";
        echo "<td>",$row4["for_desc"],"</td>";
      
                        
        echo "</tr/>";
        $count++;
  }
echo "</table>";


echo "Relevant Publications and Authors";
echo "<table border='1'>";
echo "<tr>";
echo "<th>Number of Publications</th>";
echo "<th>Average Publications per topic</th>";
echo "</tr>";
echo "<br>";
echo "<br>";
while ($row5 = mysql_fetch_array($result5)) {
       echo "<td>",$row5["count_pubs"],"</td>";
       echo "<td>",112,"</td>";
                
                
       echo "</tr/>";
       $count++;
                                  }
echo "</table>";
                                                                          





echo "List of Relevant ANU Publications:";
echo "<br>";
echo "<br>";

echo "<table border='1'>";
echo "<tr>";
echo "<th>Publication Title</th>";
echo "<th>Publication Year</th>";
echo "<th>Source</th>";
echo "</tr>";


while ($row3 = mysql_fetch_array($result3)) {
        echo "<td>",$row3["title"],"</td>";
        echo "<td>",$row3["yearpublished"],"</td>";
        echo "<td>",$row3["source"],"</td>";
                                                       
        echo "</tr/>";
        $count++;
}
echo "</table>";


echo "<br>";
echo "List of ANU people with relevant Publications:","<br>";

echo "<table border='1'>";
echo "<tr>";
echo "<th>Fullname</th>";
echo "<th>Address</th>";
echo "<th>Publication Count</th>";
echo "</tr>";
	


        
	
	while ($row = mysql_fetch_array($result)) {
		//foreach ($linepg as $col_value) {
			echo "<tr>";
		
		
			
			
			
			
			echo "<td>",$row["title"]," " ,$row["first_name"]," ",$row["family_name"],"</td>";
			echo "<td>",$row["address"],"</td>";
			echo "<td>",$row["publication_count"],"</td>"; 
			
			echo "</tr/>";			
			
			
			
			$count++;
;
	
			
			
		//}
	}
	//pg_free_result($resultpg);
	//pg_close($dbhpg);
	
	echo "</table>";
echo "<br>";



//echo '<input type="submit" value="Finalize Profile" name="FinalizeProfile"><br/>';
echo "</body>";
echo "</html>"; 
	//echo "</div>";


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
