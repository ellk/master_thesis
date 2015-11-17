
package commdetect1;

import java.math.BigInteger;
import java.sql.Connection;
import java.sql.DriverManager;
import java.sql.PreparedStatement;
import java.sql.ResultSet;
import java.sql.SQLException;
import java.sql.Statement;
import java.sql.Timestamp;

import java.text.DateFormat;
import java.text.SimpleDateFormat;
import java.util.ArrayList;
import java.util.Arrays;
import java.util.Collections;
import java.util.Date;
import java.util.HashMap;
import java.util.Iterator;
import java.util.Map;
import java.util.logging.Level;
import java.util.logging.Logger;





public class GraphModel {
    Edge[] mentions;
    Node[] nodes;
    Edge[] mentionsTmp;
    Node[] nodesTmp;
    Graph graph;
    ArrayList<Node> cand_nodes;
    ArrayList<Node> nodeToRem;
    ArrayList<Edge> candidates;
    ArrayList<Edge> candToRem;
    public Connection con=null;
    public PreparedStatement st = null;
    public Statement stat=null;
    public Statement  sta=null;
    public PreparedStatement pst=null;
    public PreparedStatement pst2=null;
    public PreparedStatement pst3=null;
    public PreparedStatement pst4=null;
    public PreparedStatement pst5=null;
    Date curtime=new Date();
    java.sql.Date time;
    static DateFormat df;
    GraphModel(){
        graph= new Graph();	
    }
    Graph getVisible(){	
	return this.graph;
    }
    public class Graph{
        int eRowCount;
        int nRowCount;
        int eRowCountTmp;
        
          public  java.sql.Date getCurrentDate() {
                java.util.Date today = new java.util.Date();
                return new java.sql.Date(today.getTime());
            
        	
        }
        Graph(){
            this.connect();
            try{
                System.out.println(CommDetect1.interval);
                time=this.getCurrentDate();
                
                df= new SimpleDateFormat("yyyy-MM-dd HH:mm:ss");
		st=con.prepareStatement("SELECT COUNT(*) AS  C FROM "
                        + "(SELECT *, COUNT(*) AS weight FROM edgem"
      			+ " WHERE t_stmp between DATE_SUB('"+ df.format(time)+"',INTERVAL 					'"+CommDetect1.interval+"'  minute) and DATE_SUB('"+ df.format(time)+"',INTERVAL 5 MINUTE) "
		      	+ " and source<>target GROUP BY source, target)edgeNum ");		      	
		ResultSet  rs=st.executeQuery();
		while(rs.next()){
                    eRowCountTmp = Integer.parseInt((String)rs.getString("C"));
                  
                }
		st.close();
		rs.close();  
		st=con.prepareStatement("SELECT *, COUNT(*) AS C FROM edgem "
	 		+ " WHERE t_stmp between DATE_SUB('"+ df.format(time)+"', INTERVAL 				'"+CommDetect1.interval+"'   minute) and  DATE_SUB('"+ df.format(time)+"',INTERVAL 5 MINUTE) "
                  	+ " and source<>target "
                        + "GROUP BY source, target");      	
		rs=st.executeQuery();
		int i;
		mentionsTmp= new Edge[eRowCountTmp];
		candidates= new ArrayList<Edge>();
		for (i=0;i<eRowCountTmp;i++){
                    if(rs.next()){
                        mentionsTmp[i]= new Edge(); 
			long src=rs.getLong("source");
           
			long trg=rs.getLong("target");
			long tw_id=rs.getLong("tw_id");
			long rtw_id=rs.getLong("rtw_id");
			float w=Float.parseFloat((String)rs.getString("C")) ;			     
			mentionsTmp[i].setSource(src);
			mentionsTmp[i].setTarget(trg);
			mentionsTmp[i].setTimestamp(rs.getTimestamp("t_stmp"));
			mentionsTmp[i].setWeight(w);
			mentionsTmp[i].setRetweetCount(rs.getLong("retweetCount"));
			mentionsTmp[i].setTweetId(tw_id);
			mentionsTmp[i].setRtweetId(rtw_id);			        	
			candidates.add(mentionsTmp[i]);
                    }
                
                }
		rs.close();
		st.close();    
		st=con.prepareStatement("SELECT COUNT(*) AS COU FROM (SELECT id, label FROM nodes, status"
				+ " WHERE status.t_id=nodes.tw_id AND "
  	     			+ " status.created_at between DATE_SUB('"+ df.format(time)+"',INTERVAL '"+CommDetect1.interval+"'   minute) and  DATE_SUB('"+ df.format(time)+"',INTERVAL 5 MINUTE) "
				+ " group by id)n");
                rs=st.executeQuery();		     
                while (rs.next()){
                    nRowCount= Integer.parseInt((String)rs.getString("COU"));
                }     	  		      
                st.close();
                rs.close();
            }
            catch (SQLException ex) {
                Logger  lgr = Logger.getLogger(Graph.class.getName());
		lgr.log(Level.SEVERE, ex.getMessage(), ex);
            }
        }	
        
