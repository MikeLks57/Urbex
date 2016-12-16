<?php

namespace Controller;

use \W\Controller\Controller;
use \W\Security\AuthentificationModel;
use \W\Model\UsersModel;
use \Model\RecoverytokensModel;
use \Model\ConfirmtokensModel;
use \Service\MailerService;

class DefaultController extends Controller
{

	/**
	 * Page d'accueil par défaut
	 */
	public function home()
	{
		$this->show('default/home');
	}

	public function login()
	{
		// Si on a essayé de se connecté
		if(isset($_POST['login'])) {
			$errors = [];

			if(isset($_POST['g-recaptcha-response'])){
          		$captcha=$_POST['g-recaptcha-response'];
        	}
			if(!$captcha)
			{
				$errors['captcha']['check'] = true;
			}

			$secretKey = "6LeX2Q4UAAAAAN7qkqbeLzu-u1hK_PV3dsgqusLE";
        	$ip = $_SERVER['REMOTE_ADDR'];
	        $response=file_get_contents("https://www.google.com/recaptcha/api/siteverify?secret=".$secretKey."&response=".$captcha."&remoteip=".$ip);
	        $responseKeys = json_decode($response,true);
	        if(intval($responseKeys["success"]) !== 1) {
	          echo '<h2>You are a F$%K&¤G ROBOT ! Get the @$%K out</h2>';
	        } else {
				$authModel = new AuthentificationModel();
				$userModel = new UsersModel();

				// L'id d'un utilisateur
				$userId = $authModel->isValidLoginInfo($_POST['mail'], $_POST['pass']);

				if($userId > 0) {
					// Connexion
					$user = $userModel->find($userId);

					if($user['confirmed_at'] == NULL)
					{
						$errors['confirmed']['notconfirmed'] = true;
						$this->show('default/login', ['errors' => $errors]);
					} else {
						// Placer user en session : $_SESSION['user'] = $user
						$authModel->logUserIn($user);
						$this->redirectToRoute('default_home');
					}

				} else {

					// Echec de la connexion
					$this->show('default/login', ['error' => true]);
				}
			}
		} else {
			$this->show('default/login');
		}
	}

	public function logout()
	{
		$authModel = new AuthentificationModel();
		$authModel->logUserOut();
		$this->redirectToRoute('default_home');
	}

	public function passwordRecovery()
	{
		$tokenModel = new RecoverytokensModel();
		$userModel = new UsersModel();
		if(isset($_POST['send-mail'])) {
			$user = $userModel->getUserByUsernameOrEmail($_POST['mail']);
			if(!empty($user)) {
				// Ajouter un token de reset de mot de passe
				$token = \W\Security\StringUtils::randomString(32);
				$tokenModel->insert([
					'id_user' 	=> $user['id'],
					'token' 	=> $token,
				]);

				// Envoyer un mail
				$resetUrl = 'http://127.0.0.1:8080' . $this->generateUrl('default_reset_password', ['token' => $token]);

				$messageHtml =<<< EOT
<h1>Réinitialisation de votre mot de passe</h1>
Quelqu'un a demandé la réinitialisation de votre mot de passe.<br>
<a href="$resetUrl">Cliquez ici</a> pour finaliser l'opération<br>
Si vous n'êtes pas à l'origine de ce mail, bla bla bla..
EOT;

				$messagePlain =<<< EOT
Réinitialisation de votre mot de passe
Quelqu'un a demandé la réinitialisation de votre mot de passe.
Accédez à $resetUrl pour finaliser l'opération
Si vous n'êtes pas à l'origine de ce mail, bla bla bla..
EOT;


				$mymailer = new MailerService();
				$mymailer->sendMail($user['mail'], $user['name'], 'Réinitialisation du mot de passe', $messageHtml, $messagePlain);

				$this->redirectToRoute('default_home');
			}
		} else {
			$this->show('default/password-recovery');
		}
	}

	public function resetPassword($token)
	{
		$tokenModel = new RecoverytokensModel();
		$authModel = new AuthentificationModel();
		$tokens = $tokenModel->search(['token' => $token]);
		if(count($tokens) > 0) {
			$myToken = $tokens[0];
		}
		if(!empty($myToken)) {
			// Le token existe bien en base

			// Si j'ai reçu une soumission
			if(isset($_POST['update-password'])) {
				// Modification du mot de passe, si confirmation exacte
				if($_POST['password'] == $_POST['password-confirm']) {
					$userModel = new UsersModel();
					$userModel->update(['password' => $authModel->hashPassword($_POST['password'])], $myToken['id_user']);

					$tokenModel->delete($myToken['id']);

					$this->redirectToRoute('default_login');
				}
			}

			// Sinon
			$this->show('default/reset-password');
		} else {
			$this->redirectToRoute('default_login');
		}
	}

