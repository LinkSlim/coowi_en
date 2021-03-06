<?php

/**
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link      http://cakephp.org CakePHP(tm) Project
 * @since     0.2.9
 * @license   http://www.opensource.org/licenses/mit-license.php MIT License
 */

namespace App\Controller;

use Cake\Controller\Controller;
use Cake\Event\Event;
use Cake\Network\Session;

/**
 * Application Controller
 *
 * Add your application-wide methods in the class below, your controllers
 * will inherit them.
 *
 * @link http://book.cakephp.org/3.0/en/controllers.html#the-app-controller
 */
class AppController extends Controller {
    
    //Constantes para los roles de usuarios
    const BASICO = 1;
    const PRO = 2;
    const ADMIN = 3;
    const LINK_MY_OFFERS = "http://localhost/coowi_en/offers/";
    const LINK_MY_PETITIONS = "http://localhost/coowi_en/petitions/";
    const LINK_MY_USER = "http://localhost/coowi_en/users/view/";
    const LINK_LOGOUT = "http://localhost/coowi_en/users/logout";
    const LINK_GESTION_USUARIOS = "http://localhost/coowi_en/users/";
    const LINK_GESTION_ETIQUETAS = "http://localhost/coowi_en/tags/";
    const LINK_GESTION_COMENTARIOS = "http://localhost/coowi_en/rates/";
    

    /**
     * Initialization hook method.
     *
     * Use this method to add common initialization code like loading components.
     *
     * e.g. `$this->loadComponent('Security');`
     *
     * @return void
     */
    public function initialize() {
        parent::initialize();
                
        $this->loadComponent('RequestHandler');
        $this->loadComponent('Flash');
        $this->loadComponent('Auth', [
            'authorize' => ['Controller'], // Para controlar la Autorizacion de accesos a contenidos de otros usuarios.
            'authenticate' => [
                'Form' => [
                    'fields' => [
                        'username' => 'email',
                        'password' => 'password'
                    ]
                ]
            ],
            'loginAction' => [
                'controller' => 'Users',
                'action' => 'login'
            ]
        ]);

        // Allow the display action so our pages controller
        // continues to work.
        $this->Auth->allow(['display']);
        
        
    }
    
    public function setLayout(){
        //Cambia el Layout en funcion de si hay usuario logeado o no
//        if (is_null($this->request->session()->read('Auth.User.id'))) {
//            $this->viewBuilder()->layout('public');
//        }
//        else {
//            $this->viewBuilder()->layout('private');
//        }
        if ($this->Auth->user('id')) {
            switch ($this->Auth->user('rol_id')) {
                case 1:
                    $this->viewBuilder()->layout('private_basic');
                    break;
                case 2:
                    $this->viewBuilder()->layout('private_pro');
                    break;
                case 3:
                    $this->viewBuilder()->layout('private_admin');
                    break;
            }
        } else {
            $this->viewBuilder()->layout('public');
        }
    }

    public function isAuthorized($user) { //Un usuario esta autorizado si tiene un rol establecido y dicho rol es el del 'admin' (aunque aqui lo determinamos usando su id en vez del nombre del rol)
        // Admin can access every action
        if (isset($user['rol_id']) && $user['rol_id'] == self::ADMIN) { 
            return true;
        }

        // Default deny
        return false;
    }

    /**
     * Before render callback.
     *
     * @param \Cake\Event\Event $event The beforeRender event.
     * @return void
     */
    public function beforeRender(Event $event) {
        if (!array_key_exists('_serialize', $this->viewVars) &&
                in_array($this->response->type(), ['application/json', 'application/xml'])
        ) {
            $this->set('_serialize', true);
        }
    }
    
    public function beforeFilter(Event $event) {
        $this->Auth->allow(['logout', 'login']);
        $this->setLayout();
    }        

}
