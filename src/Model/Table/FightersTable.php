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
    ->where(['Fighters.player_id =' => $player_id,
        'Fighters.coordinate_x !='=> -100,
        'Fighters.coordinate_Y !='=> -100]);

    return $query;
  }

  function insert($data,$user)
  {
    $fighter = $this->patchEntity($this->newEntity(), $data);
    if (!empty($fighter['name']))
    {
        $fighter['player_id'] = $user['id'];
        $fighter['level'] = 0;
        $fighter['skill_strength'] = 1;
        $fighter['skill_sight'] = 2;
        $fighter['skill_health'] = 5;
        $fighter['current_health'] = 5;
        $fighter['xp'] = 0;
        // génération aléatoires des coordonnées avec vérification qu'il n'y est pas d'autre combattant sur la case
        $boolean = FALSE;
        while (!$boolean)
        {
          $x = rand (1, 15);
          $y = rand (1, 10);
          $boolean = $this->checkdisponibiliter($x,$y);
        }
      $fighter['coordinate_x'] = $x;
      $fighter['coordinate_y'] = $y;
      $Value = $this->save($fighter);
      return $Value;
    }
    return FALSE;
  }

  function checkdisponibiliter($x,$y)
  {
    $query = $this->find();
    $query->select(['count' => $query->func()->count('*')]);
    $query->where(['coordinate_x' => $x,'coordinate_y'=>$y]);

    foreach ($query as $f)
    {
      if ($f->count == 0)
      {
        return TRUE;
      }
      else
      {
        return FALSE;
      }
    }
  }

  function moove($id,$action){
    $fighter = $this->get($id);
    $message = '';
    switch($action){
      case 'monter':
      if(($fighter["coordinate_y"] -1 != 0) && $this->checkdisponibiliter($fighter["coordinate_x"],$fighter["coordinate_y"] -1)){
        $fighter["coordinate_y"] = $fighter["coordinate_y"]-1;
      }else{
        $message = "vous ne pouvez pas monter";
      }

      break;
      case 'descendre':
      if(($fighter["coordinate_y"]+1 != 11) && $this->checkdisponibiliter($fighter["coordinate_x"],$fighter["coordinate_y"] +1)){
        $fighter["coordinate_y"] = $fighter["coordinate_y"]+1;
      }else{
        $message = "vous ne pouvez pas descendre";
      }
      break;
      case 'gauche':
      if(($fighter["coordinate_x"]-1 != 0) && $this->checkdisponibiliter($fighter["coordinate_x"]-1,$fighter["coordinate_y"])){
        $fighter["coordinate_x"] = $fighter["coordinate_x"]-1;
      }else{
        $message = "vous ne pouvez pas aller à gauche";
      }

      break;
      case 'droite':
      if(($fighter["coordinate_x"]+1 != 16) && $this->checkdisponibiliter($fighter["coordinate_x"]+1,$fighter["coordinate_y"])){
        $fighter["coordinate_x"] = $fighter["coordinate_x"]+1;
      }else{
        $message = "vous ne pouvez pas aller a droite";
      }

      break;

    }
    $this->save($fighter);
    return $message;
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
    $enemy['current_health'] = $nbPoints;
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
      if ($this->updateVie($enemy,$enemy->current_health - $player->skill_strength)) {
        $xp = $player->xp+1;
        if($enemy->current_health <= 0){
          $xp = $xp + $enemy->level;
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
        $message = "Erreur lors de l'attaque";
      }
    }else{
      $message = "Attaque râté";
      //ajoute de l'évenement de râte
      $evenement = $player->name.' attaque '.$enemy->name.' et le râte';
      $this->insererEvenement($evenement,$player->coordinate_x,$player->coordinate_y);
    }
    return $message;
   }


    function findNbPoints($fighter){
        $levelActu = $fighter->level;
        $xp = $fighter->xp;
        $levelReel = intval($xp/4);
        $res = $levelReel - $levelActu;
        return $res;
    }

    function augmenterCompetences($data){
        $fighter = $this->findById($data["id"]);
        switch ($data["skill"]) {
            case 'force':
                $fighter->skill_strength++;
                break;

            case 'vue':
                $fighter->skill_sight++;
            break;

            case 'sante':
                $fighter->skill_health+3;
            break;
        }
        $fighter->level++;
        $fighter->current_health = $fighter->skill_health;
        $this->save($fighter);
    }
    public function joinAGuild($data,$idFighter){
        $fighter = $this->findById($idFighter);
        $fighter->guild_id = $data["idGuild"];
        $this->save($fighter);

    }
}
?>
