<?php
/**
 * CakePHP(tm) : Rapid Development Framework (https://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 * @link      https://cakephp.org CakePHP(tm) Project
 * @since     0.2.9
 * @license   https://opensource.org/licenses/mit-license.php MIT License
 */
namespace App\Controller;

use Cake\Controller\Controller;
use Cake\Event\Event;

/**
 * Application Controller
 *
 * Add your application-wide methods in the class below, your controllers
 * will inherit them.
 *
 * @link https://book.cakephp.org/3.0/en/controllers.html#the-app-controller
 */
class AppController extends Controller
{

    
    /**
     * Initialization hook method.
     *
     * Use this method to add common initialization code like loading components.
     *
     * e.g. `$this->loadComponent('Security');`
     *
     * 
     */
    
    public function initialize()
    {
        $this->loadComponent('RequestHandler', [
            'enableBeforeRedirect' => false
        ]);
        $this->loadComponent('Flash');
        $this->loadComponent('Auth', [
            'authenticate' => [
                'Form' => [
                    'fields' => [
                        'username' => 'username',
                        'password' => 'password'
                                ]
                        ]      
                    ],
                    'loginAction' => [
                        'controller' => 'Users',
                        'action' => 'login'
                    ],
                    'authorize' => ['Controller'],
        ]);
    }
    
    
    public function beforeFilter(Event $event)
    {
        $this->Auth->allow(['index', 'view', 'display', 'add', 'delete', 'edit']);
    }
    
    public function isAuthorized($user)
    {
    // Admin can access every action
    if (isset($user['role']) && $user['role'] === 'admin') {
        return true;
    }

    // Default deny
    return false;
    }

    /*public function beforeRender(Event $event)
    {
        if (is_object($this->Auth)) {
            if ($this->Auth->user() !== null) {
                $this->set("userLoggedIn", false);
            } else {
                $this->set("userLoggedIn", true);
            }
        }
    }*/
}
