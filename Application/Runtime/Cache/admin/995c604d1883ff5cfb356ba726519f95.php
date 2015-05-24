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
  
	<style type="text/css">
	#big-map{
		min-height: 500px;
	}
	#pac-input{
		width: 300px;
	}
	</style>
	<script type="text/javascript" src="http://maps.googleapis.com/maps/api/js?key=AIzaSyDb2ef9JYWyphA9gEILCBNfmdZoGb9gcdg&sensor=false&libraries=places"></script>
	<link rel="stylesheet" type="text/css" href="/static/js/webuploader/webuploader.css">

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
            <li><a href="/tahiti/index.php?s=/admin/manage/editClub&club_id=2&l=chinese">中文</a></li>
            <li><a href="/tahiti/index.php?s=/admin/manage/editClub&club_id=2&l=english">English</a></li>
            <li><a href="/tahiti/index.php?s=/admin/manage/editClub&club_id=2&l=portuguese">Português</a></li>
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
      
<ol class="breadcrumb">
  <li><a href="/tahiti/index.php?s=/admin/manage"><?php echo (L("club_list")); ?></a></li>
  <li class="active">CLUB ID:<?php echo ($data["club_id"]); ?></li>
</ol>
<form class="form-horizontal" action='/tahiti/index.php?s=/admin/manage/updateClub&cid=<?php echo ($data["club_id"]); ?>' method='post' >
	<div id="legend" class="">
	    <legend class=""><?php echo (L("edit_club")); ?></legend>
	</div>
	<div class="form-group">
		<label class="control-label col-sm-2" for="club_name"><?php echo (L("club_name")); ?></label>
		<div class="col-sm-3">
		    <input type="text" placeholder="" class="form-control" id='club_name' value='<?php echo ($data["club_name"]); ?>' name='club_name'>
		    <p class="help-block"></p>
		</div>
	</div>

	<div class="form-group">
		<label class="control-label col-sm-2" for="club_type"><?php echo (L("club_type")); ?></label>
		<div class="col-sm-3">
		    <!--<input type="text" placeholder="" class="form-control" id='club_type' value='<?php echo ($data["club_type"]); ?>' name='club_type'>-->
		    <select id='club_type' class="form-control" name='club_type'>>
		    	<?php if(is_array($data["club_type_list"])): foreach($data["club_type_list"] as $k=>$v): if(intval($k) == $data['club_type']): ?><option value='<?php echo ($k); ?>' selected <?php echo ($data["club_type"]); ?>><?php echo ($v); ?></option>
		    		<?php else: ?><option value='<?php echo ($k); ?>'><?php echo ($v); ?></option><?php endif; endforeach; endif; ?>
		    </select>
		    <p class="help-block"></p>
		</div>
	</div>

	<div class="form-group">
		<label class="control-label col-sm-2" for="club_city"><?php echo (L("city")); ?></label>
		<div class="col-sm-3">
		    <select class="form-control" name='club_city' id='club_city'>
		    	<?php if(is_array($citylist)): foreach($citylist as $key=>$val): ?><option value='<?php echo ($val["city_id"]); ?>' <?php if($data['club_city'] == $val['city_id']): ?>selected<?php endif; ?>><?php echo ($val["city_name"]); ?></option><?php endforeach; endif; ?>
		    </select>
		</div>
	</div>

	<div class="form-group">
		<label class="control-label col-sm-2" for="club_address"><?php echo (L("club_address")); ?></label>
		<div class="col-sm-3">
		    <input type="text" placeholder="" class="form-control" id='club_address' value='<?php echo ($data["club_address"]); ?>' name='club_address'>
		    <p class="help-block"></p>
		</div>
	</div>

	<div class="form-group">
		<label class="control-label col-sm-2" for="club_website"><?php echo (L("club_website")); ?></label>
		<div class="col-sm-3">
		    <input type="text" placeholder="" class="form-control" id='club_website' value='<?php echo ($data["club_website"]); ?>' name='club_website'>
		    <p class="help-block"></p>
		</div>
	</div>

	<div class="form-group">
		<label class="control-label col-sm-2" for="club_fb"><?php echo (L("club_fb")); ?></label>
		<div class="col-sm-3">
		    <input type="text" placeholder="" class="form-control" id='club_fb' value='<?php echo ($data["club_fb"]); ?>' name='club_fb'>
		    <p class="help-block"></p>
		</div>
	</div>

	<div class="form-group">
		<label class="control-label col-sm-2" for="club_price"><?php echo (L("club_price")); ?></label>
		<div class="col-sm-3">
		    <input type="text" placeholder="" class="form-control" id='club_price' value='<?php echo ($data["club_price"]); ?>' name='club_price'>
		    <p class="help-block"></p>
		</div>
	</div>

	<div class="form-group">
		<label class="control-label col-sm-2" for="club_tel"><?php echo (L("club_tel")); ?></label>
		<div class="col-sm-3">
		    <input type="text" placeholder="" class="form-control" id='club_tel' value='<?php echo ($data["club_tel"]); ?>' name='club_tel'>
		    <p class="help-block"></p>
		</div>
	</div>

	<div class="form-group">
		<label class="control-label col-sm-2" for="club_follow" style='color:red;'><?php echo (L("club_follow")); ?></label>
		<div class="col-sm-3">
		    <input type="text" placeholder="" class="form-control" id='club_follow' value='<?php echo ($data["club_follow"]); ?>' name='club_follow'>
		    <p class="help-block"></p>
		</div>
	</div>

	<div class="form-group">
		<label class="control-label col-sm-2" for="club_fb" ><?php echo (L("club_loc")); ?></label>
		<input type='hidden' name='club_lat' id='club_lat' value='<?php echo ($data["club_lat"]); ?>'>
		<input type='hidden' name='club_lng' id='club_lng' value='<?php echo ($data["club_lng"]); ?>'>
		<div class="col-sm-3" id='little-map'>
		</div>
		<div class="col-sm-1">
			<a href="#" id='change-loc'>修改坐标</a>
		</div>
		
	</div>

	<div class="form-group">
		<label class="control-label col-sm-2" for="club_brief"><?php echo (L("club_brief")); ?></label>
		<div class="col-sm-3">
			<textarea class="form-control" rows="5" id='club_brief' name='club_brief'><?php echo ($data["club_brief"]); ?></textarea>
		</div>
	</div>

	<div class="form-group">
		<label class="control-label col-sm-2" for="club_logo"><?php echo (L("club_logo")); ?></label>
		<input type='hidden' name='club_thumb' id='club_thumb' value=''>
		<div class="col-sm-3">
			<div id="uploader-demo">
			    <!--用来存放item-->
			    <!--<div id="fileList" class="uploader-list"></div>-->
			    <img src="<?php echo ($data["club_thumb"]); ?>" alt="club logo" id='logo-img'>
			    <div id="filePicker">选择图片</div>
			</div>
		</div>
	</div>
	
	<div class="form-group">
		<div class="col-sm-offset-2 col-sm-2">
		  <button class="btn btn-primary" type='submit'>Update</button>
		</div>
	</div>
