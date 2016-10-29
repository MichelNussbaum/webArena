<?php
namespace App\Model\Table;

use Cake\ORM\Table;
use Cake\Utility\Text;

class PlayersTable extends Table {

	public function insert($data)
	{
		$player = $this->patchEntity($this->newEntity(), $data);
		$player['id'] = Text::uuid();
		$Value = $this->save($player);
		return $Value;
	}

	public function insertFacebook($email){
		$player = $this->newEntity();
		$player['id'] = Text::uuid();
		$player['email'] = $email;
		$player['password'] = 'facebook';
		$this->save($player);
		return $player;
	}

	public function findByEmail($mail){
		$query = $this->find('all')
		->where(['Players.email LIKE' => $mail]);
		$row = $query->first();
		return $row;
	}

	public function resetPassword($player){
		$password = "bye";
		$player->password = $password;
		if ($this->save($player)) {
			/*$email = new Email('default');
			$email->from(['michelnussbaum54@gmail.com' => 'My Site'])
			->to('cake@yopmail.com')
			->subject('Password reset '.$player->email)
			->send('nouveau password : '.$password);*/
			//$this->Flash->success(__("Le password a été mis à jour."));
			//return $this->redirect(['action' => 'index']);
		}else{
			//$this->Flash->error(__('Mise à jour du mot de passe échouée'));
		}
	}
}
?>
