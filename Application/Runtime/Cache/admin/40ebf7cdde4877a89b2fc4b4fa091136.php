<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html>

<head>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  
	<title><?php echo (L("manage_index_title")); ?></title>
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
    min-height: 500px;
  }
  
  </style>
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
      <a class="navbar-brand" href="#"><?php echo (L("manage_index_title")); ?></a>
    </div>

    <!-- Collect the nav links, forms, and other content for toggling -->
    <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
      <ul class="nav navbar-nav navbar-right">
        <li class="dropdown">
          <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false"><?php echo (cookie('uname')); ?> <span class="caret"></span></a>
          <ul class="dropdown-menu" role="menu">
            <li><a href="/tahiti/index.php?s=/admin/login/logout"><?php echo (L("logout")); ?></a></li>
          </ul>
        </li>
      </ul>
    </div><!-- /.navbar-collapse -->
  </div><!-- /.container-fluid -->
</nav>
<div class="container-fluid">
  <div class='row'>
    <div class='col-lg-2'>
      <div class="well sidebar-nav dir">
        <ul class="nav nav-list">
          <li class="nav-header"><a href="/tahiti/index.php?s=/admin/manage/changepwd"><?php echo (L("changepwd")); ?><i class="icon-circle-arrow-down toggleicon" id="icon1"></i></a></li>
          <li class="nav-header"><a href="#"><?php echo (L("club_manage")); ?><i class="icon-circle-arrow-down toggleicon" id="icon2"></i></a></li>
        </ul>
      </div>
    </div>
    <div class='col-lg-9 well '>
      
	<div>test</div>

    </div>
  </div>
</div>

</body>
<script src='/static/js/jquery-1.11.2.min.js'></script>
<script src='/static/js/bootstrap.min.js'></script>

</html>