<?php

/* VizDataVizBundle:Page:index.html.twig */
class __TwigTemplate_0dd7ecf9016c105c7c021a6ff5d924ad64375382a904fcb9dd3feeeba0554daf extends Twig_Template
{
    public function __construct(Twig_Environment $env)
    {
        parent::__construct($env);

        $this->parent = $this->env->loadTemplate("VizDataVizBundle::layout.html.twig");

        $this->blocks = array(
            'body' => array($this, 'block_body'),
            'stylesheets' => array($this, 'block_stylesheets'),
            'javascripts' => array($this, 'block_javascripts'),
        );
    }

    protected function doGetParent(array $context)
    {
        return "VizDataVizBundle::layout.html.twig";
    }

    protected function doDisplay(array $context, array $blocks = array())
    {
        // line 6
        if (array_key_exists("form", $context)) {
            // line 7
            $this->env->getExtension('form')->renderer->setTheme((isset($context["form"]) ? $context["form"] : $this->getContext($context, "form")), array(0 => "::base.html.twig"));
        }
        $this->parent->display($context, array_merge($this->blocks, $blocks));
    }

    // line 4
    public function block_body($context, array $blocks = array())
    {
    }

    // line 10
    public function block_stylesheets($context, array $blocks = array())
    {
        // line 11
        echo "      ";
        $this->displayParentBlock("stylesheets", $context, $blocks);
        echo "
  ";
    }

