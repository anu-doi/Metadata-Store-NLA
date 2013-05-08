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

 A page describing the user profile
 
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
    
<form  method="post" action="">
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
$uniid= $_SESSION['universityid'];
if ($_SESSION['logged_in']){
	$result = mysql_query("SELECT distinct a.staffnumber,a.id_org,a.title,a.first_name,a.family_name,a.address,a.email,a.www,a.description,a.tel,a.fax,a.for1,a.for2,a.for3, a.job_title  FROM useraccount a where  a.staffnumber = '$uniid' ; ") or die('Test Data: ' . mysql_error());
	$result2 = mysql_query("select distinct  a.pubtype,a.title pubtitle,a.yearpublished,a.source from publication a, pub_to_authors c where a.pubid = c.pubid and c.staffnumber = '$uniid' order by a.yearpublished;") or die('Test Data: ' . mysql_error());		
	$result3 = mysql_query("SELECT distinct b.nla_id  FROM useraccount a, oai_records b  where  a.staffnumber = '$uniid' and a.id_org = b.ori_id ; ") or die('Test Data: ' . mysql_error());
	$result4 = mysql_query("SELECT distinct b.scopus_auth_id  FROM useraccount a, mapping_scopus_anu_author_id b  where  a.staffnumber = '$uniid' and a.staffnumber = b.staffnumber ; ") or die('Test Data: ' . mysql_error());	
	//$result5 = mysql_query("SELECT distinct ariesgrantid, grant_title from grant_detail where staffid = '$uniid'");
	
	$result5 = mysql_query("SELECT distinct proportion_weight,replace(topic_area,' ',' , ') topic_area,topic_id, proportion FROM author_topic where staff_number= '$uniid'  order by  proportion_weight desc limit 3") or die('Test Data: ' . mysql_error());
        $result6 = mysql_query("SELECT distinct a.staffnumber,a.for1,b.for_description  FROM useraccount a,for_seo_code b  where  a.staffnumber = '$uniid' and  (a.for1 = b.for_code)  ") or die('Test Data: ' . mysql_error());	
        $result7 = mysql_query("SELECT distinct a.staffnumber,a.for2,b.for_description  FROM useraccount a,for_seo_code b  where  a.staffnumber = '$uniid' and  (a.for2 = b.for_code)  ") or die('Test Data: ' . mysql_error());
        $result8 = mysql_query("SELECT distinct a.staffnumber,a.for3,b.for_description  FROM useraccount a,for_seo_code b  where  a.staffnumber = '$uniid' and  (a.for3 = b.for_code)  ") or die('Test Data: ' . mysql_error());
        $result9 = mysql_query("SELECT distinct ariesgrantid, grant_title,funds_provider from grant_detail where staffid = '$uniid'");
        $result10 = mysql_query("select yearpublished, count(*) count_pubs from publication a, pub_to_authors c where a.pubid = c.pubid and c.staffnumber = '$uniid' group by yearpublished") or die('Test Data: ' . mysql_error());	
}
else 
{
	echo "Please go back to previous page";
}



// get the details using the UID:

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

while($row6 = mysql_fetch_array($result6)){
	$for1_desc = $row6['for_description'];	
}

while($row7 = mysql_fetch_array($result7)){
	$for2_desc = $row7['for_description'];
}

while($row8 = mysql_fetch_array($result8)){
	$for3_desc = $row8['for_description'];

}


$count = 1;

