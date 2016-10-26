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

    function insert($fighter,$user)
    {
      $fighter['player_id'] = $user['id'];
      $fighter['level'] = 1;
      $fighter['skill_strength'] = 1;
      $fighter['skill_sight'] = 0;
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

    function moove($id,$action){
    	$fighter = $this->get($id);
    	switch($action){
    		case 'monter':
    			$fighter["coordinate_y"] = $fighter["coordinate_y"] -1;
    			break;
    		case 'descendre':
    			$fighter["coordinate_y"] = $fighter["coordinate_y"] +1;
    			break;
    		case 'gauche':
    			$fighter["coordinate_x"] = $fighter["coordinate_y"] -1;
    			break;
    		case 'droite':
    			$fighter["coordinate_x"] = $fighter["coordinate_y"] +1;
    			break;

    	}
    	if($this->save($fighter)){
    	}
    }

    function descendre($player){

    }

    function gauche($player){

    }

    function droite($player){

    }
}
?>
