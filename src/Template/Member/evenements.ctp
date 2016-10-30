<table class="table table-bordered" id="example">
	<thead>
  	<?= $this->Html->tableHeaders(['Name', 'Date', 'posX','posY']);?>
  	</thead>
  	<tbody>
	<?php foreach ($events as $event) { ?>
		<?= $this->Html->tableCells([[$event->name, $event->date, $event->coordinate_x,$event->coordinate_y]]);?>
	<?php } ?>
	</tbody>
</table>
<script type="text/javascript">
$(document).ready(function() {
    $('#example').DataTable();
} );
</script>