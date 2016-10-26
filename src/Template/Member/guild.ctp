<div class="containerGuild">

	<!-- Si joueur n'a pas de guilde dans BD -->
	<p> Vous n'appartenez pas à une guilde ! </p>

	<?= $this->Html->link('RejoindreUneGuilde', array('action' => 'rejoindreGuilde'), array('class' => 'btn btn-primary btn-lg'));?>
	<?= $this->Html->link('CréerUneGuilde', array('action' => 'creerGuilde'), array('class' => 'btn btn-primary btn-lg'));?>

	<p>---------------------------------------------------------------</p>
	<!-- Si le joueur appartient à une guilde dans BD -->

	<p> Nom de la guilde </p>

	<button class="btn btn-default" type="button"> Infos de la guilde </button>
	<div id="infoGuild">
		Nom : Les bigboss
		Nombre de joueurs : 10
		Niveau guilde : 6
	</div>

</div>