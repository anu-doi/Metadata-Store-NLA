#/*******************************************************************************
# * Australian National University Metadata Store
# * Copyright (C) 2013  The Australian National University
# * 
# * This file is part of Australian National University Metadata Store.
# * 
# * Australian National University Metadatastore is free software: you
# * can redistribute it and/or modify it under the terms of the GNU
# * General Public License as published by the Free Software Foundation,
# * either version 3 of the License, or (at your option) any later
# * version.
# * 
# * This program is distributed in the hope that it will be useful,
# * but WITHOUT ANY WARRANTY; without even the implied warranty of
# * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
# * GNU General Public License for more details.
# * 
# * You should have received a copy of the GNU General Public License
# * along with this program.  If not, see <http://www.gnu.org/licenses/>.
# ******************************************************************************/

#
# Australian National University Metadata Store
#
# Retrieve and Update Grants Information from the java Service
# Version 	Date		Developer
# 0.1           30-04-2012      Irwan Krisna  (IK) Initial 
#
#
#


invalue="$1"
sudo cp blank.txt GRANTS.txt

# Retrieve grants information from the Java Service:
sudo wget -O grants.output --header='Accept: application/xml' http://localhost:9080/services/rest/person/grants/$invalue

# Update the grants data to the NLA Party Identifier database:
sudo java ANUJavaServiceGrants $invalue|sort|uniq