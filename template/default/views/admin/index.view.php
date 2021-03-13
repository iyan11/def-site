<?php
$_OPT['title'] =  "Админ панель - ".$_OPT['sub-title'];
?>
<div class="row panel panel-default panel-body">
<div class="col-sm-3">
	<?php require_once "template/".$_OPT['style']."/inc/admin_menu.php";?>
</div>
<div class="col-sm-9">
	<script>
		top_menu('admin');
		admin_menu('a_index');
	</script>
</div>
</div>