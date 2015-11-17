/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
package commdetect1;

import java.sql.Connection;
import java.sql.PreparedStatement;
import java.util.Calendar;
import java.util.Date;
import java.util.Timer;
import java.util.TimerTask;


import commdetect1.GraphModel.*;
import commdetect1.Modularity;
import java.util.ArrayList;
import java.util.Arrays;
import java.util.Scanner;

public class CommDetect1 {

    /**
     * @param args the command line arguments
     */
    public Connection con=null;
    public PreparedStatement st = null;	
    static int slice=18000000;
    static Date dateCompare;
    static int counter=1;
    static boolean snap=false;
    static Date current;
    static Date endtime;
    static Date lasttime;
    static boolean go=true;
    static Date taketime;
    static Date sometime;
    static int interval=300;
    static int interval1=120;
    static  boolean f=true;
    boolean b=true;
    
    public static void main(String[] args) {
        Calendar today = Calendar.getInstance();
        today.set(Calendar.HOUR_OF_DAY, 19);
	today.set(Calendar.MINUTE, 0 );
	today.set(Calendar.SECOND, 0);
	Timer timer = new Timer();
	taketime=today.getTime();
        sometime=today.getTime();
        dateCompare=new Date();
        
	TimerTask tt = new TimerTask(){
            public void run(){                         
               	int div=0;             
                go=false;                                       
                GraphModel gm= new GraphModel();
                Graph g =gm.getVisible();
                g.addEdge();
                g.addNode();
               	g.setNeighbors();
               	Modularity modularity = new Modularity();
               	modularity.setUseWeight(true);
             	modularity.execute(gm);
                gm.createGraphSnapshot();
        	gm.createMetrics();
                snap=true;      
            }
        };
        timer.schedule(tt, today.getTime(), slice);
    }
}

 
