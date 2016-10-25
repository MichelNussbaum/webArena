<?php
namespace App\Model\Table;

use Cake\ORM\Table;
use Cake\Utility\Text;

class PlayersTable extends Table {

  public function insert($player)
  {
    $player['id'] = Text::uuid();
    $Value = $this->save($player);
    return $Value;
  }
}
?>