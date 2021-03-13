<?php
$_OPT['title'] =  $data['pages']['title']." - ".$_OPT['sub-title'];
?>
<script>
top_menu('page_<?=$data['pages']['id'];?>');
</script>
	<div class="container">
		<div class=" panel panel-default panel-body center-block">
			<?=$data['pages']['text'];?>
			
		</div>
	</div>