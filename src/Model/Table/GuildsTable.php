<?php
namespace App\Model\Table;

use Cake\ORM\Table;
use Cake\Utility\Text;

class GuildsTable extends Table {

	  public function insert($guild)
	  {
	    $guild['id'] = Text::uuid();
	    $Value = $this->save($guild);
	    return $Value;
	  }

	public function findByName($guild){
	  	$query = $this->find('all')
	    	->where(['Guilds.name LIKE' => $guild->name]);
	    $row = $query->first();
	    return $row;
	}

	public function findById($guild){
		$query = $this->find('all')
			->where(['Guilds.id =' => $guild->id]);
		$row  = $query->first();
		return $row;
	}
}
?>