	public function confirm($token)
    {
        $tokenModel = new ConfirmtokensModel();
        $tokens = $tokenModel->search(['token' => $token]);
        if (count($tokens) > 0) {
            $myToken = $tokens[0];
        }
        if (!empty($myToken)) {
            // Le token existe bien en base

            // Si j'ai reçu une soumission
            if (isset($_POST['confirm-account'])) {
                // Modification du mot de passe, si confirmation exacte
                $userModel = new UsersModel();
                $userModel->update(['confirmed_at' => date('Y-m-d')], $myToken['id_user']);

                $tokenModel->delete($myToken['id']);

                $this->redirectToRoute('default_login', ['success' => 'Votre compte a etait activée !']);
            } else {
                $this->show('default/confirm-account');
            }
        } else {
            $this->redirectToRoute('default_login', ['errors' => ['La confirmation de votre compte a echouée']]);
        }
    }

    public function signin()
	{
		$usersModel = new UsersModel();
		$authModel = new AuthentificationModel();

		if(isset($_POST['add-user'])) {
			$errors = [];
			$confirm =[];
			$nameExist = $usersModel->usernameExists($_POST['pseudo']);
			$mailExist = $usersModel->emailExists($_POST['mail']);

			if(empty($_POST['pseudo'])) {
				$errors['pseudo']['empty'] = true;
			}
			if($nameExist){
				$errors['pseudo']['exist'] = true;
			}
			if(empty($_POST['mail'])) {
				$errors['mail']['empty'] = true;
			}
			if($mailExist) {
				$errors['mail']['exist'] = true;
			}
			elseif(!filter_var($_POST['mail'], FILTER_VALIDATE_EMAIL)) {
				$errors['mail']['bad'] = true;
			}
			if(empty($_POST['password'])) {
				$errors['password']['empty'] = true;
			}
			if(empty($_POST['password2'])) {
				$errors['password2']['empty'] = true;
			}
			elseif($_POST['password2'] != $_POST['password']) {
				$errors['confirmPass'] = true ;
			}
			if(isset($_POST['g-recaptcha-response'])){
          		$captcha=$_POST['g-recaptcha-response'];
        	}
			if(!$captcha)
			{
				$errors['captcha']['check'] = true;
			}
			else{
				$secretKey = "6LeX2Q4UAAAAAN7qkqbeLzu-u1hK_PV3dsgqusLE";
	        	$ip = $_SERVER['REMOTE_ADDR'];
		        $response=file_get_contents("https://www.google.com/recaptcha/api/siteverify?secret=".$secretKey."&response=".$captcha."&remoteip=".$ip);
		        $responseKeys = json_decode($response,true);
		        if(intval($responseKeys["success"]) !== 1) {
		          echo '<h2>You are a F$%K&¤G ROBOT ! Get the @$%K out</h2>';
		        } else {
		        	if(count($errors) === 0) {
					// Ajouter si OK
					$usersModel->insert([
						'name' 	=> $_POST['pseudo'],
						'mail' 	=> $_POST['mail'],
						'password' 	=> $authModel->hashpassword($_POST['password']),
						'role' => 'user',
					]);
						$this->confirmAccount($_POST['mail']);
						$this->redirectToRoute('default_login');
					}
		        }
			}
			if(count($errors) === 0) {
					// Ajouter si OK
					$usersModel->insert([
						'name' 	=> $_POST['pseudo'],
						'mail' 	=> $_POST['mail'],
						'password' 	=> $authModel->hashpassword($_POST['password']),
						'role' => 'user',
					]);
                		$this->confirmAccount($_POST['mail']);
						$this->redirectToRoute('default_login');
					}
	        $this->show('default/signin', ['errors' => $errors, 'confirm' => $confirm]);
		}

		else {
			// Sinon, afficher le formulaire
			$this->show('default/signin');
		}
	}

	private function confirmAccount($email)
    {
        $tokenModel = new ConfirmtokensModel();
        $userModel = new UsersModel();
        if (isset($_POST['add-user'])) {
            $user = $userModel->getUserByUsernameOrEmail($email);
            if (!empty($user)) {
                // Ajouter un token
                $token = \W\Security\StringUtils::randomString(32);
                $tokenModel->insert([
                    'id_user' => $user['id'],
                    'token' => $token,
                ]);

                // Envoyer un mail
                $confirmAccount = 'http://127.0.0.1:8080'.$this->generateUrl('default_confirm_account', ['token' => $token]);

                $messageHtml = <<< EOT
<h1>Confirmation de votre compte</h1>
Bonjour $user[name]<br>
<a href="$confirmAccount">Cliquez ici</a> pour finaliser votre inscription<br>
Si vous n'êtes pas à l'origine de ce mail, bla bla bla..
EOT;

                $messagePlain = <<< EOT
Confirmation de votre compte
Bonjour $user[name],
Accédez à $confirmAccount pour finaliser votre inscription
Si vous n'êtes pas à l'origine de ce mail, bla bla bla..
EOT;

				$myMailer = new MailerService();
                $myMailer->sendMail($user['mail'], $user['name'], 'Confirmation de compte', $messageHtml, $messagePlain);
            }
        } else {
            $this->redirectToRoute('default_login', ['errors' => ['Le mail de confirmation n\' a pas pu être envoyée']]);
        }
    }
}