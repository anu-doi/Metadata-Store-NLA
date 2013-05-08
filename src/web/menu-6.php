<?php session_start();


?>

<?php // Menu Template version 3.3

// each menu must have a unique id.
// e.g. the first menu is id="nav-1", the second menu is id="nav-2" and so on.

?>
<!-- noindex -->
<!-- stops ANU search from treating the menu as content-->
<div id="menu">
<div class="narrow">


<?php
if($DisplaySearch) {
	echo $SearchBox;
}

$con = mysql_connect("localhost","irwan","");
if (!$con)
  {
    die('Could not connect: ' . mysql_error());
  }
      
$deidentified_staffid= $_GET[deidentified_staffid];
$uniid= $_SESSION['universityid'];
      
mysql_select_db("oaidb", $con);
// to get 15 people with similar research: 
 $result = mysql_query(" SELECT a.topic_area,a.deidentified_staffid,a.proportion_weight,b.title,b.first_name,b.family_name,b.address from author_topic a, useraccount b where a.deidentified_staffid = b.id_org and a.topic_id = (SELECT topic_id from author_topic where proportion_weight in (SELECT MAX(proportion_weight) FROM author_topic where deidentified_staffid= '$deidentified_staffid') and deidentified_staffid= '$deidentified_staffid' limit 1) and b.id_org!= '$deidentified_staffid' order by a.proportion_weight desc limit 15; ")  or die('Test Data: ' . mysql_error());

      


?>

<!-- Start of Menu 1-->
	<div class="menu-flat menu-main">
		<p><?php echo $SiteShortName ?></p>
		<ul id="nav-1">
			<li><a href="page.php">Home</a></li>
			<li><a href="page_edit_desc.php">Edit Researcher Profile</a></li>
   			<li><a href="page_search.php">Search for people</a></li>            
   			<li><a href="page_search_topic.php">Search for topic</a></li>
			<li><a href="http://dc7-dev2.anu.edu.au/oai/oai2.php?verb=ListRecords&metadataPrefix=rif">OAI-PMH</a> 
			
				<ul>
			<!--		<li><a href="***">***Sub item 1***</a></li> -->
			<!--		<li><a href="***">***Sub item 2***</a></li> -->
				</ul>
			</li>	
			<li><a href="page_edit_bibtex.php">Import Publications Data - BibTex Format</a></li>
			  <li><a href="logout.php">Logout--</a></li> 
             
		</ul>	
	</div>
<!-- End of Menu 1-->

<br>



<!--Start of Menu 2-->	
<?php
	echo "<div class='menu-flat menu-grey'>";
	echo "<p>";
	echo $SiteSubMenu2;
	echo "</p>";
	//echo "<ul id='nav-2'>";
	while ($row = mysql_fetch_array($result)){
	
		$topic_id = $row5['topic_id'];
		
	
	

		//<!-- <p>***Insert Menu 2 Title***</p> -->
	echo "<ul id='nav-2'>";
		
        echo "<li>","<a href='page_person.php?deidentified_staffid=",$row['deidentified_staffid'],"'>",$row['title']," ", $row['first_name'], " ", $row['family_name'],"</a>","</li>";
		
        //echo "<li>","<a href='page_edit_desc.php'>","Edit Researcher Profile","</a>","</li>";
		//<!--	<li><a href="***file***">***menu item 1***</a></li> -->
	echo "</ul>";
	//echo "</div>";
	}
	
	echo "</div>";
	
?>
<!--End of Menu 2-->

<!-- don't touch-->	
<!-- endnoindex -->	
</div>
</div>
<div id="content">		