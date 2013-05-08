<?php // Page Template version 3.3

// PLEASE UPDATE THESE VALUES FOR EVERY PAGE
// -----------------------------------------------------------------------------
$title			= '';
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
include $Menu;


// BEGIN: Page Content
// =============================================================================
?>




	<div class=narrow">
		<h1><?php echo $title; ?></h1>
	</div>	
    
<?php 
//<!-- START MAIN PAGE CONTENT -->	


echo "<html>";
echo "<body>";
//echo "<div>";
echo "<form id='login' action='loginproc.php' method='get' accept-charset='UTF-8'>";
echo "<fieldset>";
echo "<legend>","Login","</legend>";
echo "<input type='hidden' name='submitted' id='submitted' value='1'/>";
//echo "<label for='username' >","UserName:","</label>","</br>";
echo "UserName:","<input type='text' name='username' id='username'  maxlength='50' />","</br>";
//echo "<label for='password' >","Password*:","</label>","</br>";
echo "</br>";
echo "Password :","<input type='password' name='password' id='password' maxlength='50' />","</br>";
echo "</br>";
echo "<input type='submit' name='Submit' value='Submit' />";
echo "</br>";
echo "</fieldset>";

echo "</body>";
echo "</form>";
//echo "<div>";
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
