<?php
namespace App\Model\Table;

use Cake\ORM\Table;
use Cake\Utility\Text;

class GuildsTable extends Table {

	public function insert($data){
	    if(empty($this->findByName($data["name"])["name"])){
	    	$guilde = $this->patchEntity($this->newEntity(), $data);
	    	$this->save($guilde);
	    	$message = "Guilde ".$data["name"]." créé";
	    }
	    else{
	    	$message = "Cette guilde existe déja";
	    }
	    return $message;
	}

	public function findAllGuild(){
		$query = $this->find('all');
		return $query;
	}

	public function findByName($guild_name){
	  	$query = $this->find('all')
	    	->where(['Guilds.name LIKE' => $guild_name]);
	    $row = $query->first();
	    return $row;
	}

	public function findById($guild_id){
		$query = $this->find('all')
			->where(['Guilds.id =' => $guild_id]);
		$row  = $query->first();
		return $row;
	}
}
?>
