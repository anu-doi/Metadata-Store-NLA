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
?>

<!-- Start of Menu 1-->
	<div class="menu-flat menu-main">
		<p><?php echo $SiteShortName ?></p>
		<ul id="nav-1">
			<li><a href="page_login.php">Home</a></li>
			<!--- <li><a href="***menu item 2 file***">***Menu Item 2***</a></li> -->
			<!-- <li><a href="***menu item 3 file***">***Menu Item 3***</a> -->
				<ul>
			<!--		<li><a href="***">***Sub item 1***</a></li> -->
			<!--		<li><a href="***">***Sub item 2***</a></li> -->
				</ul>
			</li>	
           
            
            
			<!-- <li><a href="***menu item 4 file***">***Menu Item 3***</a></li> -->
		</ul>	
	</div>
<!-- End of Menu 1-->

<!--Start of Menu 2-->	
	<div class="menu-flat menu-grey">
		<!-- <p>***Insert Menu 2 Title***</p> -->
		<ul id="nav-2">
		<!--	<li><a href="***file***">***menu item 1***</a></li> -->
		</ul>	
	</div>
<!--End of Menu 2-->

<!-- don't touch-->	
<!-- endnoindex -->	
</div>
</div>
<div id="content">		