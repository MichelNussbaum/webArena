<?php $this->assign('title', 'Évenements');?>
<table class="table table-bordered" id="evenements">
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
    $('#evenements').DataTable({
      "order": [[ 1, "desc" ]]
    });
  } );
</script>