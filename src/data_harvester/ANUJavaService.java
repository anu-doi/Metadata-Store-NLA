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

 Harvests People Information from the Java Service and updates the information to the backend. 
 Version 	Date		Developer
 0.1           30-04-2013      Irwan Krisna  (IK) Initial 


*/

 
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


import javax.xml.parsers.DocumentBuilder;
import javax.xml.parsers.DocumentBuilderFactory;
import org.w3c.dom.Document;
import org.w3c.dom.Element;
import org.w3c.dom.Node;
import org.w3c.dom.NodeList;
import org.w3c.dom.NamedNodeMap;



public class ANUJavaService {
	
  // set variables
	public static String StaffUnivID;
	public static String StaffAriesID;
	public static String StaffDeidentifiedAriesID;
	public static int countRecord;
	public static int countfor;
	public static int countforpercentage;

	public ANUJavaService (int a){
		int x = a;
	}
	
	public static String fullname;
	public static String givenname;
	public static String surname;
	public static String emailAddress;
	public static String orgunit;
	public static String jobtitle;
	public static String for1;
	public static String for2;
	public static String for3;
	public static String for1_pct;
	public static String for2_pct;
	public static String for3_pct;
	public static int intfor1_pct;
	public static int intfor2_pct;
	public static int intfor3_pct;
	public static String For[] =  new String[2];
	public static int intForPercent[] =  new int[2];
	
	
		
	public static String nlaID;
	public static String uID;
	
	
	
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
	// Method : Read the XML data from a file 
             
	public void interrogateWebsite(ANUJavaService f){
	
		     String dateNow = f.showDate();
		     // Begin interrogating the website:
		     String strTemp = "";
		     String str1 = "/home/irwan/NLA-XML-Response";	    
		     String str3 = ".xml";
		     String xmlOutput = "test.output";
	
				try {  
	   
					File file = new File(xmlOutput);
					DocumentBuilderFactory dbf = DocumentBuilderFactory.newInstance();
					DocumentBuilder db = dbf.newDocumentBuilder();
					Document doc = db.parse(file);
					doc.getDocumentElement().normalize();
					System.out.println("Root element " + doc.getDocumentElement().getNodeName());
					
					if (doc.hasChildNodes()) {
						printNote(doc.getChildNodes());
					}
					System.out.println(StaffAriesID + " " + fullname + " " + givenname + " "+ surname + " "+ StaffUnivID + " " +for1 + " " +for2 + " " +for1_pct + " " +for2_pct + " " +orgunit + " " +emailAddress + " " + jobtitle);
					
				}
				catch (Exception e) {
					System.out.println(e.getMessage());
				}
				

	} // End Interrogate website
	
	
	public static void printNote(NodeList nodeList){
	
	
		for (int count = 0; count < nodeList.getLength(); count++) {
			Node tempNode = nodeList.item(count);
			
			
			if (tempNode.getNodeType() == Node.ELEMENT_NODE) {
				
				
				if (tempNode.hasAttributes()) {
					NamedNodeMap nodeMap = tempNode.getAttributes();
					for (int i = 0; i < nodeMap.getLength(); i++) {
						Node node = nodeMap.item(i);
						System.out.println("attr name : " + node.getNodeName());
						System.out.println("attr value : " + node.getNodeValue());
					}
				}
				
				System.out.println( tempNode.getNodeName() + ":" +tempNode.getTextContent());				
				
        // Set person variables:				
				if(tempNode.getNodeName() == "aries-id"){
					StaffAriesID = tempNode.getTextContent();
				
				}else if (tempNode.getNodeName() == "display-name"){
					fullname  = tempNode.getTextContent();
				}
				else if (tempNode.getNodeName() == "given-name"){
					givenname = tempNode.getTextContent();
				}
				
				else if (tempNode.getNodeName() == "staff-type"){
					StaffUnivID  =  tempNode.getTextContent();
				}
				else if (tempNode.getNodeName() == "surname"){
					surname = tempNode.getTextContent();
				}
				else if (tempNode.getNodeName() == "email"){
					emailAddress = tempNode.getTextContent();
				}
				else if (tempNode.getNodeName() == "organisational-unit"){
					orgunit = tempNode.getTextContent();
				}	
				else if (tempNode.getNodeName() == "code"){
				        countfor++;					
					if(countfor==1){
						for1 = tempNode.getTextContent();						
					}
					else if (countfor==2){
						for2 = tempNode.getTextContent();
					}
					else if (countfor==3){
						for3 = tempNode.getTextContent();
					}
					
				
									
				}
				else if (tempNode.getNodeName() == "percentage"){
					countforpercentage++;
					if(countforpercentage==1){
						for1_pct = tempNode.getTextContent();
						int intfor1_pct = Integer.parseInt(for1_pct);
					}
					else if (countfor==2){
						for2_pct = tempNode.getTextContent();
						int intfor2_pct = Integer.parseInt(for2_pct);
					}
					else if (countfor==3){
						for3_pct = tempNode.getTextContent();
						int intfor3_pct = Integer.parseInt(for3_pct);
					}	
				}
				else if (tempNode.getNodeName() == "job-title"){
					jobtitle = tempNode.getTextContent();	
				}						
				
								
				if (tempNode.hasChildNodes()) {
					printNote(tempNode.getChildNodes());
				}
				
				
				
			}			
		}
	}	
	
