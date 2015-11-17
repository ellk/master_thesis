<?php

/* ::base.html.twig */
class __TwigTemplate_61134cf3a1ffefcbbfdd4970faceb3a31cd4b05ccb9b7d31dfe5757e95fcae86 extends Twig_Template
{
    public function __construct(Twig_Environment $env)
    {
        parent::__construct($env);

        $this->parent = false;

        $this->blocks = array(
            'title' => array($this, 'block_title'),
            'stylesheets' => array($this, 'block_stylesheets'),
            'navigation' => array($this, 'block_navigation'),
            'body' => array($this, 'block_body'),
            'javascripts' => array($this, 'block_javascripts'),
            'footer' => array($this, 'block_footer'),
        );
    }

    protected function doDisplay(array $context, array $blocks = array())
    {
        // line 1
        echo "<!-- app/Resources/views/base.html.twig -->


<!DOCTYPE html>
<html>
<head>
    <meta charset=\"utf-8\">
    <meta content=\"IE=edge,chrome=1\" http-equiv=\"X-UA-Compatible\">
    <meta content=\"width=device-width\" name=\"viewport\">
    <title>";
        // line 10
        $this->displayBlock('title', $context, $blocks);
        echo "</title>

    ";
        // line 12
        $this->displayBlock('stylesheets', $context, $blocks);
        // line 24
        echo "
    <script type=\"text/javascript\"     src=\"//code.jquery.com/jquery-latest.min.js\"></script>
    <script src=\"http://code.jquery.com/jquery-migrate-1.2.1.js\"></script>
    <script src=\"//code.jquery.com/ui/1.10.4/jquery-ui.js\"></script>
    <script type=\"text/javascript\" async src=\"http://www.google-analytics.com/ga.js\"></script>
    <script src=\"";
        // line 29
        echo twig_escape_filter($this->env, $this->env->getExtension('assets')->getAssetUrl("prettify.js"), "html", null, true);
        echo "\"></script>
    <script type=\"text/javascript\" src=\"";
        // line 30
        echo twig_escape_filter($this->env, $this->env->getExtension('assets')->getAssetUrl("jquery-timepicker-master/jquery.timepicker.min.js"), "html", null, true);
        echo "\"></script>
    <script type=\"text/javascript\" src=\"";
        // line 31
        echo twig_escape_filter($this->env, $this->env->getExtension('assets')->getAssetUrl("js/jquery-window-5.03/jquery.window.js"), "html", null, true);
        echo "\"></script>
    <link rel=\"icon\" type=\"image/x-icon\" href=\"";
        // line 32
        echo twig_escape_filter($this->env, $this->env->getExtension('assets')->getAssetUrl("favicon.ico"), "html", null, true);
        echo "\" />
</head>
<body onload=\"prettyPrint(); \">



        ";
        // line 38
        $this->displayBlock('navigation', $context, $blocks);
        // line 142
        echo "   


<section id=\"main\">
<canvas  id=canvas style=\"position: relative;\"></canvas>


<div class=\"sigma-parent\" id=\"sigma-example-parent\">

    <div class=\"sigma-expand\" id=\"sigma-example\">
        <canvas id=\"buffer\" width=800 height=600 style='width:800px;height:600px;'></canvas>
        <canvas id=\"b\" style=\"position: relative;\"  style=\"dipslay:none\"></canvas>
    </div>
</div>

<br>
";
        // line 158
        $this->displayBlock('body', $context, $blocks);
        // line 159
        $this->displayBlock('javascripts', $context, $blocks);
        // line 359
        echo "<div id=\"output\" style=\"display:none\">Empty</div>

<div id=\"out\"></div>




</section>
<footer>
    ";
        // line 368
        $this->displayBlock('footer', $context, $blocks);
        // line 371
        echo "</footer>
</body>

</html>
";
    }

    // line 10
    public function block_title($context, array $blocks = array())
    {
        echo "Social Network Visualization";
    }

