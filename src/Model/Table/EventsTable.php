<?php
namespace App\Model\Table;

use Cake\ORM\Table;
use Cake\ORM\TableRegistry;

class EventsTable extends Table
{
    function insert($message,$posX,$posY){
        $event = $this->newEntity();
        $event["date"] = date('Y-m-d H:i:s');
        $event["name"] = $message;
        $event["coordinate_x"] = $posX;
        $event["coordinate_y"] = $posY;
        $this->save($event);
    }
}
?>
