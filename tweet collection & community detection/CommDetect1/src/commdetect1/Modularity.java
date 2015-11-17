/*
Copyright 2008-2011 Gephi
Authors : Patick J. McSweeney <pjmcswee@syr.edu>, Sebastien Heymann <seb@gephi.org>
Website : http://www.gephi.org

This file is part of Gephi.

DO NOT ALTER OR REMOVE COPYRIGHT NOTICES OR THIS HEADER.

Copyright 2011 Gephi Consortium. All rights reserved.

The contents of this file are subject to the terms of either the GNU
General Public License Version 3 only ("GPL") or the Common
Development and Distribution License("CDDL") (collectively, the
"License"). You may not use this file except in compliance with the
License. You can obtain a copy of the License at
http://gephi.org/about/legal/license-notice/
or /cddl-1.0.txt and /gpl-3.0.txt. See the License for the
specific language governing permissions and limitations under the
License.  When distributing the software, include this License Header
Notice in each file and include the License files at
/cddl-1.0.txt and /gpl-3.0.txt. If applicable, add the following below the
License Header, with the fields enclosed by brackets [] replaced by
your own identifying information:
"Portions Copyrighted [year] [name of copyright owner]"

If you wish your version of this file to be governed by only the CDDL
or only the GPL Version 3, indicate your decision by adding
"[Contributor] elects to include this software in this distribution
under the [CDDL or GPL Version 3] license." If you do not indicate a
single choice of license, a recipient has the option to distribute
your version of this file under either the CDDL, the GPL Version 3 or
to extend the choice of license to its licensees as provided above.
However, if you add GPL Version 3 code and therefore, elected the GPL
Version 3 license, then the option applies only if the new code is
made subject to such option by the copyright holder.

Contributor(s): Thomas Aynaud <taynaud@gmail.com>

Portions Copyrighted 2011 Gephi Consortium.
*/
package commdetect1;

import java.text.DecimalFormat;
import java.text.NumberFormat;
import java.util.*;

import commdetect1.GraphModel.Graph;
import commdetect1.GraphModel.Node;


/**
 *
 * @author pjmcswee
 */
public class Modularity {

  
    private boolean isCanceled;
    private CommunityStructure structure;
    private double modularity;
    private double modularityResolution;
    private boolean isRandomized = false;
    private boolean useWeight = true;
    private double resolution = 1.;
    
    public void setRandom(boolean isRandomized) {
        this.isRandomized = isRandomized;
    }

    public boolean getRandom() {
        return isRandomized;
    }
    
     public void setUseWeight(boolean useWeight) {
        this.useWeight = useWeight;
    }

    public boolean getUseWeight() {
        return useWeight;
    }
    
    public void setResolution(double resolution) {
        this.resolution = resolution;
    }

    public double getResolution() {
        return resolution;
    }

    public boolean cancel() {
        this.isCanceled = true;
        return true;
    }



    class ModEdge {

        int source;
        int target;
        float weight;

        public ModEdge(int s, int t, float w) {
            source = s;
            target = t;
            weight = w;
        }
    }

    class CommunityStructure {

        HashMap<Modularity.Community, Float>[] nodeConnectionsWeight;
        HashMap<Modularity.Community, Integer>[] nodeConnectionsCount;
        HashMap<Node, Integer> map;
        Community[] nodeCommunities;
        Graph graph;
        double[] weights;
        double graphWeightSum;
        LinkedList<ModEdge>[] topology;
        LinkedList<Community> communities;
        int N;
        HashMap<Integer, Community> invMap;

