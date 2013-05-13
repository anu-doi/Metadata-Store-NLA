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

 A java program to harvest the NLA ID contributed by the ANU from the Trove Database. 
It also automatically update the NLA-ID into the database.
 
 Version 	Date		Developer
 1.0        30-04-2013      Irwan Krisna  (IK) Initial 


*/ 




// Importing various Java and SQL libraries    
import java.io.*;
import java.net.URL;
import java.util.*;
import java.text.*;
import java.sql.Connection;
import java.sql.DriverManager;
import java.sql.ResultSet;
import java.sql.SQLException;
import java.sql.Statement;
import java.sql.PreparedStatement;

// Importing Java XML parser related libraries
import javax.xml.parsers.DocumentBuilder;
import javax.xml.parsers.DocumentBuilderFactory;
import org.w3c.dom.Document;
import org.w3c.dom.Element;
import org.w3c.dom.Node;
import org.w3c.dom.NodeList;



public class NLAIDHarvester {
	
	public NLAIDHarvester (int a){
		int x = a;
	}
	
	public static String firstname;
	public static String surname;
	public static String personID;
	public static String url;
	public static String nlaID;
	
	
	// to get the detail of a person:
	public static String [][][][]personDetail ;
	
	// a method to set the current date 
	public String  showDate(){
		Locale currentLocale = new Locale("EN");
		Date today; // declaring the variable "today"
		String dateOut;
		DateFormat dateFormatter;
		dateFormatter = DateFormat.getDateInstance(DateFormat.DEFAULT, currentLocale);
		today = new Date();
		dateOut = dateFormatter.format(today);  
		return dateOut;
	}
	
   // read the XML returned data from the Trove application   
	public void interrogateWebsite(String surname, String personID, NLAHarvesterIKModified f ){
	     	
		     String dateNow = f.showDate();    
		     String strTemp = "";
		     String str1 = "/home/irwan/NLA-XML-Response";
		     String str3 = ".xml";
		     String xmlOutput = str1.concat(str3);
		 			
				try {
					String str6a = "http://www.nla.gov.au/apps/srw/search/peopleaustralia?query=cql.anywhere+%3D+%22anu.edu.au%2F";
					String str6b = str6a.concat(personID).concat("%22+and+pa.surname+%3D+%22").concat(surname).concat("%22&version=1.1&operation=searchRetrieve&recordSchema=info%3Asrw%2Fschema%2F1%2Fdc-v1.1&maximumRecords=10&startRecord=") ; 
	                                String sruQuery = str6b.concat("1").concat("&resultSetTTL=300&recordPacking=xml&recordXPath=&sortKeys=");   
		
					URL my_url = new URL(sruQuery);
					System.out.println("sruQuery: "  + sruQuery);
					BufferedReader br = new BufferedReader(new InputStreamReader(my_url.openStream()));
					while(null != (strTemp = br.readLine())){

						FileWriter fstream = new FileWriter(xmlOutput,true);
						BufferedWriter out = new BufferedWriter(fstream);
						out.write(strTemp); 
						out.close();
	
					} // END WHILE
				}// END TRY
				catch (Exception ex) {
					ex.printStackTrace();
				}

				try {  
	   
					File file = new File(xmlOutput);
					DocumentBuilderFactory dbf = DocumentBuilderFactory.newInstance();
					DocumentBuilder db = dbf.newDocumentBuilder();
					Document doc = db.parse(file);
					doc.getDocumentElement().normalize();
					System.out.println("Root element " + doc.getDocumentElement().getNodeName());
					NodeList nodeLst = doc.getElementsByTagName("record");
				
					String st;
					for (int s = 0; s < nodeLst.getLength(); s++) {
						Node fstNode = nodeLst.item(s);

						if (fstNode.getNodeType() == Node.ELEMENT_NODE) {

							Element fstElmnt = (Element) fstNode;
							NodeList fullNmElmntLst = fstElmnt.getElementsByTagName("title");
							Element fullNmElmnt = (Element) fullNmElmntLst.item(0);
							NodeList fullNm = fullNmElmnt.getChildNodes();
  
							st = ((Node) fullNm.item(0)).getNodeValue();
							st = st.replace("\n", "");

							NodeList ElmntLst = fstElmnt.getElementsByTagName("identifier");
							Element lstNmElmnt = (Element) ElmntLst.item(0);
							NodeList lstNm = lstNmElmnt.getChildNodes();
		   
							NodeList ElmntDesc = fstElmnt.getElementsByTagName("description");
							Element DescElmnt = (Element) ElmntDesc.item(0);
		  
							NodeList Desc = DescElmnt.getChildNodes();
							if(DescElmnt.getChildNodes().equals("[description: null]")){
								System.out.println("YAYYY: " + DescElmnt.getChildNodes());
							}
		   
							System.out.println(((Node) lstNm.item(0)).getNodeValue() + "\t"+ st + "\t" + ((Node) Desc.item(0)).getNodeValue() + "\n");
							
							// initialize NLA ID:
							nlaID = ((Node) lstNm.item(0)).getNodeValue();
							
						
							
							try {
								String fileOutputDir = "/home/irwan/OutputFinal";
								String fileOutput = fileOutputDir.concat("-").concat(dateNow).concat(".txt");
								FileWriter fstreamA = new FileWriter(fileOutput,true);
								BufferedWriter outA = new BufferedWriter(fstreamA);
								outA.write(((Node) lstNm.item(0)).getNodeValue() + "\t"+ st + "\t" + ((Node) Desc.item(0)).getNodeValue() + "\n");
								outA.close();
							
							}
							catch (IOException e){
			   
							} 
  
						} // END IF 
	   

					} // END The Inner FOR
				} catch (Exception e) {
					e.printStackTrace();
				}
				boolean success = (new File(xmlOutput)).delete(); // DELETE The output 

	} // End Interrogate website
	
