<!DOCTYPE html>
<html>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
<!--[if lte IE 9]>
  <script src="/static/js/html5shiv.js"></script>
  <script src="/static/js/respond.js"></script>
<![endif]-->
<head>
	<title>{$Think.lang.login_title}</title>
	<link rel="stylesheet" type="text/css" href="/static/css/bootstrap.min.css">
	<link rel="stylesheet" type="text/css" href="/static/css/signin.css">
</head>
<body>
    <div class="container">
      <form class="form-signin" role="form" action='__URL__/login' method='post' target='_self'>
        <h2 class="form-signin-heading">Tahiti {$Think.lang.login}</h2>
        <input type="text" class="form-control" placeholder="user name" required="" autofocus="" name='uname'>
        <input type="password" class="form-control" placeholder="Password" required="" name='passwd'>
        <!--
        <label class="checkbox">
          <input type="checkbox" value="remember-me"> Remember me
        </label>
    	-->
        <button class="btn btn-lg btn-primary btn-block" type="submit">Sign in</button>
      </form>

    </div>
</body>
</html>