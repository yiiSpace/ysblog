布局
=============

来看看jinjia2 如何做的
~~~jinjia

    
       <!DOCTYPE html>
       <html lang="en">
       <head>
           <meta charset="utf-8">
           <title>{% block title %}{% endblock %} | My Blog</title>
           <link rel="stylesheet"
                 href="//netdna.bootstrapcdn.com/bootstrap/3.1.0/css/bootstrap.min.
           css">
           <style type="text/css">
               body { padding-top: 60px; }
           </style>
           {% block extra_styles %}{% endblock %}
           <script src=
                           "https://code.jquery.com/jquery-1.10.2.min.js"></script>
           <script
                   src="//netdna.bootstrapcdn.com/bootstrap/3.1.0/js/
           bootstrap.min.js"></script>
           {% block extra_scripts %}{% endblock %}
       </head>
       <body class="{% block body_class %}{% endblock %}">
       <div class="navbar navbar-inverse navbar-fixed-top"
            role="navigation">
           <div class="container">
               <div class="navbar-header">
       
                   <button type="button" class="navbar-toggle"
                           data-toggle="collapse" data-target=".navbar-collapse">
                       <span class="sr-only">Toggle navigation</span>
                       <span class="icon-bar"></span>
                       <span class="icon-bar"></span>
                       <span class="icon-bar"></span>
                   </button>
                   <a class="navbar-brand" href="#">{% block branding %}My
                       Blog{% endblock %}</a>
               </div>
               <div class="collapse navbar-collapse">
                   <ul class="nav navbar-nav">
                       <li><a href="/">Home</a></li>
                       {% block extra_nav %}{% endblock %}
                   </ul>
               </div>
           </div>
       </div>
       <div class="container">
           <div class="row">
               <div class="col-md-9">
                   <h1>{% block content_title %}{% endblock %}</h1>
                   {% block content %}
                   {% endblock %}
               </div>
               <div class="col-md-3">
                   {% block sidebar %}
                   <ul class="well nav nav-stacked">
                       <li><a href="#">Sidebar item</a></li>
                   </ul>
                   {% endblock %}
               </div>
           </div>
           <div class="row">
               <hr />
               <footer>
                   <p>&copy; your name</p>
               </footer>
           </div>
       </div>
       </body>
       </html>
~~~

所有的block都是在预占位 

yii中要这样做也很容易 因为 view对象有block 变量 可以承载这些block 然后 在布局中预定义这些block
在视图或者控制器|action widget中传递block 就可以了。