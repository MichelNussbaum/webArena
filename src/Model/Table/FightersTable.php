<?php
namespace App\Model\Table;

use Cake\ORM\Table;

class FightersTable extends Table
{
    function findById($id){
      $query = $this->find(all);
          ->where(['Fighters.id =' =>$id]);
      return $query->first;
    }
}
?>
