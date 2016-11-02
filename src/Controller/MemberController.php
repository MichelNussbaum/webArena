<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\Event\Event;
use Cake\Filesystem\Folder;
use Cake\Filesystem\File;

class MemberController extends AppController
{

	public function beforeFilter(Event $event)
	{
		parent::beforeFilter($event);
		$this->viewBuilder()->layout("member");
		$user = $this->Auth->user();

		$this->set('authUser', $user);
		$this->loadModel('Fighters');
		$this->loadModel('Events');
		$this->loadModel('Guilds');
		$this->loadModel('Messages');
	}

	public function index(){
		$user = $this->Auth->user();
		$fighters = $this->Fighters->findByPlayerId($user["id"]);
		foreach ($fighters as $fighter) {
			$fighter["nbPoints"] = $this->Fighters->findNbPoints($fighter);
			$fighter["avatar"] = $this->Fighters->avatar($fighter->id);
		}
		$this->set('fighters', $fighters);

		if ($this->request->is('post'))
		{
			if ($this->request->data['type'] == 'addfighters')
			{
				$value = $this->Fighters->insert($this->request->data,$user);
				if ($value)
				{
					$this->Events->insert("Entrée de ".$value["name"],$value["coordinate_x"],$value["coordinate_y"]);
					$this->Flash->success(__("Le combattant a été ajouté."));
					return $this->redirect(['action' => 'index']);
				}
				else
				{
					$this->Flash->error(__("Impossible d'ajouter le combattant. Le champ \"name\" est vide."));
				}
			}
			elseif ($this->request->data['type'] == 'ModifierFighter')
			{
				$oldFighter = $this->Fighters->findById($this->request->data["id"]);
				$value = $this->Fighters->modifer($this->request->data);
				if ($value)
				{
					$this->Events->insert($oldFighter->name." devient ".$value->name,$value["coordinate_x"],$value["coordinate_y"]);
					$this->Flash->success(__("Le combattant a été modifié."));
					return $this->redirect(['action' => 'index']);
				}
				else
				{
					$this->Flash->error(__("Impossible d'modifer le combattant. Le champ \"name\" est vide."));
				}
			}
			elseif ($this->request->data['type'] == 'DeleteFighter')
			{
				$id = $this->request->data['id'];
				$oldFighter = $this->Fighters->findById($id);
				if ($this->Fighters->supprime($id))
				{
					$this->Events->insert("Suppression du combattant ".$oldFighter->name,$oldFighter->coordinate_x,$oldFighter->coordinate_y);
					$this->Flash->success(__("Le combattant {0} a été supprimé.",$oldFighter->name));
					return $this->redirect(['action' => 'index']);
				}
				else {
					$this->Flash->error(__("Impossible de supprimer le combattant."));
				}
			}
			elseif ($this->request->data['type'] == 'ajoutCompetence'){
				$this->Fighters->augmenterCompetences($this->request->data);
				return $this->redirect(['action' => 'index']);
			}
		}
	}

	public function deconnexion(){
		return $this->redirect($this->Auth->logout());
	}

	public function guild(){
		if($this->request->is('post')){
			if($this->request->data['action'] == 'guilde'){
				$this->set("guilds",$this->Guilds->findAllGuild());
				$this->set("fighter",$this->Fighters->findById($this->request->data['id']));
			}elseif ($this->request->data['action'] == 'rejoindre') {
				$this->Fighters->joinAGuild($this->request->data);
				$this->set("guilds",$this->Guilds->findAllGuild());
				$this->set("fighter",$this->Fighters->findById($this->request->data['idFighter']));
			}elseif ($this->request->data['action'] == 'creer') {
				$message = $this->Guilds->insert($this->request->data);
				$this->set("guilds",$this->Guilds->findAllGuild());
				$this->set("fighter",$this->Fighters->findById($this->request->data['idFighter']));
				$this->Flash->success(__($message));
			}
		}

	}
	public function arena($id){
		$user = $this->Auth->user();
		$safety = $this->Fighters->checksafety($id,$user);
		if ($safety)
		{
			if (!$this->Fighters->iamdead($id)) {
				$fighter = $this->Fighters->findById($id);
				$fighter["nbPoints"] = $this->Fighters->findNbPoints($fighter);
				$this->set('fighterNbPoints', $fighter["nbPoints"]);
				if($this->request->is('post')){
					$action = $this->request->data["action"];
					switch ($action) {
						case 'monter':
						$message = $this->Fighters->moove($id,"monter");
						if(!empty($message)){
							$this->Flash->error(__($message));
						}
						break;

						case 'descendre':
						$message = $this->Fighters->moove($id,"descendre");
						if(!empty($message)){
							$this->Flash->error(__($message));
						}
						break;

						case 'gauche':
						$message = $this->Fighters->moove($id,"gauche");
						if(!empty($message)){
							$this->Flash->error(__($message));
						}
						break;

						case 'droite':
						$message = $this->Fighters->moove($id,"droite");
						if(!empty($message)){
							$this->Flash->error(__($message));
						}
						break;

						case 'attaquer':
						$idP = $this->request->data["idP"];
						$idE = $this->request->data["idE"];
						$message = $this->Fighters->attaquer($idP,$idE);
						$this->Flash->default(__($message));
						break;

						case 'crier':
						$fighter = $this->Fighters->findById($this->request->data["id"]);
						$message = $this->request->data["message"];
						$res = $this->Events->insert($message,$fighter->coordinate_x,$fighter->coordinate_y);
						if($res){
							$this->Flash->success(__("Vous criez : ".$message));
						}
						break;

						case 'monterdeniveau':
						$this->Fighters->augmenterCompetences($this->request->data);
						return $this->redirect(['action' => 'arena',$this->request->data['id']]);
						break;
					}
				}
				$fighter = $this->Fighters->findById($id);
				$fighter["avatar"] = $this->Fighters->avatar($id);
				$this->set("fighter",$fighter);
				$fighterGuilde = $this->Guilds->findById($fighter->guild_id);
				$this->set("fighterGuilde",$fighterGuilde);
				$this->set("enemies",$this->Fighters->findEnemies($id));
			}
			else {
				return $this->redirect(['action' => 'index']);
			}
		}
		else {
			return $this->redirect(['action' => 'index']);
		}
	}

	public function chat($idFighter){
		$user = $this->Auth->user();
		$safety = $this->Fighters->checksafety($idFighter,$user);
		if ($safety)
		{
			$user = $this->Auth->user();
			$enemies = $this->Fighters->findAllFighterNotOwn($user['id']);
			$this->set("enemies",$enemies);
			$this->set("fighterCo",$this->Fighters->findById($idFighter));
			$fighters = $this->Messages->findDistinctConversationByFighterId($idFighter);
			$this->set("fighters",$fighters);
			if($this->request->is('post')){
				$this->Messages->insert($this->request->data);
				return $this->redirect(['action' => 'chat',$idFighter]);
			}
		}else {
			return $this->redirect(['action' => 'index']);
		}
	}

	public function evenements(){
		$events = $this->Events->findLastDay();
		$this->set("events",$events);
	}
}
?>