        CommunityStructure(Graph hgraph) {
            this.graph = hgraph;
            N = hgraph.getNodeCount();
            invMap = new HashMap<Integer, Community>();
            nodeConnectionsWeight = new HashMap[N];
            nodeConnectionsCount = new HashMap[N];
            nodeCommunities = new Community[N];
            map = new HashMap<Node, Integer>();
            topology = new LinkedList[N];
            communities = new LinkedList<Community>();
            int index = 0;
            weights = new double[N];
            for (Node node : hgraph.getNodes()) {
                map.put(node, index);
                nodeCommunities[index] = new Community(this);
                nodeConnectionsWeight[index] = new HashMap<Community, Float>();
                nodeConnectionsCount[index] = new HashMap<Community, Integer>();
                weights[index] = 0;
                nodeCommunities[index].seed(index);
                Community hidden = new Community(structure);
                hidden.nodes.add(index);
                invMap.put(index, hidden);
                communities.add(nodeCommunities[index]);               
                index++;
                if (isCanceled) {
                    return;
                }
            } 
  //              System.out.println(hgraph.getNodeCount());
            for (Node node : hgraph.getNodes()) {
                int node_index = map.get(node);
                topology[node_index] = new LinkedList<ModEdge>();

                for (Node neighbor : hgraph.getNeighbors(node)) {
                    if (node == neighbor) {
                        continue;
                    }
                    int neighbor_index = map.get(neighbor);
                    float weight = 1;
                    if(useWeight) {
                        weight = hgraph.getEdge(node, neighbor).getWeight();
                    } 
                      
                    weights[node_index] += weight;
                    Modularity.ModEdge me = new ModEdge(node_index, neighbor_index, weight);
                    topology[node_index].add(me);
                    Community adjCom = nodeCommunities[neighbor_index];
                    nodeConnectionsWeight[node_index].put(adjCom, weight);
                    nodeConnectionsCount[node_index].put(adjCom, 1);
                    nodeCommunities[node_index].connectionsWeight.put(adjCom, weight);
                    nodeCommunities[node_index].connectionsCount.put(adjCom, 1);
                    nodeConnectionsWeight[neighbor_index].put(nodeCommunities[node_index], weight);
                    nodeConnectionsCount[neighbor_index].put(nodeCommunities[node_index], 1);
                    nodeCommunities[neighbor_index].connectionsWeight.put(nodeCommunities[node_index], weight);
                    nodeCommunities[neighbor_index].connectionsCount.put(nodeCommunities[node_index], 1);
                    graphWeightSum += weight;
                }

                if (isCanceled) {
                    return;
                }
            }
            graphWeightSum /= 2.0;
        }

        private void addNodeTo(int node, Community to) {
            to.add(new Integer(node));
            nodeCommunities[node] = to;

            for (ModEdge e : topology[node]) {
                int neighbor = e.target;

                ////////
                //Remove Node Connection to this community
                Float neighEdgesTo = nodeConnectionsWeight[neighbor].get(to);
                if (neighEdgesTo == null) {
                    nodeConnectionsWeight[neighbor].put(to, e.weight);
                } else {
                    nodeConnectionsWeight[neighbor].put(to, neighEdgesTo + e.weight);
                }
                Integer neighCountEdgesTo = nodeConnectionsCount[neighbor].get(to);
                if (neighCountEdgesTo == null) {
                    nodeConnectionsCount[neighbor].put(to, 1);
                } else {
                    nodeConnectionsCount[neighbor].put(to, neighCountEdgesTo + 1);
                }




                ///////////////////
                Modularity.Community adjCom = nodeCommunities[neighbor];
                Float wEdgesto = adjCom.connectionsWeight.get(to);
                if (wEdgesto == null) {
                    adjCom.connectionsWeight.put(to, e.weight);
                } else {
                    adjCom.connectionsWeight.put(to, wEdgesto + e.weight);
                }
                
                Integer cEdgesto = adjCom.connectionsCount.get(to);
                if (cEdgesto == null) {
                    adjCom.connectionsCount.put(to, 1);
                } else {
                    adjCom.connectionsCount.put(to, cEdgesto + 1);
                }

                Float nodeEdgesTo = nodeConnectionsWeight[node].get(adjCom);
                if (nodeEdgesTo == null) {
                    nodeConnectionsWeight[node].put(adjCom, e.weight);
                } else {
                    nodeConnectionsWeight[node].put(adjCom, nodeEdgesTo + e.weight);
                }
                
                Integer nodeCountEdgesTo = nodeConnectionsCount[node].get(adjCom);
                if (nodeCountEdgesTo == null) {
                    nodeConnectionsCount[node].put(adjCom, 1);
                } else {
                    nodeConnectionsCount[node].put(adjCom, nodeCountEdgesTo + 1);
                }

                if (to != adjCom) {
                    Float comEdgesto = to.connectionsWeight.get(adjCom);
                    if (comEdgesto == null) {
                        to.connectionsWeight.put(adjCom, e.weight);
                    } else {
                        to.connectionsWeight.put(adjCom, comEdgesto + e.weight);
                    }
                    
                    Integer comCountEdgesto = to.connectionsCount.get(adjCom);
                    if (comCountEdgesto == null) {
                        to.connectionsCount.put(adjCom, 1);
                    } else {
                        to.connectionsCount.put(adjCom, comCountEdgesto + 1);
                    }
                    
                    
                }
            }
        }

