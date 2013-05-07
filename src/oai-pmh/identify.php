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
 * \brief Response to Verb Identify
 *
 * Tell the world what the data provider is. Usually it is static once the provider has been set up.
 *
 * \see http://www.openarchives.org/OAI/2.0/guidelines-oai-identifier.htm for details
 */

// The response to Identify is fixed
if (SHOW_QUERY_ERROR) {
	echo "Here are some settings in raw format:\n";
  print_r($identifyResponse);
	echo 'MAXRECORDS ',MAXRECORDS, ', MAXIDS ', MAXIDS,"\n";
  echo 'Token is valid for ',TOKEN_VALID," seconds\n";
  echo 'Tokens have prefix: ',TOKEN_PREFIX,"\n";
  echo 'XMLSCHEMA: ',XMLSCHEMA,"\n";
  echo "\n";
}


$baseURL 			= "http://anu.edu.au/oai/oai2.php";
$identifyResponse["baseURL"] = MY_URI;

// do not change
$identifyResponse["protocolVersion"] = '2.0';
//irwan krisna(adjustment)
$adminEmail                     = array('krisna.irwan@gmail.com');
//$identifyResponse["adminEmail"] = 'irwan.krisna@gmail.com';
// MUST (only one)
// the earliest datestamp in your repository,
// please adjust
// Only date is needed even later it will be formatted according to the granularity.
$identifyResponse["earliestDatestamp"] = '2000-01-01';

// How your repository handles deletions
// no: 			The repository does not maintain status about deletions.
//				It MUST NOT reveal a deleted status.
// persistent:	The repository persistently keeps track about deletions 
//				with no time limit. It MUST consistently reveal the status
//				of a deleted record over time.
// transient:   The repository does not guarantee that a list of deletions is 
//				maintained. It MAY reveal a deleted status for records.
// 
// If your database keeps track of deleted records change accordingly.
// Currently if $record['deleted'] is set to 'true', $status_deleted is set.
// Some lines in listidentifiers.php, listrecords.php, getrecords.php  
// must be changed to fit the condition for your database.
$identifyResponse["deletedRecord"] = 'no'; 
$deletedRecord = $identifyResponse["deletedRecord"]; // a shorthand for checking the configuration of Deleted Records

// MAY (only one)
//granularity is days
//$granularity          = 'YYYY-MM-DD';
// granularity is seconds
$identifyResponse["granularity"] = 'YYYY-MM-DDThh:mm:ssZ';

// this is appended if your granularity is seconds.
// do not change
if (strcmp($identifyResponse["granularity"],'YYYY-MM-DDThh:mm:ssZ')==0) {
	$identifyResponse["earliestDatestamp"] = $identifyResponse["earliestDatestamp"].'T00:00:00Z';
}


$outputObj = new ANDS_Response_XML($args);

//Modified by Irwan Krisna "20120905"

/*
foreach($identifyResponse as $key => $val) {
	$outputObj->add2_verbNode($key, $val);
	$outputObj->add2_verbNode($key, $val);
	
	
}
$baseURL 			= "http://anu.edu.au/oai/oai2.php";
$identifyResponse["baseURL"] = MY_URI;
$identifyResponse["protocolVersion"] = '2.0';
$adminEmail                     = array('irwan.krisna@gmail.com');
$identifyResponse["earliestDatestamp"] = '2000-01-01';
$identifyResponse["deletedRecord"] = 'no'; 
$deletedRecord = $identifyResponse["deletedRecord"]; 
$identifyResponse["granularity"] = 'YYYY-MM-DDThh:mm:ssZ';
if (strcmp($identifyResponse["granularity"],'YYYY-MM-DDThh:mm:ssZ')==0) {
	$identifyResponse["earliestDatestamp"] = $identifyResponse["earliestDatestamp"].'T00:00:00Z';
}
*/
$outputObj->add2_verbNode("repositoryName", 'Australian National University');
$outputObj->add2_verbNode("baseURL", MY_URI);
$outputObj->add2_verbNode("protocolVersion", '2.0');
$outputObj->add2_verbNode("adminEmail", 'irwan.krisna@gmail.com');
$outputObj->add2_verbNode("earliestDatestamp", '2000-01-01');
$outputObj->add2_verbNode("deletedRecord", 'no');
$outputObj->add2_verbNode("granularity", 'YYYY-MM-DDThh:mm:ssZ');






//foreach($adminEmail as $val) {
//$outputObj->add2_verbNode("adminEmail", $val);
//}

