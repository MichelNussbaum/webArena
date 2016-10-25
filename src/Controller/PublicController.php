<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\Event\Event;

class PublicController extends AppController
{

	public function beforeFilter(Event $event)
    {
        parent::beforeFilter($event);
        $this->Auth->allow(['add', 'logout']);
    }

	public function inscription()
    {
      $this->loadModel('Players');
      $player = $this->Players->newEntity();
      if ($this->request->is('post'))
        {
          $player = $this->Players->patchEntity($player, $this->request->data);
					$value = $this->Players->insert($player);
		      if ($value) {
		        $this->Flash->success(__("Le joueur a été sauvegardé."));
		      }
		      else {
		        $this->Flash->error(__("Impossible d'ajouter le joueur."));
		      }
        }
      $this->set('player',$player);
    }

		public function connexion()
		{

			if ($this->request->is('post')) {
				$player = $this->Auth->identify();
				if ($player) {
	          $this->Auth->setUser($player);
	          $this->Flash->success(__("Connexion réussi."));
	          //return $this->redirect($this->Auth->redirectUrl());
	      }
	      else {
	        $this->Flash->error(__('Invalid player or password, try again'));
	      }
			}
		}
}
