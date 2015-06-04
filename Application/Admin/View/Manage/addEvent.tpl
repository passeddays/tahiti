<extend name='./Manage/layout' />
<block name='head'>
	<style type="text/css">
	#big-map{
		min-height: 500px;
	}
	#pac-input{
		width: 300px;
	}
	</style>
	<link rel="stylesheet" type="text/css" href="/static/js/webuploader/webuploader.css">
	<link rel="stylesheet" type="text/css" href="/static/css/bootstrap-datetimepicker.min.css">
</block>
<block name='right'>
<ol class="breadcrumb">
  <li><a href="__APP__/admin/manage">{$Think.lang.club_list}</a></li>
  <li><a href="__APP__/admin/manage/editclub&club_id={$data.club_id}">CLUB ID:{$data.club_id}</a></li>
  <li class="active">{$Think.lang.add_event}</li>
</ol>
<form class="form-horizontal" action='__APP__/admin/manage/addEventApi&cid={$data.club_id}' method='post' >
	<div id="legend" class="">
	    <legend class="">{$Think.lang.edit_event}</legend>
	</div>
	<div class="form-group">
		<label class="control-label col-sm-2">{$Think.lang.club_name}</label>
		<div class="col-sm-3">
		    <input type='text' readonly="" value="{$data.club_name}" class="form-control">
		</div>
	</div>

	<div class="form-group">
		<label class="control-label col-sm-2" for="event_name">{$Think.lang.event_name}</label>
		<div class="col-sm-3">
		    <input type="text" placeholder="" class="form-control" id='event_name' value='' name='event_name'>
		    <p class="help-block"></p>
		</div>
	</div>

	<div class="form-group">
		<label class="control-label col-sm-2" for="event_time">{$Think.lang.event_time}</label>
	    <div class="col-sm-3">
		    <div class="input-group date form_datetime " >
                <input class="form-control" size="16" type="text" value="" readonly="" name='event_time'>
                <!--<span class="input-group-addon"><span class="glyphicon glyphicon-remove"></span></span>-->
				<span class="input-group-addon"><span class="glyphicon glyphicon-th"></span></span>
            </div>
		</div>
	</div>
	<div class="form-group">
		<label class="control-label col-sm-2" for="event_brief">{$Think.lang.event_brief}</label>
		<div class="col-sm-3">
			<textarea class="form-control" rows="5" id='event_brief' name='event_brief'></textarea>
		</div>
	</div>

	<div class="form-group">
		<label class="control-label col-sm-2" for="event_poster">{$Think.lang.event_img}</label>
		<input type='hidden' name='event_poster' id='event_poster' value=''>
		<div class="col-sm-3">
			<div id="uploader-demo">
			    <!--用来存放item-->
			    <!--<div id="fileList" class="uploader-list"></div>-->
			    <img src="" alt="club logo" id='logo-img' style="max-width:200px;display:none;">
			    <div id="filePicker">选择图片</div>
			</div>
		</div>
	</div>
	<div class="form-group">
		<div class="col-sm-offset-2 col-sm-2">
		  <button class="btn btn-primary" type='submit'>Add</button>
		</div>
	</div>
</form>
</block>
<block name='js'>

<script type="text/javascript" src="/static/js/webuploader/webuploader.min.js"></script>
<script type="text/javascript" src="/static/js/bootstrap-datetimepicker.min.js"></script>
<script type="text/javascript">
var uploader = WebUploader.create({

	// 选完文件后，是否自动上传。
    auto: true,

    // swf文件路径
    swf: '/static/js/Uploader.swf',

    // 文件接收服务端。
    server: '__APP__/admin/manage/upload&upload_type=event',

    // 选择文件的按钮。可选。
    // 内部根据当前运行是创建，可能是input元素，也可能是flash.
    pick: '#filePicker',

    // 只允许选择图片文件。
    accept: {
        title: 'Images',
        extensions: 'gif,jpg,jpeg,png',
        mimeTypes: 'image/*'
    }
});
// 当有文件添加进来的时候
uploader.on( 'fileQueued', function( file ) {
	$img = $('#logo-img');
    // 创建缩略图
    // 如果为非图片文件，可以不用调用此方法。
    // thumbnailWidth x thumbnailHeight 为 100 x 100
    uploader.makeThumb( file, function( error, src ) {
        if ( error ) {
            $img.replaceWith('<span>不能预览</span>');
            return;
        }

        $img.attr( 'src', src );
    }, 100, 100 );
});
uploader.on('uploadSuccess', function (file, response) {
	$('#event_poster').val(response.data);
	$('#logo-img').attr('src', '/poster/'+response.data).css('display','block');
});
$('.form_datetime').datetimepicker({
    //language:  'fr',
    weekStart: 1,
    todayBtn:  1,
	autoclose: 1,
	todayHighlight: 1,
	startView: 2,
	forceParse: 0,
    showMeridian: 1,
    format: 'yyyy-mm-dd hh:ii:ss'
});
</script>
</block>