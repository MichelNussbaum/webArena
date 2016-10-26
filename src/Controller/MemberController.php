<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\Event\Event;

class MemberController extends AppController
{

	public function beforeFilter(Event $event)
    {
        parent::beforeFilter($event);
        //$this->Auth->allow(['index']);
        $this->viewBuilder()->layout("member");
				$user = $this->Auth->user();
        $this->set('authUser', $user);
    }

    public function index(){

    }

		public function addfighters(){
			$user = $this->Auth->user();
			$this->loadModel('Fighters');
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

}
?>