        private void removeNodeFrom(int node, Community from) {
                 
            Community community = nodeCommunities[node];
            for (ModEdge e : topology[node]) {
                int neighbor = e.target;

                ////////
                //Remove Node Connection to this community
                Float edgesTo = nodeConnectionsWeight[neighbor].get(community);
                Integer countEdgesTo = nodeConnectionsCount[neighbor].get(community);
            //   System.out.println("countedgesto"+countEdgesTo);
            //   System.out.println(nodeConnectionsCount.length);
            //    System.out.println(node);
                if (countEdgesTo - 1 == 0) {
                    nodeConnectionsWeight[neighbor].remove(community);
                    nodeConnectionsCount[neighbor].remove(community);
                } else {
                    nodeConnectionsWeight[neighbor].put(community, edgesTo - e.weight);
                    nodeConnectionsCount[neighbor].put(community, countEdgesTo - 1);
                }

                ///////////////////
                //Remove Adjacency Community's connection to this community
                Modularity.Community adjCom = nodeCommunities[neighbor];
                Float oEdgesto = adjCom.connectionsWeight.get(community);
                Integer oCountEdgesto = adjCom.connectionsCount.get(community);
             
          //      if(oCountEdgesto!=null){
                if (oCountEdgesto - 1 == 0) {
                    adjCom.connectionsWeight.remove(community);
                    adjCom.connectionsCount.remove(community);
                } else {
                    adjCom.connectionsWeight.put(community, oEdgesto - e.weight);
                    adjCom.connectionsCount.put(community, oCountEdgesto - 1);
                }
         //       }
                
            
                

                
                if (node == neighbor) {
                    continue;
                }

                if (adjCom != community) {
                    Float comEdgesto = community.connectionsWeight.get(adjCom);
                    Integer comCountEdgesto = community.connectionsCount.get(adjCom);
                    if (comCountEdgesto - 1 == 0) {
                        community.connectionsWeight.remove(adjCom);
                        community.connectionsCount.remove(adjCom);
                    } else {
                        community.connectionsWeight.put(adjCom, comEdgesto - e.weight);
                        community.connectionsCount.put(adjCom, comCountEdgesto - 1);
                    }
                }
  //    System.out.println(node);
                Float nodeEgesTo = nodeConnectionsWeight[node].get(adjCom);
                Integer nodeCountEgesTo = nodeConnectionsCount[node].get(adjCom);
          //        if(nodeCountEgesTo!=null){
                if (nodeCountEgesTo - 1 == 0) {
                    nodeConnectionsWeight[node].remove(adjCom);
                    nodeConnectionsCount[node].remove(adjCom);
                } else {
                    nodeConnectionsWeight[node].put(adjCom, nodeEgesTo - e.weight);
                    nodeConnectionsCount[node].put(adjCom, nodeCountEgesTo - 1);
                }


   //         }
            }
            from.remove(new Integer(node));
        }

        private void moveNodeTo(int node, Community to) {
            Community from = nodeCommunities[node];
            removeNodeFrom(node, from);
            addNodeTo(node, to);
        }

