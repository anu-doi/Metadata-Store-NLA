<?php session_start(); 


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
include $Menu2;



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
top:0px;
right:15px;
margin-left:7em;
text-align:left;
clear:left;
cursor:hand; 
float:right;
width:420px;
padding:10px;
border:2px solid gray;
margin:0px;
}

    
    
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
	$result = mysql_query("SELECT distinct a.staffnumber,a.id_org,a.title,a.first_name,a.family_name,a.address,a.email,a.www,a.description,a.tel,a.fax,a.for1,a.for2,a.for3, a.job_title  FROM useraccount a where  a.staffnumber =  '$uniid' ; ") or die('Test Data: ' . mysql_error());
	$result2 = mysql_query("select distinct  a.pubid,a.title pubtitle,a.yearpublished,a.source from publication a, pub_to_authors c where a.pubid = c.pubid and c.staffnumber = '$uniid' order by a.yearpublished;")  or die('Test Data: ' . mysql_error());
	$result3 = mysql_query("SELECT distinct b.nla_id  FROM useraccount a, oai_records b  where  a.staffnumber = '$uniid' and a.id_org = b.ori_id ; ") or die('Test Data: ' . mysql_error());
	$result4 = mysql_query("SELECT distinct b.scopus_auth_id  FROM useraccount a, mapping_scopus_anu_author_id b  where  a.staffnumber = '$uniid' and a.staffnumber = b.staffnumber ; ") or die('Test Data: ' . mysql_error());
	
	
}
else 
{
	echo "Please go back to previous page";
}


// Create connection to the PostGreSQL:



	


	


//$aDoor = $_POST['pubidcheck'];

//echo "check", $_POST[pubidnext];


//update the chosen publications:
/*
if(empty($aDoor))
  {
    echo("You didn't select anything.");
  }
  else
  {
    $N = count($aDoor);
	mysql_query("UPDATE publication a,useraccount b SET a.included = null  where b.id_org like '$_POST[pubidnext]'");
    //echo("You selected $N door(s): ");
    for($i=0; $i < $N; $i++)
    {
      //echo($aDoor[$i] . "---xxxx");
	  mysql_query("UPDATE publication SET included='yes' WHERE pubid = '$aDoor[$i]'") or die('Test Data: ' . mysql_error()) ;
    }
	//echo $_POST[pubidnext];
}
*/
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


$count = 1; 
$dbhpg = pg_connect("host=localhost port=9432 dbname=mapappdb user=mapappuser") or die("Could not connect" . pg_last_error());
$querypg = "SELECT distinct topic_id,topic_areas, proportion  FROM author_topic where LOWER(univ_id) = '$uniid'  and proportion > 10 order by proportion desc";
//queryaddition = "\copy author_topic from '/home/irwan/documents/ResearcherbyPubTopicVolAuthor.csv' CSV";


$resultpg = pg_query($querypg) or die('Query failed: ' . pg_last_error());


	

while($row = mysql_fetch_array($result)){
        echo "<br>","<font size='3'>", "Hi  ",$row['title']," ",$row['family_name']," ", ", you are logged in now.  ","</font>","</br>";
		
        
        echo "<table>\n";
        
			
		
        echo "</br>";
	echo "<h1>","<cite>",$row['title'],"</cite>"," ","<cite>",$row['first_name'],"</cite>"," ","<cite>",$row['family_name'],"</cite>","</h1>";
	echo "<br>","<img  src='./images/no-profile-man.jpg' alt='Jobs' width='150' height='220'>","</img>",
	"<div class='ex'>";
	$colour1="#0000FF";
	$colour2="#00FFFF";
	echo "Research Themes:";
	echo "<br>";

	while ($linepg = pg_fetch_array($resultpg, null, PGSQL_ASSOC)) {
		//foreach ($linepg as $col_value) {
			echo "<br>";
			//echo "<ul>";
			//echo "Research Themes";
			
			$topic_id = $linepg['topic_id'];
			$topic_areas =  $linepg['topic_areas'];
		
			
			
			echo "<font size=3>","<a href=\"page_topic_specific_result.php?topic_id=".$topic_id."\">",$linepg['topic_areas'],"</a></font>";
			//echo "<font size=3>","<a href=\"page_topic_specific_result.php?topic_id=".$topic_id."\">",$linepg['topic_areas'],"</a></font>"
			
			
			/*
			$url = "http://http://dc7-dev2.anu.edu.au/anu_template/page_topic_specific_result.php";
			
			
			$data = array(
				"topicid" => $linepg['topic_id']
				
			);
			
			$fields = '';
			foreach($data as $key => $value) {
			               $fields .= $key . '=' . $value . '&';
			}
			
			rtrim($fields, '&');
			                        
			$post = curl_init();
			
			curl_setopt($post, CURLOPT_URL, $url);
		        curl_setopt($post, CURLOPT_POST, count($data));
			curl_setopt($post, CURLOPT_POSTFIELDS, $fields);
			curl_setopt($post, CURLOPT_RETURNTRANSFER, 1);
			
			$result = curl_exec($post);
			curl_close($post);
			
			//echo "</ul>";
			echo "<br>";
					
			*/
			
			
			$count++;
;
	
			
			
		//}
	}
	pg_free_result($resultpg);
	pg_close($dbhpg);
	echo "</div>";
	echo "<br>","<label id='labely' >","</label>","<br/>";
	echo "</br>";
     echo "</br>";
 	echo "</br>";
	
		
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
echo "<th>Publication ID</th>";
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
	echo "<td>",$row2['pubid'],"</td>"; 
	echo "<td>",$row2['pubtitle'],"</td>"; 
	echo "<td>",$row2['yearpublished'],"</td>";
	echo "<td>",$row2['source'],"</td>";
	
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
