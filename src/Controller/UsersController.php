<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\I18n\Time;
use Cake\Event\Event;
use Cake\I18n\Date;
use Cake\Core\Exception;


/**
 * Users Controller
 *
 * @property \App\Model\Table\UsersTable $Users
 */
class UsersController extends AppController
{
   
//    public function initialize() {
//        parent::setLayout();        
//    }
    

    /**
     * Index method
     *
     * @return \Cake\Network\Response|null
     */
    public function index()
    {
        $this->paginate = [
            'contain' => ['Roles']
        ];
        $users = $this->paginate($this->Users);

        $this->set(compact('users'));
        $this->set('_serialize', ['users']);
    }

    /**
     * View method
     *
     * @param string|null $id User id.
     * @return \Cake\Network\Response|null
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $user = $this->Users->get($id, [
            'contain' => ['Roles', 'Jobs', 'Petitions', 'Studies']
        ]);

        $this->set('user', $user);
        $this->set('_serialize', ['user']);
    }

    /**
     * Add method
     *
     * @return \Cake\Network\Response|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $user = $this->Users->newEntity();
        if ($this->request->is('post')) {
            $user = $this->Users->patchEntity($user, $this->request->data);
            
            
            // Added this line            
            $user->date = new DateTime();
            $user->state = "activado"; //Establece el estado del usuario creado "activado" por defecto
            if ($this->Users->save($user)) {
                $this->Flash->success(__('The user has been saved.'));
                return $this->redirect(['controller' => 'users', 'action' => 'login']);
            } else {
                $this->Flash->error(__('The user could not be saved. Please, try again.'));
            }
        }
        //$roles = $this->Users->Roles->find('list', ['fields' => ['id' => 'id', 'rolname' => 'rol']]);
        $roles = $this->Users->Roles->find('list', [ //Recupero datos de la tabla de datos
        		'keyField' => 'id',
        		'valueField' => 'rol'
        ]);
        $this->set('roles', $roles); //Almaceno datos recuperados en una variable para usarlos en la vista
        $this->set(compact('user'));
        $this->set('_serialize', ['user']);
    }

    /**
     * Edit method
     *
     * @param string|null $id User id.
     * @return \Cake\Network\Response|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {    	
        $user = $this->Users->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
        	//$this->request->session()->write('Auth.User.rol_id',$user->rol_id); //No hace el cambio en la variable de sesion
        	//$_SESSION['Auth']['User']['rol_id'] = $user->rol_id; //Pongo el id del rol de la sesion del usuario al que el usuario haya marcado en el select (asi el usuario no tiene que reiniciar sesion para que se hagan cambios)
            $user = $this->Users->patchEntity($user, $this->request->data);            
            if ($this->Users->save($user)) {
                $this->Flash->success(__('The user has been saved.'));
                return $this->redirect(['action' => 'view', $id]);
            } else {
                $this->Flash->error(__('The user could not be saved. Please, try again.'));
            }
        }
        $roles = $this->Users->Roles->find('list', ['limit' => 200]);
        $this->set(compact('user', 'roles'));
        $this->set('_serialize', ['user']);       
    }

    /**
     * Delete method
     *
     * @param string|null $id User id.
     * @return \Cake\Network\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
    	try {
	        $this->request->allowMethod(['post', 'delete']);
	        $user = $this->Users->get($id);
	        if ($this->Users->delete($user)) {
	            $this->Flash->success(__('The user has been deleted.'));
	        } else {
	            $this->Flash->error(__('The user could not be deleted. Please, try again.'));
	        }
	        return $this->redirect(['action' => 'index']);
    	}catch (Exception $e){
    		$this->Flash->error(__('Accion no permitida'));
    		return $this->redirect(['controller' => 'User', 'action' => 'view']);
    	}    	
    }
    
    public function login() {
        if ($this->request->is('post')) {
            $user = $this->Auth->identify();
//             if($user->state == "desactivado"){
//             	$this->logout();
//             }
            if ($user) {
                $this->Auth->setUser($user);
                return $this->redirect(['controller' => 'petitions', 'action' => 'index']);
            }
            
            //Si el usuario no es identificado
            $this->Flash->error('Your username or password is incorrect.');
        }
    }
    
    public function logout() {
        $this->Flash->success('You are now logged out.');
        return $this->redirect($this->Auth->logout());
    }
    
    public function beforeFilter(Event $event) {
        parent::beforeFilter($event);
     
        if(!$this->Auth->user('rol_id')){ //Si no hay usuario logged, solo se puede crear usuarios (para el Registro)
            $this->Auth->allow(['add']);
            $this->Auth->deny(['edit','view','delete','index']);
        }
        else{
            if($this->Auth->user('rol_id') == AppController::ADMIN){ //Si el usuario logged tiene rol de 'Admin', puede hacer de todo
                $this->Auth->allow(['index','add','edit','delete','view']);
            }
            else{ //Si el usuario logged no es 'Admin' no puede hacer add ni index, solo view, edit y delete de su usuario
                $this->Auth->deny(['add','index']);                
            }
        }
        
            
        
        
    }
    
    public function isAuthorized($user) {        
        // All registered users can not add user
//        if (($this->request->action === 'add') || ($this->request->action === 'index')) {
//            return true;
//        }

        // The user can edit, delete or view his own info
        if (in_array($this->request->action, ['edit', 'delete', 'view'])) {
            $userId = (int) $this->request->params['pass'][0];
            if ($userId == $user['id']) {
                return true;
            }
        }
        
        return parent::isAuthorized($user);
    }

}
