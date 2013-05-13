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

A Java program harvests Publications data from the Java Service and updates the information in the backend. 
 
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
import org.w3c.dom.NamedNodeMap;



public class ANUJavaServiceGrants {
	
  // declare public variables
	public static String StaffUnivID;
	public static String StaffAriesID;
	public static String grant_ariesID;
	public static int countRecord = 0;
	public static String fileOutput;
	public static String xmlstatus;
  // initialize constructor
	public ANUJavaServiceGrants (int a){
		int x = a;
	}		
	public static String grant_title;
	public static String first_investigator_givenname;
	public static String first_investigator_surname;
	public static String reference_number;
	public static String funds_provider;
	public static String pKey;
	
	public static String for1;
	public static String for2;
	public static String for3;
  public static String for1_pct;
  public static String for2_pct;
  public static String for3_pct;
  public static int countfor=0;
  public static int countforpercentage=0;  
  public static String For[] =  new String[2];
  public static int intForPercent[] =  new int[2];
	
	
	
	
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
	
	
	
  // read the XML returned data from the Java Service                
	public void interrogateWebsite(ANUJavaServiceGrants f){
	 	     
		     String dateNow = f.showDate();							           
		     // Begin interrogating the website:
		     String strTemp = "";
		     String str1 = "/home/irwan/NLA-XML-Response";
		     String str3 = ".xml";
		     String xmlOutput = "grants.output";

    	
				   
				try {  
	   
					File file = new File(xmlOutput);						
					DocumentBuilderFactory dbf = DocumentBuilderFactory.newInstance();
					DocumentBuilder db = dbf.newDocumentBuilder();
					Document doc = db.parse(file);
					doc.getDocumentElement().normalize();
					System.out.println("Root element " + doc.getDocumentElement().getNodeName());
					
					if (doc.hasChildNodes()) {
						NodeList nodeLst = doc.getElementsByTagName("grants");
						printNote(doc.getChildNodes());
					
						
					}

					
				}
				catch (Exception e) {
					System.out.println(e.getMessage());
				}
					

	 
				

	} // End Interrogate website
 
	
	  // parse the XML returned data from the Java Service
	public static void printNote(NodeList nodeList){
		
		for (int count = 0; count < nodeList.getLength(); count++) {
			Node tempNode = nodeList.item(count);
			
		
			if (tempNode.getNodeType() == Node.ELEMENT_NODE) {
				
				
				if (tempNode.hasAttributes()) {
					NamedNodeMap nodeMap = tempNode.getAttributes();
					for (int i = 0; i < nodeMap.getLength(); i++) {
						Node node = nodeMap.item(i);
				
					}
				}
				
								
				// set variables:
				
				if(tempNode.getNodeName() == "contract-code"){
					grant_ariesID = tempNode.getTextContent();
				
				}
					
		
				else if (tempNode.getNodeName() == "title"){
					grant_title = tempNode.getTextContent();			
				}
				
				else if (tempNode.getNodeName() == "funds-provider"){
					funds_provider = tempNode.getTextContent();
				}
			
							
				
				if (tempNode.hasChildNodes()) {
					printNote(tempNode.getChildNodes());
				}
				
		
			
				
				if(tempNode.getNodeName()== "percentage"){
					if(countforpercentage==0){
						for1_pct = tempNode.getTextContent();;
					}
					else if(countforpercentage==1){
						for2_pct = tempNode.getTextContent();;
					}
					else if(countforpercentage==2){
						for3_pct = tempNode.getTextContent();;
					}
					countforpercentage++;		
					
					
				}
				
				if(tempNode.getNodeName()== "code"){
					
					if(countfor==0){
						for1 =  tempNode.getTextContent();
						
					}
					else if(countfor==1){
						for2 =  tempNode.getTextContent();						
					}
					else if(countfor==2){
						for3 =  tempNode.getTextContent();
					
					}
				

					countfor++;
				}
				
				
				if(tempNode.getNodeName()== "grant"){
					grant_ariesID = null;
					grant_title=null;
					for1 = null;
					for2 = null;
					for3 = null;
					for1_pct = null;
					for2_pct= null;
					for3_pct = null;
					countfor = 0;
					countforpercentage = 0;
					
				}	
						
				if(grant_title != null && grant_ariesID != null && for1 != null &&  for1_pct != null ){
					
					try {
						String fileOutputDir = "/home/irwan/NLA-Harvester-Dev";
						fileOutput = "GRANTS".concat(".txt");
						FileWriter fstreamA = new FileWriter(fileOutput,true);
						BufferedWriter outA = new BufferedWriter(fstreamA);
						outA.write(grant_ariesID + "\t" + grant_title +  "\t" + StaffUnivID + "\t"  + for1 + "\t" + for2 + "\t" + for3 + "\t" + for1_pct +  "\t" + for2_pct + "\t" + for3_pct + "\t" + funds_provider + "\n" );
						outA.close();
					}
					catch (IOException e){
						System.out.println(e);
					}
						
					
				
				}

			}
		}
	
	}	
	
  
  // get the person data from the MySQL database. To check if the person record already exist in the database. 
	public static void getPersonIDMySQL(String StaffUniversityID)  {	
		Connection con = null;
		Statement stmt = null;
		ResultSet rs = null;
		PreparedStatement preparedStatement = null;
		try {
			Class.forName("com.mysql.jdbc.Driver") ;
			con = DriverManager.getConnection("jdbc:mysql://localhost/oaidb?"+ "user=irwan");
			stmt = con.createStatement();
 			rs = stmt.executeQuery("select id_org from useraccount where staffnumber = "  + "'" + StaffUniversityID +"'" + " ");
			
			while (rs.next()) {
				
				StaffAriesID = rs.getString(1);
				System.out.println(StaffAriesID);
			}
			con.close();
		}
		catch (Exception e) {
			System.err.println("Exception: "+e.getMessage());
		}
		
		finally {
			if(rs!=null){
				try {
					rs.close();
				}
				catch (SQLException sqlEx){
				}
				stmt = null;
			}
		}
				
		                                        
	
	}
	// get the grant record from the MySQL database. To check if the grant record already exist in the database. 
	public static void getMySQL(String grant_ariesID)  {
		Connection con = null;
		Statement stmt = null;
		ResultSet rs = null;
		PreparedStatement preparedStatement = null;
		
	
		try {
			Class.forName("com.mysql.jdbc.Driver") ;
			con = DriverManager.getConnection("jdbc:mysql://localhost/oaidb?"+ "user=irwan");
			stmt = con.createStatement();
			rs = stmt.executeQuery("select ariesgrantid from grant_detail where ariesgrantid = "  + "'" + grant_ariesID +"'" + " ");
			
			int countrecords = 0;
			
			while (rs.next()) {
				String pubID = rs.getString(1);
				countrecords++;
			}
			
			countRecord = countrecords;
			
			if(countRecord > 0){
				System.out.println("Exist Already");
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
	// insert a  grant record into the MySQL database
  public  static void  insertMySQL (String grant_ariesID, String grant_title, String StaffUniversityID,String for1, String for2, String for3, String for1_pct,String for2_pct,String for3_pct,String funds_provider) {
		Connection conn = null;
		Statement stmt = null;
		PreparedStatement preparedStatement = null;


		try{
	 			
			Class.forName("com.mysql.jdbc.Driver") ;
			conn = DriverManager.getConnection("jdbc:mysql://localhost/oaidb?"+ "user=irwan");
			try {
				pKey = grant_ariesID.concat("XXX").concat(StaffUniversityID); 
				stmt = conn.createStatement();				
				preparedStatement = conn.prepareStatement("insert into  grant_detail (pkey,ariesgrantid,grant_title,staffid,for1,for2,for3,for1_pct,for2_pct,for3_pct,funds_provider) values (?,?,?,?,?,?,?,?,?,?,?)");
				preparedStatement.setString(1, pKey);	
				preparedStatement.setString(2, grant_ariesID);
				preparedStatement.setString(3, grant_title);
				preparedStatement.setString(4, StaffUniversityID);
				preparedStatement.setString(5, for1);
				preparedStatement.setString(6, for2);
				preparedStatement.setString(7, for3);
				preparedStatement.setString(8, for1_pct);
				preparedStatement.setString(9, for2_pct);
				preparedStatement.setString(10, for3_pct);
				preparedStatement.setString(11,funds_provider );
				preparedStatement.executeUpdate();	
				
			}
		
			catch (SQLException s){
				
				System.out.println(s);
			}
		}
	  
	        catch (Exception e){
		  e.printStackTrace();
		}
	}	
			
	
     
	
	
	public static void main(String [] args) {		
		
		// set the university id of the grant's investigator 
		String StaffUniversityID = args[0];	
    
    // create ANUJavaServiceGrants object			
		ANUJavaServiceGrants anujavaservicegrants = new ANUJavaServiceGrants(1);	
		
		// read the XML returned data from the Java Service		
		anujavaservicegrants.interrogateWebsite(new ANUJavaServiceGrants(1));
		
		System.out.println(grant_ariesID);			
		// get the grant record from the MySQL & check if the record already there:  
 		anujavaservicegrants.getMySQL(grant_ariesID);
		
		
		// get the investigator record in the database. check if the record is there. 
		anujavaservicegrants.getPersonIDMySQL(StaffUniversityID);
	
		// Grant records insertion: If the record does not exist then insert into the database.
		try{
			FileInputStream fstream = new FileInputStream("GRANTS.txt");
			DataInputStream in = new DataInputStream(fstream);
			BufferedReader br = new BufferedReader(new InputStreamReader(in));
			String strLine;
			
			while ((strLine = br.readLine()) != null)   {
				String parts[] = strLine.split("\t");
				System.out.println (parts[0] + "\n");
				anujavaservicegrants.insertMySQL(parts[0],parts[1],StaffUniversityID,parts[3],parts[4],parts[5],parts[6],parts[7],parts[8],parts[9]);
				
			}
			in.close();
		}catch (Exception e){//Catch exception if any
		
			System.err.println("Error: " + e.getMessage());
		}
	
	}
}


