<?php

namespace App\Controller;

use Cake\Mailer\Email;
use App\Controller\AppController;
use Cake\Event\Event;
use Cake\Mailer\TransportFactory;
use Cake\ORM\TableRegistry;
use Cake\Utility\Security;
use Cake\Auth\DefaultPasswordHasher;
use  Cake\I18n\FrozenTime;
use Cake\Core\Configure;

class UsersController extends AppController
{
    public function initialize()
    {
        parent::initialize();
        $this->loadComponent('RequestHandler');
    }
    public function index()
    {
        
        $users = $this->paginate($this->Users);
        
        $this->set([
            'users' => $users,
            '_serialize' => ['users']
        ]);
    }

    public function view($id = null)
    {
        
        $user = $this->Users->get($id);
        $this->set([
            'user' => $user,
            '_serialize' => ['user']
        ]);
        
    }

    public function add()
    {
        $user = $this->Users->newEntity();
        if ($this->request->is('post')) {
            $user = $this->Users->patchEntity($user, $this->request->getData());
            if ($this->Users->save($user)) {
                $this->Flash->success(__('The user has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The user could not be saved. Please, try again.'));
        }
        $this->set(compact('user'));
    }

    public function edit($id = null)
    {
        $user = $this->Users->get($id, [
            'contain' => [],
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $user = $this->Users->patchEntity($user, $this->request->getData());
            if ($this->Users->save($user)) {
                $this->Flash->success(__('The user has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The user could not be saved. Please, try again.'));
        }
        $this->set(compact('user'));
    }

    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $user = $this->Users->get($id);
        if ($this->Users->delete($user)) {
            $this->Flash->success(__('The user has been deleted.'));
        } else {
            $this->Flash->error(__('The user could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }

    public function login()
    {
        if ($this->request->is('post')) 
        {
            $user = $this->Auth->identify();
            if ($user) 
            {
                $this->Auth->setUser($user);
                if ($user['role'] !== 'admin')
                {
                return $this->redirect(['controller' => 'articles']);
                }
                elseif($user['role'] === 'admin')
                {
                return $this->redirect(['controller' => 'users' , 'action' => 'index']);
                }
            }
             $this->Flash->error(__('Invalid username or password, try again'));    
        }
           
    }
        
        
    
    public function logout()
    {
        $this->Flash->success('You Are Logged Out');
        return $this->redirect($this->Auth->logout());
    }
    public function signup()
    {
        $user = $this->Users->newEntity();
        if ($this->request->is('post')) {
            $user = $this->Users->patchEntity($user, $this->request->getData());
            if ($this->Users->save($user)) {
                $this->Flash->success(__('Your account has been made Please Login.'));

                return $this->redirect(['action' => 'login']);
            }
            $this->Flash->error(__('Make Sure Everything is filled out!'));
        }
        $this->set(compact('user'));
        
    }
    public function beforeFilter(Event $event)
    {
        $this->Auth-> allow(['signup' , 'logout', 'forgotPassword', 'resetPassword']);
        
       
    }

	/**
	 * Generate Password Reset Token
	 *
	 * @param User $user
	 * @param mixed int
	 * @return void
	 */
    public function generatePasswordResetToken($user, int $expiration = 15): string 
    {
		$data = [
            'id' => $user->id,
			'expiration' => (new FrozenTime())->addMinutes($expiration)
        ];
        
        $key = Configure::read('Blog.passwordResetTokenKey');
		return base64_encode(Security::encrypt(json_encode($data), $key));
	}

	/**
	 * Validate Password Reset Token
	 *
	 * @param string $value
	 * @return User|null
	 */
    public function validatePasswordResetToken($value): ?Users
    {   
        
        $key = Configure::read('Blog.passwordResetTokenKey');
        
      
		if ($token = Security::decrypt(base64_decode($value), Configure::read('Blog.passwordResetTokenKey'))) {
            
            $token = json_decode($token, true);
            $exp = new FrozenTime($token['expiration']);
			if  ($exp->gt(new FrozenTime())) {
                
                return $this->Users->get($token['id']);
                
			}
        }

		return null;
    }
    
    public function forgotPassword()
    {
        if($this->request->is('post'))
        {
            
            $Useremail = $this->request->getData('email');
       
            $user = $this->Users->find('all')->where(['email'=>$Useremail])->first();
            $tokenID = $this->generatePasswordResetToken($user);
            $user->password = '';
            
            if ($this->Users->save($user))
            {
                $this->Flash->success('Reset Password link has been sent to your email ('.$Useremail.')! Please Check Your Email.');
                TransportFactory::setConfig('mailtrap', [
                    'host' => 'smtp.mailtrap.io',
                    'port' => 2525,
                    'username' => '11aded4568df92',
                    'password' => 'bde91710390d19',
                    'className' => 'Smtp'
                  ]);
                  $email = new Email('default');
                  $email->setTransport('mailtrap');
                  $email->setEmailFormat('html');
                  $email->setFrom('stevona199999@gmail.com', 'Steven Portillo');
                  $email->setSubject('Please Confirm your rest password');
                  $email->setTo($Useremail);
                  $email->send('Hello '.$Useremail.' <br/> Please Click the link below to reset your password <br/><br/><a href="http://206.189.202.188:43554/users/resetpassword/'.$Useremail.'/?token='.$tokenID.'">Reset Password</a>');
            }
        }
    }

    public function resetPassword($Useremail)
    {
        $token = $this->request->getQuery('token');
        
        $user = $this->Users->newEntity();
        $user= $this->Users->find('all')->where(['email'=>$Useremail])->first();
       
        if ($this->request->is('post')) 
        {
           
            $user = $this->Users->patchEntity($user, $this->request->getData());
            $tokenCheck = $this->validatePasswordResetToken($token);
            
            if ($this->Users->save($user) && $tokenCheck = $token) 
            {
                
                
                $this->Flash->success(__('Your password has been updated. '));
                return $this->redirect(['action' => 'login']);
            }
        $this->Flash->error(__('Unable to update your password.'));
        }
    }

    

}
