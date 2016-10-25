<<?php
namespace App\Model\Table;

use Cake\ORM\Table;

class PlayersTable extends Table {

  public function insert($player)
  {
    $player['id'] = Text::uuid();
    $Value = $this->save($player);
    return $Value;
  }
}
?>

<!--
public function add()
{
    $player = $this->Players->newEntity();
    if ($this->request->is('post')) {
        $player = $this->Players->patchEntity($player, $this->request->data);
        $player['id'] = Text::uuid();
        if ($this->Players->save($player)) {
            $this->Flash->success(__("Le joueur a été sauvegardé."));

            $player = $this->Auth->identify();

            $this->Auth->setUser($player);
            $this->Flash->success(__("Connexion réussi."));
            //return $this->redirect($this->Auth->redirectUrl());
            return $this->redirect(['controller'=>'fighters','action' => 'index']);
        }
        $this->Flash->error(__("Impossible d'ajouter le joueur."));
    }
    $this->set('player', $player);
}
-->
