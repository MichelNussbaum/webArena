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

    public function attaquer($idP, $idE){
        //$event->date = date('Y-m-d H:i:s');
        $enemy = $this->Fighters->findById($idE);
        $player = $this->Fighters->findById($idP);
        $rand = rand(1,20);
        $seuil = 10+$player->level-$enemy->level;
        $this->log("rand : ".$rand);
        $this->log("seuil : ".$seuil);
        if($rand > $seuil){
            $this->log("j'attaque : ");
            if ($this->Fighters->updateVie($enemy,$enemy->skill_health - $player->skill_strength)) {
                $this->Flash->success(__("Attaque réussi"));
                $xp = $player->xp++;
                if($enemy->skill_health <= 0){
                    $xp = $player->xp + $enemy->level;
                    $this->Fighters->supprime($enemy);
                    //ajout de l'évenement de tue
                    $this->Flash->success(__("tué"));
                    //$event->name = $player->name.' attaque '.$enemy->name.' et le tue';
                }else{
                    //ajout de l'evenement de touche
                    $this->Flash->success(__("touché"));
                    //$event->name = $player->name.' attaque '.$enemy->name.' et le touche';
                }
                $this->Fighters->updateXp($player,$xp);
            }else{
                $this->Flash->error(__("Erreur lors de l'attaque"));
            }
        }else{
            $this->Flash->success(__("Attaque râté"));
            //ajoute de l'évenement de râte
            //$event->name = $player->name.' attaque '.$enemy->name.' et le râte';
        }
        //$eventsTable->save($event);
        return $this->redirect(['action' => 'arena',$idP]);
    }
}
?>
