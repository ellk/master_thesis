package TwitterCollector;



import java.sql.Connection;
import java.sql.DriverManager;
import java.sql.PreparedStatement;
import java.sql.SQLException;
import java.sql.Statement;
import java.util.Date;
import java.util.logging.Level;
import java.util.logging.Logger;

import twitter4j.HashtagEntity;
import twitter4j.Relationship;
import twitter4j.Status;
import twitter4j.Twitter;
import twitter4j.TwitterException;
import twitter4j.TwitterFactory;
import twitter4j.UserMentionEntity;


public  final class db_connection {
	static boolean flag=true;
	private Connection con=null;
	PreparedStatement st = null;
	PreparedStatement st1 = null;       
	PreparedStatement st2 = null;
	PreparedStatement st3 = null;
	Statement sta=null;
	String sql=null;
	long retcount;
	long rtw;
	long foll;
	Object stResultSet=null;
	Twitter twitter;

	public db_connection(){
	    	Connection con = null;
	    	Statement statement=null;
	    	String url = "jdbc:mysql://localhost:3306/?useServerPrepStmts=false&rewriteBatchedStatements=true";
	    	String driverName = "com.mysql.jdbc.Driver";
	    	String userName = "root";
	    	String password = "######";
	    	try{
		    	Class.forName(driverName);
		    	con = DriverManager.getConnection(url, userName, password);
		    	statement = con.createStatement();
		    	statement.executeUpdate("SET NAMES utf8mb4");

		    	String sql = "CREATE DATABASE IF NOT EXISTS graph_sample CHARACTER SET utf8mb4 COLLATE utf8mb4_bin;";
		    	statement.executeUpdate(sql);
		    
		    	
			sql="SET GLOBAL event_scheduler='ON'";
			statement.executeUpdate(sql);
			statement.close();
		
		
		    	con.close();
	    	}catch (Exception e) {
	    		e.printStackTrace();
	    	}
	    	
	    	this.connect();
}
    
  
  final public void connect(){
       String cs = "jdbc:mysql://localhost:3306/graph_sample?useServerPrepStmts=false&rewriteBatchedStatements=true";
       String user = "root";
       String password = "ellika";
       

        try{
        	con = DriverManager.getConnection(cs, user, password);
            	do_proc();
    
    } catch (SQLException ex) {
        	Logger lgr = Logger.getLogger(db_connection.class.getName());
        	lgr.log(Level.SEVERE, ex.getMessage(), ex);

    }	try{
    		
    		sql="CREATE TABLE IF NOT EXISTS `status` ("
    				+ "`t_text` VARCHAR(255)  CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL,"
    				+ "`t_id` bigint(20) NOT NULL,"
    				+ "`in_rpl_scr_name` varchar(30)  CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL,"
    				+ "`in_rpl_stat_id` bigint(20) NOT NULL,"
    				+ "`int_rpl_usr_id` bigint(20) NOT NULL,"
    				+ "`retweeted` varchar(10)  CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL,"
    				+ "`retweetCount` bigint(11) NOT NULL,"
    				+ "`created_at`  timestamp NOT NULL,"								
    				+ "`usr_id` bigint(20) NOT NULL,"
    				+ "`usr_name` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL,"
    				+ "`usr_scr_name` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL,"
    				+ "PRIMARY KEY (`t_id`),"
    				+ "KEY  `t_id` (`t_id`)"
    		+ ") ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;";
    		
    		sta=con.createStatement();
    		sta.execute(sql);
    		
    		
    		sql="CREATE TABLE IF NOT EXISTS `hashtags` ("
    				+ " `hashtag` VARCHAR(45)  CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL,"
    				+ " `t_id` bigint(20) NOT NULL,"
    				+ " `timesta` timestamp NOT NULL,"
    				+ " FOREIGN KEY (`t_id`) REFERENCES status(`t_id`)"
    				+ " ON DELETE CASCADE ON UPDATE CASCADE"
    				+ ") ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin; ";
    		
    		sta=con.createStatement();
    		sta.execute(sql);
    		
    		
    	}
    	
    	 catch (SQLException ex) {
             	Logger lgr = Logger.getLogger(db_connection.class.getName());
             	lgr.log(Level.SEVERE, ex.getMessage(), ex);
             

         }
      try{
        	sql="CREATE TABLE IF NOT EXISTS `edgem` ("
        			+ "`id` bigint(20) NOT NULL AUTO_INCREMENT,"
        			+ "`source` bigint(20) NOT NULL, "
        			+ "`target` bigint(20) NOT NULL, "
        			+ "`retweetCount` bigint(11) NOT NULL, "
        			+ "`text` text  CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL,"
        			+ " `t_stmp` timestamp NOT NULL,"
        			+ " `label` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL,"
        			+ "`tw_id` bigint(20) NOT NULL,"
        			+ "`rtw_id` bigint(20) NOT NULL,"
        			+ "PRIMARY KEY (`id`),"
        			+ "  KEY `tw_id` (`tw_id`),"
        			+ "KEY `source` (`source`),"
        			+ "KEY `target` (`target`),"
        			+ "FOREIGN KEY (`tw_id`) REFERENCES status(`t_id`)"
        			+ "ON DELETE CASCADE ON UPDATE CASCADE"
        			+ ") ENGINE=InnoDB  DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin AUTO_INCREMENT=1 ;";
        	
        	sta=con.createStatement();
        	sta.execute(sql);
   
        	
        	sql="CREATE TABLE IF NOT EXISTS `nodes` ("
        			+ "`nid` bigint(20) NOT NULL AUTO_INCREMENT,"
        			+ "`id` bigint(20) NOT NULL,"
        			+ "`tw_id` bigint(20)  NULL,"
        			+ "`retweets` int(11) NOT NULL,"   
        			+ "`rtw` bigint(20) NOT NULL," 
        			+ "`label` varchar(25) CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL,"
        			+ "PRIMARY KEY (`nid`),"
        			+ "UNIQUE combined(`id`,`tw_id`),"
        			+ "KEY `tw_id` (`tw_id`),"
        			+ "KEY `id` (`id`),"
        			+ " FOREIGN KEY (`tw_id`) REFERENCES status(`t_id`)"
        			+ ") ENGINE=InnoDB  DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin AUTO_INCREMENT=1 ;";
        	sta=con.createStatement();
        	sta.execute(sql);
        	sta.close();	
        }
        catch (SQLException ex) {
            	Logger  lgr = Logger.getLogger(db_connection.class.getName());
              	lgr.log(Level.SEVERE, ex.getMessage(), ex);

         }
      
      
      try{
		st = con.prepareStatement(                                                       
		        "INSERT  INTO status(t_text," +
				"t_id," +
				"in_rpl_scr_name," +
				"in_rpl_stat_id," +
				"int_rpl_usr_id," +
				"retweeted," +
				"retweetCount," +
				"created_at," +
				"usr_id," +
				"usr_name," +
				"usr_scr_name)VALUES (?,?,?,?,?,?,?,?,?,?,?)");
		st1=con.prepareStatement(
			"INSERT IGNORE INTO hashtags(hashtag,t_id,timesta) VALUES(?,?,?)");
		        
	      
		st2 = con.prepareStatement("INSERT IGNORE INTO `nodes`(id,tw_id,retweets,rtw,label) VALUES(?,?,?,?,?)")
		st3 = con.prepareStatement("INSERT INTO `edgem`(source,target,retweetCount,text,t_stmp,label,tw_id,rtw_id) VALUES(?,?,?,?,?,?,?,?)");
      
      }
        catch (SQLException ex) {
		Logger  lgr = Logger.getLogger(db_connection.class.getName());
              	lgr.log(Level.SEVERE, ex.getMessage(), ex);

         }
		
}
     
 
    public final void insertStatus(Status status){	
        try{
        	if (status.isRetweet()){
        		retcount=status.getRetweetedStatus().getRetweetCount();
        	}
        	else{
        		retcount=0;
        	}
		st.setNString(1, status.getText());
		st.setLong(2, status.getId());
		st.setNString(3, status.getInReplyToScreenName());
		st.setLong(4, status.getInReplyToStatusId());
		st.setLong(5, status.getInReplyToUserId());
		st.setBoolean(6, status.isRetweet());
		st.setLong(7,retcount);
		st.setObject(8,  status.getCreatedAt());
		st.setLong(9, status.getUser().getId());
		st.setString(10, status.getUser().getName());
		st.setString(11, status.getUser().getScreenName());
		st.addBatch();

        
		if(status.getHashtagEntities()!=null){
			for(HashtagEntity hash: status.getHashtagEntities()){
				st1.setNString(1,hash.getText());
				st1.setLong(2, status.getId());
		    		st1.setObject(3, status.getCreatedAt());
		    		st1.addBatch();
        	}
        
        }
        	int[] s=st.executeBatch();
        	int[] h=st1.executeBatch();
        
       
       
        }
        catch (SQLException ex) {
            Logger lgr = Logger.getLogger(db_connection.class.getName());
            lgr.log(Level.SEVERE, ex.getMessage(), ex);
            System.out.println(status.getId());
            System.out.println(status.getUser().getScreenName());
        }
       
    }
    public final  void insertGraph(Status status, UserMentionEntity u){
      
       
        try{
         
		if (status.isRetweet()){
		  	retcount=status.getRetweetedStatus().getRetweetCount();
		  	rtw= status.getRetweetedStatus().getId();
			}
		else{
		  	retcount=0;
		  	rtw=0;
		  	}
		st2.setLong(1, status.getUser().getId());
		st2.setLong(2, status.getId());
		st2.setInt(3, 0);
		st2.setLong(4, 0);
		st2.setString(5,status.getUser().getScreenName());
		st2.addBatch();
		int[] so=st2.executeBatch();
		
		st2.setLong(1, u.getId());
		st2.setLong(2, status.getId());
		st2.setLong(3,  retcount);
		st2.setLong(4, rtw);
		st2.setString(5,u.getScreenName());
		st2.addBatch();
	     
		st3.setLong(1, status.getUser().getId());
		st3.setLong(2, u.getId());
		st3.setLong(3,retcount);
		st3.setLong(4, status.getId());
		st3.setObject(5, status.getCreatedAt());
		st3.setString(6, "mention");
		st3.setLong(7, status.getId());
		st3.setLong(8,rtw);
	       	st3.addBatch();
		int[] t=st2.executeBatch();
		int[] e=st3.executeBatch();
        }
        catch (SQLException ex) {
		Logger  lgr = Logger.getLogger(db_connection.class.getName());
            	lgr.log(Level.SEVERE, ex.getMessage(), ex);

       }   
    }   
 
    
 	void do_proc(){
	 try{       
		 sta=con.createStatement();
		 sta.executeUpdate(
			" CREATE DEFINER=`root`@`localhost` PROCEDURE `cle`()"
			 + "BEGIN "
			 + "SELECT * FROM (SELECT CONCAT('DROP TABLE ', GROUP_CONCAT(table_name) , ';')"
			 + "FROM INFORMATION_SCHEMA.TABLES "
			 + "WHERE table_name LIKE concat('cluster_hash',concat(DATE_FORMAT(DATE_SUB(NOW(), INTERVAL 1 day),'%Y%m%d')),'%')"
			 + ") a INTO @stmt;"
			 + "PREPARE statement FROM @stmt;"
			 + "EXECUTE statement;"
			 
			 + "SELECT * FROM ("
			 + "SELECT CONCAT('DROP TABLE ', GROUP_CONCAT(table_name) , ';')"
			 + "FROM INFORMATION_SCHEMA.TABLES "
			 + "WHERE table_name LIKE concat('tweets_texts',concat(DATE_FORMAT(DATE_SUB(NOW(), INTERVAL 1 day),'%Y%m%d')),'%')"
			 + ") a INTO @stmt;"
			 + "PREPARE statement FROM @stmt;"
			 + "EXECUTE statement;"
			 
			 + "SELECT * FROM ("
			 + "SELECT CONCAT('DROP TABLE ', GROUP_CONCAT(table_name) , ';')"
			 + "FROM INFORMATION_SCHEMA.TABLES "
			 + "WHERE table_name LIKE concat('retweets',concat(DATE_FORMAT(DATE_SUB(NOW(), INTERVAL 1 day),'%Y%m%d')),'%')"
			 + ") a INTO @stmt;"
			 + "PREPARE statement FROM @stmt;"
			 + "EXECUTE statement;"
			 + "SELECT * FROM (SELECT CONCAT('DROP TABLE ', GROUP_CONCAT(table_name) , ';')"
			 + "FROM INFORMATION_SCHEMA.TABLES "
			 + "WHERE table_name LIKE concat('communities',concat(DATE_FORMAT(DATE_SUB(NOW(), INTERVAL 1 day),'%Y%m%d')),'%')"
			 + ") a INTO @stmt;"
			 + "PREPARE statement FROM @stmt;"
			 + "EXECUTE statement;"
			 + "SELECT * FROM ("
			 + "SELECT CONCAT('DROP TABLE ', GROUP_CONCAT(table_name) , ';')"
			 + "FROM INFORMATION_SCHEMA.TABLES "
			 + "WHERE table_name LIKE concat('meta_edges',concat(DATE_FORMAT(DATE_SUB(NOW(), INTERVAL 1 day),'%Y%m%d')),'%')"
			 + ") a INTO @stmt;"
			 + "PREPARE statement FROM @stmt;"
			 + "EXECUTE statement;"
			 + "SELECT * FROM ("
			 + "SELECT CONCAT('DROP TABLE ', GROUP_CONCAT(table_name) , ';')"
			 + "FROM INFORMATION_SCHEMA.TABLES "
			 + "WHERE table_name LIKE concat('node_snap',concat(DATE_FORMAT(DATE_SUB(NOW(), INTERVAL 1 day),'%Y%m%d')),'%')"
			 + ") a INTO @stmt;"
			 + "PREPARE statement FROM @stmt;"
			 + "EXECUTE statement;"
			 + "SELECT * FROM ("
			 + "SELECT CONCAT('DROP TABLE ', GROUP_CONCAT(table_name) , ';')"
			 + "FROM INFORMATION_SCHEMA.TABLES "
			 + "WHERE table_name LIKE concat('edge_snap',concat(DATE_FORMAT(DATE_SUB(NOW(), INTERVAL 1 day),'%Y%m%d')),'%')"
			 + ") a INTO @stmt;"
			 + "PREPARE statement FROM @stmt;"
			 + "EXECUTE statement;"
			 + "END"       
			);
		 sta.close();
	 
	 } 
	catch (SQLException ex) {
		System.out.println(ex.getMessage());
	}
	 try{
		 sta=con.createStatement();
		 sta.executeUpdate("CREATE DEFINER=`root`@`localhost` EVENT do_clean_up\n" +
		"ON SCHEDULE EVERY 1 DAY STARTS DATE(NOW()) + INTERVAL 1440 MINUTE \n" +
		"do\n" +
		"call cle()");
		 sta.close();
	 } 
	catch (SQLException ex) {
		System.out.println(ex.getMessage());
	}
	 
	}
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
}