    // line 12
    public function block_stylesheets($context, array $blocks = array())
    {
        // line 13
        echo "        <link href=\"";
        echo twig_escape_filter($this->env, $this->env->getExtension('assets')->getAssetUrl("css/style.css"), "html", null, true);
        echo "\" type=\"text/css\" rel=\"stylesheet\" />
        <link href=\"";
        // line 14
        echo twig_escape_filter($this->env, $this->env->getExtension('assets')->getAssetUrl("css/bootstrap-responsive.min.css"), "html", null, true);
        echo "\" type=\"text/css\" rel=\"stylesheet\" />
        <link href=\"";
        // line 15
        echo twig_escape_filter($this->env, $this->env->getExtension('assets')->getAssetUrl("css/bootstrap.min.css"), "html", null, true);
        echo "\" type=\"text/css\" rel=\"stylesheet\" />
        <link href=\"";
        // line 16
        echo twig_escape_filter($this->env, $this->env->getExtension('assets')->getAssetUrl("css/style.css"), "html", null, true);
        echo "\" type=\"text/css\" rel=\"stylesheet\" />
        <link href=\"";
        // line 17
        echo twig_escape_filter($this->env, $this->env->getExtension('assets')->getAssetUrl("css/screen.css"), "html", null, true);
        echo "\" type=\"text/css\" rel=\"stylesheet\" />
        <link href=\"";
        // line 18
        echo twig_escape_filter($this->env, $this->env->getExtension('assets')->getAssetUrl("css/prettify.css"), "html", null, true);
        echo "\" type=\"text/css\" rel=\"stylesheet\" />
        <link rel=\"stylesheet\" href=\"//code.jquery.com/ui/1.10.4/themes/smoothness/jquery-ui.css\">
        <link rel='stylesheet' href=";
        // line 20
        echo twig_escape_filter($this->env, $this->env->getExtension('assets')->getAssetUrl("spectrum/spectrum.css"), "html", null, true);
        echo " />
        <link rel='stylesheet' href=";
        // line 21
        echo twig_escape_filter($this->env, $this->env->getExtension('assets')->getAssetUrl("js/jquery-window-5.03/css/jquery.window.css"), "html", null, true);
        echo " />

    ";
    }

