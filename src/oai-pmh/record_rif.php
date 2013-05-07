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

/** \file
 * \brief Definition of RIF-CS handler.
 *
 * It is a plug-in helper function which will be called from where a metadata in rif format is being generated.
 * The name of function defined here cannot be changed.
 * This can also be used as an example for your own metadata strucutre:
 * - create a metetadata node
 * - append contents of the record to the metedata node
 *
 * In this example, every time when a new record is being generated, a new instance of ANDS_TPA is created.
 * As XML output document and the database connection are the same, it is possible to design otherwise.
 *
 * \sa oaidp-config.php
	*/

// This handles RIF-CS records, but can be also used as a sample
// for other formats.
// Just define this function as template to deal your metadata records.

// Create a metadata object and a registryObjects, and its only child registryObject
function create_metadata($outputObj, $cur_record, $identifier, $setspec, $db) {
	// debug_message('In '.__FILE__.' function '.__FUNCTION__.' was called.');

	// debug_var_dump('metadata_node',$metadata_node);
 	$metadata_node = $outputObj->create_metadata($cur_record);
	$obj_node = new ANDS_TPA($outputObj, $metadata_node, $db);
	try {
		$obj_node->create_obj_node($setspec, $identifier);
	} catch (Exception $e) {
			echo 'Caught exception: ',  $e->getMessage(), " when adding $identifier\n";
	}
}

