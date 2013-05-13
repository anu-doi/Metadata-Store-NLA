/*
Created by : Irwan Krisna, Research Service Division, Australian National University
ANDS-Funded Project
This Java program harvests Publications data from the Java Service and updates the information in the backend. 

Last Updated: 05--March-2013

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



public class ANUJavaServiceGrants {
	
	public static String StaffUnivID;
	public static String StaffAriesID;
	public static String grant_ariesID;
	public static int countRecord = 0;
	public static String fileOutput;

	
	public static String xmlstatus;

	public ANUJavaServiceGrants (int a){
		int x = a;
	}

	//public static String category;		
	public static String grant_title;
	//public static String source_name;
	//public static String source_id;
	//public static String pub_year;
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
	
	
	//public static String nlaID;
	
	
	// to get the detail of a person:
	//public static String [][][][]personDetail ;

	
	//public static String nlaID;
	//public static String uID;
	
	
	
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
	
	
	
           
	public void interrogateWebsite(ANUJavaServiceGrants f){
	 	     // Step 1: interrogate the website : Based on the number of web pages
		     //int loopCountCopy = Integer.parseInt(loopCount);
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

						//System.out.println("PUBS  " + pub_ariesID + " " + category + " " + pub_title + " " + for1 + " " +for2 );
					
						
					}

					
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
				/*
				else if (tempNode.getNodeName() == "publication-year"){
					pub_year = tempNode.getTextContent();
					
				}
				*/
			
							
				
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
					//System.out.println("TESTCODE: " + tempNode.getTextContent() + " " + countfor);
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
				
				
				//System.out.println("WOW " + xmlstatus);
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
					//getMySQL(pub_ariesID);
					//System.out.println("TEST " + pub_ariesID);
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
	
	public static void getPersonIDMySQL(String StaffUniversityID)  {	
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
 			rs = stmt.executeQuery("select id_org from useraccount where staffnumber = "  + "'" + StaffUniversityID +"'" + " ");
			//System.out.println("MySQL Query ok.");
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
	
	public static void getMySQL(String grant_ariesID)  {
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
			rs = stmt.executeQuery("select ariesgrantid from grant_detail where ariesgrantid = "  + "'" + grant_ariesID +"'" + " ");
			//System.out.println("MySQL Query ok.");
			int countrecords = 0;
			
			while (rs.next()) {
				String pubID = rs.getString(1);
				countrecords++;
				
							
				
				
			}
			
			countRecord = countrecords;
			
			if(countRecord > 0){
				System.out.println("Exist Already");
			}
			
		
			
			//System.out.println("Connected with host:port/database.");
			
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
	
  public  static void  insertMySQL (String grant_ariesID, String grant_title, String StaffUniversityID,String for1, String for2, String for3, String for1_pct,String for2_pct,String for3_pct,String funds_provider) {
		Connection conn = null;

		Statement stmt = null;
	
	

		//System.out.println("MySQL JDBC driver loaded ok."); 

		//System.out.println("MySQL Access ok.");

		PreparedStatement preparedStatement = null;



		try{
	 		//System.out.println("MySQL Access TESTTT.");	
			Class.forName("com.mysql.jdbc.Driver") ;
			//System.out.println("MySQL Access AFTER.");
			conn = DriverManager.getConnection("jdbc:mysql://localhost/oaidb?"+ "user=irwan");
			try {
				pKey = grant_ariesID.concat("XXX").concat(StaffUniversityID); 
				stmt = conn.createStatement();
				//System.out.println("Mine: "+ grant_ariesID);
				preparedStatement = conn.prepareStatement("insert into  grant_detail (pkey,ariesgrantid,grant_title,staffid,for1,for2,for3,for1_pct,for2_pct,for3_pct,funds_provider) values (?,?,?,?,?,?,?,?,?,?,?)");
				//System.out.println("1 row affected");
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
				
				
				
	
				//preparedStatement.setString(2, personID);
				preparedStatement.executeUpdate();	
				//conn.close();
			}
		
			catch (SQLException s){
				//System.out.println("SQL statement is not executed!");
				System.out.println(s);
			}
		}
	  
	        catch (Exception e){
		  e.printStackTrace();
		}
	}	
			
	
     
	
	
	public static void main(String [] args) {		
		
		// To create an object Harvest
		String StaffUniversityID = args[0];		
		ANUJavaServiceGrants anujavaservicegrants = new ANUJavaServiceGrants(1);	
		
		// value given in the wget command on the unix script	
		anujavaservicegrants.interrogateWebsite(new ANUJavaServiceGrants(1));
		
		System.out.println(grant_ariesID);			
		// get the value from the MySQL & check if the record already there: 
 		anujavaservicegrants.getMySQL(grant_ariesID);
		
		
		
		anujavaservicegrants.getPersonIDMySQL(StaffUniversityID);
	
		// read from a file:
		try{
			FileInputStream fstream = new FileInputStream("GRANTS.txt");
			DataInputStream in = new DataInputStream(fstream);
			BufferedReader br = new BufferedReader(new InputStreamReader(in));
			String strLine;
			//System.out.println("MY ID" + StaffAriesID);
			
			while ((strLine = br.readLine()) != null)   {
				//System.out.println (strLine);
				String parts[] = strLine.split("\t");
				System.out.println (parts[0] + "\n");
				anujavaservicegrants.insertMySQL(parts[0],parts[1],StaffUniversityID,parts[3],parts[4],parts[5],parts[6],parts[7],parts[8],parts[9]);
				
			}
			in.close();
		}catch (Exception e){//Catch exception if any
		
			System.err.println("Error: " + e.getMessage());
		}
			
			
			
		// Delete the PUBS.txt file
		//boolean success = (new File(fileOutput)).delete();
		
  		
		//System.out.println(countRecord);
	
		
		
		
	
  
	}
}


