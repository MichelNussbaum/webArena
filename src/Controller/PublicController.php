<?php
namespace App\Controller;

use App\Controller\AppController;

class PublicController extends AppController
{
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
}
