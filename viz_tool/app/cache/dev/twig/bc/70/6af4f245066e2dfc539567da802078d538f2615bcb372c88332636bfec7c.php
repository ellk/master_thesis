<?php

/* @WebProfiler/Profiler/toolbar_item.html.twig */
class __TwigTemplate_bc706af4f245066e2dfc539567da802078d538f2615bcb372c88332636bfec7c extends Twig_Template
{
    public function __construct(Twig_Environment $env)
    {
        parent::__construct($env);

        $this->parent = false;

        $this->blocks = array(
        );
    }

    protected function doDisplay(array $context, array $blocks = array())
    {
        // line 1
        if ((isset($context["link"]) ? $context["link"] : $this->getContext($context, "link"))) {
            // line 2
            echo "    ";
            ob_start();
            // line 3
            echo "        <a href=\"";
            echo twig_escape_filter($this->env, $this->env->getExtension('routing')->getPath("_profiler", array("token" => (isset($context["token"]) ? $context["token"] : $this->getContext($context, "token")), "panel" => (isset($context["name"]) ? $context["name"] : $this->getContext($context, "name")))), "html", null, true);
            echo "\">";
            echo twig_escape_filter($this->env, (isset($context["icon"]) ? $context["icon"] : $this->getContext($context, "icon")), "html", null, true);
            echo "</a>
    ";
            $context["icon"] = ('' === $tmp = ob_get_clean()) ? '' : new Twig_Markup($tmp, $this->env->getCharset());
        }
        // line 6
        echo "<div class=\"sf-toolbar-block\">
     <div class=\"sf-toolbar-icon\">";
        // line 7
        echo twig_escape_filter($this->env, ((array_key_exists("icon", $context)) ? (_twig_default_filter((isset($context["icon"]) ? $context["icon"] : $this->getContext($context, "icon")), "")) : ("")), "html", null, true);
        echo "</div>
     <div class=\"sf-toolbar-info\">";
        // line 8
        echo twig_escape_filter($this->env, ((array_key_exists("text", $context)) ? (_twig_default_filter((isset($context["text"]) ? $context["text"] : $this->getContext($context, "text")), "")) : ("")), "html", null, true);
        echo "</div>
</div>
";
    }

    public function getTemplateName()
    {
        return "@WebProfiler/Profiler/toolbar_item.html.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  21 => 2,  349 => 323,  347 => 322,  95 => 39,  93 => 38,  24 => 3,  19 => 1,  273 => 96,  254 => 92,  240 => 86,  238 => 85,  230 => 82,  221 => 77,  219 => 76,  217 => 75,  204 => 72,  179 => 69,  171 => 64,  159 => 61,  138 => 54,  135 => 53,  78 => 22,  71 => 18,  51 => 13,  34 => 5,  31 => 4,  806 => 488,  803 => 487,  792 => 485,  788 => 484,  784 => 482,  771 => 481,  745 => 476,  742 => 475,  723 => 473,  706 => 472,  702 => 470,  698 => 469,  694 => 468,  690 => 467,  686 => 466,  682 => 465,  678 => 464,  675 => 463,  673 => 462,  656 => 461,  645 => 460,  630 => 455,  625 => 453,  621 => 452,  618 => 451,  616 => 450,  602 => 449,  565 => 414,  547 => 411,  530 => 410,  527 => 409,  525 => 408,  520 => 406,  515 => 404,  244 => 136,  199 => 71,  196 => 92,  188 => 90,  182 => 70,  173 => 65,  68 => 30,  62 => 27,  28 => 3,  357 => 123,  344 => 321,  341 => 118,  332 => 116,  327 => 114,  324 => 113,  318 => 111,  306 => 107,  297 => 104,  291 => 102,  263 => 95,  258 => 94,  243 => 88,  231 => 83,  224 => 79,  212 => 78,  202 => 77,  190 => 76,  187 => 75,  174 => 65,  143 => 55,  136 => 71,  122 => 41,  117 => 39,  112 => 36,  104 => 32,  85 => 24,  75 => 19,  58 => 25,  44 => 10,  161 => 63,  158 => 80,  154 => 58,  151 => 59,  140 => 58,  125 => 42,  121 => 50,  118 => 49,  100 => 39,  87 => 25,  49 => 14,  46 => 12,  27 => 3,  91 => 27,  88 => 25,  63 => 15,  389 => 160,  386 => 159,  378 => 157,  371 => 156,  367 => 155,  363 => 126,  358 => 151,  353 => 121,  345 => 147,  343 => 146,  340 => 145,  334 => 141,  331 => 140,  328 => 139,  326 => 138,  321 => 112,  309 => 108,  307 => 128,  302 => 281,  296 => 121,  293 => 120,  290 => 119,  288 => 101,  283 => 100,  281 => 114,  276 => 111,  274 => 97,  269 => 94,  265 => 96,  259 => 103,  255 => 93,  253 => 100,  235 => 83,  232 => 88,  227 => 81,  222 => 83,  210 => 77,  208 => 73,  189 => 66,  184 => 63,  175 => 65,  170 => 84,  166 => 54,  163 => 62,  155 => 47,  152 => 46,  144 => 42,  127 => 35,  109 => 52,  94 => 28,  82 => 28,  76 => 28,  61 => 23,  39 => 6,  36 => 7,  79 => 21,  72 => 27,  69 => 26,  54 => 12,  47 => 9,  42 => 11,  40 => 8,  37 => 10,  22 => 2,  164 => 58,  157 => 56,  145 => 74,  139 => 49,  131 => 52,  120 => 31,  115 => 39,  111 => 47,  108 => 47,  106 => 51,  101 => 43,  98 => 45,  92 => 43,  83 => 35,  80 => 29,  74 => 14,  66 => 11,  60 => 6,  55 => 24,  52 => 12,  50 => 10,  41 => 19,  32 => 7,  29 => 6,  462 => 202,  453 => 199,  449 => 198,  446 => 197,  441 => 196,  439 => 195,  431 => 189,  429 => 188,  422 => 184,  415 => 180,  408 => 176,  401 => 172,  394 => 168,  387 => 164,  380 => 158,  373 => 156,  361 => 333,  355 => 150,  351 => 120,  348 => 140,  342 => 137,  338 => 135,  335 => 134,  329 => 131,  325 => 129,  323 => 128,  320 => 127,  315 => 110,  312 => 109,  303 => 106,  300 => 280,  298 => 120,  289 => 113,  286 => 112,  278 => 98,  275 => 105,  270 => 102,  267 => 101,  262 => 98,  256 => 96,  248 => 97,  246 => 90,  241 => 93,  233 => 87,  229 => 87,  226 => 84,  220 => 81,  216 => 79,  213 => 78,  207 => 75,  203 => 73,  200 => 72,  197 => 69,  194 => 68,  191 => 67,  185 => 74,  181 => 65,  178 => 66,  176 => 86,  172 => 64,  168 => 61,  165 => 83,  162 => 57,  156 => 62,  153 => 77,  150 => 55,  147 => 75,  141 => 73,  134 => 54,  130 => 46,  123 => 61,  119 => 42,  116 => 41,  113 => 48,  105 => 25,  102 => 32,  99 => 31,  96 => 37,  90 => 37,  84 => 40,  81 => 23,  73 => 33,  70 => 15,  67 => 17,  64 => 24,  59 => 22,  53 => 12,  45 => 9,  43 => 12,  38 => 7,  35 => 6,  33 => 6,  30 => 3,);
    }
}