if(isset($compression)) {
	foreach($compression as $val) {
		$outputObj->add2_verbNode("compression", $val);
	}
}

// A description MAY be included.
// Use this if you choose to comply with a specific format of unique identifiers
// for items. 
// See http://www.openarchives.org/OAI/2.0/guidelines-oai-identifier.htm 
// for details

// As they will not be changed, using string for simplicity.
$output = '';
if ($show_identifier && $repositoryIdentifier && $delimiter && $sampleIdentifier) {
	$output .= 
'  <description>
   <oai-identifier xmlns="http://www.openarchives.org/OAI/2.0/oai-identifier"
                   xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance"
                   xsi:schemaLocation="http://www.openarchives.org/OAI/2.0/oai-identifier
                   http://www.openarchives.org/OAI/2.0/oai-identifier.xsd">
    <scheme>oai</scheme>
    <repositoryIdentifier>'.$repositoryIdentifier.'</repositoryIdentifier>
    <delimiter>'.$delimiter.'</delimiter>
    <sampleIdentifier>'.$sampleIdentifier.'</sampleIdentifier>
   </oai-identifier>
  </description>'."\n"; 
}

// A description MAY be included.
// This example from arXiv.org is used by the e-prints community, please adjust
// see http://www.openarchives.org/OAI/2.0/guidelines-eprints.htm for details

// To include, change 'false' to 'true'.
if (false) {
	$output .= 
'  <description>
   <eprints xmlns="http://www.openarchives.org/OAI/1.1/eprints"
            xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance"
            xsi:schemaLocation="http://www.openarchives.org/OAI/1.1/eprints 
            http://www.openarchives.org/OAI/1.1/eprints.xsd">
    <content>
     <text>Author self-archived e-prints</text>
    </content>
    <metadataPolicy />
    <dataPolicy />
    <submissionPolicy />
   </eprints>
  </description>'."\n"; 
}

// If you want to point harvesters to other repositories, you can list their
// base URLs. Usage of friends container is RECOMMENDED.
// see http://www.openarchives.org/OAI/2.0/guidelines-friends.htm 
// for details

// To include, change 'false' to 'true'.
if (false) {
	$output .= 
'  <description>
   <friends xmlns="http://www.openarchives.org/OAI/2.0/friends/" 
            xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance"
            xsi:schemaLocation="http://www.openarchives.org/OAI/2.0/friends/
            http://www.openarchives.org/OAI/2.0/friends.xsd">
    <baseURL>http://naca.larc.nasa.gov/oai2.0/</baseURL>
    <baseURL>http://techreports.larc.nasa.gov/ltrs/oai2.0/</baseURL>
    <baseURL>http://physnet.uni-oldenburg.de/oai/oai2.php</baseURL>
    <baseURL>http://cogprints.soton.ac.uk/perl/oai</baseURL>
    <baseURL>http://ub.uni-duisburg.de:8080/cgi-oai/oai.pl</baseURL>
    <baseURL>http://rocky.dlib.vt.edu/~jcdlpix/cgi-bin/OAI1.1/jcdlpix.pl</baseURL>
   </friends>
  </description>'."\n"; 
}

// If you want to provide branding information, adjust accordingly.
// Usage of friends container is OPTIONAL.
// see http://www.openarchives.org/OAI/2.0/guidelines-branding.htm 
// for details

// To include, change 'false' to 'true'.
if (false) {
	$output .= 
'  <description>
   <branding xmlns="http://www.openarchives.org/OAI/2.0/branding/"
             xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance"
             xsi:schemaLocation="http://www.openarchives.org/OAI/2.0/branding/
             http://www.openarchives.org/OAI/2.0/branding.xsd">
    <collectionIcon>
     <url>http://my.site/icon.png</url>
     <link>http://my.site/homepage.html</link>
     <title>MySite(tm)</title>
     <width>88</width>
     <height>31</height>
    </collectionIcon>
    <metadataRendering 
     metadataNamespace="http://www.openarchives.org/OAI/2.0/oai_dc/" 
     mimeType="text/xsl">http://some.where/DCrender.xsl</metadataRendering>
    <metadataRendering
     metadataNamespace="http://another.place/MARC" 
     mimeType="text/css">http://another.place/MARCrender.css</metadataRendering>
   </branding>
  </description>'."\n";
}

if(strlen($output)>10) {
	$des = $outputObj->doc->createDocumentFragment();
	$des->appendXML($output);
	$outputObj->verbNode->appendChild($des);
}
?>