    // line 14
    public function block_javascripts($context, array $blocks = array())
    {
        // line 15
        echo "    ";
        $this->displayParentBlock("javascripts", $context, $blocks);
        echo "
    <script type=\"text/javascript\">


    function init() {
        // var r=";
        // line 20
        echo twig_jsonencode_filter($this->getAttribute((isset($context["metadata"]) ? $context["metadata"] : $this->getContext($context, "metadata")), "nodes"));
        echo ";
        //    alert(r.toSource());
        var sigInst = sigma.init(\$('#sigma-example')[0]).drawingProperties({
            defaultLabelColor: '#000',
            edgeColor: 'target',
            defaultEdgeType: 'line'
        }).graphProperties({
                    minNodeSize: 4,
                    maxNodeSize: 10,
                    minEdgeSize: 1,
                    maxEdgeSize: 5,
                    scalingMode: 'inside'
                });
        var greyColor = '#fff';
        sigInst.parseJson(";
        // line 34
        echo twig_jsonencode_filter((isset($context["metadata"]) ? $context["metadata"] : $this->getContext($context, "metadata")));
        echo ");

        sigInst.draw();

    //    alert(sigInst.getEdgesCount());

        var wer=";
        // line 40
        echo $this->getAttribute((isset($context["metadata"]) ? $context["metadata"] : $this->getContext($context, "metadata")), "flag");
        echo ";



        if(wer==22){
            document.getElementById('c').hidden=false;
            document.getElementById('time').hidden=false;
            document.getElementById('e').hidden=false;
            \$( \"#ndslider\" ).slider({
                value:0,
                min: 0,
                max: sigInst.getNodesCount(),
                step: 1,
                slide: function( event, ui ) {
                    \$( \"#ndamount\" ).val(  [ui.value] );
                    filterClusterByNodes([ui.value]);
                }
            });

            var valMap=getRetwArray();

            \$( \"#rtslider\" ).slider({
                value:0,
                min: 0,
                max: valMap.length-1,
                step: 1,
                slide: function( event, ui ) {
                    \$( \"#rtamount\" ).val(  valMap[ui.value] );
                    retweeting(valMap[ui.value]);
                }
            });
            \$( \"#rtamount\" ).val(  \$( \"#rtslider\" ).slider( \"value\" ) );
            sigInst.bind('downnodes',gotoProfile);
               getTimeRange();
            if(!timerange || timerange.length<2){
                document.getElementById('time').hidden=true;
            }
            newCanvas('22');
        }
        else{
            sigInst.bind('downnodes',onClick);
            if(wer==11){
                \$( \"#ndslider\" ).slider({
                    value:0,
                    min: 0,
                    max: sigInst.getNodesCount(),
                    step: 1,
                    slide: function( event, ui ) {
                        \$( \"#ndamount\" ).val(  [ui.value] );
                        filterClusterByNodes([ui.value]);
                    }
                });
            }
            newCanvas('11');
        }

        function gotoProfile(downnodes){
            var href;
            sigInst.iterNodes(function(n){
                href=n.label;

            },[downnodes.content[0]]);
            var l= \"https://twitter.com/\"+href;
            window.open(l);

            if (sigInst._core.mousecaptor.isMouseDown==true){
                sigInst._core.mousecaptor.isMouseDown = !sigInst._core.mousecaptor.isMouseDown;
            }


        }



        \$( \"#ndamount\" ).val(  \$( \"#ndslider\" ).slider( \"value\" ) );
        var edgeArray=getEdgesArray();

        \$( \"#edslider\" ).slider({
            value:0,
            min: 0,
            max: getEdgesArray().length-1,
            step: 1,
            slide: function( event, ui ) {
                \$( \"#edamount\" ).val(  edgeArray[ui.value] );
                filterClusterByEdges(edgeArray[ui.value]);
            }
        });
        \$( \"#edamount\" ).val(  \$( \"#edslider\" ).slider( \"value\" ) );

        sigInst.bind('overnodes',function(event){
            var nodes = event.content;
            var neighbors = {};
            sigInst.iterEdges(function(e){
                if(nodes.indexOf(e.source)<0 && nodes.indexOf(e.target)<0){
                    if(!e.attr['grey']){
                        e.attr['true_color'] = e.color;
                        e.color = greyColor;
                        e.attr['grey'] = 1;
                    }
                }else{
                    e.color = e.attr['grey'] ? e.attr['true_color'] : e.color;
                    e.attr['grey'] = 0;
                    neighbors[e.source] = 1;
                    neighbors[e.target] = 1;
                }
            }).iterNodes(function(n){
                        if(!neighbors[n.id]){
                            if(!n.attr['grey']){
                                n.attr['true_color'] = n.color;
                                n.color = greyColor;
                                n.attr['grey'] = 1;
                            }
                        }else{
                            n.color = n.attr['grey'] ? n.attr['true_color'] : n.color;
                            n.attr['grey'] = 0;
                        }
                    }).draw(2,2,2);
        }).bind('outnodes',function(){
                    sigInst.iterEdges(function(e){
                        e.color = e.attr['grey'] ? e.attr['true_color'] : e.color;
                        e.attr['grey'] = 0;
                    }).iterNodes(function(n){
                                n.color = n.attr['grey'] ? n.attr['true_color'] : n.color;
                                n.attr['grey'] = 0;
                            }).draw(2,2,2);
                });
        sigInst.draw();
        (function(){
            var popUp;
            function attributesToString(attr) {
                return '<ul>' +
                        attr.map(function(o){
                            while(o.attr!='retweets'){
                                return '<li>' + o.attr + ' : ' + o.val + '</li>';
                            }
                        }).join('') +
                        '</ul>';
            }
            function showNodeInfo(event) {
                popUp && popUp.remove();
                var node;
                sigInst.iterNodes(function(n){
                    node = n;
                },[event.content[0]]);
                popUp = \$(
                        '<div class=\"node-info-popup\"></div>').append(
                                attributesToString( node['attr']['attributes'] )
                        ).attr(
                                'id',
                                'node-info'+sigInst.getID()
                        ).css({
                            'display': 'inline-block',
                            'width' : '160px',

                            'overflow' : 'scroll',
                            'border-radius': 3,
                            'padding': 5,
                            'background': '#fff',
                            'color': '#000',
                            'box-shadow': '0 0 4px #666',
                            'position': 'relative',
                            'left': node.displayX,

                            'top': node.displayY+5
                        });

                \$('ul',popUp).css('margin','0 0 0 20px');
                \$('#sigma-example').append(popUp);
            }
            function hideNodeInfo(event) {
                popUp && popUp.remove();
                popUp = false;
            }
            sigInst.bind('overnodes',showNodeInfo).bind('outnodes',hideNodeInfo).bind('downnodes',hideNodeInfo).draw();

            sigInst.draw();
        })();
        var str;

        function onClick(downnodes){
            /*  if(running){
             sigInst.stopForceAtlas2();
             sigInst.draw();
             }*/
            wer=33;

            document.getElementById('c').hidden=false;
            document.getElementById('time').hidden=false;
            document.getElementById('e').hidden=false;
            sigInst.iterNodes(function(n){
                var id= n.id;
                //  str=cluster(id);
                \$.ajax({
                    type: \"POST\",

                    url: \"";
        // line 235
        echo $this->env->getExtension('routing')->getPath("VizDataVizBundle_commShow");
        echo "\",
                    data: {id: id},
                    dataType:'json',
                    success: function(response){
                        str=response;
                        sigInst.emptyGraph();
                        sigInst.parseJson(response);
                        sigInst.draw();
                        sigInst.iterNodes(function(n){
                            var    ar=getRetweetsPerNode(n.id);

                            //    alert(n.label+ \"has\"+ar+\"retweets\" );
                        });
                        var maximum;
                        var minimum;
                        var valMap=getRetwArray();
                        if(valMap.length==1){
                            minimum=0;
                            maximum=71;

                        }
                        else{
                            maximum=valMap.length-1;
                            minimum=0;
                        }
                        \$( \"#rtslider\" ).slider({

                            value:0,
                            min: minimum,
                            max: maximum


                        });

                        \$('#rtslider').slider(\"option\",\"slide\",function(event, ui) {
                            var slidervalue;
                            if(valMap.length==1){
                                slidervalue=valMap[0];

                            }
                            else{
                                slidervalue=valMap[ui.value];
                            }
                            \$( \"#rtamount\" ).val( slidervalue);
                            retweeting(slidervalue);
                        });
                        \$( \"#rtamount\" ).val(  \$( \"#rtslider\" ).slider( \"value\" ) );
                        \$(\"#ndslider\").slider(\"option\",\"max\",sigInst.getNodesCount());
                        var valMap2=getEdgesArray();
                        \$('#edslider').slider(\"option\",\"max\",valMap2.length-1);
                        \$('#edslider').slider(\"option\",\"slide\",function(event, ui) {
                            \$( \"#edamount\" ).val(  valMap2[ui.value] );
                            filterClusterByEdges(valMap2[ui.value]);
                        });
                        \$('#ndslider').slider(\"option\",\"slide\",function(event, ui) {
                            \$( \"#ndamount\" ).val( [ui.value] );
                            filterClusterByNodes([ui.value]);
                        });
                        \$( \"#edamount\" ).val(  \$( \"#edslider\" ).slider( \"value\" ) );
                        var s='cl';

                        newCanvas(s);
                       getTimeRange();
                        function onClick1(downnodes){
                            var href;
                            sigInst.iterNodes(function(no){
                                href=\"https://twitter.com/\"+no.label;


                            },[downnodes.content[0]]);

                            window.open(href);
                        }
                        sigInst.bind('downnodes',onClick1);



                    }

                });

            },[downnodes.content[0]]);
            sigInst.draw();

            if (sigInst._core.mousecaptor.isMouseDown==true){
                sigInst._core.mousecaptor.isMouseDown = !sigInst._core.mousecaptor.isMouseDown;
            }



        }

        sigma.publicPrototype.myCircularLayout = function() {
            var R = 100,
                    i = 0,
                    L = this.getNodesCount();

            this.iterNodes(function(n){
                n.x = Math.cos(Math.PI*(i++)/L)*R;
                n.y = Math.sin(Math.PI*(i++)/L)*R;
            });

            return this.position(0,0,1).draw();
        };



        function getRetwArray(){   /// ex getMaxRetwCount()
            var  ar=[];
            sigInst.iterNodes(function(n){
                var o=n.attr['attributes'][2].val[0];
                var m=0;
                if(o!=null){
                    for(var i=0;i< n.attr['attributes'][2].val.length;i++){
                        ar.push(n.attr['attributes'][2].val[i].rtw);
                    }
                }
            });
            ar.sort(function(a,b){return a-b});
            ar = ar.filter( function( item, index, inputArray ) {
                return inputArray.indexOf(item) == index;
            });

            return ar;
        }
        function getTempRetwArray(){   /// ex getMaxRetwCount()
            var  ar=[];
            sigInst.iterNodes(function(n){
                if(!n.hidden){
                    var o=n.attr['attributes'][2].val[0];
                    var m=0;
                    if(o!=null){
                        for(var i=0;i< n.attr['attributes'][2].val.length;i++){
                            ar.push(n.attr['attributes'][2].val[i].rtw);
                        }
                    }
                }
            });
            ar.sort(function(a,b){return a-b});
            ar = ar.filter( function( item, index, inputArray ) {
                return inputArray.indexOf(item) == index;
            });

            return ar;
        }

        function findNeighbors(id){
            var neighbors=[];
            sigInst.iterEdges(function(e){
                if(id== e.source){
                    neighbors.push(e.target);
                }
                else if (id== e.target){
                    neighbors.push(e.source);
                }
            });
            return neighbors.length;
        }
        function findTempNeighbors(id){
            var neighbors=[];
            sigInst.iterEdges(function(e){
                if(!e.hidden){
                    if(id== e.source){
                        neighbors.push(e.target);
                    }
                    else if (id== e.target){
                        neighbors.push(e.source);
                    }
                }
            });
            return neighbors.length;
        }

        function getMaxRetwCount(){
            var  max=0;
            sigInst.iterNodes(function(n){
                var o=n.attr['attributes'][2].val[0];
                var m=0;
                if(o!=null){
                    for(var i=0;i< n.attr['attributes'][2].val.length;i++){
                        if(n.attr['attributes'][2].val[i].rtw>m){
                            m= n.attr['attributes'][2].val[i].rtw;
                        }
                    }
                    if(max<m){
                        max=m;
                    }
                    m=0;
                }
            });
            return max;
        }

        function getMaxDegree(){
            var max=0
            sigInst.iterNodes(function(n){
                if(n.size>max){
                    max= n.size;
                }
            });
            return max;
        }

        function sortNodes(){
            var newArray= [];
            sigInst.iterNodes(function(n){
                if(n.attr['attributes'][2]){
                    newArray.push({id: n.id, size: n.size,density:  n.attr['attributes'][2].val, flag:0});
                }else{
                    newArray.push({id: n.id, size: n.size,density: n.size  ,flag:0});
                }
            });
            var swapped;
            do {
                swapped = false;
                for (var i = 0; i < newArray.length - 1; i++) {
                    if (newArray[i].size < newArray[i + 1].size) {
                        var temp = newArray[i];
                        newArray[i] = newArray[i + 1];
                        newArray[i + 1] = temp;
                        swapped = true;
                    }
                }
            } while (swapped);

            for ( i = 0; i < newArray.length - 1; i++) {
                for ( var j = 0; j < newArray.length - 1; j++){
                    if(newArray[i].size===newArray[j].size && newArray[j].flag!=1){
                        if(newArray[i].density<newArray[j].density){
                            temp=newArray[i];
                            newArray[i]=newArray[j];
                            newArray[j]=temp;
                            newArray[i].flag=1;
                            newArray[j].flag=1;
                        }
                    }
                }
            }
            return newArray;
        }

        function sortTemporalNodes(nodes){

            var swapped;
            do {
                swapped = false;
                for (var i = 0; i < nodes.length - 1; i++) {
                    if (nodes[i].size < nodes[i + 1].size) {
                        var temp = nodes[i];
                        nodes[i] = nodes[i + 1];
                        nodes[i + 1] = temp;
                        swapped = true;
                    }
                }
            } while (swapped);

            for ( i = 0; i < nodes.length - 1; i++) {
                for ( var j = 0; j < nodes.length - 1; j++){
                    if(nodes[i].size===nodes[j].size && nodes[j].flag!=1){
                        if(nodes[i].density<nodes[j].density){
                            temp=nodes[i];
                            nodes[i]=newArray[j];
                            nodes[j]=temp;
                            nodes[i].flag=1;
                            nodes[j].flag=1;
                        }
                    }
                }
            }
            return nodes;
        }
        var resc=false;
        \$('#circular').click(function() {
            if(!resc){
                sigInst.myCircularLayout();
                resc=true;

                \$('#circular').val('rescale');
                sigInst.draw(2,2,2);
                newCanvas('circ');
            }
            else{
                sigInst.iterNodes(function(n){
                    n.x = Math.random();
                    n.y =Math.random();
                });
                sigInst.draw(2,2,2);
                resc=false;
                \$('#circular').val('circular');
                newCanvas('rand');
            }
        });

        var fish=false;
        \$('#fisheye').click(function(){
            if(!fish){
                sigInst.activateFishEye().draw();
                \$('#fisheye').val('stop fisheye');
                fish=true;
            }
            else{
                sigInst.desactivateFishEye().draw();
                fish=false;
                \$('#fisheye').val('start fisheye');            }
        });
        var running=false;
        \$('#force-atlas').click(function(){
            if(\$('#force-atlas').val()=='start force atlas'){
                running=true;
                sigInst.startForceAtlas2();
                \$('#force-atlas').val('stop force atlas');
                newCanvas('forced');
            }
            else{

                sigInst.stopForceAtlas2();
                \$('#force-atlas').val('start force atlas');
                //  sigInst.draw(2,2,2);
                newCanvas('forced');
                running=false;

            }
        });

        function checkForceAtlas(overnodes){
            if(running){
                sigInst.iterNodes(function(no){
                    sigInst.stopForceAtlas2();
                    running=false;
                    \$('#force-atlas').val('start force atlas');
                },[overnodes.content[0]]);

            }


        };
        sigInst.bind('overnodes',checkForceAtlas);
        /*     (function(){

         var v=\$('#force-atlas').val();
         if(running){
         /* if(v=='Stop random'){
         document.getElementById('force-atlas').childNodes[0].nodeValue ='Start random ';

         }
         alert(\"grg\");
         }
         })();**/

        function getEdgesArray(){     /// neighbors sto metagrafo
            var ar=[];
            sigInst.iterNodes(function(n){
                var neigh=findNeighbors(n.id);
                ar.push(neigh);
            });

            ar.sort(function(a,b){return a-b});
            ar = ar.filter( function( item, index, inputArray ) {
                return inputArray.indexOf(item) == index;
            });

            return ar;
        }

        var temporalEdgesArray=[];
        function getTemporalEdgesArray(){
            var ar=[];


            sigInst.iterNodes(function(n){
                if(!n.hidden){
                    var neigh=findTempNeighbors(n.id);
                    temporalEdgesArray.push({neigh:neigh, id: n.id});
                    ar.push(neigh);
                }

            });
            var tmp;
            for(var i=0;i<ar.length-1;i++){
                if(ar[i].neigh>ar[i+1].neigh){
                    tmp=ar[i];
                    ar[i]=ar[i+1];
                    ar[i+1]=tmp;
                }
            }

            ar.sort(function(a,b){return a-b});
            ar = ar.filter( function( item, index, inputArray ) {
                return inputArray.indexOf(item) == index;
            });
            ///   alert(JSON.stringify(ar));
            return ar;

        }

        function   filterClusterByEdges(edgeNum){
            \$('#ndslider').slider(\"option\",\"value\",0);
            \$( \"#ndamount\" ).val(  \$( \"#ndslider\" ).slider( \"value\" ) );
            sigInst.draw(2,2,2);
            var s='e';
            var flag=false;
            var neighbors = {};
            sigInst.iterEdges(function(e){
                if (sigInst.getNodes(e.source).size %1===0){ //vlepw an eimai sto metagrafo i se mesa sto cluster
                    var id1=sigInst.getNodes(e.source).id;
                    var size1=findNeighbors(id1);
                    var  id2=sigInst.getNodes(e.target).id;
                    var size2=findNeighbors(id2);
                    if(edgeNum==size1){
                        neighbors[e.source] = 1;
                        neighbors[e.target] = 1;
                        flag=true;
                    }
                    else if(edgeNum==size2){
                        neighbors[e.source] = 1;
                        neighbors[e.target] = 1;
                        flag=true;
                    }
                }
                else{
                    if(edgeNum==sigInst.getNodes(e.source).size){
                        neighbors[e.source] = 1;
                        neighbors[e.target] = 1;
                        flag=true;
                    }
                    else if( edgeNum==sigInst.getNodes(e.target).size){
                        neighbors[e.source] = 1;
                        neighbors[e.target] = 1;
                        flag=true;
                    }
                }
            })
                    .iterNodes(function(n){
                        if(!neighbors[n.id]){
                            n.hidden = 1;
                        }else{
                            n.hidden = 0;
                            if(coloredNodeId){
                                coloredNodeId.map(function(m){
                                    if(m== n.id){
                                        n.color='#f00';}
                                });
                            }
                        }

                    }).draw(2,2,2);

            if (flag){
                newCanvas(s);
                flag=false;
            }
        }

        function filterTemporalByEdges(edgeNum){
            \$('#ndslider').slider(\"option\",\"value\",0);
            \$( \"#ndamount\" ).val(  \$( \"#ndslider\" ).slider( \"value\" ) );
            sigInst.draw(2,2,2);
            var s='e';
            var flag=false;
            var neighbors = {};
            sigInst.iterNodes(function(n){
                n.hidden=n['before'];

            });


            var newnodes=[];
            //alert(JSON.stringify(temporalEdgesArray));
            for(var i=0; i<temporalEdgesArray.length; i++){
                if(temporalEdgesArray[i].neigh==edgeNum ){
                    newnodes.push(temporalEdgesArray[i].id);

                }
            }
            //  alert(temporalEdgesArray[i].neigh);
            var neighbors={};
            sigInst.iterEdges(function(e){
                if(!e.hidden){
                    if(newnodes.indexOf(e.source)>-1) {
                        neighbors[e.source]=1;
                        neighbors[e.target]=1;
                    }
                    else if( newnodes.indexOf(e.target)>-1){
                        neighbors[e.source]=1;
                        neighbors[e.target]=1;
                    }


                }
            }).iterNodes(function(n){
                        if(!n.hidden){
                            if(!neighbors[n.id]){
                                n['before']= n.hidden;
                                n.hidden = 1;

                            }else{
                                n['before']= n.hidden;
                                n.hidden = 0;
                                tcoloredNodeId.map(function(m){
                                    if(m== n.id){
                                        n.color='#f00';}
                                });

                            }
                        }
                    }
            )
                    .draw(2,2,2);

            if (flag){
                newCanvas(s);
                flag=false;
            }


        }
        function filterClusterByNodes(nodeNum){
            \$('#edslider').slider(\"option\",\"value\",0);
            \$( \"#edamount\" ).val(  \$( \"#edslider\" ).slider( \"value\" ) );
            var s='n';
            var flag;
            //  var nodeNum=this.value;
            var a=[];
            a=sortNodes();
            var ar= [];
            var neighbors = {};
            for(var i=0;i<nodeNum;i++){
                ar.push(a[i].id);
            }
            sigInst.iterEdges(function(e){
                var flag=false;
                if(ar.indexOf(e.source)<0 && ar.indexOf(e.target)<0){
                    //  e.hidden=1;

                    neighbors[e.source]=1;
                    neighbors[e.target]=1;
                }
                else if(ar.indexOf(e.source)<0){
                    neighbors[e.source]=1;
                }
                else if(ar.indexOf(e.target)<0){
                    neighbors[e.target]=1;
                }
            }).iterNodes(function(n){
                        if(!neighbors[n.id]){
                            n.hidden =0;

                            //    alert(\"found\");
                            coloredNodeId.map(function(m){
                                if(m== n.id){
                                    n.color='#f00';}
                            });

                        }
                        else{
                            n.hidden = 1;
                        }
                    }
            ).draw(2,2,2);

            newCanvas(s);
        }
        var timeflag=true;
        var vMap;
        var nds=[];
        var timerange=[];
           function getTimeRange(){
         timerange=[];
         sigInst.iterEdges(function(e){
         var time=e.attr['attributes'][1].val;
         timerange.push(time);

         });

         timerange.sort(function (a, b) {
         return new Date('1970/01/01 ' + a) - new Date('1970/01/01 ' + b);
         });

         \$('#time3').timepicker('option','minTime', timerange[0]);
        \$('#time3').timepicker('option','maxTime', timerange[timerange.length-1]);
               \$('#time4').timepicker('option','minTime', timerange[0]);
               \$('#time4').timepicker('option','maxTime', timerange[timerange.length-1]);
               \$('#time3').timepicker('option','step', 1);
               \$('#time4').timepicker('option','step',1);









           }
  /*      \$(document).on('click','#hashtags',function(){
            \$('#time3').timepicker('option','step', 1);
            \$('#time4').timepicker('option','step',1);



        });*/
      \$('#time3').on('changeTime',function(){
         //   \$('#time3').timepicker('setTime',\$(this).val);
            \$('#time3').timepicker('setTime',(\$('#time3').val()));


        });
        \$('#time4').on('changeTime', function() {
            var s='t';

            var v1=document.getElementById('time3').value;
            var v2=document.getElementById('time4').value;
            sigInst.emptyGraph();
            if (wer.valueOf()==33){
                sigInst.parseJson(str);
            }
            else{
                sigInst.parseJson(";
        // line 852
        echo twig_jsonencode_filter((isset($context["metadata"]) ? $context["metadata"] : $this->getContext($context, "metadata")));
        echo ");
            }
            if(timeflag){
                newCanvas(s);
            }//  alert(sigInst.getNodesCount());

            \$('#ndslider').slider(\"option\",\"value\",0);
            \$( \"#ndamount\" ).val(  \$( \"#ndslider\" ).slider( \"value\" ) );
            \$('#edslider').slider(\"option\",\"value\",0);
            \$( \"#edamount\" ).val(  \$( \"#edslider\" ).slider( \"value\" ) );
            \$('#rtslider').slider(\"option\",\"value\",0);
            \$( \"#rtamount\" ).val(  \$( \"#rtslider\" ).slider( \"value\" ) );

            temporalUnfiltered(v1,v2); // edw allazw k ta oria
            var counter=0;

            sigInst.iterNodes(function(n){
                if(!n.hidden){
                    counter++;
                    nds.push({id: n.id,density:n.size, size: n.size,label: n.label});
                }
            });
            //   alert(JSON.stringify(nds));
            //    a=sortTemporalNodes(nodes);
            \$(\"#ndslider\").slider(\"option\",\"max\",counter);
            vMap=getTemporalEdgesArray();
            \$('#edslider').slider(\"option\",\"max\",vMap.length-1);
            var rMap=getTempRetwArray();
            \$('#rtslider').slider(\"option\",\"max\",rMap.length-1);
            \$('#rtslider').slider(\"option\",\"slide\",function(event, ui) {
                \$( \"#rtamount\" ).val(  rMap[ui.value] );
                temporalRetweeting(rMap[ui.value]);
            });




            \$('#edslider').slider(\"option\",\"slide\",function(event, ui) {
                \$( \"#edamount\" ).val(  vMap[ui.value] );
                filterTemporalByEdges(vMap[ui.value]);

            });
            \$('#ndslider').slider(\"option\",\"slide\",function(event, ui) {
                \$( \"#ndamount\" ).val( [ui.value] );
                filterTemporalBynodes([ui.value]);

            });


        });

        function filterTemporalBynodes(nnn){
            \$('#edslider').slider(\"option\",\"value\",0);
            \$( \"#edamount\" ).val(  \$( \"#edslider\" ).slider( \"value\" ) );
            var s='n';
            var flag;
            //  alert();
            var  a=sortTemporalNodes(nds);
            var ar= [];
            var neighbors = {};
            for(var i=0;i<nnn;i++){
                ar.push(a[i].id)
            }
            sigInst.iterEdges(function(e){
                var flag=false;
                if(ar.indexOf(e.source)<0 && ar.indexOf(e.target)<0){

                    neighbors[e.source]=1;
                    neighbors[e.target]=1;
                }
                else if(ar.indexOf(e.source)<0){
                    neighbors[e.source]=1;
                }
                else if(ar.indexOf(e.target)<0){
                    neighbors[e.target]=1;
                }


            }).iterNodes(function(n){

                        if(!neighbors[n.id]){
                            n['before']= n.hidden;
                            n.hidden =0;


                            tcoloredNodeId.map(function(m){
                                if(m== n.id){
                                    n.color='#f00';}
                            });

                        }
                        else{
                            n['before']= n.hidden;
                            n.hidden = 1;
                        }

                    }

            ).draw(2,2,2);

            newCanvas(s);

        }

        function temporalUnfiltered(v1,v2){
            var neighbors={};
            var arEd=[];
            //   var v1=document.getElementById('time3').value;
            //   var v2=document.getElementById('time4').value;
            if(v1<v2){
                sigInst.iterEdges(function(e){

                    var time=e.attr['attributes'][1].val;
                    //    alert(time);
                    if (!(v1<=time && v2>=time)){
                        e['before']= e.hidden;
                        e.hidden=1;
                    }

                });
                sigInst.iterEdges(function(e){
                    if(!e.hidden){
                        arEd.push(e.source);
                        arEd.push(e.target);
                    }

                }).iterNodes(function(n){
                            if(arEd.indexOf(n.id)>-1){
                                n.hidden=0;
                            }
                            else{n.hidden=1;
                            }

                        })
                        .draw(2,2,2);
            }
        }
        function getRetweetsPerNode(id){

            var rtws=[];

            var n=sigInst.getNodes(id);
            var o=n.attr['attributes'][2].val[0];
            if(o!=null){
                //   alert(n.label);
                for(var i=0;i< n.attr['attributes'][2].val.length;i++){
                    rtws.push(n.attr['attributes'][2].val[i].rtw);/// _id gia ta ids
                }
            }
            else {
                rtws=0;
            }

            return rtws;
        }

        var coloredNodeId=[];

        function retweeting(num){
            //  alert(num);
            if(coloredNodeId.length>0){
                sigInst.iterNodes(function(n){
                    coloredNodeId.map(function(m){
                        if(m== n.id){
                            n.color= n.attr['true_color'];
                        }

                    })

                });

            }
            coloredNodeId=[];
            var s='rt';
            var flag=false;
            sigInst.iterNodes(function(n){
                var    ar=getRetweetsPerNode(n.id);
                //  alert(n.label+ \"has\"+ar+\"retweets\" );


                if (ar!==0){

                    for(var i=0;i<ar.length;i++){
                        if(num==ar[i]){

                            //   if(ar.indexOf(num)!=-1){
                            //  alert(n.label);
                            var color='#f00';
                            if(!n.attr['c']){
                                n.attr['true_color'] = n.color;
                                n.color = color;
                                //  alert(n.label);
                                n.attr['c'] = 1;
                                flag=true;
                                coloredNodeId.push(n.id);
                            }
                        }
                    }
                }
            }).iterEdges(function(e){
                        if(sigInst.getNodes(e.source).attr['c']==1){
                            e.attr['true_color']= e.color;
                            e.color=sigInst.getNodes(e.source).attr['true_color'];
                        }
                    }).draw(2,2,2);
            if(flag){
                newCanvas(s);
                flag=false;
            }

            sigInst.iterNodes(function(n){
                n.color = n.attr['c'] ?  n.attr['true_color'] : n.color;
                n.attr['c'] = 0;

            }).iterEdges(function(e){
                        e.color= e.attr['true_color'];
                    });
            sigInst.edgeColor='target';
        }

        var tcoloredNodeId=[];
        function temporalRetweeting(num){

            if(tcoloredNodeId.length>0){
                sigInst.iterNodes(function(n){
                    if(!n.hidden){
                        tcoloredNodeId.map(function(m){
                            if(m== n.id){
                                n.color= n.attr['true_color'];
                            }

                        })
                    }
                });

            }

            tcoloredNodeId=[];
            //  alert(coloredNodeId.length);
            var s='rt';
            var flag=false;
            //    sigInst.draw(2,2,2);
            sigInst.iterNodes(function(n){
                if(!n.hidden){
                    var ar=[];
                    ar=getRetweetsPerNode(n.id);
                    if (ar!==0){
                        for(var i=0;i<ar.length;i++){
                            if(num==ar[i]){
                                var color='#f00';
                                if(!n.attr['c']){
                                    n.attr['true_color'] = n.color;
                                    n.color = color;
                                    n.attr['c'] = 1;
                                    flag=true;
                                    tcoloredNodeId.push(n.id);
                                }
                            }
                        }
                    }
                }
            }).iterEdges(function(e){
                        if(!e.hidden){
                            if(sigInst.getNodes(e.source).attr['c']==1){
                                e.attr['true_color']= e.color;
                                e.color=sigInst.getNodes(e.source).attr['true_color'];
                            }
                        }
                    }).draw(2,2,2);
            if(flag){
                newCanvas(s);
                flag=false;
            }

            sigInst.iterNodes(function(n){
                //   n.attr['true_color']=nc;
                n.color = n.attr['c'] ?  n.attr['true_color'] : n.color;
                n.attr['c'] = 0;

            }).iterEdges(function(e){
                        e.color= e.attr['true_color'];
                    });
            sigInst.edgeColor='target';
        }

        \$('#colorNodes').on('change', function() {
            var s='cn';
            var color=this.value;
            sigInst.iterNodes(function(n){
                n.color=color;
            });
            sigInst.draw(2,2,2);
            newCanvas(s);

        });
        \$('#colorEdges').on('change', function() {
            var s='ce';
            var color=this.value;
            sigInst.iterEdges(function(e){
                e.color=color;
            });
            sigInst.draw(2,2,2);
            newCanvas(s);
        });
        document.getElementById('refresh').addEventListener('click',function(){
                    timeflag=false;
                    sigInst.emptyGraph();
                    if (wer.valueOf()==33){
                        sigInst.parseJson(str);
                    }
                    else{
                        sigInst.parseJson(";
        // line 1163
        echo twig_jsonencode_filter((isset($context["metadata"]) ? $context["metadata"] : $this->getContext($context, "metadata")));
        echo ");
                    }


                    \$('#ndslider').slider(\"option\",\"value\",0);
                    \$( \"#ndamount\" ).val(  \$( \"#ndslider\" ).slider( \"value\" ) );
                    \$('#edslider').slider(\"option\",\"value\",0);
                    \$( \"#edamount\" ).val(  \$( \"#edslider\" ).slider( \"value\" ) );

                    coloredNodeId=[];
                    tcoloredNodeId=[];
                    nds=[];
                    temporalEdgesArray=[];


                    \$(\"#ndslider\").slider(\"option\",\"max\",sigInst.getNodesCount());
                    var valMap2=getEdgesArray();
                    \$('#edslider').slider(\"option\",\"max\",valMap2.length-1);
                    \$('#edslider').slider(\"option\",\"slide\",function(event, ui) {
                        \$( \"#edamount\" ).val(  valMap2[ui.value] );
                        filterClusterByEdges(valMap2[ui.value]);
                    });
                    \$('#ndslider').slider(\"option\",\"slide\",function(event, ui) {
                        \$( \"#ndamount\" ).val( [ui.value] );
                        filterClusterByNodes([ui.value]);
                    });

                    if(wer.valueOf()==22 || wer.valueOf()==33){
                        \$('#rtslider').slider(\"option\",\"value\",0);
                        \$( \"#rtamount\" ).val(  \$( \"#rtslider\" ).slider( \"value\" ) );
                        var rta=getRetwArray();
                        \$('#rtslider').slider(\"option\",\"max\",rta.length-1);
                        \$('#rtslider').slider(\"option\",\"slide\",function(event, ui) {
                            \$( \"#rtamount\" ).val( rta[ui.value] );
                            retweeting(rta[ui.value]);
                        });
                        \$('#time3').timepicker('setTime', '00:00:00');
                        \$('#time4').timepicker('setTime', '00:00:00');
                    }
                    sigInst.draw();
                    timeflag=true;
                }
                ,true);



        var filters=[];
        var json=[];
        sigInst.draw();
        var filtersArray=[];
        var jsonArray={};




        document.getElementById('export').addEventListener('click',function(){

            var list=document.getElementById('filterlist');
            \$(\"#filt\").dialog({  resizable: false,
                height: 180,
                modal: true,
                title: 'Save filter as',
                autoOpen: true,
                buttons: {
                    'Submit': function(){
                        filterDialog();
                        submit=true;
                        \$(this).dialog('close');
                    },
                    'Cancel': function() {
                        \$(this).dialog('close');
                        \$(\"#filtt\").val('');
                    }
                }
            });


            function  filterDialog(){
                var fn=\$('#filtt').val();
                \$('#filtt').val=[];
                \$('#ldf').show();
                filtersArray=[];
                var v1=\$( \"#ndamount\" ).val();
                var v2=\$( \"#edamount\" ).val();
                var v3,v4,v5;

                if (wer.valueOf()==33){

                    v3=\$('#rtamount').val();
                    v4=document.getElementById('time3').value;
                    v5=document.getElementById('time4').value;
                    jsonArray=str;
                    filtersArray.push({name:fn,edges:v2,nodes:v1,retweets:v3,timer1:v4,timer2:v5});
                    filters.push(filtersArray);
                    json.push({name: fn, graph:jsonArray});
                }
                else if(wer.valueOf()==22){
                    v3=\$('#rtamount').val();
                    v4=document.getElementById('time3').value;
                    v5=document.getElementById('time4').value;
                    jsonArray=";
        // line 1263
        echo twig_jsonencode_filter((isset($context["metadata"]) ? $context["metadata"] : $this->getContext($context, "metadata")));
        echo ";
                    filtersArray.push({name:fn,edges:v2,nodes:v1,retweets:v3,timer1:v4,timer2:v5,hashtags:";
        // line 1264
        echo twig_jsonencode_filter($this->getAttribute((isset($context["metadata"]) ? $context["metadata"] : $this->getContext($context, "metadata")), "d"));
        echo "});
                    filters.push(filtersArray);
                    json.push({name: fn, graph:jsonArray});

                }else{
                    filtersArray.push({name:fn,edges:v2,nodes:v1});
                    jsonArray=";
        // line 1270
        echo twig_jsonencode_filter((isset($context["metadata"]) ? $context["metadata"] : $this->getContext($context, "metadata")));
        echo ";
                    filters.push(filtersArray);
                    json.push({name: fn, graph:jsonArray});
                    wer=11;
                }

                var a = document.createElement('a');
                var linkText = document.createTextNode(fn);
                a.appendChild(linkText);
                a.href = \"#\";
                a.title=fn;
                a.id=fn;
                a.className=\"filterin\";
                list.appendChild(a);
                \$(\"#filtt\").val('');
            }

        },true);

        \$(document).on('click','.filterin',function(){

            var n=\$(this).attr('id');
            //    alert(n);
            filters.map(function (f){
                f.map(function(fi){
                    if (n===fi.name){
                        var edge=fi.edges;
                        var node=fi.nodes;
                        var ret=fi.retweets;
                        var t1=fi.timer1;
                        var t2=fi.timer2;
                        \$('#filterdialog').html(\"<ul>\" +
                                \"<li class='fd21'><div id='nf'></div></li>\" +
                                \"<li class='fd22'><div id='ef'></div></li>\" +
                                \"<li class='fd31'><div id='rtf'></div></li>\" +
                                \"<li class='fd32'><div id='tf'></div></li>\" +
                                \"<li class='fd13'><div id='htf'></div></li>\" +
                                \"</ul>\");
                        if(edge==0){
                            \$('.fd22').hide();
                        }
                        if(node==0){
                            \$('.fd21').hide();
                        }
                        if(ret==0 || !ret){
                            \$('.fd31').hide();
                        }
                        if(!t1 && !t2 ){
                            \$('.fd32').hide();
                        }
                        var t=";
        // line 1320
        echo twig_jsonencode_filter($this->getAttribute((isset($context["metadata"]) ? $context["metadata"] : $this->getContext($context, "metadata")), "d"));
        echo ";
                        if (edge==0 && node==0 && (ret==0 || !ret) && !t1 && !t2){
                            if(t=='none'){
                                \$('.fd22').hide();
                                \$('.fd21').hide();
                                \$('.fd31').hide();
                                \$('.fd32').hide();
                                \$('#filterdialog').html(\" <p id='dial' align='center'> No Filters Selected </p> \" );
                            }
                        }

                        //     alert(JSON.stringify(";
        // line 1331
        echo twig_jsonencode_filter($this->getAttribute((isset($context["metadata"]) ? $context["metadata"] : $this->getContext($context, "metadata")), "d"));
        echo "));
                        \$('#rtf').html(\"Retweets:\"+ret);
                        \$('#tf').html(\"From:\"+t1+\"to:\"+t2);
                        \$('#nf').html(\"Nodes:\"+node);
                        \$('#ef').html(\"Edges:\"+edge);

                        \$('#htf').html(\"Hashtags:\"+";
        // line 1337
        echo twig_jsonencode_filter($this->getAttribute((isset($context["metadata"]) ? $context["metadata"] : $this->getContext($context, "metadata")), "d"));
        echo ");

                        if(wer.valueOf()==11){
                            \$('.fd31').hide();
                            \$('.fd32').hide();
                            \$('.fd13').hide();
                        }
                        else if(wer.valueOf()==33){
                            \$('.fd13').hide();
                        }
                    }
                });
            });

            \$('#filterdialog').dialog({  resizable: false,
                height: 180,
                modal: true,
                title:n,
                autoOpen: true,
                buttons: {
                    'Reconstruct': function(){
                    //    alert(n);
                        reconstructGraph(n);
                        submit=true;
                        \$(this).dialog('close');

                    },
                    'Close': function() {
                        \$(this).dialog('close');
                    }
                }
            });
        });

        function reconstructGraph(name){
            if(name!=undefined){
                sigInst.emptyGraph();
                json.map(function(map){

                    if(name== map.name){
                        sigInst.parseJson(map.graph);
                        sigInst.draw();
                    }
                });
                filters.map(function (f){
                    f.map(function(fi){
                        if (name===fi.name){
                            if(!fi.retweets){ //eimai sta clusters
                                if(fi.nodes!=0){
                                    filterClusterByNodes(fi.nodes);
                                    sigInst.draw();
                                }
                                else if(fi.edges!=0){
                                    filterClusterByEdges(fi.edges);
                                    sigInst.draw();
                                }
                                else{
                                    sigInst.draw();}
                            }
                            else{  /// eimai se grafo
                                if((!fi.timer1 && !fi.timer2) ||(fi.timer1==\"00:00:00\" && fi.timer2==\"00:00:00\")){
                                    if(fi.nodes!=0){
                                        filterClusterByNodes(fi.nodes);
                                    }
                                    else if(fi.edges!=0){
                                        filterClusterByEdges(fi.edges);
                                    }
                                    if(fi.retweets!=0){
                                        coloredNodeId=[];
                                        //     alert(fi.retweets);
                                        //    alert(JSON.stringify(coloredNodeId));
                                        retweeting(fi.retweets);
                                    }
                                    else{
                                        sigInst.draw();
                                    }

                                }
                                else if(fi.timer1 && fi.timer2){
                                    temporalUnfiltered(fi.timer1,fi.timer2);

                                    if(fi.nodes!=0){
                                        filterTemporalBynodes(fi.nodes);
                                        sigInst.draw();
                                    }
                                    else if(fi.edges!=0){
                                        filterTemporalByEdges(fi.edges);
                                        sigInst.draw();
                                    }
                                    if(fi.retweets!=0){
                                        tcoloredNodeId=[];
                                        //    alert(fi.retweets);
                                        temporalRetweeting(fi.retweets);
                                    }
                                    else{
                                        sigInst.draw();
                                    }
                                }
                            }
                        }
                    });
                });
            }
            sigInst.draw(2,2,2);
            /// midenizw sliders
            \$('#ndslider').slider(\"option\",\"value\",0);
            \$( \"#ndamount\" ).val(  \$( \"#ndslider\" ).slider( \"value\" ) );
            \$('#edslider').slider(\"option\",\"value\",0);
            \$( \"#edamount\" ).val(  \$( \"#edslider\" ).slider( \"value\" ) );


            if(wer.valueOf()==22 || wer.valueOf()==33){
                \$('#rtslider').slider(\"option\",\"value\",0);
                \$( \"#rtamount\" ).val(  \$( \"#rtslider\" ).slider( \"value\" ) );
                var rta=getRetwArray();
                \$('#rtslider').slider(\"option\",\"max\",rta.length-1);
                \$('#rtslider').slider(\"option\",\"slide\",function(event, ui) {
                    \$( \"#rtamount\" ).val( rta[ui.value] );
                    retweeting(rta[ui.value]);
                });
                \$('#time3').timepicker('setTime', '00:00:00');
                \$('#time4').timepicker('setTime', '00:00:00');
            }
            newCanvas('filter');


        }
        function color(id){
            sigInst.iterNodes(function(n){

            })
        }
    }

    if (document.addEventListener) {
        document.addEventListener(\"DOMContentLoaded\", init, false);
    } else {
        window.onload = init;
    }
    </script>
";
    }

    public function getTemplateName()
    {
        return "VizDataVizBundle:Page:index.html.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  1412 => 1337,  1403 => 1331,  1389 => 1320,  1336 => 1270,  1327 => 1264,  1323 => 1263,  1220 => 1163,  906 => 852,  286 => 235,  88 => 40,  79 => 34,  62 => 20,  53 => 15,  50 => 14,  43 => 11,  40 => 10,  35 => 4,  29 => 7,  27 => 6,);
    }
}
