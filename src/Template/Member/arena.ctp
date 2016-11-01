<?php echo $this->Html->css('damier');?>
<?php $this->assign('title', 'Arène');?>
	<div class="row">
		<div class="col-xs-1">
			<?= $this->Html->link('Evenements', array('action' => 'evenements'), array('class' => 'btn btn-success'));?>
		</div>
	  	<div class="col-xs-1 col-xs-offset-4">
			<?= $this->Form->create();?>
			<?= $this->Form->hidden('action',["value"=>"monter"]);?>
			<?= $this->Form->button(__('<span class="glyphicon glyphicon-arrow-up" aria-hidden="true"></span>'),array('class' => 'btn btn-default'));?>
		  	<?= $this->Form->end();?>
	  	</div>
	  	<div class="col-xs-1 col-xs-offset-5">
		  	<?= $this->Form->create();?>
			<?= $this->Form->hidden('action',["value"=>"hurler"]);?>
			<?= $this->Form->button(__('Hurler'),array('class' => 'btn btn-warning'));?>
		  	<?= $this->Form->end();?>
		</div>
  	</div>
  	<div class="row">
			<div class="col-xs-1">
				<button type="button" class="btn btn-warning" data-toggle="modal" data-target="#Boutique">Passer de niveau</button>
			</div>
  		<div class="col-xs-1 col-xs-offset-3">
		  	<?= $this->Form->create();?>
			<?= $this->Form->hidden('action',["value"=>"gauche"]);?>
			<?= $this->Form->button(__('<span class="glyphicon glyphicon-arrow-left" aria-hidden="true"></span>'),array('class' => 'btn btn-default'));?>
		  	<?= $this->Form->end();?>
			</div>
			<div class="col-xs-1 col-xs-offset-1">
		  	<?= $this->Form->create();?>
				<?= $this->Form->hidden('action',["value"=>"droite"]);?>
				<?= $this->Form->button(__('<span class="glyphicon glyphicon-arrow-right" aria-hidden="true"></span>'),array('class' => 'btn btn-default'));?>
		  	<?= $this->Form->end();?>
			</div>
			<div class="col-xs-1 col-xs-offset-4">
				<?= $this->Html->link('Communiquer', array('action' => 'chat',$fighter->id), array('class' => 'btn btn-success'));?>
			</div>
  	</div>
  	<div class="row">
  		<div class="col-xs-1 col-xs-offset-5">
		  	<?= $this->Form->create();?>
			<?= $this->Form->hidden('action',["value"=>"descendre"]);?>
			<?= $this->Form->button(__('<span class="glyphicon glyphicon-arrow-down" aria-hidden="true"></span>'),array('class' => 'btn btn-default'));?>
		  	<?= $this->Form->end();?>
		</div>
  	</div>
	<div>
	<?php
	for ($i=0; $i < 10; $i++) {?>
		<div class="ligne">
		<?php for ($j=0; $j < 15; $j++) {
			$array = ['alt' => 'warrior',"class"=>"img-responsive","data-toggle"=>"popover","data-trigger"=>"click"];
			if($fighter->coordinate_x-1 == $j && $fighter->coordinate_y-1 == $i){
				if(!empty($fighterGuilde)){
					$guildName = $fighterGuilde->name;
				}
				else{
					$guildName = "";
				}
				$array["title"] = $fighter->name;
				$array["data-content"] = '<ul class="list-unstyled">
				<li>LVL : '.$fighter->level.'</li>
				<li>XP : <progress value="'.$fighter->xp%4 .'" max="4"></progress></li>
				<li>♥️ : '.$fighter->current_health.'/'.$fighter->skill_health.'</li>
				<li>💪 : '.$fighter->skill_strength.'</li>
				<li>👀 : '.$fighter->skill_sight.'</li>
				<li>❇ X: '.$fighter->coordinate_x.'</li>
				<li>❇ Y: '.$fighter->coordinate_y.'</li>
				<li>guild : '.$guildName.'</li>';
				?><div class="cell">
				<?php if($fighter->avatar){
					echo $this->Html->image('Avatars/'.$fighter['id'].'.jpg', $array);
				}else{
					echo $this->Html->image('Avatars/warrior.png', $array);
				}?>
				</div><?php
			}else{
				$trouve = false;
				foreach ($enemies as $enemy) {
					if($enemy["coordinate_x"]-1 == $j && $enemy["coordinate_y"]-1 == $i){
						$array["title"] = $enemy["name"];
						$array["data-content"] = '<ul class="list-unstyled">
						<li>LVL : '.$enemy["level"].'</li>
						<li>XP : <progress value="'.$enemy["xp"]%4 .'" max="4"></progress></li>
						<li>♥️ : '.$enemy["current_health"].'/'.$enemy["skill_health"].'</li>
						<li>💪 : '.$enemy["skill_strength"].'</li>
						<li>👀 : '.$enemy["skill_sight"].'</li>
						<li>❇ X: '.$enemy["coordinate_x"].'</li>
						<li>❇ Y: '.$enemy["coordinate_y"].'</li>
						<li>guild : '.$enemy["guild_name"].'</li>';
						if( ($enemy["player_id"] != $fighter["player_id"]) && (($enemy["coordinate_x"] == $fighter["coordinate_x"] && ($enemy["coordinate_y"] == $fighter["coordinate_y"]-1 || $enemy["coordinate_y"] == $fighter["coordinate_y"]+1)) || ($enemy["coordinate_y"] == $fighter["coordinate_y"] && ($enemy["coordinate_x"] == $fighter["coordinate_x"]-1 || $enemy["coordinate_x"] == $fighter["coordinate_x"]+1)))){
							$array["data-content"].='<li>'.$this->Form->create().
							$this->Form->hidden('action',['value' => 'attaquer']).
							$this->Form->hidden('idP',['value' => $fighter->id]).
							$this->Form->hidden('idE',['value' => $enemy->id]).
							$this->Form->button(__('Attaquer'),['class'=>'btn btn-default']).
							$this->Form->end().'</li>';
						}
						if($enemy["player_id"] == $fighter["player_id"]) {
							?><div class="cell">
								<?php if($enemy['avatar']){
									echo $this->Html->image('Avatars/'.$enemy['id'].'.jpg', $array);
								}else{
									echo $this->Html->image('Avatars/warrior.png', $array);
								}?>
							</div><?php
						}
						else {
							?><div class="cell">
								<?php if($enemy->avatar){
									echo $this->Html->image('Avatars/'.$enemy['id'].'.jpg', $array);
								}else{
									echo $this->Html->image('Avatars/enemy.jpg', $array);
								}?>
							</div><?php
						}
						$trouve = true;
					}
				}
				if(!$trouve){?><div class="cell"></div><?php }
			}
		}?>
		</div>
	<?php }?>
	</div>
	<script type="text/javascript">$(".img-responsive").popover({ html : true });
	$('.cell').height($('.cell').width());
	$( window ).resize(function() {
	  $('.cell').height($('.cell').width());
	});</script>

	<!-- Boutique -->
	<div class="modal fade" id="Boutique" tabindex="-1" role="dialog" aria-labelledby="Boutique">
		<div class="modal-dialog" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
					<h4 class="modal-title" id="Boutique">Passer de niveau</h4>
				</div>
				<div class="modal-body">
					<?php if($fighterNbPoints>0){ ?>
					<p>Vous avez <?= $fighterNbPoints?> points à ajouter</p>
					<table class="table">
					<?php
						$arrayligne = array();
						$vue = $this->Form->create();
						$vue.=$this->Form->hidden('action',["value"=>"monterdeniveau"]);
						$vue.= $this->Form->hidden('type',['value' => 'ajoutCompetence']);
						$vue.= $this->Form->hidden('skill',['value' => 'vue']);
						$vue.= $this->Form->hidden('id',['value' =>  $fighter->id]);
						$vue.= $this->Form->button(__('Augmenter'),['class'=>'btn btn-primary']);
						$vue.=$this->Form->end();
						$arrayligne["vue"] = $vue;
						$force = $this->Form->create();
						$force.=$this->Form->hidden('action',["value"=>"monterdeniveau"]);
						$force.= $this->Form->hidden('type',['value' => 'ajoutCompetence']);
						$force.= $this->Form->hidden('skill',['value' => 'force']);
						$force.= $this->Form->hidden('id',['value' =>  $fighter->id]);
						$force.= $this->Form->button(__('Augmenter'),['class'=>'btn btn-primary']);
						$force.=$this->Form->end();
						$arrayligne["force"] = $force;
						$sante = $this->Form->create();
						$sante.= $this->Form->hidden('action',["value"=>"monterdeniveau"]);
						$sante.= $this->Form->hidden('type',['value' => 'ajoutCompetence']);
						$sante.= $this->Form->hidden('skill',['value' => 'sante']);
						$sante.= $this->Form->hidden('id',['value' =>  $fighter->id]);
						$sante.= $this->Form->button(__('Augmenter'),['class'=>'btn btn-primary']);
						$sante.=$this->Form->end();
						$arrayligne["sante"] = $sante;
					?>
						<?= $this->Html->tableHeaders(['Compétence', 'Point actuel', 'Ajouter']);?>
						<?= $this->Html->tableCells([['Vue',$fighter->skill_sight,$arrayligne["vue"]],['Force',$fighter->skill_strength,$arrayligne["force"]],['Santé',$fighter->current_health,$arrayligne["sante"]]]);?>
					</table>
					<?php }else{?>
						<p>Vous n'avez pas de points de compétences disponibles</p>
					<?php }?>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
				</div>
			</div>
		</div>
	</div>
