/*
Created by Irwan Krisna, Research Service Division, Australian National University
ANDS -Funded Project

The Java Program to harvest people information from the ANU Java Service and Populate the data into the backend MySQL database.
It also check whether the people data already exist in the database and then updates the information accordingly from the service. 

Last Updated: 05-March-2013

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
					//System.out.println("Root element " + doc.getDocumentElement().getNodeName());
					
					if (doc.hasChildNodes()) {
						printNote(doc.getChildNodes());
					}
					//System.out.println(StaffAriesID + " " + fullname + " " + givenname + " "+ surname + " "+ StaffUnivID + " " +for1 + " " +for2 + " " +for1_pct + " " +for2_pct + " " +orgunit + " " +emailAddress + " " + jobtitle);
					
				}
				catch (Exception e) {
					System.out.println(e.getMessage());
				}
				

	} // End Interrogate website
	
	
	// the getMySQL should extract all the relevant data 
	
	
	public static void printNote(NodeList nodeList){
	
	
		for (int count = 0; count < nodeList.getLength(); count++) {
			Node tempNode = nodeList.item(count);
			
			
			if (tempNode.getNodeType() == Node.ELEMENT_NODE) {
				
				
				if (tempNode.hasAttributes()) {
					NamedNodeMap nodeMap = tempNode.getAttributes();
					for (int i = 0; i < nodeMap.getLength(); i++) {
						Node node = nodeMap.item(i);
						//System.out.println("attr name : " + node.getNodeName());
						//System.out.println("attr value : " + node.getNodeValue());
					}
				}
				
				//System.out.println( tempNode.getNodeName() + ":" +tempNode.getTextContent());				
				// set variables:
				
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
	
	public void getMySQL(String personID)  {
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
		
			rs = stmt.executeQuery("select staffnumber from useraccount where staffnumber = "  + "'" + personID +"'" + " ");
			System.out.println("MySQL Query ok.");
			int countrecords = 0;
			
			while (rs.next()) {
				String uID = rs.getString(1);
		
				countrecords++;
				
		
				
			}
			
			countRecord = countrecords;
			
			
			
		
			
			//System.out.println("Connected with host:port/database.");
			con.close();
		}
		catch (Exception e) {
			System.err.println("Exception: "+e.getMessage());
		}
		
		//urlprocessed = url;
		
	
		
		
		
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
	
	
	
	
	public void insertMySQL (String StaffAriesID, String personID, String emailAdd, String givenName, String surName, String organizationUnit, String for1, String for2, String for3, String for1_pct, String for2_pct, String for3_pct, String jobtitle) {
		Connection conn = null;
		Statement stmt = null;
		System.out.println(intfor1_pct +  intfor2_pct +  intfor3_pct);
	
		
		//System.out.println("MySQL JDBC driver loaded ok."); 
		
		StaffDeidentifiedAriesID = "I".concat(StaffAriesID);
		//System.out.println("MySQL Access ok.");
		String address_updated = organizationUnit.concat(", ANU");
		
		PreparedStatement preparedStatement = null;
		
		try{
	 		//System.out.println("MySQL Access TESTTT.");	
			Class.forName("com.mysql.jdbc.Driver") ;
			//System.out.println("MySQL Access AFTER.");
			conn = DriverManager.getConnection("jdbc:mysql://localhost/oaidb?"+ "user=irwan");
			try {
				stmt = conn.createStatement();
				preparedStatement = conn.prepareStatement("insert into  useraccount(id_org,email,first_name,family_name,address,staffnumber,for1,for2,for3,for1_pct,for2_pct,for3_pct,job_title,id_rep,post_code,city,state,country) values (?,?,?,?,?,?,?,?,?,?,?,?,?,?,'0200','Acton','ACT','Australia')");
				System.out.println("1 row affected");				
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
				preparedStatement.setString(14, StaffDeidentifiedAriesID);
				
				//preparedStatement.setString(2, personID);
				preparedStatement.executeUpdate();	
				//conn.close();
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
			
	
	
	
	public void updateMySQL (String personID, String orgunit, String email, String jobtitle)  {
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
		
		// To create an object Harvest
		String StaffUniversityID = args[0];		
		ANUJavaService anujavaservice = new ANUJavaService(1);	
		
		// value given in the wget command on the unix script	
		anujavaservice.interrogateWebsite(new ANUJavaService(1));
		
		
		// get the value from the MySQL & check if the record already there: 
		anujavaservice.getMySQL(StaffUniversityID);
	
		                                
		
		// Check if the record already in the database
		if(countRecord > 0){
			System.out.println("The record already exist---");		
			anujavaservice.updateMySQL(StaffUniversityID,orgunit,emailAddress,jobtitle);
		}
		else {
			anujavaservice.insertMySQL(StaffAriesID,StaffUniversityID,emailAddress,givenname,surname,orgunit,for1,for2,for3,for1_pct,for2_pct,for3_pct,jobtitle);
		
		}
		
	
		
	
		
		
		
	
  
	}
}


