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
        $this->set('authUser', $this->Auth->user());
        $this->loadModel('Fighters');
    }

    public function index(){
    	
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

    public function arena($id,$action){
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
        $fighter = $this->Fighters->findById($id);
        $this->set("fighter",$fighter);
        $this->set("enemies",array());
    }

    public function gauche($player){
        

    }

    public function droite($player){

    }

    public function monter($id){
        //$this->Fighters->monter($this->sd);
        return $this->redirect(['action' => 'arena']);
    }

    public function descendre($player){
        
    }
}
?>