    // line 38
    public function block_navigation($context, array $blocks = array())
    {
        // line 39
        echo "            <nav>
                <ul class=\"menu\">
                    <li class=\"menuItem\"><a href='#'>Load</a>
                        <ul class=\"submenu\">

                            <li class=\"submenuItem\"><a href=\"";
        // line 44
        echo $this->env->getExtension('routing')->getPath("VizDataVizBundle_homepage");
        echo "\">connect to database</a></li>
                            <div id=\"ldf\" hidden=\"true\">
                                <li class=\"submenuItem\" id=\"list\"><a href=\"#\" >load filtered graph</a>
                                    <ol  id=\"filterlist\" class=\"filtering\">
                                        <div id=\"filterdialog\" style=\"display:none;\">
                                        </div>

                                    </ol>
                                </li>
                            </div>
                        </ul>
                    </li>
                    <li class=\"menuItem\"><a href=\"#\" class=\"links\">View</a>
                        <ul class=\"submenu\">
                            <li class=\"submenuItem\">
                                <input type=\"button\" class=\"myButton\" id=\"fisheye\" value=\"start fisheye\">
                            </li>
                            <li class=\"submenuItem\">
                                <input type=\"button\" class=\"myButton\" id=\"force-atlas\" value=\"start force atlas\">
                            </li>
                            <li class=\"submenuItem\">
                                <input type=\"button\" class=\"myButton\" id=\"circular\" value=\"circular\">
                            </li>
                        </ul>
                    </li>
                    <li class=\"menuItem\"><a href=\"#\" class=\"links\">Filter</a>
                        <ul class=\"submenu\">
                            <div id=\"e\" hidden=\"true\">
                                <li class=\"menuItem\"><a href=\"#\" class=\"links\">Visualize by </a>
                                    <ul class=\"submenu\">
                                        <li class=\"submenuItem\" id=\"hashtags\">
                                            <ul>
                                                <form action=\"";
        // line 76
        echo $this->env->getExtension('routing')->getPath("VizDataVizBundle_homepage");
        echo "\" method=\"post\" ";
        echo $this->env->getExtension('form')->renderer->searchAndRenderBlock((isset($context["form"]) ? $context["form"] : $this->getContext($context, "form")), 'enctype');
        echo " class=\"viz\">
                                                    ";
        // line 77
        echo $this->env->getExtension('form')->renderer->searchAndRenderBlock($this->getAttribute((isset($context["form"]) ? $context["form"] : $this->getContext($context, "form")), "hashtags"), 'row');
        echo "
                                                    ";
        // line 78
        echo $this->env->getExtension('form')->renderer->searchAndRenderBlock($this->getAttribute((isset($context["form"]) ? $context["form"] : $this->getContext($context, "form")), "hashtags"), 'errors');
        echo "
                                                    ";
        // line 79
        echo $this->env->getExtension('form')->renderer->searchAndRenderBlock((isset($context["form"]) ? $context["form"] : $this->getContext($context, "form")), 'rest');
        echo "
                                                    <input type=\"submit\" value=\"Submit\"/>
                                                </form>
                                            </ul>
                                        </li>
                                    </ul>
                                </li>
                            </div>
                            <div id=\"c\"  hidden=\"true\">
                                <li class=\"submenuItem\"><a href=\"#\" class=\"links\">most retweeted</a>
                                    <div id=\"rtslider\" class=\"ui-slider-handle\"></div>
                                    <p>
                                        <input class=\"texts\" type=\"text\" id=\"rtamount\">
                                    </p>
                                </li>
                            </div>
                            <li class=\"submenuItem\"><a href=\"#\" class=\"links\">number of nodes</a>
                                <div id=\"ndslider\" class=\"ui-slider-handle\"></div>
                                <p>
                                    <input class=\"texts\" type=\"text\" id=\"ndamount\">
                                </p>
                            </li>
                            <li class=\"submenuItem\"><a href=\"#\" class=\"links\">number of edges</a>
                                <div id=\"edslider\" class=\"ui-slider-handle\"></div>
                                <p>
                                    <input class=\"texts\" type=\"text\" id=\"edamount\">
                                </p>
                            </li>
                            <li class=\"submenuItem\"><a href=\"#\" class=\"links\"></a>
                                <ul><div id=\"buttons\">
                                        <input class=\"myButton\" id=\"refresh\" type=\"button\" value=\"refresh\" >
                                        <input class=\"myButton\" id=\"export\" type=\"button\" value=\"export\" onClick=\"giveName();\">

                                        <div id=\"confirm\" style=\"display:none;\">
                                            <input type=\"text\" id=\"filtername\"></div>
                                        <div id=\"filt\" style=\"display:none;\">
                                            <input type=\"text\" id=\"filtt\"></div>
                                    </div>
                                </ul>
                            </li>
                            <div id=\"time\" hidden=\"true\">
                                <li class=\"submenuItem\"><a href=\"#\" class=\"links\">time</a>
                                    <input id=\"time3\" type=\"text\"  autocomplete=\"off\"  /><span id=\"timeRange\"></span>
                                    <input id=\"time4\" type=\"text\"  autocomplete=\"off\">

                                </li>
                            </div>
                        </ul>
                    </li>

                    <li class=\"menuItem\"><a href=\"#\" class=\"links\">Edit</a>
                        <ul class=\"submenu\">
                            <li class=\"submenuItem\"><a href=\"#\" class=\"links\">nodes</a>
                                <input type=\"text\" id=\"colorNodes\">
                            </li>
                            <li class=\"submenuItem\"><a href=\"#\" class=\"links\">edges</a>
                                <input type=\"text\" id=\"colorEdges\">
                            </li>
                        </ul>
                    </li>
                </ul>
            </nav>
        ";
    }

    // line 158
    public function block_body($context, array $blocks = array())
    {
        echo "qwertty";
    }