	// the getMySQL should extract all the relevant data 
	
	public void getMySQL()  {
		Connection con = null;
		Statement stmt = null;
		ResultSet rs = null;
		PreparedStatement preparedStatement = null;
		
	
		try {
			Class.forName("com.mysql.jdbc.Driver") ;
			//System.out.println("MySQL JDBC driver loaded ok.");
			con = DriverManager.getConnection("jdbc:mysql://localhost/oaidb?"+ "user=irwan");
			//System.out.println("MySQL Access ok.");
			stmt = con.createStatement();
			rs = stmt.executeQuery("select ori_id, first_name, family_name, url from oai_records a, useraccount b where (a.nla_id is null or nla_id = '') and a.ori_id = b.id_org ");
			//System.out.println("MySQL Query ok.");
			while (rs.next()) {
				personID = rs.getString(1);
				firstname = rs.getString(2);
				surname = rs.getString(3);
				url = rs.getString(4);
				
				System.out.println(" person ID = " + personID);
				System.out.println(" First Name = " + firstname);
				System.out.println(" Family Name = " + surname);
				System.out.println(" url = " + url);

			}
			con.close();
		}
		catch (Exception e) {
			System.err.println("Exception: "+e.getMessage());
		}
	
		finally {
			if (rs != null) {
				try  {
					rs.close();
				}
				catch (SQLException sqlEx) {
				}
				stmt = null;
			}
		}// end finally	

	}
	
	public void updateMySQL (String personID, String nlaID)  {
	
		Connection conn = null;
		Statement statement = null;
		PreparedStatement preparedStatement = null;
		ResultSet resultSet = null;
		try {
			Class.forName("com.mysql.jdbc.Driver") ;
			conn = DriverManager.getConnection("jdbc:mysql://localhost/oaidb?"+ "user=irwan");
			preparedStatement = conn.prepareStatement("update oai_records set nla_id = ? where ori_id = ? ");
			preparedStatement.setString(1, nlaID);
			preparedStatement.setString(2, personID);
			preparedStatement.executeUpdate();
			
		
			conn.close();
		}
		catch (Exception e) {
			System.err.println("Exception: "+e.getMessage());
		}
		
		finally {
			if (resultSet != null) {
				try {
					resultSet.close();
				}	
				catch (SQLException sqlEx) {
				}
				statement = null;
			}
		}// end finally
		
		
	
	}
	public static void main(String argv[]) {		
		
		// To create an object Harvest 
		NLAIDHarvester nla = new NLAIDHarvester(1);
		
		// Process 1: To search for the people records whose NLA IDs to be harvested
		nla.getMySQL();
	
		//  check if there's any person records whose NLA IDs to be harvested:
		
		if(surname == null || personID == null){
		 	System.out.println("---- Notes: No NLA IDs to be searched for ----");
			return;
		}
		else {				
			// Process 2: To interrogate(crawl) website 
			nla.interrogateWebsite(surname,personID,new NLAHarvesterIKModified(1));
			System.out.println(nlaID);
			
			// Process 3: Update the NLA IDs in the  Database
			nla.updateMySQL(personID,nlaID);
		}
		
		
		
	
  
	}
}