        void addNode(){
            long rtwi;
            int retweets;
            try{
                st=con.prepareStatement("SELECT  id,label FROM nodes, status "
			+ " WHERE status.t_id=nodes.tw_id "
	  		+ " and status.created_at between DATE_SUB('"+ df.format(time)+"',INTERVAL '"+CommDetect1.interval+"' MINUTE) and  DATE_SUB('"+ df.format(time)+"',INTERVAL 5 MINUTE) "
			+ "group by id");
                     
		ResultSet  rs=st.executeQuery();
		ResultSet rs2;
		int i;
		nodesTmp= new Node[nRowCount];
		cand_nodes= new ArrayList<Node>();
	
		for (i=0;i<nRowCount;i++){
                    if(rs.next()){
                        nodesTmp[i]= new Node(); 
			long id=rs.getLong("id");
			nodesTmp[i].getNodeData().setID(id);
			String str=rs.getString("label");
			nodesTmp[i].nd.setScreenName(str);
			cand_nodes.add(nodesTmp[i]);
                    }   	  
                }
		rs.close();
		st.close();
		nodeToRem= new ArrayList<Node>();
		System.out.println("here");
             stat=con.createStatement();
            pst=con.prepareStatement("SELECT nodes.id as id, rtw, MAX(retweets) AS retweets,count(*) FROM nodes,status WHERE retweets<>0 AND "
            		+ "status.t_id=nodes.tw_id AND "
	      		+ "  status.created_at between DATE_SUB('"+ df.format(time)+"',interval '"+CommDetect1.interval+"' MINUTE) and  DATE_SUB('"+ df.format(time)+"',INTERVAL 5 MINUTE) "
			+ " GROUP BY rtw ");
            
           	rs2=pst.executeQuery();
              	long t;
            	while(rs2.next()){
            		for(Node n:nodesTmp){
            			t=rs2.getLong("id");
            			if(t==n.getNodeData().getID()){
                     			retweets=rs2.getInt("retweets");			       		
                     			rtwi=rs2.getLong("rtw");
                     			n.nd.setMap(rtwi,retweets);	             
                	}	}	
               	}
                pst.close();
                st.close();             
            }
           
            catch (SQLException ex) {
                Logger  lgr = Logger.getLogger(Graph.class.getName());
		lgr.log(Level.SEVERE, ex.getMessage(), ex);
            }
            
        }
        
	public void addEdge(){
            candToRem= new ArrayList<Edge>();
            for(Edge e:candidates){
             
                    for(Edge ed:candidates){
                        if(e.getSource()==ed.getTarget() && e.getTarget()==ed.getSource()){
                            if(e.getFlag()==false){
                                e.setFlag(true);
                                ed.setFlag(true);
                                candToRem.add(e);                                                    
                                float w= ed.getWeight()+e.getWeight();
                                ed.setWeight(w);         
                            }	
                        }
                    }
                
            }
            for(Edge can : candToRem) {
                candidates.remove(can);
            }
            mentions= candidates.toArray(new Edge[ candidates.size()]);
            eRowCount=mentions.length;
            System.out.println(eRowCount);
        }
			
	public Edge getEdge(Node n1, Node n2){
            for(Edge e: graph.getMentions()){
                if ((e.getSource()==n1.getNodeData().getID() && e.getTarget()==n2.getNodeData().getID()
                    || (e.getSource()==n2.getNodeData().getID() && e.getTarget()==n1.getNodeData().getID()))){
                    return e;	
                } 
            }
            return null;
	}
        
        int getEdgeCount(){	
            return eRowCount;
	}
        
        public Node getTmpNode(long l){
        	 for (Node n: nodesTmp ){
                 if (n.getNodeData().getID()==l){
                     return n;
 		}
             }
             return null;
        	
        }
	public Node getNode(long l){
            for (Node n: this.getNodes()){
                if (n.getNodeData().getID()==l){
                    return n;
		}
            }
            return null;
        }
		
	int getNodeCount(){
            return nRowCount;
	}
		
	Node[] getNodes(){
            return nodes;
	}
		
	Edge[] getMentions(){	
            return mentions;
	}
		
