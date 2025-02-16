<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\Event\Event;
use Facebook\Facebook;

class PublicController extends AppController
{

	public function beforeFilter(Event $event)
	{
		parent::beforeFilter($event);
		$this->Auth->allow(['inscription', 'logout','forgetPassword','connexion','facebook']);				// n'exige pas une authentification à ces pages
		$this->verifyConnect();
		$this->loadModel('Players');																											// Vérifie s’il y a un utilisateur connecter et si oui, il le redirige vers sa page.
	}

	public function inscription()
	{
		if ($this->request->is('post'))
		{
			$value = $this->Players->insert($this->request->data);
			if ($value) {
				$this->Flash->success(__("Le joueur a été sauvegardé."));

				$player = $this->Auth->identify();
				$this->Auth->setUser($player);
				$this->Flash->success(__("Connexion réussi."));
				return $this->redirect($this->Auth->redirectUrl());

			}
			else
			{
				$this->Flash->error(__("Impossible d'ajouter le joueur."));
			}
		}
		//$this->set('player',$value);
	}

	public function connexion()
	{
		$this->set('player', $this->Auth->user());
		if ($this->request->is('post')) {
			if ($this->request->data['type'] == 'connexion')
			{
				$player = $this->Auth->identify();
				if ($player) {
					$this->Auth->setUser($player);
					$this->Flash->success(__("Connexion réussi."));
					return $this->redirect($this->Auth->redirectUrl());
				}
				else {
					$this->Flash->error(__('Adresse e-mail inconnue ou mot de passé erroné !'));
				}
			}elseif ($this->request->data['type'] == 'MDPOublié') {
				$playerFind = $this->Players->findByEmail($this->request->data["email"]);
				if(!empty($playerFind)){
					$this->Players->resetPassword($playerFind);
					$this->Flash->success(__('Un mail vous a été envoyé à '.$playerFind->email));
				}else{
					$this->Flash->error(__('Aucun joueur trouvé avec cette adresse email'));
				}
			}
		}
	}

	public function verifyConnect(){
		if($this->Auth->user()){
			return $this->redirect(['controller'=>'Member','action' => 'index']);
		}
	}

	public function facebook(){
		if($_SERVER['HTTP_HOST'] == "localhost:8888"){
		  //on met les id de l'application de test
			$appId = "1242440412484253";
			$appSecret = "77412844f205bd09ed47a7954611259e";
		}elseif ($_SERVER['HTTP_HOST'] == "michelnussbaum.fr" || $_SERVER['HTTP_HOST'] == "www.michelnussbaum.fr") {
		  //on met les id de l'application de prod
			$appId = "1242436859151275";
			$appSecret = "d35c67c6507a9587e2657b27c0ae720e";
		}
		$fb = new Facebook([
			'app_id' => $appId, 
			'app_secret' => $appSecret,
			'default_graph_version' => 'v2.2',
			]);
		$helper = $fb->getRedirectLoginHelper();

		try {
			$accessToken = $helper->getAccessToken();
		} catch(Facebook\Exceptions\FacebookResponseException $e) {
				// When Graph returns an error
			echo 'Graph returned an error: ' . $e->getMessage();
			exit;
		} catch(Facebook\Exceptions\FacebookSDKException $e) {
				// When validation fails or other local issues
			echo 'Facebook SDK returned an error: ' . $e->getMessage();
			exit;
		}

		if (! isset($accessToken)) {
			if ($helper->getError()) {
				header('HTTP/1.0 401 Unauthorized');
				echo "Error: " . $helper->getError() . "\n";
				echo "Error Code: " . $helper->getErrorCode() . "\n";
				echo "Error Reason: " . $helper->getErrorReason() . "\n";
				echo "Error Description: " . $helper->getErrorDescription() . "\n";
			} else {
				header('HTTP/1.0 400 Bad Request');
				echo 'Bad request';
			}
			exit;
		}

			// Logged in
			/*echo '<h3>Access Token</h3>';
			var_dump($accessToken->getValue());*/

			// The OAuth 2.0 client handler helps us manage access tokens
			$oAuth2Client = $fb->getOAuth2Client();
			// Get the access token metadata from /debug_token
			$tokenMetadata = $oAuth2Client->debugToken($accessToken);
			/*echo '<h3>Metadata</h3>';
			var_dump($tokenMetadata);*/

			// Validation (these will throw FacebookSDKException's when they fail)
			$tokenMetadata->validateAppId($appId); // app test
			//$tokenMetadata->validateAppId('1242436859151275'); // app prod
			// If you know the user ID this access token belongs to, you can validate it here
			//$tokenMetadata->validateUserId('123');
			$tokenMetadata->validateExpiration();

			if (! $accessToken->isLongLived()) {
				// Exchanges a short-lived access token for a long-lived one
				try {
					$accessToken = $oAuth2Client->getLongLivedAccessToken($accessToken);
				} catch (Facebook\Exceptions\FacebookSDKException $e) {
					echo "<p>Error getting long-lived access token: " . $helper->getMessage() . "</p>\n\n";
					exit;
				}

				echo '<h3>Long-lived</h3>';
				var_dump($accessToken->getValue());
			}

			try {
				// Returns a `Facebook\FacebookResponse` object
				$response = $fb->get('/me?fields=email', $accessToken);
			} catch(Facebook\Exceptions\FacebookResponseException $e) {
				echo 'Graph returned an error: ' . $e->getMessage();
				exit;
			} catch(Facebook\Exceptions\FacebookSDKException $e) {
				echo 'Facebook SDK returned an error: ' . $e->getMessage();
				exit;
			}

			$user = $response->getGraphUser();
			$player = $this->Players->findByEmail($user['email']);
			if($player){
				$this->Auth->setUser($player);
				$this->Flash->success(__("Connexion réussi."));
				return $this->redirect($this->Auth->redirectUrl());
			}else{
				$player = $this->Players->insertFacebook($user['email']);
				if ($player) {
					$this->Auth->setUser($player);
					$this->Flash->success(__("Connexion réussi."));
					return $this->redirect($this->Auth->redirectUrl());
				}
				else {
					$this->Flash->error(__('Adresse e-mail inconnue ou mot de passé erroné !'));
				}
			}


		}
	}
