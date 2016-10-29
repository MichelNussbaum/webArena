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
        $this->loadModel('Guilds');
	}

	public function index(){
		$user = $this->Auth->user();
		$fighters = $this->Fighters->findByPlayerId($user["id"]);
		foreach ($fighters as $fighter) {
			$fighter["nbPoints"] = $this->Fighters->findNbPoints($fighter);
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
			}
		}
	}

    public function deconnexion(){
    	$this->Flash->success('Vous êtes maintenant déconnecté.');
        return $this->redirect($this->Auth->logout());
    }

    public function guild($id){
        $this->set('idFighter',$id);
    }

    public function creerGuilde(){
        $guild = $this->Guilds->newEntity();
        if($this->request->is('post')){

            $guild = $this->Guilds->patchEntity($guild, $this->request->data);
            $value = $this->Guilds->insert($guild);
            if($value == null){
                $this->set("failInsertGuild",$value);
            }

        }

    }

    public function rejoindreGuilde($idFighter){
            $value = $this->Guilds->findAllGuild();
            $this->set("allGuild",$value);
            if($this->request->is('post')){
                $value = $this->Fighters->joinAGuild($this->request->data,$idFighter);
            }
    }

	public function arena($id){
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
			}
		}else{

		}
		$fighter = $this->Fighters->findById($id);
		$this->set("fighter",$fighter);
		$this->set("enemies",$this->Fighters->findEnemies($id));
	}
}
?>
