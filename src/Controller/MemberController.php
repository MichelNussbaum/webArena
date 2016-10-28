<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\Event\Event;

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
	}

	public function index(){
		$user = $this->Auth->user();
		$fighters = $this->Fighters->findByPlayerId($user["id"]);
		$this->set('fighters', $fighters);

		$fighter = $this->Fighters->newEntity();
		if ($this->request->is('post'))
		{
			if ($this->request->data['type'] == 'addfighters')
			{
				$fighter = $this->Fighters->patchEntity($fighter, $this->request->data);
				$value = $this->Fighters->insert($fighter,$user);
				if ($value)
				{
					$this->Events->insert("Entrée de ".$value["name"],$value["coordinate_x"],$value["coordinate_y"]);
					$this->Flash->success(__("Le combattant a été ajouté."));
				}
				else
				{
					$this->Flash->error(__("Impossible d'ajouter le combattant. Le champ \"name\" est vide."));
				}
			}
			elseif ($this->request->data['type'] == 'ModifierFighter')
			{
				$fighter = $this->Fighters->patchEntity($fighter, $this->request->data);
				$oldFighter = $this->Fighters->findById($this->request->data["id"]);
				$value = $this->Fighters->modifer($fighter);
				if ($value)
				{
					$this->Events->insert($oldFighter->name." devient ".$value->name,$value["coordinate_x"],$value["coordinate_y"]);
					$this->Flash->success(__("Le combattant a été modifié."));
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
				}
				else {
					$this->Flash->error(__("Impossible de supprimer le combattant."));
				}
			}
		}
	}

	public function deconnexion(){
		$this->Flash->success('Vous êtes maintenant déconnecté.');
		return $this->redirect($this->Auth->logout());
	}

	public function guild(){

	}

	public function creerGuilde(){

	}

	public function rejoindreGuilde(){

	}

	public function arena($id){
		if($this->request->is('post')){
			$action = $this->request->data["action"];
			switch ($action) {
				case 'monter':
				$this->Fighters->moove($id,"monter");
				break;

				case 'descendre':
				$this->Fighters->moove($id,"descendre");
				break;

				case 'gauche':
				$this->Fighters->moove($id,"gauche");
				break;

				case 'droite':
				$this->Fighters->moove($id,"droite");
				break;

				case 'attaquer':
				$idP = $this->request->data["idP"];
				$idE = $this->request->data["idE"];
				$message = $this->Fighters->attaquer($idP,$idE);
				$this->Flash->default(__($message));
				break;

				default:
				# code...
				break;
			}
		}else{

		}
		$fighter = $this->Fighters->findById($id);
		$this->set("fighter",$fighter);
		$this->set("enemies",$this->Fighters->findEnemies($id));
	}
}
?>
