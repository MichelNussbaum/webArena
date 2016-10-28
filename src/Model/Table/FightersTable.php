<?php
namespace App\Model\Table;

use Cake\ORM\Table;
use Cake\ORM\TableRegistry;

class FightersTable extends Table
{
  function findById($id)
  {
    return $this->get($id);
  }

  function findByPlayerId($player_id)
  {
    $query = $this->find("all")
    ->where(['Fighters.player_id =' => $player_id]);

    return $query;
  }

  function insert($data,$user)
  {
    $fighter = $this->patchEntity($this->newEntity(), $data);
    if (!empty($fighter['name']))
    {
      $fighter['player_id'] = $user['id'];
      $fighter['level'] = 1;
      $fighter['skill_strength'] = 1;
      $fighter['skill_sight'] = 2;
      $fighter['skill_health'] = 3;
      $fighter['current_health'] = 3;
      $fighter['xp'] = 0;
      // génération aléatoires des coordonnées avec vérification qu'il n'y est pas d'autre combattant sur la case
      $fighters = TableRegistry::get('Fighters');
      $boolean = FALSE;
      while (!$boolean)
      {
        $x = rand (1, 15);
        $y = rand (1, 10);
        $query = $fighters->find();
        $query->select(['count' => $query->func()->count('*')]);
        $query->where(['coordinate_x' => $x,'coordinate_y'=>$y]);

        foreach ($query as $f)
        {
          if ($f->count == 0)
          {
            $boolean = TRUE;
          }
        }
      }
      $fighter['coordinate_x'] = $x;
      $fighter['coordinate_y'] = $y;
      $Value = $this->save($fighter);
      return $Value;
    }
    return FALSE;
  }

  function moove($id,$action){
    $fighter = $this->get($id);
    switch($action){
      case 'monter':
      if($fighter["coordinate_y"] -1 != 0){
        $fighter["coordinate_y"] = $fighter["coordinate_y"]-1;
      }else{
        print_r("vous ne pouvez pas monter");
      }

      break;
      case 'descendre':
      if($fighter["coordinate_y"]+1 != 11){
        $fighter["coordinate_y"] = $fighter["coordinate_y"]+1;
      }else{
        print_r("vous ne pouvez pas descendre");
      }
      break;
      case 'gauche':
      if($fighter["coordinate_x"]-1 != 0){
        $fighter["coordinate_x"] = $fighter["coordinate_x"]-1;
      }else{
        print_r("vous ne pouvez pas aller à gauche");
      }

      break;
      case 'droite':
      if($fighter["coordinate_x"]+1 != 16){
        $fighter["coordinate_x"] = $fighter["coordinate_x"]+1;
      }else{
        print_r("vous ne pouvez pas aller a droite");
      }

      break;

    }
    if($this->save($fighter)){
    }
  }

  function findEnemies($id){
    $fighter = $this->get($id);
    $query = $this->find("all")
    ->where(["id !="=>$id,"ABS(coordinate_x-".$fighter["coordinate_x"].") + ABS(coordinate_y - ".$fighter["coordinate_y"].") <="=>$fighter["skill_sight"]]);
    return $query;

  }

  function supprime($id){
    $fighter = $this->get($id);
    return $this->delete($fighter);
  }

  function modifer($data)
  {
    $fighter = $this->patchEntity($this->newEntity(), $data);
    $id = $fighter['id'];
    $newfighter = $this->get($id);
    if (!empty($fighter['name']))
    {
      $newfighter['name'] = $fighter['name'];
      $Value = $this->save($newfighter);
      return $Value;
    }
    return FALSE;
  }

  function updateVie($enemy,$nbPoints){
    $enemy['skill_health'] = $nbPoints;
    return $this->save($enemy);
  }

  function updateXp($player,$xp){
    $player['xp'] = $xp;
    return $this->save($player);
  }

  function mourir($enemy){
    $enemy["coordinate_x"] = -100;
    $enemy["coordinate_y"] = -100;
    $this->save($enemy);
  }

  function insererEvenement($message,$posX,$posY){
    $eventsTable = TableRegistry::get('Events');
    $eventsTable->insert($message,$posX,$posX);
  }

  function attaquer($idP,$idE){
    $enemy = $this->findById($idE);
    $player = $this->findById($idP);
    $rand = rand(1,20);
    $seuil = 10+$player->level-$enemy->level;
    $message = array();
    if($rand > $seuil){
      if ($this->updateVie($enemy,$enemy->skill_health - $player->skill_strength)) {
        $xp = $player->xp+1;
        if($enemy->skill_health <= 0){
          $xp = $player->xp + $enemy->level;
          $this->mourir($enemy);
          //ajout de l'évenement de tue
          $message = "tué";
          $evenement = $player->name.' attaque '.$enemy->name.' et le tue';
          $this->insererEvenement($evenement,$player->coordinate_x,$player->coordinate_y);
        }else{
          //ajout de l'evenement de touche
          $message = "touché";
          $evenement = $player->name.' attaque '.$enemy->name.' et le touche';
          $this->insererEvenement($evenement,$player->coordinate_x,$player->coordinate_y);
        }
        $this->updateXp($player,$xp);
      }else{
        //$this->Flash->error(__("Erreur lors de l'attaque"));
      }
    }else{
      $message = "Attaque râté";
      //ajoute de l'évenement de râte
      $evenement = $player->name.' attaque '.$enemy->name.' et le râte';
      $this->insererEvenement($evenement,$player->coordinate_x,$player->coordinate_y);
    }
    return $message;
  }
}
?>
