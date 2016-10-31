<?php
namespace App\Model\Table;

use Cake\ORM\Table;
use Cake\Utility\Text;

class GuildsTable extends Table {

	public function insert($guild){
	    if($this->findByName($guild) == null){
	    	$value = $this->save($guild);
	    }
	    else{
	    	$value = 0;
	    }
	    return $value;
	}

	public function findAllGuild(){
		$query = $this->find('all');
		$data = $query->toArray();
		return $data;
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