    // line 159
    public function block_javascripts($context, array $blocks = array())
    {
        // line 160
        echo "
    <script type=\"text/javascript\" src=\"";
        // line 161
        echo twig_escape_filter($this->env, $this->env->getExtension('assets')->getAssetUrl("js/sigma.min.js"), "html", null, true);
        echo "\"></script>
    <script type=\"text/javascript\" src=\"";
        // line 162
        echo twig_escape_filter($this->env, $this->env->getExtension('assets')->getAssetUrl("sigma.js-master/plugins/sigma.forceatlas2.js"), "html", null, true);
        echo "\"></script>
    <script type=\"text/javascript\" src=\"";
        // line 163
        echo twig_escape_filter($this->env, $this->env->getExtension('assets')->getAssetUrl("sigma.js-master/plugins/sigma.fisheye.js"), "html", null, true);
        echo "\"></script>
    <script type=\"text/javascript\" src=\"";
        // line 164
        echo twig_escape_filter($this->env, $this->env->getExtension('assets')->getAssetUrl("js/sigma.parseJson.js"), "html", null, true);
        echo "\"></script>
    <script type=\"text/javascript\" async src=";
        // line 165
        echo twig_escape_filter($this->env, $this->env->getExtension('assets')->getAssetUrl("http://www.google-analytics.com/ga.js"), "html", null, true);
        echo "></script>
    <script src=\"";
        // line 166
        echo twig_escape_filter($this->env, $this->env->getExtension('assets')->getAssetUrl("prettify.js"), "html", null, true);
        echo "\"></script>
    <script type=\"text/javascript\" src=";
        // line 167
        echo twig_escape_filter($this->env, $this->env->getExtension('assets')->getAssetUrl("spectrum/spectrum.js"), "html", null, true);
        echo "></script>

    <script type=\"text/javascript\">
        \$(function(){
            var filtersArray=[];
            var jsonArray={};


            \$('#colorNodes,#colorEdges').spectrum({clickoutFiresChange: true,
                preferredFormat: \"hex\",
                showInput: true});

            \$('#time3,#time4').timepicker({
                'scrollDefaultNow': true,
                'useSelect': true,
                'step':1,
                'timeFormat': 'H:i:s',
                hour: '00',
                minute : '00',
                sec: '00'


            });

        });
        function giveName(){

            \$(\"#confirm\").dialog({  resizable: false,
                height: 180,
                modal: true,
                title: 'Save graph',
                autoOpen: true,
                buttons: {
                    'Submit': function() {
                        var suffix=\".png\";
                        var name=\$('#filtername').val()

                        \$('#filtername').val('');
                        //     name=name.concat(suffix);

                        download(buffer,name);
                        submit=true;
                        \$(this).dialog('close');


                    },
                    'Cancel': function() {
                        \$(\"#filtername\").val('');
                        \$(this).dialog('close');
                    }
                }
            });



        }

        function download(canvas, filename) {
            //   alert(filename);
            var lnk = document.createElement('a'),
                    e;
            lnk.download = filename;
            // alert(filename);
            lnk.href = canvas.toDataURL();

            if (document.createEvent) {
                e = document.createEvent(\"MouseEvents\");
                e.initMouseEvent(\"click\", true, true, window,
                        0, 0, 0, 0, 0, false, false, false,
                        false, 0, null);

                lnk.dispatchEvent(e);

            } else if (lnk.fireEvent) {

                lnk.fireEvent(\"onclick\");
            }

        }

        function newCanvas(s){
            var msg;
            switch(s)
            {
                case \"n\":
                    msg=\"node filtering\";
                    break;
                case \"e\":
                    msg=\"edge filtering\";
                    break;
                case \"rt\":
                    msg=\"most retweeted nodes\";
                    break;
                case \"cl\":
                    msg=\"cluster\";
                    break;
                case \"t\":
                    msg=\"time filtering\";
                    break;
                case \"22\":
                    msg=\"hashtag filtering\";
                    break;
                case \"cn\":
                    msg=\"colored nodes\";
                    break;
                case \"ce\":
                    msg=\"colored edges\";
                    break;
                case \"11\":
                    msg=\"meta-graph\";
                    break;
                case \"circ\":
                    msg=\"circular layout\";
                    break;
                case \"forced\":
                    msg=\"force-atlas2 layout\";
                    break;
                case \"filter\":
                    msg=\"filter\";
                    break;
                case \"rand\":
                    msg=\"random layout\";
                    break;
                default:
                    msg=\"\";

            }

            var target=document.getElementById('buffer');

      //      alert(target.width);
            target.width=target.width;
            var t_con=target.getContext(\"2d\");
            setTimeout(function(){t_con.drawImage(sigma_nodes_1,0,0);
                t_con.drawImage(sigma_edges_1,0,0);
                t_con.drawImage(sigma_labels_1,0,0);



                //        t_con.drawImage(sigma_nodes_1,0,0);
                //         t_con.drawImage(sigma_edges_1,0,0);
                //        t_con.drawImage(sigma_labels_1,0,0);

                /*      var buf=document.getElementById('b');
                 var tc=b.getContext(\"2d\");
                 tc.drawImage(sigma_nodes_1,0,0);
                 tc.drawImage(sigma_edges_1, 0, 0);
                 tc.drawImage(sigma_labels_1,0,0);*/

                var buffer_img = new Image();
                buffer_img.src = target.toDataURL();
                //    fillBuffer(buffer_img.src,msg);
                var output = document.getElementById('output');
                output.innerHTML = '<img src=\"' + buffer_img.src + '\" alt=\"Canvas Image\" /> ';
                \$.window.prepare({
                    dock: 'bottom',       // change the dock direction: 'left', 'right', 'top', 'bottom'
                    animationSpeed: 200,  // set animation speed
                    minWinLong: 180       // set minimized window long dimension width in pixel
                });
                \$.window({
                    showModal: false,
                    modalOpacity: 0.5,
                    draggable: true,
                    minimizable: true,
                    maximizable:true,
                    scrollable:true,
                    checkBoundary: true,
                    width: 200,
                    height: 160,
                    maxWidth: 900,
                    maxHeight: 940,
                    y: 580,
                    x:0,
                    title: msg,
                    content: \$(\"#output\").html() // load window_block2 html content
                });

            } ,100);
        }
        function fillBuffer(str,st){
            \$('#b').html('');
            document.getElementById('b').innerHTML= '<img src=\"' + str + '\" alt=\"Canvas Image\" /> st';
        }
        function clearBuffer(){

            document.getElementById('b').html('');
        }


    </script>

";
    }

    // line 368
    public function block_footer($context, array $blocks = array())
    {
        // line 369
        echo "        Visualizing Data From Social Networks
    ";
    }

    public function getTemplateName()
    {
        return "::base.html.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  523 => 369,  520 => 368,  324 => 167,  320 => 166,  316 => 165,  312 => 164,  308 => 163,  304 => 162,  300 => 161,  297 => 160,  294 => 159,  288 => 158,  221 => 79,  217 => 78,  213 => 77,  207 => 76,  172 => 44,  165 => 39,  162 => 38,  155 => 21,  151 => 20,  146 => 18,  142 => 17,  138 => 16,  134 => 15,  130 => 14,  125 => 13,  122 => 12,  116 => 10,  108 => 371,  106 => 368,  95 => 359,  93 => 159,  91 => 158,  73 => 142,  71 => 38,  58 => 31,  54 => 30,  41 => 12,  36 => 10,  25 => 1,  1412 => 1337,  1403 => 1331,  1389 => 1320,  1336 => 1270,  1327 => 1264,  1323 => 1263,  1220 => 1163,  906 => 852,  286 => 235,  88 => 40,  79 => 34,  62 => 32,  53 => 15,  50 => 29,  43 => 24,  40 => 10,  35 => 4,  29 => 7,  27 => 6,);
    }
}
