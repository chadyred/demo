<!DOCTYPE html>
<html lang="fr">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>{% block title %}{% endblock %}</title>
        {#        <link rel="shortcut icon" href="{{ asset('bundles/floriandemo/images/favicon.ico') }}" />
        #}        
        {% block javascript  %}
            {% javascripts filter='uglifyjs'
                "@jquery_js"
                "@jquery_ui_js"
                "@bootstrap_js"
            %} 
            <script type="text/javascript" src="{{ asset_url }}"></script> 
            {% endjavascripts %}

        {% endblock %}	
        {% stylesheets filter='css_url_rewrite,yui_css'
		'@florianDemoBundle/Resources/public/css/style.css'
                '@florianUserBundle/Resources/public/css/style.css'
                '@florianBlogBundle/Resources/public/css/style_blog.css'
                '@bootstrap'
                '@flat_ui'
		'@font_awesome'
                '@bootstrap_css'
        %}			
        <link rel="stylesheet" href="{{ asset_url }}" type="text/css" media="all"/>
        {% endstylesheets %}
    </head> 
    <body>

        {% block header %}
            <div class="navbar navbar-inverse navbar-top" role="navigation">
                <div class="navbar-inner navigation">
                    <div class="container">
                        <div class="row">
                            <div class="col-sm-12">
                                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                                    <span class="icon-bar"></span>
                                    <span class="icon-bar"></span>
                                    <span class="icon-bar"></span>
                                </button>
                                <div class="navbar-collapse collapse">
                                    <div class="navbar-header">
                                        <a href="#">
                                            {% image '@florianDemoBundle/Resources/public/images/logo.jpg' filter='jpegoptim' output='/images/logo.jpg' %}
                                            <img class="logo-voreppe img-responsive brand" src="{{ asset_url }}" title="Logo Voreppe" alt="Logo Voreppe"/>
                                            {% endimage %}
                                        </a>
                                    </div>
                                    <ul class="nav navbar-nav navbar-left">
                                        {#Si l'utilisateur est logger par formulaire ou par cookie #}
                                        {% if (is_granted("IS_AUTHENTICATED_REMEMBER") or is_granted("IS_AUTHENTICATED_FULLY")) == TRUE  %} 
                                            <li>
                                                <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                                                    <span class="fui-user"></span> Bienvenue {{ app.user.username }} !
                                                    <ul class="dropdown-menu">
                                                        <li><a href="{{ path('fos_user_security_logout') }}"><i class="fa fa-sign-out fa-fw"></i>Se déconnecter</a></li>
                                                    </ul>
                                            </li>                                            
                                            <li>
                                                <a id="demo" href="{{ path('post') }}"><i class="fa fa-home fa-fw"></i>Accueil
                                                </a>
                                            </li>
                                            <li>    
                                                <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                                                    Menu 
                                                    <span class="fa fa-align-justify"></span></a>
                                                <ul class="dropdown-menu">
                                                    <li><a href="#"><i class="fa fa-file-text-o fa-fw"></i>Action 1</a></li>
                                                    <li><a href="#"><i class="fa fa-comment-o fa-fw"></i>Action 2</a></li>
                                                    <li><a href="#"><i class="fa fa-comment-o fa-fw"></i>Action 3</a></li>
                                                </ul>
                                            </li>   
                                            <li>
                                                <a href="{{ path('florian_blog_accueil') }}"><i class="fa fa-film fa-fw"></i>
                                                    Blog
                                                </a>
                                            </li>
                                        {% else %}
                                            <li>
                                                <a href="#">Page d'authentification</a>
                                            </li>
                                            <li><a href="{{ path('login') }}">{{ 'layout.login'|trans({}, 'FOSUserBundle') }}</a></li>
                                            {% endif %}
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>   
                </div> 
            </div>
            <div id="header-wrapper">
                <div id="alert-info" style="background-color:#0193CC;text-align: center;color:white;font-family: 'Arvo', serif;">
                    {% for flashMessage in app.session.flashbag.get('notice') %}
                        {{ flashMessage }}     
                    {% endfor %}
                </div>
            </div>  
            <script type="text/javascript" >
                $('.dropdown-toggle').dropdown();
            </script> 
        {% endblock header %}
        <div id="contenu">
            {% block contenu %}
            {% endblock contenu %} 
        </div>
        {% block footer %}
            <section class="pageFooter">
                <div class="container">
                    <div class="row">
                        <div class="col-md-3 col-sm-3 col-xs-12">
                            <dl>
                                <dt><a href="#">Tab1</a></dt>
                                <dd><a href="#">Tab1</a></dd>
                                <dd><a href="#">Tab1</a></dd>
                            </dl>
                        </div>
                        <div class="col-md-3 col-sm-3 col-xs-12">
                            <dl>
                                <dt><a href="#">Tab2</a></dt>
                                <dd><a href="#">Tab2</a></dd>
                                <dd><a href="#">Tab2</a></dd>                           
                            </dl>
                        </div>
                        <div class="col-md-3 col-sm-3 col-xs-12">
                            <dl>
                                <dt><a href="#">Tab3</a></dt>
                                <dd><a href="#">Tab3</a></dd>
                                <dd><a href="#">Tab3</a></dd>
                            </dl>
                        </div>
                        <div class="col-md-3 col-sm-3 col-xs-12">
                            <dl>
                                <dt><a href="#">Tab4</a></dt>
                                <dd><a href="#">Tab4</a></dd>
                                <dd><a href="#">Tab4</a></dd>
                            </dl>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 col-sm-12 col-xs-12">
                            <a href="#" class="logo-wrapper" title="Demo">
                                {% image '@florianDemoBundle/Resources/public/images/logo.jpg' filter='jpegoptim' output='/images/logo.jpg' %}
                                <img class="logo-voreppe img-responsive brand" src="{{ asset_url }}" title="Logo Voreppe" alt="Logo Voreppe"/>
                                {% endimage %}
                            </a>
                        </div>
                        <div class="col-md-6 col-sm-12">
                            <dl class="legal">
                                <dd>Copyright © florian, Inc. All rights reserved.</dd>
                                <dd><a href="#">Privacy Policy</a></dd>
                                < /dl>
                        </div>
                    </div>
                </div>
            </section>
        {% endblock %}
    </body>
</html>
--------------------------------------------------------------
{% set accueil = accueil|default(false) %}

{#Si on est sur l'accueil on met le lien pour voir notre article, sinon on met en gros le titre#}

{% if accueil %}

    <p class="titre">
        <a href="{{ path('florian_blog_voir_article', { 'slugTitre' : article.getSlugTitre }) }}">
            <span class="fui-play"></span>qsdqsd
        </a>
        {{ article.getTitre }}
    </p>
{% else %}
    <h2>
        {{ article.getTitre }}
        <br/>
        Redigé par {{ article.getUser.getUsername }}
    </h2>
{% endif %}

{#Sur l'accueil on affiche pas l'image#}
{% if accueil == false %}
    {# On vérifie qu'une image est bien associée à l'article #}
    {% if article.getImageArticle is not null %}
        {# On va utiliser notre fonction qui va nous permettre de concaténer le chemin de notre image#}
        <img src="{{ asset(article.getImageArticle.getWebPath) }}" alt="{{ article.getImageArticle.getAlt }}"/>
    {% endif %}


    <p>
        {{ article.getContenu|raw }}
    </p>
    <div class="navbar-inner navigation">
        <div class="container">
            <div class="row"> 
                <ul class="nav navbar-nav navbar-left">
                    <li>
                        <a href="{{ path('florian_blog_modifier', {'slugTitre': article.getSlugTitre}) }}" class="btn">
                            <i class="icon-edit"></i>
                            Modifier l'article
                        </a>
                    </li>
                    <li>
                        <a href="{{ path('florian_blog_supprimer', {'slugTitre': article.getSlugTitre}) }}" class="btn">
                            <i class="icon-trash"></i>
                            Supprimer l'article
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </div>                   

{% endif %}


<br/>

écrit le {{ article.getDateCreation|date('d/m/Y \à g:i:s') }} :
<br/>
Modifié le : {{ article.getDateEdition|date('d/m/Y \à g:i:s') }}

</p>