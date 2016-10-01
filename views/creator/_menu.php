<?php
    $this->registerCss('
	#left, #right {min-width:20px; min-height:50px;border: solid 1px #DCD8D8}
	.navbar-nav > li > .dropdown-menu { min-height: 30px;}
	.ghost { opacity: 0.3;outline: 0;background: #C8EBFB;}
	a { outline: 0;}
	#trash, #edit { min-height:120px; margin-top: 85px; margin-left:40px}

	#trash i, #edit i { font-size:33px; margin-top:10px; color:#ccc}
	#trash li, #edit li { text-align:center; list-style-type: none; font-size:200%;}

	#trash li a {color:red; opacity: 1;}
	#edit li a {color:#1D9841;opacity: 1;}

	.dropdown-menu .divider {
		height: 5px;
	}'
);	?>

<div class="row" id="container-nav">
  <nav class="navbar navbar-default">
        <div class="container-fluid">
          
		  <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
              <span class="sr-only">Toggle navigation</span>
              <span class="icon-bar"></span>
              <span class="icon-bar"></span>
              <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="#">L</a>
          </div>
		  
          <div id="navbar" class="navbar-collapse collapse pceuropa-menu">
            <ul id="left" class="nav navbar-nav"></ul>
            <ul id="right" class="nav navbar-nav navbar-right"></ul>
          </div><!--/.nav-collapse -->
        </div><!--/.container-fluid -->
  </nav>
<!--<div class="row pull-right">Preview: <a id=''>Life</a> | <a id=''>Html</a> | <a id=''>Yii2 Array</a></div><br/>-->
