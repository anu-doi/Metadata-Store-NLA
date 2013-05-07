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
 * \brief Definition of Dublin Core handler.
 *
 * It is not working as it does not provide any content to the metadata node. It only included
 * to demonstrate how a new metadata can be supported. For a working
 * example, please see record_rif.php.
 *
 * \sa oaidp-config.php 
	*/

function create_metadata($outputObj, $cur_record, $identifier, $setspec, $db) {
	$metadata_node = $outputObj->create_metadata($cur_record);
}
