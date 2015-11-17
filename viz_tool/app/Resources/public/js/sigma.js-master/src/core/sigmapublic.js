function SigmaPublic(sigmaInstance) {
  var s = sigmaInstance;
  var self = this;
  sigma.classes.EventDispatcher.call(this);

  this._core = sigmaInstance;

  this.kill = function() {function init() {
  /**
   * First, let's instanciate sigma.js :
   */
  var sigInst = sigma.init($('#sigma-example')[0]).drawingProperties({
    defaultLabelColor: '#fff'
  }).graphProperties({
    minNodeSize: 0.5,
    maxNodeSize: 5
  });
 
  // (requires "sigma.parseGexf.js" to be executed)
  sigInst.parseGexf('/data/les_miserables.gexf');
 
  /**
   * Now, here is the code that shows the popup :
   */
  (function(){
    var popUp;
 
    // This function is used to generate the attributes list from the node attributes.
    // Since the graph comes from GEXF, the attibutes look like:
    // [
    //   { attr: 'Lorem', val: '42' },
    //   { attr: 'Ipsum', val: 'dolores' },
    //   ...
    //   { attr: 'Sit',   val: 'amet' }
    // ]
    function attributesToString(attr) {
      return '' +
        attr.map(function(o){
          return '' + o.attr + ' : ' + o.val + '';
        }).join('') +
        '';
    }
 
    function showNodeInfo(event) {
      popUp && popUp.remove();
 
      var node;
      sigInst.iterNodes(function(n){
        node = n;
      },[event.content[0]]);
 
      popUp = $(
        ''
      ).append(
        // The GEXF parser stores all the attributes in an array named
        // 'attributes'. And since sigma.js does not recognize the key
        // 'attributes' (unlike the keys 'label', 'color', 'size' etc),
        // it stores it in the node 'attr' object :
        attributesToString( node['attr']['attributes'] )
      ).attr(
        'id',
        'node-info'+sigInst.getID()
      ).css({
        'display': 'inline-block',
        'border-radius': 3,
        'padding': 5,
        'background': '#fff',
        'color': '#000',
        'box-shadow': '0 0 4px #666',
        'position': 'absolute',
        'left': node.displayX,
        'top': node.displayY+15
      });
 
      $('ul',popUp).css('margin','0 0 0 20px');
 
      $('#sigma-example').append(popUp);
    }
 
    function hideNodeInfo(event) {
      popUp && popUp.remove();
      popUp = false;
    }
 
    sigInst.bind('overnodes',showNodeInfo).bind('outnodes',hideNodeInfo).draw();
  })();
}
 
if (document.addEventListener) {
  document.addEventListener('DOMContentLoaded', init, false);
} else {
  window.onload = init;
}
    // TODO
  };

  this.getID = function() {
    return s.id;
  };

  // Config:
  this.configProperties = function(a1, a2) {
    var res = s.config(a1, a2);
    return res == s ? self : res;
  };

  this.drawingProperties = function(a1, a2) {
    var res = s.plotter.config(a1, a2);
    return res == s.plotter ? self : res;
  };

  this.mouseProperties = function(a1, a2) {
    var res = s.mousecaptor.config(a1, a2);
    return res == s.mousecaptor ? self : res;
  };

  this.graphProperties = function(a1, a2) {
    var res = s.graph.config(a1, a2);
    return res == s.graph ? self : res;
  };

  this.getMouse = function() {
    return {
      mouseX: s.mousecaptor.mouseX,
      mouseY: s.mousecaptor.mouseY,
      down: s.mousecaptor.isMouseDown
    };
  };

  // Actions:
  this.position = function(stageX, stageY, ratio) {
    if (arguments.length == 0) {
      return {
        stageX: s.mousecaptor.stageX,
        stageY: s.mousecaptor.stageY,
        ratio: s.mousecaptor.ratio
      };
    }else {
      s.mousecaptor.stageX = stageX != undefined ?
        stageX :
        s.mousecaptor.stageX;
      s.mousecaptor.stageY = stageY != undefined ?
        stageY :
        s.mousecaptor.stageY;
      s.mousecaptor.ratio = ratio != undefined ?
        ratio :
        s.mousecaptor.ratio;

      return self;
    }
  };

  this.goTo = function(stageX, stageY, ratio) {
    s.mousecaptor.interpolate(stageX, stageY, ratio);
    return self;
  };

  this.zoomTo = function(x, y, ratio) {
    ratio = Math.min(
              Math.max(s.mousecaptor.config('minRatio'), ratio),
              s.mousecaptor.config('maxRatio')
            );
    if (ratio == s.mousecaptor.ratio) {
      s.mousecaptor.interpolate(
        x - s.width / 2 + s.mousecaptor.stageX,
        y - s.height / 2 + s.mousecaptor.stageY
      );
    }else {
      s.mousecaptor.interpolate(
        (ratio * x - s.mousecaptor.ratio * s.width/2) /
        (ratio - s.mousecaptor.ratio),
        (ratio * y - s.mousecaptor.ratio * s.height/2) /
        (ratio - s.mousecaptor.ratio),
        ratio
      );
    }
    return self;
  };

  this.resize = function(w, h) {
    s.resize(w, h);
    return self;
  };

  this.draw = function(nodes, edges, labels, safe) {
    s.draw(nodes, edges, labels, safe);
    return self;
  };

  this.refresh = function() {
    s.refresh();
    return self;
  };

  // Tasks methods:
  this.addGenerator = function(id, task, condition) {
    sigma.chronos.addGenerator(id + '_ext_' + s.id, task, condition);
    return self;
  };

  this.removeGenerator = function(id) {
    sigma.chronos.removeGenerator(id + '_ext_' + s.id);
    return self;
  };

  // Graph methods:
  this.addNode = function(id, params) {
    s.graph.addNode(id, params);
    return self;
  };

  this.addEdge = function(id, source, target, params) {
    s.graph.addEdge(id, source, target, params);
    return self;
  }

  this.dropNode = function(v) {
    s.graph.dropNode(v);
    return self;
  };

  this.dropEdge = function(v) {
    s.graph.dropEdge(v);
    return self;
  };

  this.pushGraph = function(object, safe) {
    object.nodes && object.nodes.forEach(function(node) {
      node['id'] && (!safe || !s.graph.nodesIndex[node['id']]) &&
                    self.addNode(node['id'], node);
    });

    var isEdgeValid;
    object.edges && object.edges.forEach(function(edge) {
      validID = edge['source'] && edge['target'] && edge['id'];
      validID &&
        (!safe || !s.graph.edgesIndex[edge['id']]) &&
        self.addNode(
          edge['id'],
          edge['source'],
          edge['target'],
          edge
        );
    });

    return self;
  };

  this.emptyGraph = function() {
    s.graph.empty();
    return self;
  };

  this.getNodesCount = function() {
    return s.graph.nodes.length;
  };

  this.getEdgesCount = function() {
    return s.graph.edges.length;
  };

  this.iterNodes = function(fun, ids) {
    s.graph.iterNodes(fun, ids);
    return self;
  };

  this.iterEdges = function(fun, ids) {
    s.graph.iterEdges(fun, ids);
    return self;
  };

  this.getNodes = function(ids) {
    return s.graph.getNodes(ids);
  };

  this.getEdges = function(ids) {
    return s.graph.getEdges(ids);
  };

  // Monitoring
  this.activateMonitoring = function() {
    return s.monitor.activate();
  };

  this.desactivateMonitoring = function() {
    return s.monitor.desactivate();
  };

  // Events
  s.bind('downnodes upnodes downgraph upgraph', function(e) {
    self.dispatch(e.type, e.content);
  });

  s.graph.bind('overnodes outnodes', function(e) {
    self.dispatch(e.type, e.content);
  });
}

