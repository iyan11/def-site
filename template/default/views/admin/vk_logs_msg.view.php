<?php
$_OPT['title'] =  "Логи принятых сообщений вконтакте - Админ панель - ".$_OPT['sub-title'];
?>
<div class="row panel panel-default panel-body">
<div class="col-sm-3">
	<?php require_once "template/".$_OPT['style']."/inc/admin_menu.php";?>
</div>
<div class="col-sm-9">
	<script>
		top_menu('admin');
		admin_menu('a_logs_msg_vk');
	</script>
	<?php
	if(isset($data['log_zero'])){
	?>
	<div class="page-header">
		<h1>Логов нет!</h1>
	</div>
	<?php
	}else {
	?>
	<table class="table table-striped table-hover">
		<thead>
			<td>
				Пользователь
			</td>
			<td>
				Сообщение
			</td>
			<td>
				Дата
			</td>
		</thead>
		<?php
		if(isset($data['vk_logs_msg'])){
			foreach($data['vk_logs_msg'] as $logs){
				if(isset($logs['id'])){
					echo "<tr>";
						echo "<td>";
							echo "<a href=\"http://vk.com/id".$logs['froms']."\">id:".$logs['froms']."</a>";
						echo "</td>";
						echo "<td>";
							echo $logs['msg'];
						echo "</td>";
						echo "<td>";
							echo date("j.m.Y", $logs['date'])." г.";
						echo "</td>";
					echo "</tr>";
				}
			}
		}
		?>
	</table>
	<?php
	}
	?>
</div>
</div>