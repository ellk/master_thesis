package TwitterCollector;


import java.io.BufferedWriter;
import java.io.FileNotFoundException;
import java.io.FileOutputStream;
import java.io.OutputStreamWriter;
import java.io.PrintStream;
import java.io.UnsupportedEncodingException;
import java.nio.charset.Charset;
import java.util.ArrayList;
import java.util.Arrays;
import java.util.Scanner;

import twitter4j.FilterQuery;
import twitter4j.Status;
import twitter4j.StatusAdapter;
import twitter4j.StatusDeletionNotice;
import twitter4j.StatusListener;
import twitter4j.TwitterException;
import twitter4j.TwitterStream;
import twitter4j.TwitterStreamFactory;
import twitter4j.User;
import twitter4j.HashtagEntity;
import twitter4j.UserMentionEntity;




public final class filter   {
    public static void main(String[] args) throws TwitterException, FileNotFoundException, UnsupportedEncodingException{
         Scanner input = new Scanner(System.in,"UTF-8");	 
		  ArrayList<String> al = new ArrayList<String>();  
        String key  =new String( "UTF-8");

        String []appArray ;
         while(true){

              
              System.out.println("Please enter a keyword: ");
              key=input.next();
              System.out.println(key);
            
                al.add(key);
              System.out.println("Do you want to add another keyword yes/no?");
              String answer = input.next(); 

              if (answer.equals("no")){
                  
            	
           
            	  appArray= al.toArray(new String[al.size()]);

                  System.out.println(Arrays.toString(appArray));
                  break; 
              }
             
          
         }
         
        input.close();
    	try{
    		final db_connection DBconnection= new db_connection();
    	  	TwitterStream twitterStream = new TwitterStreamFactory().getInstance();
          	StatusListener listener = new StatusListener() { 
			public void onException(Exception ex) {
                 	 ex.printStackTrace();
              }   	 
        	  
            	public void onDeletionNotice(StatusDeletionNotice statusDeletionNotice) {
                // TODO Auto-generated method stub
            }
		public void onScrubGeo(long userId, long upToStatusId) {
                // TODO Auto-generated method stub

            }
         
          	@Override
            	public void onStatus(Status status) {  
            		if (status.getUserMentionEntities().length>0){
                 		DBconnection.insertStatus(status);
	         	 	for( UserMentionEntity us : status.getUserMentionEntities()){
	                    		DBconnection.insertGraph(status, us);  
	            		}
            		}
            	}
            	public void onTrackLimitationNotice(int numberOfLimitedStatuses) {
                // TODO Auto-generated method stub
            	}
         };
                  
		twitterStream.addListener(listener);
        	FilterQuery filters = new FilterQuery();
        	filters.track(appArray);
        	twitterStream.filter(filters);
    }
    catch(Exception e){
		e.printStackTrace();
    	
    }
   }
    
    
}