        private void zoomOut() {
            int M = communities.size();
            LinkedList<ModEdge>[] newTopology = new LinkedList[M];
            int index = 0;
            nodeCommunities = new Community[M];
            nodeConnectionsWeight = new HashMap[M];
            nodeConnectionsCount = new HashMap[M];
            HashMap<Integer, Community> newInvMap = new HashMap<Integer, Community>();
            for (int i = 0; i < communities.size(); i++) {//Community com : mCommunities) {
                Community com = communities.get(i);
                nodeConnectionsWeight[index] = new HashMap<Community, Float>();
                nodeConnectionsCount[index] = new HashMap<Community, Integer>();
                newTopology[index] = new LinkedList<ModEdge>();
                nodeCommunities[index] = new Community(com);
                Set<Community> iter = com.connectionsWeight.keySet();
                double weightSum = 0;

                Community hidden = new Community(structure);
                for (Integer nodeInt : com.nodes) {
                    Community oldHidden = invMap.get(nodeInt);
                    hidden.nodes.addAll(oldHidden.nodes);
                }
                newInvMap.put(index, hidden);
                for(Modularity.Community adjCom : iter) {
                    int target = communities.indexOf(adjCom);
                    float weight = com.connectionsWeight.get(adjCom);
                    if(target == index)
                        weightSum += 2.*weight;
                    else
                        weightSum += weight;
                    ModEdge e = new ModEdge(index, target, weight);
                    newTopology[index].add(e);
                }
                weights[index] = weightSum;
                nodeCommunities[index].seed(index);

                index++;
            }
            communities.clear();

            for (int i = 0; i < M; i++) {
                Community com = nodeCommunities[i];
                communities.add(com);
                for (ModEdge e : newTopology[i]) {
                    nodeConnectionsWeight[i].put(nodeCommunities[e.target], e.weight);
                    nodeConnectionsCount[i].put(nodeCommunities[e.target], 1);
                    com.connectionsWeight.put(nodeCommunities[e.target], e.weight);
                    com.connectionsCount.put(nodeCommunities[e.target], 1);
                }

            }

            N = M;
            topology = newTopology;
            invMap = newInvMap;
        }
    }

    class Community {
        double weightSum;
        CommunityStructure structure;
        LinkedList<Integer> nodes;
        HashMap<Modularity.Community, Float> connectionsWeight;
        HashMap<Modularity.Community, Integer> connectionsCount;

        public int size() {
            return nodes.size();
        }

        public Community(Modularity.Community com) {
            structure = com.structure;
            connectionsWeight = new HashMap<Modularity.Community, Float>();
            connectionsCount = new HashMap<Modularity.Community, Integer>();
            nodes = new LinkedList<Integer>();
            //mHidden = pCom.mHidden;
        }

        public Community(CommunityStructure structure) {
            this.structure = structure;
            connectionsWeight = new HashMap<Modularity.Community, Float>();
            connectionsCount = new HashMap<Modularity.Community, Integer>();
            nodes = new LinkedList<Integer>();
        }

        public void seed(int node) {
            nodes.add(node);
            weightSum += structure.weights[node];
        }

        public boolean add(int node) {
            nodes.addLast(new Integer(node));
            weightSum += structure.weights[node];
            return true;
        }

        public boolean remove(int node) {
            boolean result = nodes.remove(new Integer(node));
            weightSum -= structure.weights[node];
            if (nodes.size() == 0) {
                structure.communities.remove(this);
            }
            return result;
        }
    }

    public void execute(GraphModel graphModel) {
        Graph hgraph = graphModel.getVisible();
        execute(hgraph);
    }

