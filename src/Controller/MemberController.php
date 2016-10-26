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
        $this->set('authUser', $this->Auth->user());
    }

    public function index(){
    	
    }

    public function deconnexion(){
    	$this->Flash->success('Vous êtes maintenant déconnecté.');
        return $this->redirect($this->Auth->logout()); 
    }

}
?>