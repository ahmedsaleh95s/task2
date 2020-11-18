<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ibtikar</title>
    <link rel="stylesheet" href="/css/style.css">
    <link href="//maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
</head>
<body>
    <div class="success-alert-login"></div>
<div class="login-reg-panel">
		<div class="login-info-box">
			<h2>Have an account?</h2>
			<p>Lorem ipsum dolor sit amet</p>
			<label id="label-register" for="log-reg-show">Login</label>
			<input type="radio" name="active-log-panel" id="log-reg-show"  checked="checked">
		</div>
							
		<div class="register-info-box">
			<h2>Don't have an account?</h2>
			<p>Lorem ipsum dolor sit amet</p>
			<label id="label-login" for="log-login-show">Register</label>
			<input type="radio" name="active-log-panel" id="log-login-show">
		</div>
							
		<div class="white-panel">
			<div class="login-show">
                <h2>LOGIN</h2>
                <input type="text"  id="email" placeholder="Email">
                <input type="password"  id="password" placeholder="Password">
				<input type="button" class="login-btn" value="Login">
				<a href="">Forgot password?</a>
			</div>
			<div class="register-show">
                <h2>REGISTER</h2>
                <form method="post" id="form" enctype="multipart/form-data">
                    <input type="text" name="name"  id="name" placeholder="Name">
                    <input type="text" name="email"  id="email2" placeholder="Email">
                    <input type="text" name="phone"  id="phone" placeholder="Phone">
                    <input type="password" name="password" id="password2" placeholder="Password">
                    <input type="file" name="photo" id="photo" class="uploading-image"/>
                    <input type="button" class="register-btn" value="Register">
                </form>
			</div>
		</div>
    </div>
    <script src="//maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script src="/js/user-login.js"></script>
</body>
</html>