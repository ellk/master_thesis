<?php

/* VizDataVizBundle::layout.html.twig */
class __TwigTemplate_82cd4cbe5ac8db0c329b75fd6fb53e46424c4d6d633caff49198df374c115265 extends Twig_Template
{
    public function __construct(Twig_Environment $env)
    {
        parent::__construct($env);

        $this->parent = $this->env->loadTemplate("::base.html.twig");

        $this->blocks = array(
            'sidebar' => array($this, 'block_sidebar'),
        );
    }

    protected function doGetParent(array $context)
    {
        return "::base.html.twig";
    }

    protected function doDisplay(array $context, array $blocks = array())
    {
        $this->parent->display($context, array_merge($this->blocks, $blocks));
    }

    // line 4
    public function block_sidebar($context, array $blocks = array())
    {
        // line 5
        echo "
";
    }

    public function getTemplateName()
    {
        return "VizDataVizBundle::layout.html.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  31 => 5,  28 => 4,  1412 => 1337,  1403 => 1331,  1389 => 1320,  1336 => 1270,  1327 => 1264,  1323 => 1263,  1220 => 1163,  906 => 852,  286 => 235,  88 => 40,  79 => 34,  62 => 20,  53 => 15,  50 => 14,  43 => 11,  40 => 10,  35 => 4,  29 => 7,  27 => 6,);
    }
}
