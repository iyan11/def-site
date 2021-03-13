<?php
$_OPT['title'] =  "Вход - ".$_OPT['sub-title'];
?>
<script src="https://www.google.com/recaptcha/api.js" async defer></script>
<script>
top_menu('login');
function onSubmit(token) {
	document.getElementById("reg-form").submit();
}
</script>
<style>
.form-signin {
  max-width: 330px;
  padding: 15px;
  margin: 0 auto;
}
.form-signin .form-signin-heading,
.form-signin .checkbox {
  margin-bottom: 10px;
}
.form-signin .checkbox {
  font-weight: normal;
}
.form-signin .form-control {
  position: relative;
  font-size: 16px;
  height: auto;
  padding: 10px;
  -webkit-box-sizing: border-box;
     -moz-box-sizing: border-box;
          box-sizing: border-box;
}
.form-signin .form-control:focus {
  z-index: 2;
}
.form-signin input[type="text"] {
  margin-bottom: -1px;
  border-bottom-left-radius: 0;
  border-bottom-right-radius: 0;
}
.form-signin input[type="password"] {
  margin-bottom: 10px;
  border-top-left-radius: 0;
  border-top-right-radius: 0;
}
</style>
<div class="container">
<?php
	if(isset($data['err'])){
		switch($data['err']){
			case '1':
				?>
				<div class="alert alert-danger">Введите корректный логин или пароль<a class="close" data-dismiss="alert" href="#" aria-hidden="true">&times;</a></div>
				<?php
				break;
			case '2':
				?>
				<div class="alert alert-danger">Логин или пароль не верны<a class="close" data-dismiss="alert" href="#" aria-hidden="true">&times;</a></div>
				<?php
				break;
		}
	}
?>
<form class="form-signin" id="reg-form" role="form" method="POST" action="/login">
<h2 class="form-signin-heading">Пожалуйста, войдите</h2>
<input type="text" name="login" class="form-control" placeholder="Логин" required autofocus>
<input type="password" name="password" class="form-control" placeholder="Пароль" required>
<div class="g-recaptcha"
      data-sitekey="6Ld2llMaAAAAAAxq2av4fQAl3rdKSzSkT-KcCX95"
      data-callback="onSubmit"
      data-size="invisible">
</div>
<button class="btn btn-lg btn-primary btn-block g-recaptcha" type="submit" data-sitekey="6Ld2llMaAAAAAAxq2av4fQAl3rdKSzSkT-KcCX95" data-callback='onSubmit'>Вход</button>
</form>
</div> 