    public void execute(Graph hgraph) {
        isCanceled = false;
     
        Random rand = new Random();
      
        structure = new Modularity.CommunityStructure(hgraph);
        double totalWeight = structure.graphWeightSum;
        double[] nodeDegrees = structure.weights.clone();
        if (isCanceled) {
          
            return;
        }
        boolean someChange = true;
        while (someChange) {
            someChange = false;
            boolean localChange = true;
            while (localChange) {
                localChange = false;
                int start = 0;
                if (isRandomized) {
                    start = Math.abs(rand.nextInt()) % structure.N;
                }
    //            System.out.println(start);
                int step = 0;
                for (int i = start; step < structure.N; i = (i + 1) % structure.N) {
                    step++;
                    double best = 0.;
                    Community bestCommunity = null;
                    Community nodecom = structure.nodeCommunities[i];
                    Set<Community> iter = structure.nodeConnectionsWeight[i].keySet();
                    for(Community com : iter) {
                        double qValue = q(i, com);
                        if (qValue > best) {
                            best = qValue;
                            bestCommunity = com;
                        } 
                    }
                    if ((structure.nodeCommunities[i] != bestCommunity) && (bestCommunity != null)) {
                        structure.moveNodeTo(i, bestCommunity);
                        localChange = true;
                    }
                    if (isCanceled) {
                
                        return;
                    }
                }
                someChange = localChange || someChange;
                if (isCanceled) {
          
                    return;
                }
            }

            if (someChange) {
                structure.zoomOut();
            }
        }

        int[] comStructure = new int[hgraph.getNodeCount()];
        int count = 0;
        double[] degreeCount = new double[structure.communities.size()];
        for (Community com : structure.communities) {
            for (Integer node : com.nodes) {
                Community hidden = structure.invMap.get(node);
                for (Integer nodeInt : hidden.nodes) {
                    comStructure[nodeInt] = count;
                }
            }
            count++;
        }
        for (Node node : hgraph.getNodes()) {
            int index = structure.map.get(node);
            if(useWeight) {
                degreeCount[comStructure[index]] += nodeDegrees[index];
            } else {                
                degreeCount[comStructure[index]] += hgraph.getTotalDegree(node);
            }
            
        }
        
        modularity = finalQ(comStructure, degreeCount, hgraph, totalWeight, 1.);
        modularityResolution = finalQ(comStructure, degreeCount, hgraph,  totalWeight, resolution);
        
     
    }

    private double finalQ(int[] struct, double[] degrees, Graph hgraph,  double totalWeight, double usedResolution) {
      

        double res = 0;
        double[] internal = new double[degrees.length];
        for (Node n : hgraph.getNodes()) {
            int n_index = structure.map.get(n);
            n.nd.setMod(struct[n_index]);
            for (Node neighbor : hgraph.getNeighbors(n)) {
                if (n == neighbor) {
                    continue;
                }
                int neigh_index = structure.map.get(neighbor);
                if (struct[neigh_index] == struct[n_index]) {
                    if(useWeight) {
                        internal[struct[neigh_index]] += hgraph.getEdge(n, neighbor).getWeight();
                    } else {
                        internal[struct[neigh_index]]++;
                    }
                }
            }
        }
        for (int i = 0; i < degrees.length; i++) {
            internal[i] /= 2.0;
            res += usedResolution * (internal[i] / totalWeight) - Math.pow(degrees[i] / (2 * totalWeight), 2);//HERE
        }
        return res;
    }

    public double getModularity() {
        return modularity;
    }

   
    private double q(int node, Community community) {
        Float edgesToFloat = structure.nodeConnectionsWeight[node].get(community);
        double edgesTo = 0;
        if (edgesToFloat != null) {
            edgesTo = edgesToFloat.doubleValue();
        }
        double weightSum = community.weightSum;
        double nodeWeight = structure.weights[node];
        double qValue = resolution * edgesTo - (nodeWeight * weightSum) / (2.0 * structure.graphWeightSum);
        if ((structure.nodeCommunities[node] == community) && (structure.nodeCommunities[node].size() > 1)) {
            qValue = resolution * edgesTo - (nodeWeight * (weightSum - nodeWeight)) / (2.0 * structure.graphWeightSum);
        }
        if ((structure.nodeCommunities[node] == community) && (structure.nodeCommunities[node].size() == 1)) {
            qValue = 0.;
        }
      //  System.out.println(qValue);
        return qValue;
    }
}