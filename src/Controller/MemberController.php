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
			}

		public function addfighters(){
			$user = $this->Auth->user();
      $fighter = $this->Fighters->newEntity();
      if ($this->request->is('post'))
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
