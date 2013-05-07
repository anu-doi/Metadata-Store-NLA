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
 * \file
 * \brief Response to Verb ListMetadataFormats
 *
 * The information of supported metadata formats is saved in database and retrieved by calling function <B>idFormatQuery</B>.
 * \sa idFormatQuery
 */

/**
 * Add a metadata format node to an ANDS_Response_XML
 * \param &$outputObj
 *	type: ANDS_Response_XML. The ANDS_Response_XML object for output.
 * \param $key
 * 	type string. The name of new node.
 * \param $val
 * 	type: array. Values accessable through keywords 'schema' and 'metadataNamespace'.
 *
 */
function addMetedataFormat(&$outputObj,$key,$val) {
	$cmf = $outputObj->add2_verbNode("metadataFormat");
	$outputObj->addChild($cmf,'metadataPrefix',$key);
	$outputObj->addChild($cmf,'schema',$val['schema']);
	$outputObj->addChild($cmf,'metadataNamespace',$val['metadataNamespace']);
}

if (isset($args['identifier'])) {
	$identifier = $args['identifier'];
	$query = idFormatQuery($identifier);
	$res = $db->query($query);
 	if ($res==false) {
		if (SHOW_QUERY_ERROR) {
			echo __FILE__.','.__LINE__."<br />";
			echo "Query: $query<br />\n";
			die($db->errorInfo());
		} else {
			$errors[] = oai_error('idDoesNotExist','', $identifier);
		}
	} else {
		$record = $res->fetch();
		if($record===false) {
			$errors[] = oai_error('idDoesNotExist', '', $identifier);
		} else {
			$mf = explode(",",$record[$SQL['metadataPrefix']]);    
		}
	}
}

//break and clean up on error
if (!empty($errors)) oai_exit();

$outputObj = new ANDS_Response_XML($args);
if (isset($mf)) {
	foreach($mf as $key) {
		$val = $METADATAFORMATS[$key];
		addMetedataFormat($outputObj,$key, $val);
	}
} elseif (is_array($METADATAFORMATS)) {
		foreach($METADATAFORMATS as $key=>$val) {
			addMetedataFormat($outputObj,$key, $val);
		}
}
else { // a very unlikely event
	$errors[] = oai_error('noMetadataFormats'); 
	oai_exit();
}
?>
