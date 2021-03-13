<nav class="navbar navbar-default">
  <div class="container-fluid">
    <!-- Brand and toggle get grouped for better mobile display -->
    <div class="navbar-header">
      <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
        <span class="sr-only">Toggle navigation</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </button>
      <a class="navbar-brand" href="#"><?=$_OPT['sub-title'];?></a>
    </div>

    <!-- Collect the nav links, forms, and other content for toggling -->
    <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
      <ul class="nav navbar-nav">
        <li id="index"><a href="/">Главная страница</a></li>
        <li id="news"><a href="/news">Вестник Эриандора</a></li>
		<?php
		$db->Query("SELECT * FROM `pages`");
		if($db->NumRows() > 0){
			$pages_links = $db->FetchAll();
			foreach ($pages_links as $links){
				if(isset($links['id'])){
					echo "<li id=\"page_".$links['id']."\"><a href=\"/pages?id=".$links['id']."\">".$links['title']."</a></li>";
				}
			}
		}
		?>
      </ul>
      <ul class="nav navbar-nav navbar-right">
		<?php
		if(isset($_SESSION['u_id'])){
			if($_SESSION['lvl_admin'] >= 10){
		?>
		<li id="admin"><a href="/admin">Админ-панель</a></li>
		<?php
			}
		?>
		<li id="account"><a href="/account">Личный кабинет</a></li>
		<li id="exit"><a href="/exit">Выход</a></li>
		<?php			
		}else{
		?>
        <li id="login"><a href="/login">Вход</a></li>
        <li id="reg"><a href="/reg">Регистрация</a></li>		
		<?php
		}
		?>
      </ul>
    </div><!-- /.navbar-collapse -->
  </div><!-- /.container-fluid -->
</nav>