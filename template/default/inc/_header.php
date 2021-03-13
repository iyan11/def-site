<!DOCTYPE html>
<html lang="ru">
	<head>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<title>{!TITLE!}</title>
		<!-- Bootstrap -->
		<link rel="stylesheet" href="//netdna.bootstrapcdn.com/bootstrap/3.3.2/css/bootstrap.min.css">
		<link rel="stylesheet" href="//netdna.bootstrapcdn.com/bootstrap/3.3.2/css/bootstrap-theme.min.css">
		
		<link href="/template/<?=$_OPT['style']?>/css/font-awesome.min.css" rel="stylesheet">
		<script src="/template/<?=$_OPT['style']?>/js/top_menu.js"></script>
		<script src="https://code.jquery.com/jquery.js"></script>
		<!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
		<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
		<!--[if lt IE 9]>
			<script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
			<script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
		<![endif]-->
		<link rel="stylesheet" href="/template/<?=$_OPT['style']?>/css/style.css">
		<link rel="icon" href="favicon.ico" type="image/x-icon"> 
	</head>
	<body>
		<header>
			<div class="container">
				<?php require_once "template/".$_OPT['style']."/inc/top_menu.php";?>
			</div>
		</header>
