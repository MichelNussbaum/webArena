<?php
namespace App\Model\Table;

use Cake\ORM\Table;

class FightersTable extends Table
{
    function findById($id){
      return $this->get($id);
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
