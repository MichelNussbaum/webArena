<?php
namespace App\Model\Table;

use Cake\ORM\Table;
use Cake\ORM\TableRegistry;

class MessagesTable extends Table{

	function findDistinctConversationByFighterId($idFighter){
    	$fightersIds = $this->find()
    	->select(['fighter_id'])
    	->where(['fighter_id_from' => $idFighter])
    	->distinct(['fighter_id'])
    	->all();
    	$fightersTable = TableRegistry::get('Fighters');
    	$fighters = array();
    	foreach ($fightersIds as $fighterId) {
    		$fighter = $fightersTable->findById($fighterId->fighter_id);
            $messages = $this->findMessageByFighter($idFighter,$fighterId->fighter_id);
    		array_push($fighters, array($fighter,$messages));
    	}
    	return $fighters;
    }

    function findMessageByFighter($idFrom,$idTo){
    	$rows = $this->find('all')
    	->where(['fighter_id_from' => $idFrom,'fighter_id'=>$idTo])
        ->orWhere(['fighter_id_from' => $idTo,'fighter_id'=>$idFrom])
    	->order(['date' => 'ASC'])
    	->all();
    	return $rows;
    }

    function insert($data){
        $message = $this->patchEntity($this->newEntity(), $data);
        $message->date = date('Y-m-d H:i:s');
        $this->save($message);
    }
}
