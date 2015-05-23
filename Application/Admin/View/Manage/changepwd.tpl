<extend name='./Manage/layout' />
<block name='right'>
	
  <form class="form-horizontal" action='__APP__/admin/manage/changepwdapi' method='post' >
	<div id="legend" class="">
	    <legend class="">{$Think.lang.changepwd}</legend>
	</div>
	<div class="form-group">

	  <!-- Text input-->
	  <label class="control-label col-sm-2" for="uname">{$Think.lang.uname}</label>
	  <div class="col-sm-3">
	    <input type="text" placeholder="" class="form-control" id='uname' disabled value='{$Think.cookie.uname}' name='uname'>
	    <p class="help-block"></p>
	  </div>
	</div>

	<div class="form-group">

	  <!-- Text input-->
	  <label class="control-label col-sm-2" for="old_pwd">{$Think.lang.old_pwd}</label>
	  <div class="col-sm-3">
	    <input type="password" placeholder="" class="form-control" id='old_pwd' required="" autofocus="" name='old_pwd'>
	    <p class="help-block"></p>
	  </div>
	</div>

	<div class="form-group">

	  <!-- Text input-->
	  <label class="control-label col-sm-2" for="new_pwd">{$Think.lang.new_pwd}</label>
	  <div class="col-sm-3">
	    <input type="password" placeholder="" class="form-control" id='new_pwd' required="" name='new_pwd'>
	    <p class="help-block"></p>
	  </div>
	</div>

	<div class="form-group">

	  <!-- Search input-->
	  <label class="control-label col-sm-2" for='new_pwd_again'>{$Think.lang.new_pwd_again}</label>
	  <div class="col-sm-3">
	    <input type="password" placeholder="" class="form-control" id='new_pwd_again' required="" name='new_pwd_again'>
	    <p class="help-block"></p>
	  </div>

	</div>
	<div class="form-group">
		<div class="col-sm-offset-2 col-sm-2">
		  <button class="btn btn-primary" type='submit'>Submit</button>
		</div>
	</div>
  </form>

</block>
<block name='js'>
<script type="text/javascript">
$(function(){
	var diffNewpwd = function(){
		if(($('#new_pwd').val() == $('#new_pwd_again').val()) && $('#new_pwd').val()){
			return 1;
		}else{
			alert('{$Think.lang.new_old_diff}');
			return 0;
		}
	}
	$('form').submit(function(){
		if(diffNewpwd()){
			if($('#uname').val() && $('#old_pwd').val() && $('#new_pwd').val()){
				return true;
			}else{
				alert('{$Think.lang.form_unfilled}');
				return false;
			}
		}else{
			return false;
		}
	});
});
</script>
</block>