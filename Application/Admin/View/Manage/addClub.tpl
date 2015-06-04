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
	<script type="text/javascript" src="http://maps.googleapis.com/maps/api/js?key=AIzaSyDb2ef9JYWyphA9gEILCBNfmdZoGb9gcdg&sensor=false&libraries=places"></script>
	<link rel="stylesheet" type="text/css" href="/static/js/webuploader/webuploader.css">
</block>
<block name='right'>
<form class="form-horizontal" action='__APP__/admin/manage/addClubApi' method='post' >
	<div id="legend" class="">
	    <legend class="">{$Think.lang.add_club}</legend>
	</div>
	<div class="form-group">
		<label class="control-label col-sm-2" for="club_name">{$Think.lang.club_name}</label>
		<div class="col-sm-3">
		    <input type="text" placeholder="" class="form-control" id='club_name' value='' name='club_name'>
		    <p class="help-block"></p>
		</div>
	</div>

	<div class="form-group">
		<label class="control-label col-sm-2" for="club_type">{$Think.lang.club_type}</label>
		<div class="col-sm-3">
		    <select id='club_type' class="form-control" name='club_type'>>
		    	<foreach name='data.club_type_list' key='k' item='v'>
		    		<if condition="intval($k) eq $data['club_type']">
		    		<option value='{$k}' selected {$data.club_type}>{$v}</option>
		    		<else /><option value='{$k}'>{$v}</option>
		    		</if>
		    	</foreach>
		    </select>
		    <p class="help-block"></p>
		</div>
	</div>

	<div class="form-group">
		<label class="control-label col-sm-2" for="club_city">{$Think.lang.city}</label>
		<div class="col-sm-3">
		    <select class="form-control" name='club_city' id='club_city'>
		    	<foreach name='citylist' item='val'>
		    		<option value='{$val.city_id}' <if condition="$data['club_city'] eq $val['city_id']">selected</if>>{$val.city_name}</option>
		    	</foreach>
		    </select>
		</div>
	</div>

	<div class="form-group">
		<label class="control-label col-sm-2" for="club_address">{$Think.lang.club_address}</label>
		<div class="col-sm-3">
		    <input type="text" placeholder="" class="form-control" id='club_address' value='' name='club_address'>
		    <p class="help-block"></p>
		</div>
	</div>

	<div class="form-group">
		<label class="control-label col-sm-2" for="club_website">{$Think.lang.club_website}</label>
		<div class="col-sm-3">
		    <input type="text" placeholder="" class="form-control" id='club_website' value='' name='club_website'>
		    <p class="help-block"></p>
		</div>
	</div>

	<div class="form-group">
		<label class="control-label col-sm-2" for="club_fb">{$Think.lang.club_fb}</label>
		<div class="col-sm-3">
		    <input type="text" placeholder="" class="form-control" id='club_fb' value='' name='club_fb'>
		    <p class="help-block"></p>
		</div>
	</div>

	<div class="form-group">
		<label class="control-label col-sm-2" for="club_price">{$Think.lang.club_price}</label>
		<div class="col-sm-3">
		    <input type="text" placeholder="" class="form-control" id='club_price' value='' name='club_price'>
		    <p class="help-block"></p>
		</div>
	</div>

	<div class="form-group">
		<label class="control-label col-sm-2" for="club_tel">{$Think.lang.club_tel}</label>
		<div class="col-sm-3">
		    <input type="text" placeholder="" class="form-control" id='club_tel' value='' name='club_tel'>
		    <p class="help-block"></p>
		</div>
	</div>

	<div class="form-group">
		<label class="control-label col-sm-2" for="club_follow" style='color:red;'>{$Think.lang.club_follow}</label>
		<div class="col-sm-3">
		    <input type="text" placeholder="" class="form-control" id='club_follow' value='' name='club_follow'>
		    <p class="help-block"></p>
		</div>
	</div>

	<div class="form-group">
		<label class="control-label col-sm-2" for="club_fb" >{$Think.lang.club_loc}</label>
		<input type='hidden' name='club_lat' id='club_lat' value=''>
		<input type='hidden' name='club_lng' id='club_lng' value=''>
		<div class="col-sm-3" id='little-map'>
		</div>
		<div class="col-sm-1">
			<a href="#" id='change-loc'>修改坐标</a>
		</div>
		
	</div>

	<div class="form-group">
		<label class="control-label col-sm-2" for="club_brief">{$Think.lang.club_brief}</label>
		<div class="col-sm-3">
			<textarea class="form-control" rows="5" id='club_brief' name='club_brief'></textarea>
		</div>
	</div>

	<div class="form-group">
		<label class="control-label col-sm-2" for="club_logo">{$Think.lang.club_logo}</label>
		<input type='hidden' name='club_thumb' id='club_thumb' value=''>
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
		  <button class="btn btn-primary" type='submit'>ADD</button>
		</div>
	</div>
</form>
<div class="modal fade" id='modal' tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content" >
    	<div class="modal-header">
    		<h4 class="modal-title">{$Think.lang.drag_point}</h4>
    	</div>
    	<input id="pac-input" class="controls form-control" type="text" placeholder="Search Box">
    	<div class="modal-body" id='big-map'>
    	</div>
    </div>
  </div>
</div>
</block>
<block name='js'>

<script type="text/javascript" src="/static/js/webuploader/webuploader.min.js"></script>
<script type="text/javascript">
$(function(){
	$('#little-map').height($('#little-map').width());
	var lat = -11.07777, lng = -44.255559;
	var littleMap = {
		init : function(){
			var point = new google.maps.LatLng(lat, lng);
			var mapOptions = {
				center: point,
				zoom: 3,
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
				zoom: 3,
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
    server: '__APP__/admin/manage/upload&upload_type=thumb&self_id={$data.club_id}',

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
	$('#logo-img').attr('src', "/thumb/"+response.data).css('display', 'block');
});
</script>
</block>