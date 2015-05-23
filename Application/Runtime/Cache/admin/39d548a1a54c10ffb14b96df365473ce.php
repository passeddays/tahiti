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
    min-height: 800px;
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

      <!--language-->
      <ul class="nav navbar-nav navbar-right">
        <li class="dropdown">
          <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false"><?php echo ($current_language); ?> <span class="caret"></span></a>
          <ul class="dropdown-menu" role="menu">
            <li><a href="/tahiti/index.php?s=/admin/manage/clublist.html&l=chinese">中文</a></li>
            <li><a href="/tahiti/index.php?s=/admin/manage/clublist.html&l=english">English</a></li>
            <li><a href="/tahiti/index.php?s=/admin/manage/clublist.html&l=portuguese">Português</a></li>
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
          <li class="nav-header"><a href="/tahiti/index.php?s=/admin/manage/changepwd"><?php echo (L("changepwd")); ?><i class="icon-circle-arrow-down toggleicon" id="icon1"></i></a></li>
          <li class="nav-header"><a href="#"><?php echo (L("club_manage")); ?><i class="icon-circle-arrow-down toggleicon" id="icon2"></i></a></li>
        </ul>
      </div>
    </div>
    <div class='col-lg-9 well right'>
      
<div class="row">
  <div class="col-lg-6">
    <div class="input-group">
      <div class="input-group-btn">
        <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
        	<span id='menu-text'><?php echo (L("club_id")); ?></span>
        	<input id='search-condition' type='hidden' value='1'>
        	<span class="caret"></span>
        </button>
        <ul class="dropdown-menu search-condition-group" role="menu">
          <li><a href="#" value="1"><?php echo (L("club_id")); ?></a></li>
          <li><a href="#" value="2"><?php echo (L("club_name")); ?></a></li>
          <li><a href="#" value="3"><?php echo (L("club_type")); ?></a></li>
          <li><a href="#" value="4"><?php echo (L("city")); ?></a></li>
        </ul>
      </div><!-- /btn-group -->
      <input type="text" class="form-control" aria-label="..." id='search-word' name='search-word'>
      <span class="input-group-btn">
        <button class="btn btn-default" type="button" id='search'>Search</button>
      </span>
    </div><!-- /input-group -->
  </div><!-- /.col-lg-6 -->
</div><!-- /.row -->
<table class="table table-hover">
	<thead>
		<tr>
			<th><?php echo (L("club_id")); ?></th>
			<th><?php echo (L("club_name")); ?></th>
			<th><?php echo (L("club_type")); ?></th>
			<th><?php echo (L("city")); ?></th>
			<th></th>
		</tr>
	</thead>
	<tbody>

	</tbody>
</table>
<nav>
  <ul class="pagination">
    <li class="pre">
      <a href="#" aria-label="Previous" >
        <span aria-hidden="true">&laquo;</span>
      </a>
    </li>
    <li class='page'><a href="#" >1</a></li>
    <li class='page'><a href="#" >2</a></li>
    <li class='page'><a href="#" >3</a></li>
    <li class='page'><a href="#" >4</a></li>
    <li class='page'><a href="#" >5</a></li>
    <li class='next'>
      <a href="#" aria-label="Next" >
        <span aria-hidden="true">&raquo;</span>
      </a>
    </li>
  </ul>
</nav>

    </div>
  </div>
</div>

</body>
<script src='/static/js/jquery-1.11.2.min.js'></script>
<script src='/static/js/bootstrap.min.js'></script>


<script type="text/javascript">
$(function(){
	var current_page = 1, count_per_page = 10;
	var pagination = function(current_page, total_page_count){
		$('.pagination').find('li').removeClass('disabled').removeClass('active');
		var page_num = 5, html;
		var start = Math.floor(current_page/page_num)*page_num+1,
			end = Math.ceil(current_page/page_num)*page_num;
		if(current_page <= page_num){
			$('.pre').addClass('disabled');
		}
		if((start+5) >= total_page_count){
			$('.next').addClass('disabled');
			end = total_page_count;
		}
		for(var i=0; i<page_num; i++){
			if(i <= (end-start)){
				$('.page').eq(i).css('display','inline').find('a').text(start+i);
				if((start+i) == current_page){
					$('.page').eq(i).addClass('active');
				}
			}else{
				$('.page').eq(i).css('display','none');
			}
		}
		
	};
	var getClubList = function(page_num){
		var word = $('#search-word').val(),
			condition = {
				current_page:page_num,
				count_per_page:count_per_page
			};
		console.log(word);
		if(word){
			switch($('#search-condition').val()){
				case "1":
					condition.club_id = word;
					break;
				case "2":
					condition.club_name = word;
					break;
				case "3":
					condition.club_type = word;
					break;
				case "4":
					condition.club_city = word;
					break;
			}
		}
		$.getJSON('/tahiti/index.php?s=/admin/manage/getclublist',condition,function(data){
			if(data.err_no == 0){
				var list = data.data.list,
					total_count = data.data.total_count,
				 	html;
				current_page = data.data.current_page;
				for(var i in list){
					html += '<tr>'
						+'<td>'+list[i].club_id+'<input name="club_id" value="'+list[i].club_id+'" type="hidden"> </td>'
						+'<td>'+list[i].club_name+'</td>'
						+'<td>'+list[i].club_type+'</td>'
						+'<td>'+list[i].club_city+'</td>'
						+'<td><button type="button" class="btn btn-primary edit"><?php echo (L("edit")); ?></button>&nbsp&nbsp<button type="button" class="btn btn-warning delete"><?php echo (L("delete")); ?></button></td>'
						+'</tr>';
				}
				$('tbody').html(html);
				pagination(current_page, Math.ceil(total_count/count_per_page));
				bindClick();
			}else{
				alert('search failed');
			}
		});
	};
	$('.search-condition-group').find('a').click(function(){
		var value = $(this).attr('value'),
			text = $(this).text();
		$('#search-condition').val(value);
		$('#menu-text').text(text);
	});
	$('#search').click(function(){
		getClubList(1);
	}).click();
	var bindClick = function(){
		$('.page').unbind();
		$('.next').unbind();
		$('.pre').unbind();
		$('.delete').unbind();

		$('.page').click(function(){
			if($(this).find('a').text() == current_page){
				return ;
			}
			getClubList($(this).find('a').text());
		});
		$('.next').click(function(){
			if($(this).hasClass('disabled')){
				return ;
			}
			getClubList(Number(current_page)+5);
		});
		$('.pre').click(function(){
			if($(this).hasClass('disabled')){
				return ;
			}
			getClubList(Number(current_page)-5);
			
		});
		$('.delete').click(function(){
			var club_id = $(this).parent().parent().find("input[name='club_id']").val();
			var me = this;
			$.getJSON('/tahiti/index.php?s=/admin/manage/deleteClubByClubId',{club_id:club_id},function(data){
				if(data.err_no == 0){
					$(me).parent().parent().remove();
				}else{
					alert('DELETE failed');
				}
			});
		});
		$('.edit').click(function(){
			var club_id = $(this).parent().parent().find("input[name='club_id']").val();
			var me = this;
			$.getJSON('/tahiti/index.php?s=/admin/manage/editClub',{club_id:club_id},function(data){
				if(data.err_no == 0){
					$(me).parent().parent().remove();
				}else{
					alert('DELETE failed');
				}
			});
			window.location.href = '/tahiti/index.php?s=/admin/manage/editClub'+'&club_id='+club_id;
		});
	}
	
});
</script>

</html>