while($row = mysql_fetch_array($result)){
        echo "<br>","<font size='3'>", "Hi  ",$row['title']," ",$row['family_name']," ", ", you are logged in now.  ","</font>","</br>";
		
		
        echo "</br>";
	echo "<h1>","<cite>",$row['title'],"</cite>"," ","<cite>",$row['first_name'],"</cite>"," ","<cite>",$row['family_name'],"</cite>","</h1>";
	echo "<br>","<img  src='./images/no-profile-man.jpg' alt='Jobs' width='150' height='150'>","</img>",
	"<div class='ex'>";
	$colour1="#0000FF";
	$colour2="#00FFFF";
	echo "<br>";
	
	echo "Fields Of Research: ";
	echo "<ul>";
	if ($for1_desc!=""){
	
	                echo "<li>",$for1_desc,"</li>";
	}
	                        
	if ($for2_desc!=""){
	                                
	                echo "<li>",$for2_desc,"</li>";
	}
	                                                        
	if ($for3_desc!=""){
	                echo "<li>",$for3_desc,"</li>";
	}
	echo "</ul>";
	
	
	echo "Research themes :";
	echo "<br>";
	echo "<ul>";
	while ($row5 = mysql_fetch_array($result5)) {
		//foreach ($linepg as $col_value) {
			echo "<br>";
			//echo "<ul>";
			//echo "Research Themes";
			
			$topic_id = $row5['topic_id'];
			$topic_areas =  $row5['topic_area'];
			echo "<li>","<font size=3>","<a href=\"page_topic_specific_result.php?topic_id=".$topic_id."\">",$topic_id,": ",$row5['topic_area'],"</a></font>","</li>";
			$count++;

	
			
			
		//}
	}
	echo "</ul>";
	echo "</div>";
	/*
	echo "<br>","<label id='labely' >","</label>","<br/>";
	echo "</br>";
	*/
	//echo "</br>";
 	//echo "</br>";
	
	//echo "<h1>","<cite>",$row['title'],"</cite>"," ","<cite>",$row['first_name'],"</cite>"," ","<cite>",$row['family_name'],"</cite>","</h1>";
	//echo "<br>","<img src='./images/no-profile-man.jpg' alt='Jobs' width='150' height='220'>","<br/>";
	//echo "<br>";
	echo "<br>","Biography:   ","<p align='justify'>",$row['description'],"</p>","<br/>";
	
	echo "<label id='labelx' for='StaffNumber'>","Staff Number:","</label>",
	$row['staffnumber'],"<br>";
	echo "<br>";
	
	echo "<label id='labelx' for='DeidentifiedStaffID'>","Deidentified Staff ID:","</label>",
	$row['id_org'],"<br>";
	echo "<br>";

	echo "<label id='labelx' for='nlaid'>","NLA ID:","</label>",
	"<a ", "href='",$nlaid,"'>",$nlaid,"</a>","<br/>"; 	
	echo "<br>";
	
	echo "<label id='labelx' for='nlaid'>","Job Title:","</label>",
	$row['job_title'],"<br/>"; 	
	echo "<br>";
	
	echo "<label id='labelx' for='title'>","Title:   ","</label>",
	$row['title'],"<br/>"; 
	echo "<br>";
	
	echo "<label id='labelx' for='firstname'>","First name:   ","</label>",
	$row['first_name'],"<br/>";
	echo "<br>";
	
	echo "<label id='labelx' for='lastname'>","Last name:   ","</label>",
	$row['family_name'],"<br/>";
	echo "<br>";

	echo "<label id='labelx' for='address'>","Address:   ","</label>",
	$row['address'],"<br/>";
	echo "<br>";
	
	echo "<label id='labelx' for='email'>","Email:   ","</label>",
	$row['email'],"<br/>";
	echo "<br>";
	
	echo "<label id='labelx' for='email'>","URL:   ","</label>",
	"<a ", "href='",$row['www'],"'>",$row['www'],"</a>","<br/>"; 	
	echo "<br>";
	
	echo "<label id='labelx' for='telephone'>","Telephone:   ","</label>",
	$row['tel'],"<br/>";
	echo "<br>";
	
	echo "<label id='labelx' for='fax'>","Fax:   ","</label>",
	$row['fax'],"<br/>";
	echo "<br>";
	
	

   while($row4 = mysql_fetch_array($result4)){
	    $scopus_auth_id = $row4['scopus_auth_id'];
   echo "<label id='labelx' for='scopus_auth_id'>","Scopus Author ID:   ","</label>",
     "<a ", "href='http://www.scopus.com/authid/detail.url?authorId=",$scopus_auth_id,"'>",	  $scopus_auth_id,"</a>","<br/>"; 	
	echo "<br>";   
	
   }
	
	
	
	echo "<label id='labelx' for='for1'>","Fields of Research Code 1:   ","</label>",
	$row['for1'],"<br/>";
	echo "<br>";
	
	echo "<label id='labelx' for='for2'>","Fields of Research Code 2:   ","</label>",
	$row['for2'],"<br/>";
	echo "<br>";
	
	echo "<label id='labelx' for='for3'>","Fields of Research Code 3:   ","</label>",
	$row['for3'],"<br/>";
	echo "<br>";
	
	
	
	// Two different processes for the existing and the  new people record:
	 	                                	

	
}

