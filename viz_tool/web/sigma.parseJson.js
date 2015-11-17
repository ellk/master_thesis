// Scott Hale (Oxford Internet Institute)
// Requires sigma.js and jquery to be loaded
// based on parseGexf from Mathieu Jacomy @ Sciences Po M�dialab & WebAtlas

sigma.publicPrototype.parseJson = function(data,callback) {
	var sigmaInstance = this;
	//
	var ccount;
	alert("in");
		for (i=0; i<data.nodes.length; i++){
			
			var id=data.nodes[i].id;
			var labe=data.nodes[i].label ;
	
			if(typeof data.nodes[i].attributes!=='undefined'){
				var node = {label:labe || id, 
							'x': Math.random(), 
							'y': Math.random(),
							'color': 	'rgb('+Math.round(Math.random()*256)+','+
											Math.round(Math.random()*256)+','+
											Math.round(Math.random()*256)+')', 
							'size': data.nodes[i].attributes[0].num_nodes || data.nodes[i].attributes[0].degree ,
							attributes:[]
							};

				for (var key in data.nodes[i].attributes[0]){
					if(data.nodes[i].attributes[0].hasOwnProperty(key)){
						var val= data.nodes[i].attributes[0][key];
						var attr=key;
						node.attributes.push({attr: attr, val:val});
					}
				}
				sigmaInstance.addNode(id,node );
			}
			else{
			sigmaInstance.addNode(id,{label:labe, 'x': Math.random(), 'y': Math.random(), 'color': '#fff'});
			
			
			}

			//window.NODE = data.nodes[i];//In the original, but not sure purpose
		
		}
		(function(){
		var ar=new Array();
		 sigmaInstance.iterNodes(function(n){
			
				if(n.attr['attributes'][2]){
				ar.push(n.attr['attributes'][2].val);
				}
				else{
					ar.push(n.attr['attributes'][0].val);
				}
		
		});
			var max=Math.max.apply(Math,ar);
		sigmaInstance.iterNodes(function(n){
		if(n.attr['attributes'][2]){
		var nodesize=n.attr['attributes'][2].val/max;
		if(nodesize===1){
			nodesize=nodesize-0.1;
		
		}
	
		n.color= 'rgb('+Math.round(nodesize*256)+','+
							Math.round(nodesize*256)+','+
							Math.round(nodesize*256)+')';
		
		}
		else{
		var nodesize=n.attr['attributes'][0].val/max;
		if(nodesize===1){
		nodesize=nodesize-0.1;
		
		}
		n.color= 'rgb('+Math.round(nodesize*256)+','+
							Math.round(nodesize*256)+','+
							Math.round(nodesize*256)+')';
		
		
		
		}
		
		});
		
		
		
		
		
		})();
		var ar=new Array();
		
		for(j=0; j<data.edges.length; j++){
			var edgeNode = data.edges[j];

			var source = edgeNode.source;
			var target = edgeNode.target;
			var lab = edgeNode.label;
			var eid = edgeNode.id;
			if(typeof edgeNode.attributes!=='undefined'){
				var weight=edgeNode.attributes[0].weight;
				sigmaInstance.addEdge(eid,source,target,{'weight':weight,'size':weight,'label': lab});
			}
			else{
			sigmaInstance.addEdge(eid,source,target,{'weight': sigmaInstance.minEdgeSize  ,'size':sigmaInstance.minEdgeSize,'label': lab});
		}
		}
		c=sigmaInstance.getNodesCount();
	
		if (callback) callback.call(this);//Trigger the data ready function
	


};//end sigma.parseJson function
