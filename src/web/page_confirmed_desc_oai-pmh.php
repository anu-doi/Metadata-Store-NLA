<?php session_start(); ?>
<?php // Page Template version 3.3

// PLEASE UPDATE THESE VALUES FOR EVERY PAGE
// -----------------------------------------------------------------------------
$title			= 'Research Profile';
$description	= 'Research Activities';
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
    
<?php

$con = mysql_connect("localhost","irwan","");
if (!$con)
  {
  die('Could not connect: ' . mysql_error());
  }



mysql_select_db("oaidb", $con);
$aDoor = $_POST['pubidcheck'];

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


if($_POST[pubidnext]!= ""){
	
	$resultfirst = mysql_query("SELECT distinct  id_org,title,first_name,family_name,address,email,www,description,for1,for2,for3 FROM useraccount where staffnumber like '$_POST[pubidnext]' ; ") or die('Cannot view useraccount data: ' . mysql_error());


	// Define a public variable:

	while($row = mysql_fetch_array($resultfirst)){
			$id_org_db = $row['id_org'];
			$person_title = $row['title'];
			
	}


        //if($_POST[DescUpdated]!="Enter your Latest Description"){
        //    $resultDesc = mysql_query("update useraccount set description = '$_POST[DescUpdated]' where id_org like '$_POST[pubidnext]'; ")  or die('Cannot Update Description: ' .mysql_error()); 
        //}
         
	$result = mysql_query("SELECT distinct  id_org,title,first_name,family_name,address,email,www,description,for1,for2,for3 FROM useraccount where id_org like '$id_org_db' ; ") or die('Cannot view useraccount data: ' . mysql_error());
	$result2 = mysql_query("select distinct id_org,b.title persontitle,first_name,family_name,address,subject,description, pubid,a.title pubtitle,yearpublished,source from publication a, useraccount b where a.authorid = b.id_rep and b.id_rep  like '$id_org_db'  ; ") or die('publicationvand useraccount ' . mysql_error());
	$result3 = mysql_query("select ori_id from oai_records where ori_id like '$id_org_db' ; ") or die('Cannot view useraccount data: ' . mysql_error());
	
            
	
        if($result3=== TRUE){
	    echo "<br>",$row3['ori_id'],", ","'s"," profile already exist in the OAI-PMH database", "<br/>";
        }
        else{
				
			
         $person_id = "anu.edu.au/".$id_org_db;
		 
		// edit person's title if equal to nbsp because it may disrupt the XML generation
		if($person_title== "&nbsp"){
			mysql_query("update useraccount set title = null where staffnumber like '$_POST[pubidnext]%'; ")  or die('Cannot Update Description: ' .mysql_error());
		}
			
			
	    mysql_query("insert into oai_records values (null,'testprovider','$person_id',NOW(),'$person_id','class:party',NOW(),'false','this is a title','creator','CompScience','desc ','contributor','publisher1','2012-12-01','type1','format1','id2 ','source1','English ','relation1','coverage1','rights1','rif','useraccount','$id_org_db','person','',null,'')") or die('Cannot insert data-- already exist:  please see here the OAI-PMH page--' . mysql_error());
	    echo "<br>","Status: ",$_POST[pubidnext],"'s"," profile just been added  in the OAI-PMH database", "<br/>";
	    
	    
        }
	  
	    
}
else{
	echo "Please check the 'Confim' Button";
}

//echo "<br>","TEST",$_POST[pubidnext],"</br>";
if(($result === FALSE) or ($result2 === FALSE)) {
    die(mysql_error()); // TODO: better error handling
}

echo "<html>";
echo "<body>";
echo "<br>";
/*
echo "<h1>","<cite>",$row['title'],"</cite>",". ","<cite>",$row['family_name'],"</cite>",", ","<cite>",$row['first_name'],"</cite>","</h1>";
*/
echo "<br>", "The Profile has been finalized and updated in the OAI-PMH feed to the NLA", "</br>";
while($row = mysql_fetch_array($result)){
	
	echo "<br>","Deidentified Staff ID:   ",$row['id_org'],"<br/>"; 
	echo "<br>","Title:   ",$row['title'],"<br/>"; 
	echo "<br>","First Name:   ",$row['first_name'],"<br/>";
	echo "<br>","Last Name:   ",$row['family_name'],"<br/>";
	echo "<br>","Address:   ",$row['address'],"<br/>";
	echo "<br>","Email:   ",$row['email'],"<br/>";
	echo "<br>","URL:   ",$row['www'],"<br/>";
	echo "<br>","Fields of Research Code 1:   ",$row['for1'],"<br/>";
	echo "<br>","Fields of Research Code 2:   ",$row['for2'],"<br/>";
	echo "<br>","Fields of Research Code 3:   ",$row['for3'],"<br/>";
	echo "<br>","Description:   ",$row['description'],"<br/>";
	
	// Two different processes for the existing and the  new people record:
	 
	
    
        
          
          
	

	
}
echo "<br>";
echo "<a href='http://dc7-dev2.anu.edu.au/oai/oai2.php?verb=ListRecords&metadataPrefix=rif'> Please click on this link to see the OAI-PMH result</a>";
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
