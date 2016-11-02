<?php
namespace App\Model\Table;

use Cake\ORM\Table;
use Cake\Utility\Text;
use Cake\Mailer\Email;

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
		$password = $this->generatePass();
		$player->password = $password;
		if ($this->save($player)) {
			$email = new Email('default');
			$email->from(['webarenaecemfv@gmail.com' => 'Web Arena ECE'])
			->to($player->email)
			->subject('Password reset '.$player->email)
			->send('nouveau password : '.$password);
			//$this->Flash->success(__("Le password a été mis à jour."));
			//return $this->redirect(['action' => 'index']);
		}else{
			//$this->Flash->error(__('Mise à jour du mot de passe échouée'));
		}
	}

	function generatePass() {
		$nbChar = 8;
		
		$characters = '023456789abcdefghijkmnopqrstuvwxyzABCDEFGHJKLMNOPQRSTUVWXYZ#!$';
		$specials = '#!?$%&*';
		
		$firstPart = substr(str_shuffle($characters), 0, $nbChar - 1);
		$lastPart = substr(str_shuffle($specials), 0, 1);
		
		return str_shuffle($firstPart . $lastPart);
	}
}
?>
