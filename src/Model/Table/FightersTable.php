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
    $rows = $this->find("all")
    ->where(['Fighters.player_id =' => $player_id,
        'Fighters.coordinate_x !='=> -100,
        'Fighters.coordinate_Y !='=> -100]);
    $guildsTable = TableRegistry::get('Guilds');
    foreach ($rows as $row) {
      if(!empty($row->guild_id)){
        $guild = $guildsTable->findById($row->guild_id);
        $row["guild_name"] = $guild->name;
      }

    }
    return $rows;
  }

  function findAllFighterNotOwn($playerId){
    $query = $this->find()
    ->select(['id','name'])
    ->where(['player_id !=' => $playerId])
    ->all();
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
      $value = $this->save($fighter);
      if (!empty($data['avatar_file']['tmp_name']))
        {
          $extension = strtolower(pathinfo($data['avatar_file']['name'], PATHINFO_EXTENSION));
          if($extension=="jpg")
          {
            move_uploaded_file($data['avatar_file']['tmp_name'], WWW_ROOT. 'img' . DS . 'Avatars' . DS . $value['id']. '.' .$extension);
          }
        }
      return $value;
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

  function findNbPartenaireGuildAutourCible($x,$y,$guilde){
    $res = 0;
    if(!empty($guilde)){
      $query = $this->find();
      $query->select(['count' => $query->func()->count('*')])
      ->where(["coordinate_x"=>$x-1,"coordinate_y"=>$y])
      ->orWhere(["coordinate_x"=>$x+1,"coordinate_y"=>$y])
      ->orWhere([["coordinate_x"=>$x,"coordinate_y"=>$y+1],["coordinate_x"=>$x,"coordinate_y"=>$y-1]])
      ->andWhere(["guild_id"=>$guilde]);
      foreach ($query as $f)
      {
        $res = $f->count-1;
      }
    }

    return $res;
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
        $message = "vous ne pouvez pas aller à droite";
      }

      break;

    }
    $this->save($fighter);
    return $message;
  }

  function findEnemies($id){
    $guildsTable = TableRegistry::get('Guilds');
    $fighter = $this->get($id);
    $rows = $this->find("all")
    ->where(["id !="=>$id,
      "ABS(coordinate_x-".$fighter["coordinate_x"].") + ABS(coordinate_y - ".$fighter["coordinate_y"].") <="=>$fighter["skill_sight"]]);
    foreach ($rows as $row) {
      if(!empty($row->guild_id)){
        $guild = $guildsTable->findById($row->guild_id);
        $row["guild_name"] = $guild->name;
      }
      $row["avatar"] = $this->avatar($row->id);
    }
    return $rows;

  }

  function supprime($id){
    $fighter = $this->get($id);
    return $this->delete($fighter);
  }

  function modifer($data)
  {
    $newfighter = $this->get($data['id']);
    if (!empty($data['name']))
    {
      $newfighter['name'] = $data['name'];
      $value = $this->save($newfighter);
      return $value;
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

  function iamdead($idFighter)
  {
    $fighter = $this->get($idFighter);
    if (($fighter["coordinate_x"] == -100) && ($fighter["coordinate_y"] == -100)) {
      return true;
    }
    else {
      return false;
    }
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
      $bonusGuilde = $this->findNbPartenaireGuildAutourCible($enemy->coordinate_x,$enemy->coordinate_y,$player->guild_id);
      if ($this->updateVie($enemy,$enemy->current_health - $player->skill_strength - $bonusGuilde)) {
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

    public function avatar($idfighter)
    {
      $file = WWW_ROOT. 'img' . DS . 'Avatars' . DS . $idfighter. '.jpg';
      if(file_exists($file))
      {
        return true;
      }else {
        return false;
      }
    }
}
?>
