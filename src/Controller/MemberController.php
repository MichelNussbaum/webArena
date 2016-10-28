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
					$this->Flash->success(__("Le combattant a été ajouté."));
					return $this->redirect(['action' => 'index']);
				}
				else
				{
					$this->Flash->error(__("Impossible d'ajouter le combattant."));
				}
			}
			elseif ($this->request->data['type'] == 'ModifierFighter')
		 	{
				$fighter = $this->Fighters->patchEntity($fighter, $this->request->data);
			}
			elseif ($this->request->data['type'] == 'DeleteFighter')
		 	{
				$id = $this->request->data['id'];
				if ($this->Fighters->supprime($id)) {
					$this->Flash->success(__("Le combattant {0} a été supprimé.", ($fighter->name)));
					return $this->redirect(['action' => 'index']);
		    	}
		    	$this->Flash->error(__("Impossible de supprimer le combattant."));
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

    public function attaquer($idP, $idE){
        //$event->date = date('Y-m-d H:i:s');
        $this->Fighters->attaquer($idP,$idE);
        return $this->redirect(['action' => 'arena',$idP]);
    }
}
?>
