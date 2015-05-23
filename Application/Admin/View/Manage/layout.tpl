<!DOCTYPE html>
<html>

<head>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  
	<title>{$Think.lang.manage_index_title}</title>
	<link rel="stylesheet" type="text/css" href="/static/css/bootstrap.min.css">
  <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
  <!--[if lte IE 9]>
  <script src="/static/js/html5shiv.js"></script>
  <script src="/static/js/respond.js"></script>
  <![endif]-->
  <style type="text/css">
  body { 
    padding-top: 70px; 
    font-family: "微软雅黑";
  }
  .well{
    min-height: 800px;
  }
  </style>
  <block name="head"></block>
</head>
<body>
<nav class="navbar navbar-default navbar-fixed-top">
  <div class="container-fluid">
    <!-- Brand and toggle get grouped for better mobile display -->
    <div class="navbar-header">
      <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
        <span class="sr-only">Toggle navigation</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </button>
      <a class="navbar-brand" href="#">{$Think.lang.manage_index_title}</a>
    </div>

    <!-- Collect the nav links, forms, and other content for toggling -->
    <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
      
      <ul class="nav navbar-nav navbar-right">
        <li class="dropdown">
          <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">{$Think.cookie.uname} <span class="caret"></span></a>
          <ul class="dropdown-menu" role="menu">
            <li><a href="__APP__/admin/login/logout">{$Think.lang.logout}</a></li>
          </ul>
        </li>
      </ul>

      <!--language-->
      <ul class="nav navbar-nav navbar-right">
        <li class="dropdown">
          <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">{$current_language} <span class="caret"></span></a>
          <ul class="dropdown-menu" role="menu">
            <li><a href="__SELF__&l=chinese">中文</a></li>
            <li><a href="__SELF__&l=english">English</a></li>
            <li><a href="__SELF__&l=portuguese">Português</a></li>
          </ul>
        </li>
      </ul>
    </div><!-- /.navbar-collapse -->
  </div><!-- /.container-fluid -->
</nav>
<div class="container-fluid">
  <div class='row'>
    <div class='col-lg-2 left'>
      <div class="well sidebar-nav dir">
        <ul class="nav nav-list">
          <li class="nav-header"><a href="__APP__/admin/manage/changepwd">{$Think.lang.changepwd}<i class="icon-circle-arrow-down toggleicon" id="icon1"></i></a></li>
          <li class="nav-header"><a href="#">{$Think.lang.club_manage}<i class="icon-circle-arrow-down toggleicon" id="icon2"></i></a></li>
        </ul>
      </div>
    </div>
    <div class='col-lg-9 well right'>
      <block name='right'></block>
    </div>
  </div>
</div>

</body>
<script src='/static/js/jquery-1.11.2.min.js'></script>
<script src='/static/js/bootstrap.min.js'></script>

<block name='js'></block>
</html>