  // Method : get the person information
	public void getPerson(String personID)  {
		Connection con = null;
		Statement stmt = null;
		ResultSet rs = null;
		PreparedStatement preparedStatement = null;
		
	
		try {
			Class.forName("com.mysql.jdbc.Driver") ;
			System.out.println("MySQL JDBC driver loaded ok.");
			con = DriverManager.getConnection("jdbc:mysql://localhost/oaidb?"+ "user=irwan");
			System.out.println("MySQL Access ok.");
			stmt = con.createStatement();
		
			rs = stmt.executeQuery("select staffnumber from useraccount where staffnumber = "  + "'" + personID +"'" + " ");
			System.out.println("MySQL Query ok.");
			int countrecords = 0;
			
			while (rs.next()) {
				String uID = rs.getString(1);		
				countrecords++;              			
			}
			countRecord = countrecords;
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
	
	
	
	// Method : Insert the person information
	public void insertPerson (String StaffAriesID, String personID, String emailAdd, String givenName, String surName, String organizationUnit, String for1, String for2, String for3, String for1_pct, String for2_pct, String for3_pct, String jobtitle) {
		Connection conn = null;
		Statement stmt = null;
		StaffDeidentifiedAriesID = "I".concat(StaffAriesID);
		String address_updated = organizationUnit.concat(", ANU");
		PreparedStatement preparedStatement = null;
		
		try{
			Class.forName("com.mysql.jdbc.Driver") ;
		  conn = DriverManager.getConnection("jdbc:mysql://localhost/oaidb?"+ "user=irwan");
			try {
				stmt = conn.createStatement();
				preparedStatement = conn.prepareStatement("insert into  useraccount(id_org,email,first_name,family_name,address,staffnumber,for1,for2,for3,for1_pct,for2_pct,for3_pct,job_title) values (?,?,?,?,?,?,?,?,?,?,?,?,?)");				
				preparedStatement.setString(1, StaffDeidentifiedAriesID);
				preparedStatement.setString(2, emailAdd);
				preparedStatement.setString(3, givenName);
				preparedStatement.setString(4, surName);
				preparedStatement.setString(5, address_updated);
				preparedStatement.setString(6, personID);
				preparedStatement.setString(7, for1);
				preparedStatement.setString(8, for2);
				preparedStatement.setString(9, for3);
				preparedStatement.setString(10, for1_pct);
				preparedStatement.setString(11, for2_pct);
				preparedStatement.setString(12, for3_pct);
				preparedStatement.setString(13, jobtitle);
				preparedStatement.executeUpdate();					
			}
		
			catch (SQLException s){
				System.out.println("SQL statement is not executed!");
				System.out.println(s);
			}
		}
	  
	        catch (Exception e){
		  e.printStackTrace();
		}
	}	
			
	
	
	// Method : Update the person information
	public void updatePerson (String personID, String orgunit, String email, String jobtitle)  {
		Connection conn = null;
                Statement statement = null;
                PreparedStatement preparedStatement = null;
                ResultSet resultSet = null;   
                try {
                	Class.forName("com.mysql.jdbc.Driver") ;
			conn = DriverManager.getConnection("jdbc:mysql://localhost/oaidb?"+ "user=irwan");
			String address_updated = orgunit.concat(", ANU");
			preparedStatement = conn.prepareStatement("update useraccount set address = ? , email = ?, job_title = ? where staffnumber = ? ");
			preparedStatement.setString(1, address_updated);
			preparedStatement.setString(2, email);
			preparedStatement.setString(3, jobtitle);
			preparedStatement.setString(4, personID);
			preparedStatement.executeUpdate();
			                                      
	
			conn.close();
		}
		catch (Exception e) {
			System.err.println("Exception: "+e.getMessage());
	        }			                           
		finally{
			if (resultSet != null) {
				try{
					resultSet.close();
				}
				catch (SQLException sqlEx) {
				
				}
				statement= null;
			}
	}	                                                                                                                                                                                                                                                                                                                	                                                	
	}

        
	public static void main(String [] args) {		
		
	  // To set a variable for the University ID:
		String StaffUniversityID = args[0];		
    
     // Declare and create an object of anujavaservicepublications:  
		ANUJavaService anujavaservice = new ANUJavaService(1);	
		
		// Read the XML data from the text file:  
		anujavaservice.interrogateWebsite(new ANUJavaService(1));
		
		
		// check if the record already there: 
		anujavaservice.getPerson(StaffUniversityID);
			                              	
		// update if the staff data is already there and insert data if the staff record does not exist:
		if(countRecord > 0){
			System.out.println("The record already exist---");
      //update if the staff data is already there: 		
			anujavaservice.updatePerson(StaffUniversityID,orgunit,emailAddress,jobtitle);
		}
		else {
    //insert data if the staff record does not exist:
			anujavaservice.insertPerson(StaffAriesID,StaffUniversityID,emailAddress,givenname,surname,orgunit,for1,for2,for3,for1_pct,for2_pct,for3_pct,jobtitle);
		
		}
	}
}


