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

 A Login Page
 
 Version 	Date		Developer
 1.0        30-04-2013      Irwan Krisna  (IK) Initial 


*/ 

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