	void setNeighbors(){ 
            Node no=null;
            for (Node node: cand_nodes){
                long id=node.getNodeData().getID();
		ArrayList<Node>	neigh=new ArrayList<Node>();	
                for(Edge e: this.getMentions()){
                    long s=e.getSource();
                    long t=e.getTarget();
                    if(id==s){
                        no=this.getTmpNode(t);
                        node.getNodeData().setFlag(true);
                        neigh.add(no);
                    }	
                    else if(id==t) {
                        no=this.getTmpNode(s);
                        node.getNodeData().setFlag(true);
                        neigh.add(no);
                    }
                    
                    else{
                    	 node.neighbors= new Node[0];
                    }
                }
             if (neigh.size()>0){  
		node.neighbors= neigh.toArray(new Node[neigh.size()]);
            }
            
            }
               nRowCount=cand_nodes.size();
       
    	nodes=new Node[cand_nodes.size()]; 
    		  nodes= cand_nodes.toArray(nodes);
        }

	int getTotalEdgeCount(){		
            return this.getMentions().length;
        }
		
	Node[] getNeighbors(Node node){
            for (Node n: this.getNodes()){
                if (node.getNodeData().getID()==n.getNodeData().getID()){	
                    return node.neighbors;
		}
            }
            return null;
        }
	
	double getTotalDegree(Node node){
            int rank= this.getNeighbors(node).length;
            return rank;
        }	
        
	public void connect(){
            String cs = "jdbc:mysql://localhost:3306/graph_sample?useServerPrepStmts=false&rewriteBatchedStatements=true";
	    String user = "root";
	    String password = "######";
	    try{
                con = DriverManager.getConnection(cs, user, password);
	    }
	    catch (SQLException ex) {
	        Logger lgr = Logger.getLogger(GraphModel.Graph.class.getName());
	        lgr.log(Level.SEVERE, ex.getMessage(), ex);
	    }
        } 		
    }
    public class Node {	
        long id;
	double tw_id;
	NodeData nd;
	int l=0;
	Node[] neighbors ;
	int mod;
	String scr_name;
	Map<Long, Integer> mp;	
	boolean flag;
        
	Node(){
            nd= new NodeData();
	}
        
	NodeData getNodeData(){
            return this.nd;
        }
	public class NodeData{
            NodeData(){
                mp=new HashMap<Long, Integer>();
                flag=false;
            };	
            void setID(long ide){
                id=ide;
            }
            void setTweetID(double twid){
                tw_id=twid;
            }
            void setScreenName(String n){
                scr_name=n;
            }
            void setMap(long l, int i){
                mp.put(l, i);
            }
            void setMod(int m){
                mod=m;
            }
            void setFlag(boolean fl){
            	flag=fl;
            }
            Map<Long, Integer> getMap(){
                return mp;
            }	
            boolean getFlag(){
            	return flag;
            };
            long getID(){
                return id;
            }
            double getTweetID(){
		return tw_id;
            }
            String getScreenName(){
                return scr_name;
            }
            int getModul(){
                return mod;
            }
            String[] getNodeLabel(){
                int rows;
                long identity=this.getID();
                try{
                    String sql1="SELECT COUNT(*) AS  C FROM nodes where id=? ";
                    st=con.prepareStatement(sql1);
                    st.setLong(1, identity);
                    ResultSet  rs=st.executeQuery();
                    while(rs.next()){
                        rows= Integer.parseInt((String)rs.getString("C"));
			rs.close();
			st.close();
			int i=0;
			String[] labels= new String[rows];
			if(!rs.wasNull()){
                            String sql2="SELECT label FROM nodes where id=? ";
                            st=con.prepareStatement(sql2);
                            st.setLong(1, identity);
                            rs=st.executeQuery();
                            String nid=rs.getString("label");
                            labels[i]=new String();
                            labels[i]=nid;
                            i++;
                        }	  	        	  
			rs.close();
			st.close();
			return labels; 	        
                    }   
		}
                catch (SQLException ex) {
                    Logger  lgr = Logger.getLogger(Graph.class.getName());
                    lgr.log(Level.SEVERE, ex.getMessage(), ex);
                }		      		
                return null;
            }			
        }
    }
    