</form>
<div class="modal fade" id='modal' tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content" >
    	<div class="modal-header">
    		<h4 class="modal-title"><?php echo (L("drag_point")); ?></h4>
    	</div>
    	<input id="pac-input" class="controls form-control" type="text" placeholder="Search Box">
    	<div class="modal-body" id='big-map'>
    	</div>
    </div>
  </div>
</div>

    </div>
  </div>
</div>

</body>
<script src='/static/js/jquery-1.11.2.min.js'></script>
<script src='/static/js/bootstrap.min.js'></script>



<script type="text/javascript" src="/static/js/webuploader/webuploader.min.js"></script>
<script type="text/javascript">
$(function(){
	$('#little-map').height($('#little-map').width());
	var lat = <?php echo ($data["club_lat"]); ?>, lng = <?php echo ($data["club_lng"]); ?>;
	var littleMap = {
		init : function(){
			var point = new google.maps.LatLng(lat, lng);
			var mapOptions = {
				center: point,
				zoom: 13,
				mapTypeId: google.maps.MapTypeId.ROADMAP,
				streetViewControl: false
			};
			var map = new google.maps.Map(document.getElementById("little-map"),mapOptions);
			var marker = new google.maps.Marker({
			    position: point,
			    map: map
			});
		}
	};
	var bigMap = {
		map : '',
		init : function(){
			var point = new google.maps.LatLng(lat, lng),
				me = this;
			var mapOptions = {
				center: point,
				zoom: 13,
				mapTypeId: google.maps.MapTypeId.ROADMAP,
				streetViewControl: false,
				scaleControl: false
			};
			me.map = new google.maps.Map(document.getElementById("big-map"),mapOptions);
			var myMarker = new google.maps.Marker({
			    position: point,
			    map: me.map,
			    draggable : true
			});
			google.maps.event.addListener(myMarker, 'dragend', function() {    
		        newPoint = myMarker.getPosition();    
		        lat = newPoint.lat();
		        lng = newPoint.lng();
		        $('#club_lat').val(lat);
		        $('#club_lng').val(lng);
		        littleMap.init();
		    });   
		    google.maps.event.addListener(me.map, 'click', function(e) {    
		        lat = e.latLng.lat();
		        lng = e.latLng.lng();
		        myMarker.setPosition(e.latLng);
		        $('#club_lat').val(lat);
		        $('#club_lng').val(lng);
		        littleMap.init();
		    });  

		    // Create the search box and link it to the UI element.
			  var input = /** @type {HTMLInputElement} */(
			      document.getElementById('pac-input')),markers = [];
			  me.map.controls[google.maps.ControlPosition.TOP_LEFT].push(input);

			  var searchBox = new google.maps.places.SearchBox(
			    /** @type {HTMLInputElement} */(input));

			  // [START region_getplaces]
			  // Listen for the event fired when the user selects an item from the
			  // pick list. Retrieve the matching places for that item.
			  google.maps.event.addListener(searchBox, 'places_changed', function() {
			    var places = searchBox.getPlaces();

			    if (places.length == 0) {
			      return;
			    }
			    for (var i = 0, marker; marker = markers[i]; i++) {
			      marker.setMap(null);
			    }

			    // For each place, get the icon, place name, and location.
			    markers = [];
			    var bounds = new google.maps.LatLngBounds();
			    for (var i = 0, place; place = places[i]; i++) {
			      var image = {
			        url: place.icon,
			        size: new google.maps.Size(71, 71),
			        origin: new google.maps.Point(0, 0),
			        anchor: new google.maps.Point(17, 34),
			        scaledSize: new google.maps.Size(25, 25)
			      };

			      // Create a marker for each place.
			      var marker = new google.maps.Marker({
			        map: me.map,
			        icon: image,
			        title: place.name,
			        position: place.geometry.location
			      });

			      markers.push(marker);

			      bounds.extend(place.geometry.location);
			    }

			    me.map.fitBounds(bounds);
			  });
			  // [END region_getplaces]

			  // Bias the SearchBox results towards places that are within the bounds of the
			  // current map's viewport.
			  google.maps.event.addListener(me.map, 'bounds_changed', function() {
			    var bounds = me.map.getBounds();
			    searchBox.setBounds(bounds);
			  });
		},
		reload : function(){
			google.maps.event.trigger(this.map, 'resize');
			this.map.setCenter(new google.maps.LatLng(lat, lng));
		}
	};
	littleMap.init();
	bigMap.init();
	$('#modal').on('shown.bs.modal', function (e) {
		bigMap.reload();
	})
	$('#change-loc').click(function(){
		$('#modal').modal('show');
	});
});
var uploader = WebUploader.create({

	// 选完文件后，是否自动上传。
    auto: true,

    // swf文件路径
    swf: '/static/js/Uploader.swf',

    // 文件接收服务端。
    server: '/tahiti/index.php?s=/admin/manage/upload&upload_type=thumb&self_id=<?php echo ($data["club_id"]); ?>',

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
	$('#club_thumb').val(response.data);
});
</script>

</html>