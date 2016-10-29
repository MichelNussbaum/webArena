<?php echo $this->Html->css('damier');?>
	<?= $this->Form->create();?>
	<?= $this->Form->hidden('action',["value"=>"monter"]);?>
	<?= $this->Form->button(__('Monter'),array('class' => 'btn btn-default'));?>
  	<?= $this->Form->end();?>
  	<?= $this->Form->create();?>
	<?= $this->Form->hidden('action',["value"=>"descendre"]);?>
	<?= $this->Form->button(__('Descendre'),array('class' => 'btn btn-default'));?>
  	<?= $this->Form->end();?>
  	<?= $this->Form->create();?>
	<?= $this->Form->hidden('action',["value"=>"gauche"]);?>
	<?= $this->Form->button(__('Gauche'),array('class' => 'btn btn-default'));?>
  	<?= $this->Form->end();?>
  	<?= $this->Form->create();?>
	<?= $this->Form->hidden('action',["value"=>"droite"]);?>
	<?= $this->Form->button(__('Droite'),array('class' => 'btn btn-default'));?>
  	<?= $this->Form->end();?>
	<?php 
	for ($i=0; $i < 10; $i++) {?>
		<div>
		<?php for ($j=0; $j < 15; $j++) {
			$array = ['alt' => 'warrior',"class"=>"contentDamier","data-toggle"=>"popover","data-trigger"=>"click"];
			if($fighter->coordinate_x-1 == $j && $fighter->coordinate_y-1 == $i){
				$array["title"] = $fighter->name;
				$array["data-content"] = '<ul class="list-unstyled">
				<li>LVL : '.$fighter->level.'</li>
				<li>XP : <progress value="'.$fighter->xp%4 .'" max="4"></progress></li>
				<li>♥️ : '.$fighter->current_health.'</li>
				<li>💪 : '.$fighter->skill_strength.'</li>
				<li>👀 : '.$fighter->skill_sight.'</li>
				<li>❇ X: '.$fighter->coordinate_x.'</li>
				<li>❇ Y: '.$fighter->coordinate_y.'</li>
				<li>guild : '.$fighter->guild_id.'</li>';
				?><div class="cell"><?=$this->Html->image('warrior.png', $array)?></div><?php
			}else{
				$trouve = false;
				foreach ($enemies as $enemy) {
					if($enemy["coordinate_x"]-1 == $j && $enemy["coordinate_y"]-1 == $i){
						$array["title"] = $enemy["name"];
						$array["data-content"] = '<ul class="list-unstyled">
						<li>LVL : '.$enemy["level"].'</li>
						<li>XP : <progress value="'.$enemy["xp"]%4 .'" max="4"></progress></li>
						<li>♥️ : '.$enemy["current_health"].'</li>
						<li>💪 : '.$enemy["skill_strength"].'</li>
						<li>👀 : '.$enemy["skill_sight"].'</li>
						<li>❇ X: '.$enemy["coordinate_x"].'</li>
						<li>❇ Y: '.$enemy["coordinate_y"].'</li>
						<li>guild : '.$enemy["guild_id"].'</li>';
						if(($enemy["coordinate_x"] == $fighter["coordinate_x"] && ($enemy["coordinate_y"] == $fighter["coordinate_y"]-1 || $enemy["coordinate_y"] == $fighter["coordinate_y"]+1)) || ($enemy["coordinate_y"] == $fighter["coordinate_y"] && ($enemy["coordinate_x"] == $fighter["coordinate_x"]-1 || $enemy["coordinate_x"] == $fighter["coordinate_x"]+1))){
							$array["data-content"].='<li>'.$this->Form->create().
							$this->Form->hidden('action',['value' => 'attaquer']).
							$this->Form->hidden('idP',['value' => $fighter->id]).
							$this->Form->hidden('idE',['value' => $enemy->id]).
							$this->Form->button(__('Attaquer'),['class'=>'btn btn-default']).
							$this->Form->end().'</li>';
						}
						?><div class="cell"><?=$this->Html->image('enemy.jpg', $array)?></div><?php
						$trouve = true;
					}
				}
				if(!$trouve){?><div class="cell"></div><?php }
			}
		}?>
		</div>
	<?php }?>
	<script type="text/javascript">$(".contentDamier").popover({ html : true })</script>