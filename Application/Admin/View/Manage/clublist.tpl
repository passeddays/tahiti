<extend name='./Manage/layout' />
<block name='head'>
	<style type="text/css">
        .pagination li > input{
        	margin-left: 10px;
            height: 34px;
            width:40px;
            float:left;
        }
    </style>
</block>
<block name='right'>
<div class="row">
  <div class="col-lg-6">
    <div class="input-group">
      <div class="input-group-btn">
        <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
        	<span id='menu-text'>{$Think.lang.club_id}</span>
        	<input id='search-condition' type='hidden' value='1'>
        	<span class="caret"></span>
        </button>
        <ul class="dropdown-menu search-condition-group" role="menu">
          <li><a href="#" value="1">{$Think.lang.club_id}</a></li>
          <li><a href="#" value="2">{$Think.lang.club_name}</a></li>
          <li><a href="#" value="3">{$Think.lang.club_type}</a></li>
          <li><a href="#" value="4">{$Think.lang.city}</a></li>
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
			<th>{$Think.lang.club_id}</th>
			<th>{$Think.lang.club_name}</th>
			<th>{$Think.lang.club_type}</th>
			<th>{$Think.lang.city}</th>
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
    <li class='page'><a href="#" >6</a></li>
    <li class='page'><a href="#" >7</a></li>
    <li class='page'><a href="#" >8</a></li>
    <li class='page'><a href="#" >9</a></li>
    <li class='page'><a href="#" >10</a></li>
    <li class='next'>
      <a href="#" aria-label="Next" >
        <span aria-hidden="true">&raquo;</span>
      </a>
    </li>
    <li><input type="text" class="form-control" id='page-id'></li>
    <li><a href="#" id='page-go'>Go</a></li>
  </ul>
</nav>
</block>
<block name='js'>
<script type="text/javascript">
$(function(){
	var current_page = 1, count_per_page = 10;
	var pagination = function(current_page, total_page_count){
		$('.pagination').find('li').removeClass('disabled').removeClass('active');
		var page_num = 10, html;
		var start = Math.floor(current_page/page_num)*page_num+1,
			end = Math.ceil(current_page/page_num)*page_num;
		if(current_page <= page_num){
			$('.pre').addClass('disabled');
		}
		if((start+page_num) >= total_page_count){
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
		$('#page-id').val(current_page);
	};
	var getClubList = function(page_num){
		var word = $('#search-word').val(),
			condition = {
				current_page:page_num,
				count_per_page:count_per_page
			};
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
		$.getJSON('__APP__/admin/manage/getclublist',condition,function(data){
			if(data.err_no == 0){
				var list = data.data.list,
					total_count = data.data.total_count,
				 	html = '';
				current_page = data.data.current_page;
				for(var i in list){
					html += '<tr>'
						+'<td>'+list[i].club_id+'<input name="club_id" value="'+list[i].club_id+'" type="hidden"> </td>'
						+'<td>'+list[i].club_name+'</td>'
						+'<td>'+list[i].club_type+'</td>'
						+'<td>'+list[i].club_city+'</td>'
						+'<td><button type="button" class="btn btn-primary edit">{$Think.lang.edit}</button>&nbsp&nbsp<button type="button" class="btn btn-warning delete">{$Think.lang.delete}</button></td>'
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
	$(document).keypress(function(e) {  
    	// 回车键事件  
        if(e.keyCode == 13) {  
    		$('#search').click();  
        }  
    }); 
    $('#page-go').click(function(){
    	getClubList($('#page-id').val());
    });
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
			getClubList(Number(current_page)+10);
		});
		$('.pre').click(function(){
			if($(this).hasClass('disabled')){
				return ;
			}
			getClubList(Number(current_page)-10);
			
		});
		$('.delete').click(function(){
			var club_id = $(this).parent().parent().find("input[name='club_id']").val();
			var me = this;
			$.getJSON('__APP__/admin/manage/deleteClubByClubId',{club_id:club_id},function(data){
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
			$.getJSON('__APP__/admin/manage/editClub',{club_id:club_id},function(data){
				if(data.err_no == 0){
					$(me).parent().parent().remove();
				}else{
					alert('DELETE failed');
				}
			});
			window.location.href = '__APP__/admin/manage/editClub'+'&club_id='+club_id;
		});
	}
	
});
</script>
</block>