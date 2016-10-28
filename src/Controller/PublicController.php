<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\Event\Event;

class PublicController extends AppController
{

	public function beforeFilter(Event $event)
	{
		parent::beforeFilter($event);
		$this->Auth->allow(['inscription', 'logout','forgetPassword','connexion']);				// n'exige pas une authentification à ces pages
		$this->verifyConnect();
		$this->loadModel('Players');																											// Vérifie s’il y a un utilisateur connecter et si oui, il le redirige vers sa page.
	}

	public function inscription()
	{
		if ($this->request->is('post'))
		{
			$value = $this->Players->insert($this->request->data);
			if ($value) {
				$this->Flash->success(__("Le joueur a été sauvegardé."));

				$player = $this->Auth->identify();
				$this->Auth->setUser($player);
				$this->Flash->success(__("Connexion réussi."));
				return $this->redirect($this->Auth->redirectUrl());

			}
			else
			{
				$this->Flash->error(__("Impossible d'ajouter le joueur."));
			}
		}
		//$this->set('player',$value);
	}

	public function connexion()
	{
		if ($this->request->is('post')) {
			$player = $this->Auth->identify();
			if ($player) {
				$this->Auth->setUser($player);
				$this->Flash->success(__("Connexion réussi."));
				return $this->redirect($this->Auth->redirectUrl());
			}
			else {
				$this->Flash->error(__('Invalid player or password, try again'));
			}
		}
	}

	public function forgetPassword(){
		if ($this->request->is('post')) {
			$playerFind = $this->Players->findByEmail($this->request->data);
			$this->Players->resetPassword($playerFind);
		}
		$this->set('player', $player);
	}

	public function verifyConnect(){
		if($this->Auth->user()){
			return $this->redirect(['controller'=>'Member','action' => 'index']);
		}
	}
}
