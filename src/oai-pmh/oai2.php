<?php
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
* This is an implementation for an OAI-PMH 2.0 Data Provider 
* (sometimes, repository is used exchangeablly) written in PHP.
*  http://code.google.com/p/oai-pmh-2/
 * Principal Developer:
 * author Jianfeng Li
 * The Plant Accelerator<br>
*  University of Adelaide 
 version 1.1
 * \date 2010-2011
 * 
 *  
 Australian National University Metadata Store
 Version 	      Date		  Modification made by 
 version 2.0    30-4-2013        Irwan Krisna @ Australian National University 
 
 * 
 *
 *    


*/

/**
 * \file oai2.php
 * \brief
 * OAI Data Provider command processor
 *
 * OAI Data Provider is not designed for human to retrieve data.
 *
 * This is an implementation of OAI Data Provider version 2.0.
 * @see http://www.openarchives.org/OAI/2.0/openarchivesprotocol.htm
 * 
 * It needs other files:
 * - oaidp-config.php : Configuration of provider
 * - oaidp-util.php : Utility functions
 * - xml_creater.php : XML generating functions
 * - Actions:
 * 	- identify.php : About the provider
 * 	- listmetadataformats.php : List supported metadata formats
 * 	- listrecords.php : List identifiers and records
 * 	- listsets.php : List sets
 * 	- getrecord.php : Get a record
 *		- Your own implementation for providing metadata records.
 *
 * It also initiates:
 *	- PDO datbase connection object $db.
 *	- ANDS_XML XML document handler $outputObj.  
 *
 * \todo <b>Remember:</b> to define your own classess for generating metadata records.
 * In common cases, you have to implement your own code to act fully and correctly.
 * For generic usage, you can try the ANDS_Response_XML defined in xml_creater.php.
 */
 
// Report all errors except E_NOTICE
// This is the default value set in php.ini
// If anything else, try them.
// error_reporting (E_ALL ^ E_NOTICE);

/**
 * An array for collecting erros which can be reported later. It will be checked before a new action is taken.
 */
$errors = array();

/**
 * Supported attributes associate to verbs.
 */
$attribs = array ('from', 'identifier', 'metadataPrefix', 'set', 'resumptionToken', 'until');

if (in_array($_SERVER['REQUEST_METHOD'],array('GET','POST'))) {
		$args = $_REQUEST;
} else {
	$errors[] = oai_error('badRequestMethod', $_SERVER['REQUEST_METHOD']);
}

require_once('oaidp-util.php');
// Always using htmlentities() function to encodes the HTML entities submitted by others.
// No one can be trusted.
foreach ($args as $key => $val) {
	$checking = htmlspecialchars(stripslashes($val));
	if (!is_valid_attrb($checking)) {
		$errors[] = oai_error('badArgument', $checking);
	} else {$args[$key] = $checking; }
}
if (!empty($errors)) {	oai_exit(); }

foreach($attribs as $val) {
	unset($$val);
}

require_once('oaidp-config.php');

// Create a PDO object
try {
		$db = new PDO('mysql:host=localhost;dbname=oaidb', 'irwan', '');
    
} catch (PDOException $e) {
    exit('Connection failed: ' . $e->getMessage());
}

// For generic usage or just trying:
// require_once('xml_creater.php');
// In common cases, you have to implement your own code to act fully and correctly.
require_once('ands_tpa.php');

// Default, there is no compression supported
$compress = FALSE;
if (isset($compression) && is_array($compression)) {
	if (in_array('gzip', $compression) && ini_get('output_buffering')) {
		$compress = TRUE;
	}
}

if (SHOW_QUERY_ERROR) {
	echo "Args--:\n"; print_r($args);
}

if (isset($args['verb'])) {
	switch ($args['verb']) {

		case 'Identify':
			// we never use compression in Identify
			$compress = FALSE;
			if(count($args)>1) {
				foreach($args as $key => $val) {
					if(strcmp($key,"verb")!=0) {
						$errors[] = oai_error('badArgument', $key, $val);
					}	
				}
			}
			if (empty($errors)) include 'identify.php';
			break;

		case 'ListMetadataFormats':
			$checkList = array("ops"=>array("identifier"));
			checkArgs($args, $checkList);
			if (empty($errors)) include 'listmetadataformats.php';
			break;

		case 'ListSets':
			if(isset($args['resumptionToken']) && count($args) > 2) {
					$errors[] = oai_error('exclusiveArgument');
			}
			$checkList = array("ops"=>array("resumptionToken"));
			checkArgs($args, $checkList);
			if (empty($errors)) include 'listsets.php';
			break;

		case 'GetRecord':
			$checkList = array("required"=>array("metadataPrefix","identifier"));
			checkArgs($args, $checkList);
			if (empty($errors)) include 'getrecord.php';
			break;

		case 'ListIdentifiers':
		case 'ListRecords':
			if(isset($args['resumptionToken'])) {
				if (count($args) > 2) {
					$errors[] = oai_error('exclusiveArgument');
				}
				$checkList = array("ops"=>array("resumptionToken"));
			} else {
				$checkList = array("required"=>array("metadataPrefix"),"ops"=>array("from","until","set"));
			}
			checkArgs($args, $checkList);
			if (empty($errors)) include 'listrecords.php';
			break;

		default:
			// we never use compression with errors
			$compress = FALSE;
			$errors[] = oai_error('badVerb', $args['verb']);
	} /*switch */
} else {
	$errors[] = oai_error('noVerb');
}

if (!empty($errors)) {	oai_exit(); }

if ($compress) {
	ob_start('ob_gzhandler');
}

header(CONTENT_TYPE);

if(isset($outputObj)) {
	$outputObj->display();
} else {
	exit("There is a bug in codes");
}

	if ($compress) {
		ob_end_flush();
	}

?>