?>
<!--
<br>
<br>
<script type="text/javascript" src="https://www.google.com/jsapi">
</script>
<script type="text/javascript">

google.load('visualization', '1', {packages: ['corechart']});
google.setOnLoadCallback(drawChart);

</script>

<script type="text/javascript">
        function drawChart() {
                        var data = google.visualization.arrayToDataTable([
                                ['Year', 'All Publications'],

<?php
while($row10 = mysql_fetch_array($result10)){
	if($row10['yearpublished']=="2008"){
		$tot_pubs_2008 = $row10['count_pubs'];
	}
	elseif($row10['yearpublished']=="2009"){
		$tot_pubs_2009 = $row10['count_pubs'];
	}
	elseif($row10['yearpublished']=="2010"){
		$tot_pubs_2010 = $row10['count_pubs'];
	}
	elseif($row10['yearpublished']=="2011"){
		$tot_pubs_2011 = $row10['count_pubs'];
	}
	elseif($row10['yearpublished']=="2012"){
		$tot_pubs_2012 = $row10['count_pubs'];
	}
}
	echo $tot_pubs_2008;

		echo "['2008', $tot_pubs_2008, ],";
		echo "['2009', $tot_pubs_2009,      ],";
		echo "['2010', $tot_pubs_2010,      ],";
		echo "['2011', $tot_pubs_2011,      ],";
		echo "['2012', $tot_pubs_2012,      ]";
		echo "])";

?>
		var options = {
			 title : 'Publications by type',
			 hAxis: {title: 'Year', titleTextStyle: {color: 'red'}}
		};
		var chart = new google.visualization.ColumnChart(document.getElementById('chart_divs'));
		 chart.draw(data, options);
	}
	google.setOnLoadCallback(drawChart);
	
</script>
<div id="chart_divs" style="width: 900px; height: 500px;"></div>
-->
<?php
	
			

echo "<br>";
echo "<br>";
echo "<a href='http://dc7-dev2.anu.edu.au/oai/oai2.php?verb=ListRecords&metadataPrefix=rif'> Please click on this link to see the OAI-PMH result</a>","</br>";
echo "<a href='http://dc7-dev2.anu.edu.au/anu_template/page_edit_desc.php'> Please click on this link to edit the profile </a>","</br>";
echo "<br>";
echo "<br>","List of Publications:","<br>";
echo "<br>";
echo "<html>";
echo "<body>";
echo "<table border='1'>";
echo "<tr>";
//echo "<th>Include ?</th>";
echo "<th>Publication Type</th>";
echo "<th>Publication Title</th>";
echo "<th>Year Published</th>";
echo "<th>Source Title</th>";
echo "</tr>";
//echo '<form action="http://dc7-dev2.anu.edu.au/oai/oai2.php?verb=ListRecords&metadataPrefix=rif" method="post">';
while($row2 = mysql_fetch_array($result2))
  {
	$valuetextbox = "V-".$row2["pubid"];
	
	//Checkbox = C $row2['pubid'];
	echo "<tr>";
	//echo "<td>",'<input type="checkbox" name="pubidcheck[]" value=',$valuetextbox,'>',"</td>";    	
	echo "<td>",$row2['pubtype'],"</td>"; 
	echo "<td>",$row2['pubtitle'],"</td>"; 
	echo "<td>",$row2['yearpublished'],"</td>";
	echo "<td>",$row2['source'],"</td>";
	
	echo "</tr/>";	
  }
echo "</table>";
echo "<br>";
echo "<br>","List of Grants: ","<br>";
echo "<br>";
echo "<table border='1'>";
echo "<tr>";
echo "<th>Grant ID</th>";
echo "<th>Grant Title</th>";
echo "<th>Primary Funds Provider </th>";
echo "</tr>";
while($row9 = mysql_fetch_array($result9))
  {
  	echo "<tr>";
  	echo "<td>",$row9['ariesgrantid'],"</td>";
  	echo "<td>",$row9['grant_title'],"</td>";
  	echo "<td>",$row9['funds_provider'],"</td>";
  	echo "</tr/>";
 
  	 
  	
  }
echo "</table>";
echo "<br>";  





//echo '<input type="submit" value="Finalize Profile" name="FinalizeProfile"><br/>';
echo "</body>";
echo "</html>"; 


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
