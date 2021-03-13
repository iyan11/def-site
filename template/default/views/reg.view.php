<?php
$_OPT['title'] =  "Регистрация - ".$_OPT['sub-title'];
?>
<script src="https://www.google.com/recaptcha/api.js" async defer></script>
<script>
top_menu('reg');
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
  margin-left: 20px;
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
  margin-bottom: 10px;
}
.form-signin input[type="email"] {
  margin-bottom: 10px;
}
.form-signin input[type="password"] {
  margin-bottom: 10px;

}
</style>
<div class="container">
	<?php
	if(isset($data['err'])){
		switch($data['err']){
			case '1':
				?>
				<div class="alert alert-danger">Пожалуйста, примите <a href="/terms">Пользовательское соглашение</a> и <a href="/policy">Политику обработки персональных данных</a> <a class="close" data-dismiss="alert" href="#" aria-hidden="true">&times;</a></div>
				<?php
				break;
			case '2':
				?>
				<div class="alert alert-danger">Вы не ввели Пароль или Повторный пароль, попробуйте ещё раз, пожалуйста!<a class="close" data-dismiss="alert" href="#" aria-hidden="true">&times;</a></div>
				<?php
				break;
				case '3':
				?>
				<div class="alert alert-danger">Пароли не совпадают, попробуйте ещё раз, пожалуйста!<a class="close" data-dismiss="alert" href="#" aria-hidden="true">&times;</a></div>
				<?php
				break;
				case '4':
				?>
				<div class="alert alert-danger">Логин не введён, попробуйте ещё раз, пожалуйста!<a class="close" data-dismiss="alert" href="#" aria-hidden="true">&times;</a></div>
				<?php
				break;
				case '5':
				?>
				<div class="alert alert-danger">Почта не введена, попробуйте ещё раз, пожалуйста!<a class="close" data-dismiss="alert" href="#" aria-hidden="true">&times;</a></div>
				<?php
				break;
		}
	}
	?>
	
<form class="form-signin" role="form" id="reg-form" name="contact-form" method="POST" action="/reg">
<h2 class="form-signin-heading">Пожалуйста, зарегистрируйтесь</h2>
<input type="text" name="login" class="form-control" placeholder="Логин" required autofocus value="<?php if(isset($_POST['login'])) echo $_POST['login'];?>">
<input type="password" name="password" class="form-control" placeholder="Пароль" required>
<input type="password" name="re_password" class="form-control" placeholder="Повторите пароль" required>
<input type="email" name="email" class="form-control" placeholder="Введите E-mail" required value="<?php if(isset($_POST['email'])) echo $_POST['email'];?>">
<label class="checkbox">
<input type="checkbox" name="terms" value="complate" required> Принимаю <a href="/terms">Пользовательское соглашение</a><br>
<input type="checkbox" name="policy" value="complate" required> Принимаю <a href="/policy">Политику обработки персональных данных</a>
</label>
<div class="g-recaptcha"
      data-sitekey="6Ld2llMaAAAAAAxq2av4fQAl3rdKSzSkT-KcCX95"
      data-callback="onSubmit"
      data-size="invisible">
</div>
<button class="btn btn-lg btn-primary btn-block g-recaptcha" type="submit" data-sitekey="6Ld2llMaAAAAAAxq2av4fQAl3rdKSzSkT-KcCX95" data-callback='onSubmit'>Регистрация</button>
</form>
</div> 