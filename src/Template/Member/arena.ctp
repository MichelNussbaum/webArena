<?php echo $this->Html->css('damier');?>
	<?= $this->Html->link('Monter', array('action' => 'monter',$fighter->id), array('class' => 'btn btn-default'))?>
	<?= $this->Html->link('Descendre', array('action' => 'descendre',$fighter->id), array('class' => 'btn btn-default'))?>
	<?= $this->Html->link('Gauche', array('action' => 'gauche',$fighter->id), array('class' => 'btn btn-default'))?>
	<?= $this->Html->link('Droite', array('action' => 'droite',$fighter->id), array('class' => 'btn btn-default'))?>
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
				<li>♥️ : '.$fighter->skill_health.'</li>
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
						<li>♥️ : '.$enemy["skill_health"].'</li>
						<li>💪 : '.$enemy["skill_strength"].'</li>
						<li>👀 : '.$enemy["skill_sight"].'</li>
						<li>❇ X: '.$enemy["coordinate_x"].'</li>
						<li>❇ Y: '.$enemy["coordinate_y"].'</li>
						<li>guild : '.$enemy["guild_id"].'</li>
						<li>'.$this->Html->link('Attaquer', array('controller' => 'Visions', 'action' => 'attaquer',$player->id,$enemy["id"]), array('class' => 'btn btn-default')).'</li>';
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