    public class Edge {
        long source;
        long target;
        String label;
        long tw_id;
        long rtw_id;
        float weight;
        Date time;
        boolean f;
        long retweetCount;	
        Edge(){ f=false;}
        void setTweetId(long i){
            this.tw_id=i;
	}
	void setRtweetId(long i){
            this.rtw_id=i;
	}
	void setRetweetCount(long rc){
            this.retweetCount=rc;
	}
        void setSource(long src){
            this.source=src;
	}
	void setFlag(boolean fl){
            this.f=fl;
	}
	void setTarget(long trg){
            this.target=trg;
	}
        void setLabel(String l){
            this.label=l;	
	}
	void setWeight(float w){
            this.weight=w;
	}
        void setTimestamp(Date t){
            this.time=t;			
	}
	long getSource(){
            return source;
	}
        long getRetweetCount(){
            return retweetCount;
        }
        long getTarget(){
            return target;
        }
        long getTweetId(){
            return tw_id;
	}
	long getRtweetId(){
            return rtw_id;
	}
	String getLabel(){
            return label;
	}
        float getWeight(){
            return weight;
	}
        Date getTimestamp(){
            return time;
	}
	boolean getFlag(){
            return f;
	}
    }
    void createGraphSnapshot(){
        String s1=null;
	String s2=null;
	String sql=null;
	DateFormat dateFormat = new SimpleDateFormat("yyyyMMdd");
	Date date = new Date();              			
	SimpleDateFormat fmt = new SimpleDateFormat("HH:mm:ss");              
        String d=dateFormat.format(date);
	StringBuilder da=new StringBuilder();
	String dat=da.append(d).toString(); 
        try{
         stat= con.createStatement();
                    sql="CREATE TABLE IF NOT EXISTS `edge_snap_tr` ("
						+ "`id` int(11) NOT NULL AUTO_INCREMENT,"
						+ "`tw_id` bigint(20) NOT NULL,"
						+ "`rtw_id` bigint(20) NOT NULL,"
						+ "`source` bigint(20) NOT NULL,"
						+ "`target` bigint(20) NOT NULL,"
						+ "`weight` int(11) NOT NULL,"
						+ "`modu` int(11) NOT NULL,"
						+ "`retweetCount` bigint(11) NOT NULL,"
						+ "`label` text NOT NULL,"
						+ "`timesta` text NOT NULL,"
						+ "PRIMARY KEY (`id`),"
						+ "KEY `mod` (`modu`),"
						+ "KEY `modu` (`modu`),"
						+ "KEY `modu_2` (`modu`),"
						+ "KEY `modu_3` (`modu`),"
						+ "FOREIGN KEY (`tw_id`) REFERENCES status(`t_id`)"
						+ ") ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;";
								
                    stat.execute(sql);
                    stat.close();
    }
                    catch (SQLException ex) {
                    System.out.println(ex.getMessage());
		}
        try{
         sql="CREATE TABLE IF NOT EXISTS `node_snap_tr` ("  		
					  	+ "`modu` int(11) NOT NULL,"
					  	+ "`nid` bigint(20) NOT NULL,"
					  	+ "`degree` double NOT NULL,"					  	
					  	+ "`label` varchar(20) NOT NULL,"
					  	+ "PRIMARY KEY (`nid`),"
					  	+ "KEY `mod` (`modu`),"
					  	+ "KEY `nid` (`nid`),"
					  	+ "KEY `modu` (`modu`),"
					  	+ "KEY `modu_2` (`modu`),"
					  	+ "KEY `modu_3` (`modu`),"
					  	+ "FOREIGN KEY (`nid`) REFERENCES nodes(`id`)"			
					  	+ ") ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;";
                    stat=con.createStatement();
                    stat.execute(sql);
                    stat.close();
                    sql="CREATE TABLE IF NOT EXISTS `retweets_tr` ("
						+ " `id` int(11) NOT NULL AUTO_INCREMENT,"						  		
						+ "`nid` bigint(20) NOT NULL,"
						+ "`rtw_id` bigint(20) NOT NULL,"						 
						+ "`retweets` int(11) NOT NULL,"
						+ "PRIMARY KEY (`id`),"		
						+ "UNIQUE (`nid`,`rtw_id`),"	
						+ "FOREIGN KEY (`nid`) REFERENCES node_snap_tr(`nid`)"
						+ ") ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;";
                   stat=con.createStatement();
                   stat.execute(sql);
                   stat.close();    }
         catch (SQLException ex) {
                    System.out.println(ex.getMessage());
		}
          try{			
                    sql="CREATE TABLE IF NOT EXISTS `meta_edges_tr` ("
						+ "`id` int(11) NOT NULL AUTO_INCREMENT,"
						+ "`source` int(11) NOT NULL,"
						+ " `target`int(11) NOT NULL,"
						+ "`sourceNo` bigint(20) NOT NULL,"
						+ " `targetNo` bigint(20) NOT NULL,"
						+ "`label` text NOT NULL,"
						+ "`timesta` text NOT NULL,"
						+ "PRIMARY KEY (`id`),"
						+ "FOREIGN KEY (`sourceNo`) REFERENCES edgem(`source`),"
						+ "FOREIGN KEY (`targetNo`) REFERENCES edgem(`target`)"
						+ ") ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;";
                    stat=con.createStatement();
                    stat.execute(sql);
          }
           catch (SQLException ex) {
                    System.out.println(ex.getMessage());
		} 
         try{
                st=con.prepareStatement("INSERT INTO `edge_snap_tr`( tw_id,rtw_id,source, target, weight, modu,retweetCount,label, timesta ) VALUES (?,?,?,?,?,?,?,?,?)");
                pst=con.prepareStatement("INSERT IGNORE INTO `node_snap_tr`(modu,nid,degree,label)"
						+ " VALUES(?,?,?,?)");
                pst2=con.prepareStatement("INSERT IGNORE INTO `retweets_tr`(nid,rtw_id,retweets)"
						+ " VALUES(?,?,?)");
                pst3=con.prepareStatement("INSERT INTO `meta_edges_tr`(source,target,sourceNo,targetNo,label,timesta)"
				    		+ " VALUES(?,?,?,?,?,?)");
                
                pst4=con.prepareStatement("INSERT IGNORE INTO `node_snap_tr`(modu,nid,degree,label)"
						+ " VALUES(?,?,?,?)");
                pst5=con.prepareStatement("INSERT IGNORE INTO `retweets_tr`(nid,rtw_id,retweets)"
						+ " VALUES(?,?,?)");
                
            }
            catch (SQLException ex) {
                    System.out.println(ex.getMessage());
		}
         int counter1=0;
         int counter2=0;
         int counter3=0;
         int counter4=0;
	for (Edge e: this.graph.getMentions()){
            int s= this.graph.getNode(e.getSource()).getNodeData().getModul();
            int t=this.graph.getNode(e.getTarget()).getNodeData().getModul();
            StringBuilder str=new StringBuilder();
            Date edtime= e.getTimestamp();
            String o=str.append(edtime).toString();
           
            if(s==t){
                try{
                   
                    st.setLong(1, e.getTweetId());
                    st.setLong(2, e.getRtweetId());
                    st.setLong(3, e.getSource());
                    st.setLong(4, e.getTarget());
                    st.setFloat(5, e.getWeight());
                    st.setLong(6,s);
                    st.setLong(7,e.getRetweetCount());
                    st.setString(8, "mention");
                    st.setString(9, fmt.format(e.getTimestamp()));
                    st.addBatch();
                  
                   double srcDeg=this.graph.getTotalDegree(this.graph.getNode(e.getSource()));
                   s1=this.graph.getNode(e.getSource()).getNodeData().getScreenName();  
                   pst.setLong(1, s);               
                   pst.setLong(2, e.getSource());
                   pst.setDouble(3, srcDeg);                
                   pst.setString(4, s1); 
                   pst.addBatch(); 
                   Iterator it =this.graph.getNode(e.getSource()).getNodeData().getMap().entrySet().iterator()
                   while (it.hasNext()) {
                       	Map.Entry pairs = (Map.Entry)it.next();				
                   	pst2.setLong(1, e.getSource());               
                    	pst2.setObject(2, pairs.getKey());
                    	pst2.setObject(3,pairs.getValue());                
                    	pst2.addBatch();               
                        counter3++;
                        it.remove(); 
                   }
                   double trgDeg=this.graph.getTotalDegree(this.graph.getNode(e.getTarget()));
                   s2=this.graph.getNode(e.getTarget()).getNodeData().getScreenName();
                   pst4.setLong(1, t);               
                   pst4.setLong(2, e.getTarget());
                   pst4.setDouble(3, trgDeg);                
                   pst4.setString(4, s2);                  
                   pst4.addBatch();
                 
                   it =this.graph.getNode(e.getTarget()).getNodeData().getMap().entrySet().iterator();
                  while (it.hasNext()) {
			Map.Entry pairs = (Map.Entry)it.next();					          
                        pst5.setLong(1, e.getTarget());               
                    	pst5.setObject(2, pairs.getKey());
                    	pst5.setObject(3,pairs.getValue());                                               
                    	pst5.addBatch();
                    	counter4++;
                    	it.remove();                  
                  }  counter1++;
                }	
		catch (SQLException ex) {
                    System.out.println(ex.getMessage());
		}	
            }
            else{
              try{	    
                    pst3.setLong(1, s);               
                    pst3.setLong(2, t);
                    pst3.setDouble(3, this.graph.getNode(e.getSource()).getNodeData().getID());                
                    pst3.setDouble(4, this.graph.getNode(e.getTarget()).getNodeData().getID());    
                    pst3.setString(5,"metaedge");
                    pst3.setString(6,dat);
                    pst3.addBatch();                
                    counter2++;                
                }
		catch (SQLException ex) {
                    System.out.println(ex.getMessage());
		}
            }
        }
	try{
	int[] EdgesInserted = new int[counter1];
	EdgesInserted = st.executeBatch();
       int[] NodesInserted=new int[counter1];
       NodesInserted=pst.executeBatch();
       int[] RetweetsInserted= new int[counter3];
       RetweetsInserted=pst2.executeBatch();
       int[] Nodes2Inserted=new int[counter1];
       Nodes2Inserted=pst4.executeBatch();
       int[] Retweets2Inserted= new int[counter4];
       Retweets2Inserted=pst5.executeBatch();
       int[] MetaEdges= new int[counter2];
       MetaEdges=pst3.executeBatch();
	}catch (SQLException ex) {
        System.out.println(ex.getMessage());
}
	
    }
    void createMetrics(){
       ResultSet  rs=null;
	ArrayList<String> hashtagNames;
	String sql=null;
	int max=0;
	int counter1=0;
	int EdgeNum[]=null;
	ArrayList<Integer> modul=new ArrayList<Integer>();
	DateFormat dateFormat = new SimpleDateFormat("yyyyMMdd");
	Date date = new Date();
	String d=dateFormat.format(date);
	StringBuilder da=new StringBuilder();
	String dat=da.append(d).toString();
        String communities;
	String meta_edges;
	String node_snap;
	String edge_snap;
        String retweets;
        String cluster_hashtags;
        String tweets_texts;      
        StringBuilder sb_com= new StringBuilder();		
        StringBuilder sb_me= new StringBuilder();		
	StringBuilder sb_ns=new StringBuilder();		
	StringBuilder sb_ch= new StringBuilder();
        StringBuilder sb_rt= new StringBuilder();
        StringBuilder sb_tt= new StringBuilder();
        StringBuilder sb_es= new StringBuilder();
        Date d1 = new Date();
        String dd=dateFormat.format(d1);
        try{
            sql="CREATE TABLE IF NOT EXISTS `communities_tr` ("
				+ "`id` int(11),"
				+ "`num_nodes` int(11) NOT NULL,"
				+ "`num_edges` int(11) NOT NULL,"
				+ "`density` decimal(10,5) NOT NULL,"
				+ "`timesta` text NOT NULL,"
				+ "PRIMARY KEY (`id`)"
				+ ") ENGINE=InnoDB DEFAULT CHARSET=utf8 ;";
            stat=con.createStatement();
            stat.execute(sql);
              sql="CREATE TABLE IF NOT EXISTS `tweets_texts_tr` ("				
				+ "`modu` int(11) NOT NULL,"
				+ "`tweet_id` bigint(20) NOT NULL,"
				+ "`tweet_text` text  CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL,"
				+ "`usr_id` bigint(25) NOT NULL,"
				+ "`timesta` text NOT NULL,"
				+ "FOREIGN KEY (`usr_id`) REFERENCES node_snap_tr(`nid`) "
				+ ") ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 ;";
            stat=con.createStatement();
            stat.execute(sql);
             sql="CREATE TABLE IF NOT EXISTS `cluster_hash_tr` ("
			+ "`modu` int(11) NOT NULL ,"
			+ "`cl_hashtag` text NOT NULL,"
            + "`t_id` bigint(20) NOT NULL,"
			+ "FOREIGN KEY (`modu`) REFERENCES communities_tr(`id`) "
			+ ") ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;";
            stat=con.createStatement();
            stat.execute(sql);
                   			
        }
        catch (SQLException ex) {
            System.out.println(ex.getMessage());
        }
        for(Node n:this.graph.getNodes()){
            modul.add(n.getNodeData().getModul());
            if(n.getNodeData().getModul()>max){
                max=n.getNodeData().getModul();
            }	
        }
	try{
        st=con.prepareStatement("INSERT INTO `communities_tr`(id,num_nodes,num_edges,density,timesta) "
                + "VALUES(?,?,?,?,?)");
        
        }
        catch (SQLException ex) {
            System.out.println(ex.getMessage());
        }

     try{
    	 int num=0;
    	 float dens;
    	 long numNo,numEd,mod;
    	 rs=stat.executeQuery("SELECT e.tw,n.modu,n.nodes from (select modu as modu ,count(tw_id) as tw from edge_snap_tr group by modu) as e right"
    	 		+ " join (select modu as modu, count(nid) as nodes from node_snap_tr group by modu) as n "
    	 		+ "on e.modu=n.modu ORDER BY `n`.`modu`,e.modu ASC");
    	 while(rs.next()){
    		  mod= rs.getInt("n.modu");
    		  if(rs.getLong("e.tw")==0){
    			  numEd=0;
    		  }
    		  else{
    			  numEd=rs.getLong("e.tw");
    		  }
    	 numNo=rs.getLong("n.nodes");
    	 dens=(float) numEd/numNo;						
         st.setLong(1,mod);
         st.setLong(2,numNo);
         st.setLong(3,numEd);
         st.setFloat(4, dens);
         st.setString(5,dat);
         st.addBatch();
         num++;
    	 }
    	 int[] comm= new int[num];
    	 comm=st.executeBatch();	 
     }
     catch (SQLException ex) {
         System.out.println(ex.getMessage());
     }   
     try{
         sql="UPDATE communities_tr SET id=0 WHERE id IS NULL;";
         stat=con.createStatement();
         stat.execute(sql);
        }
	catch (SQLException ex) {
            System.out.println(ex.getMessage());
        }
	try{
            sql="ALTER TABLE communities_tr ALTER COLUMN id INT NOT NULL;";
            stat=con.createStatement();
            stat.execute(sql);
        }
	catch (SQLException ex) {
            System.out.println(ex.getMessage());
        }
        try{
            sql="ALTER TABLE `communities_tr`  ADD PRIMARY KEY(id) ;";
            stat=con.createStatement();
            stat.execute(sql);
        }
        catch (SQLException ex) {
            System.out.println(ex.getMessage());
        }
	try{
	   st=con.prepareStatement("SELECT nid FROM node_snap_tr;");
       	   rs=st.executeQuery();
           pst2=con.prepareStatement("SELECT edge_snap_tr.modu, edge_snap_tr.tw_id, status.t_text,status.created_at FROM status,edge_snap_tr"
			+ " WHERE (edge_snap_tr.source=? OR edge_snap_tr.target=?) AND status.t_id=edge_snap_tr.tw_id"
                        + " and status.created_at>=DATE_SUB('"+ df.format(CommDetect1.sometime)+"',INTERVAL '"+CommDetect1.interval+"'  minute)"
                        + " GROUP BY  edge_snap_tr.tw_id");
           pst3=con.prepareStatement("INSERT INTO `tweets_texts_tr`( modu, tweet_id, tweet_text, usr_id, timesta ) VALUES (?,?,?,?,?)");

            while(rs.next()){
                long id=rs.getLong("nid");
		pst2.setLong(1, id);
		pst2.setLong(2, id);
		ResultSet rs2=pst2.executeQuery();
		while(rs2.next()){
                    pst3.setLong(1, rs2.getLong("modu"));
                    pst3.setLong(2, rs2.getLong("tw_id"));
                    pst3.setNString(3, rs2.getNString("t_text"));
                    pst3.setLong(4,id);
                    pst3.setString(5, rs2.getString("created_at"));
                    pst3.addBatch();
                    counter1++;
                }
		rs2.close();
	
            }	
        }
        catch (SQLException ex) {
		System.out.println(ex.getMessage());
        }
	try{
		int[] tweet_t= new int[counter1];
		tweet_t= pst3.executeBatch();
		}
	catch (SQLException ex) {
            	System.out.println(ex.getMessage());
		}
        try{
            	sql="ALTER TABLE tweets_texts_tr ADD id INT PRIMARY KEY AUTO_INCREMENT;";
            	stat=con.createStatement();
            	stat.execute(sql);
	}
	catch (SQLException ex) {
            	System.out.println(ex.getMessage());
        }
        try{
		counter1=0;
		st=con.prepareStatement("SELECT modu, hashtag, t_id  FROM tweets_texts_tr, hashtags WHERE hashtags.t_id=tweets_texts_tr.tweet_id GROUP BY modu, hashtag,t_id");
            	rs=st.executeQuery();
            	pst=con.prepareStatement("INSERT INTO `cluster_hash_tr`(modu,cl_hashtag,t_id) VALUES(?,?,?)");
            	while(rs.next()){
              		long  modular=rs.getLong("modu");
                	String s=rs.getString("hashtag");
                 	long tid=rs.getLong("t_id");  
                 	pst.setLong(1,modular);
                 	pst.setString(2,s);
                 	pst.setLong(3,tid);
                 	pst.addBatch();
                 	counter1++;     
            }
        rs.close();
        }catch (SQLException ex) {
            System.out.println(ex.getMessage());
        }
        try{
        	int[] ch=new int[counter1];
        	ch=pst.executeBatch();	
        }
        catch (SQLException ex) {
            System.out.println(ex.getMessage());
        }
        try{
            sql="ALTER TABLE `cluster_hash_tr` ADD nid INT PRIMARY KEY AUTO_INCREMENT;";
            stat=con.createStatement();
            stat.execute(sql);
        }
	catch (SQLException ex) {
            System.out.println(ex.getMessage());
        }                    
        if(CommDetect1.snap==true){
            if(!d.equals(dateFormat.format(CommDetect1.dateCompare)) && CommDetect1.counter!=1){
                date = new Date(System.currentTimeMillis() - 24 * 60 * 60 * 1000L);
                d=dateFormat.format(date);
            } 
            float times=CommDetect1.slice;
            times=times/1000;
            times=86400/times;
            communities=sb_com.append("communities").append(d).append("n").append(CommDetect1.counter).toString();               
            meta_edges=sb_me.append("meta_edges").append(d).append("n").append(CommDetect1.counter).toString();
            node_snap=sb_ns.append("node_snap").append(d).append("n").append(CommDetect1.counter).toString();
            edge_snap=sb_es.append("edge_snap").append(d).append("n").append(CommDetect1.counter).toString();
            tweets_texts=sb_tt.append("tweets_texts").append(d).append("n").append(CommDetect1.counter).toString();
            cluster_hashtags=sb_ch.append("cluster_hash").append(d).append("n").append(CommDetect1.counter).toString();
            retweets=sb_rt.append("retweets").append(d).append("n").append(CommDetect1.counter).toString();
            try{
                stat= con.createStatement();
                stat.executeUpdate("RENAME TABLE  `cluster_hash` TO  "+cluster_hashtags+" ");
                stat.executeUpdate("RENAME TABLE  `tweets_texts` TO  "+tweets_texts+" ");
                stat.executeUpdate("RENAME TABLE  `communities` TO  "+communities+" ");
                stat.executeUpdate("RENAME TABLE  `retweets` TO  "+retweets+" ");          
                stat.executeUpdate("RENAME TABLE  `edge_snap` TO  "+edge_snap+" ");  
                stat.executeUpdate("RENAME TABLE  `node_snap` TO  "+node_snap+" ");
                stat.close();
            }
            catch (SQLException ex) {
                System.out.println(ex.getMessage());
            }
            try{      
                sta=con.createStatement();
                rs=sta.executeQuery("SHOW TABLES LIKE 'meta_edges'");
                while(rs.next()){
                    stat= con.createStatement();
                    stat.executeUpdate("RENAME TABLE  `meta_edges` TO  "+meta_edges+" ");     
                }
                stat.close();
                sta.close();
               rs.close();
            }
            catch (SQLException ex) {
                System.out.println(ex.getMessage());
            }
            if(!dd.equals(d)){ //set again comparison date
                date = new Date(System.currentTimeMillis() +24 * 60 * 60 * 1000L);
                d= dateFormat.format(date);
            }
            if(d.equals(dateFormat.format(CommDetect1.dateCompare))){                   
                if(CommDetect1.counter<times){                            
                    CommDetect1.counter++;                           	
                }
            }
            else{      
                CommDetect1.dateCompare= new Date();
                CommDetect1.counter=1;
                try{
                stat= con.createStatement();
                stat.executeUpdate("DROP TABLE cluster_hash, communities, tweets_texts, retweets, edge_snap, node_snap, meta_edges");
                stat.close();
                }
                catch (SQLException ex) {
                    System.out.println(ex.getMessage());
                }
            }                              
        }
        else{			//delete previous basic tables	
        	 try{
                 stat= con.createStatement();
                 stat.executeUpdate("DROP TABLE IF EXISTS cluster_hash, communities, tweets_texts, retweets, edge_snap, node_snap, meta_edges");
                 stat.close();
                 }
                 catch (SQLException ex) {
                     System.out.println(ex.getMessage());
                 }
        	
        	
        }
        try{
            stat= con.createStatement();
            stat.executeUpdate("RENAME TABLE  `cluster_hash_tr` TO  cluster_hash ");
            stat.executeUpdate("RENAME TABLE  `tweets_texts_tr` TO  tweets_texts ");
            stat.executeUpdate("RENAME TABLE  `communities_tr` TO  communities ");
            stat.executeUpdate("RENAME TABLE  `retweets_tr` TO  retweets ");                         
            stat.executeUpdate("RENAME TABLE  `edge_snap_tr` TO  edge_snap ");  
            stat.executeUpdate("RENAME TABLE  `node_snap_tr` TO  node_snap ");
            stat.close();
        }
        catch (SQLException ex) {
            System.out.println(ex.getMessage());
        }
        try{
            sta=con.createStatement();
            rs=sta.executeQuery("SHOW TABLES LIKE 'meta_edges_tr'");
            while(rs.next()){
                stat= con.createStatement();
                stat.executeUpdate("RENAME TABLE  `meta_edges_tr` TO  meta_edges ");  
            }
            stat.close();
            sta.close();
            rs.close();                                   
        }
        catch (SQLException ex) {
            System.out.println(ex.getMessage());
        }          
	}
}




		




