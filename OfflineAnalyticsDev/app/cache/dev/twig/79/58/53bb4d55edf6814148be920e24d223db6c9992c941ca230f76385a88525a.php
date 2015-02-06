<?php

/* OfflineAnalyticsAdminBundle:Default:client.html.twig */
class __TwigTemplate_795853bb4d55edf6814148be920e24d223db6c9992c941ca230f76385a88525a extends Twig_Template
{
    public function __construct(Twig_Environment $env)
    {
        parent::__construct($env);

        $this->parent = $this->env->loadTemplate("base.html.twig");

        $this->blocks = array(
            'title' => array($this, 'block_title'),
            'body' => array($this, 'block_body'),
        );
    }

    protected function doGetParent(array $context)
    {
        return "base.html.twig";
    }

    protected function doDisplay(array $context, array $blocks = array())
    {
        $this->parent->display($context, array_merge($this->blocks, $blocks));
    }

    // line 2
    public function block_title($context, array $blocks = array())
    {
        echo "Cliente";
    }

    // line 4
    public function block_body($context, array $blocks = array())
    {
        // line 5
        echo "\t<h1>Nombre: ";
        echo twig_escape_filter($this->env, $this->getAttribute((isset($context["client"]) ? $context["client"] : $this->getContext($context, "client")), "name", array()), "html", null, true);
        echo "</h1>
\t<p>ID: ";
        // line 6
        echo twig_escape_filter($this->env, $this->getAttribute((isset($context["client"]) ? $context["client"] : $this->getContext($context, "client")), "id", array()), "html", null, true);
        echo "</p>
\t
\t<ul>
\t";
        // line 9
        $context['_parent'] = (array) $context;
        $context['_seq'] = twig_ensure_traversable($this->getAttribute((isset($context["client"]) ? $context["client"] : $this->getContext($context, "client")), "crmObjects", array()));
        foreach ($context['_seq'] as $context["_key"] => $context["crmObject"]) {
            // line 10
            echo "\t
    \t<li>";
            // line 11
            echo twig_escape_filter($this->env, $this->getAttribute($context["crmObject"], "id", array()), "html", null, true);
            echo "</li>
        <li>";
            // line 12
            echo twig_escape_filter($this->env, $this->getAttribute($context["crmObject"], "type", array()), "html", null, true);
            echo "</li>
\t    <li>";
            // line 13
            echo twig_escape_filter($this->env, $this->getAttribute($context["crmObject"], "url", array()), "html", null, true);
            echo "</li>
       \t<li>";
            // line 14
            echo twig_escape_filter($this->env, $this->getAttribute($context["crmObject"], "trackingId", array()), "html", null, true);
            echo "</li>
 \t    <li>";
            // line 15
            echo twig_escape_filter($this->env, $this->getAttribute($context["crmObject"], "lastRetrieved", array()), "html", null, true);
            echo "</li>
 \t    <li>";
            // line 16
            echo twig_escape_filter($this->env, $this->getAttribute($context["crmObject"], "date_fieldname", array()), "html", null, true);
            echo "</li>
       \t<li>";
            // line 17
            echo twig_escape_filter($this->env, $this->getAttribute($context["crmObject"], "cid_fieldname", array()), "html", null, true);
            echo "</li>
 \t    <li>";
            // line 18
            if (($this->getAttribute($context["crmObject"], "isActive", array()) == 1)) {
                echo "Activo";
            } else {
                echo "Inactivo";
            }
            echo "</li>
    ";
        }
        $_parent = $context['_parent'];
        unset($context['_seq'], $context['_iterated'], $context['_key'], $context['crmObject'], $context['_parent'], $context['loop']);
        $context = array_intersect_key($context, $_parent) + $_parent;
        // line 20
        echo "    </ul>
";
    }

    public function getTemplateName()
    {
        return "OfflineAnalyticsAdminBundle:Default:client.html.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  96 => 20,  84 => 18,  80 => 17,  76 => 16,  72 => 15,  68 => 14,  64 => 13,  60 => 12,  56 => 11,  53 => 10,  49 => 9,  43 => 6,  38 => 5,  35 => 4,  29 => 2,);
    }
}
