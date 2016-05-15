<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * Jobs Controller
 *
 * @property \App\Model\Table\JobsTable $Jobs
 */
class JobsController extends AppController
{	

    /**
     * Index method
     *
     * @return \Cake\Network\Response|null
     */
    public function index()
    {
        $this->paginate = [
            'contain' => ['Users']
        ];
        $jobs = $this->paginate($this->Jobs);

        $this->set(compact('jobs'));
        $this->set('_serialize', ['jobs']);
    }

    /**
     * View method
     *
     * @param string|null $id Job id.
     * @return \Cake\Network\Response|null
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $job = $this->Jobs->get($id, [
            'contain' => ['Users']
        ]);

        $this->set('job', $job);
        $this->set('_serialize', ['job']);
    }

    /**
     * Add method
     *
     * @return \Cake\Network\Response|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
    	if(isset($_POST['cancel'])){
    		return $this->redirect(['controller' => 'Users', 'action' => 'view', $this->Auth->user('id')]);
    	}
    	
    	
        $job = $this->Jobs->newEntity();
        if ($this->request->is('post')) {
            $job = $this->Jobs->patchEntity($job, $this->request->data);
            $job->user_id = $this->Auth->user('id');
            if ($this->Jobs->save($job)) {
                $this->Flash->success(__('The job has been saved.'));
                return $this->redirect(['controller' => 'Users', 'action' => 'view', $this->Auth->user('id')]);
            } else {
                $this->Flash->error(__('The job could not be saved. Please, try again.'));
            }
        }
        $users = $this->Jobs->Users->find('list', ['limit' => 200]);
        $this->set(compact('job', 'users'));
        $this->set('_serialize', ['job']);
    }

    /**
     * Edit method
     *
     * @param string|null $id Job id.
     * @return \Cake\Network\Response|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
    	
        $job = $this->Jobs->get($id, [
            'contain' => []
        ]);        
        
        if(isset($_POST['cancel'])){
        	return $this->redirect(['controller' => 'Users', 'action' => 'view', $job->user_id]);
        }
        
        if ($this->request->is(['patch', 'post', 'put'])) {
            $job = $this->Jobs->patchEntity($job, $this->request->data);
            $job->user_id = $this->Auth->user('id');
            if ($this->Jobs->save($job)) {
                $this->Flash->success(__('The job has been saved.'));
                return $this->redirect(['controller' => 'Users', 'action' => 'view', $this->Auth->user('id')]);
            } else {
                $this->Flash->error(__('The job could not be saved. Please, try again.'));
                return $this->redirect(['controller' => 'Users', 'action' => 'view', $this->Auth->user('id')]);
            }
        }
        $users = $this->Jobs->Users->find('list', ['limit' => 200]);
        $this->set(compact('job', 'users'));
        $this->set('_serialize', ['job']);
    }

    /**
     * Delete method
     *
     * @param string|null $id Job id.
     * @return \Cake\Network\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $job = $this->Jobs->get($id);
        if ($this->Jobs->delete($job)) {
            $this->Flash->success(__('The job has been deleted.'));
            return $this->redirect(['controller' => 'Users', 'action' => 'view', $this->Auth->user('id')]);
        } else {
            $this->Flash->error(__('The job could not be deleted. Please, try again.'));
            return $this->redirect(['controller' => 'Users', 'action' => 'view', $this->Auth->user('id')]);
        }
        return $this->redirect(['action' => 'index']);
    }
    
    
//     public function beforeFilter(Event $event) {
//     	parent::beforeFilter($event);
    
//     	if(!$this->Auth->user('rol_id')){ //Si no hay usuario logged no se puede hacer nada
//     		$this->Auth->deny(['add','edit','view','delete','index']);
//     	}
//     	else{
//     		if($this->Auth->user('rol_id') == AppController::ADMIN){ //Si el usuario logged tiene rol de 'Admin', puede hacer de todo
//     			$this->Auth->allow(['index','add','edit','delete','view']);
//     		}
//     		else{ //Si el usuario logged no es 'Admin' no puede hacer add ni index, solo view, edit y delete de su usuario
//     			$this->Auth->deny(['index']);
//     			$this->Auth->allow(['add','edit','delete','view']);
//     		}
//     	}
//     }
    
    
    public function isAuthorized($user) {        
        
    	if (in_array($this->request->action, ['add'])) {
    		return true;
    	}

        // The user can edit, delete or view his own info
        if (in_array($this->request->action, ['edit', 'delete', 'view'])) {
            //$userId = (int) $this->request->params['pass'][0];
	        if ($this->Jobs->isOwnedBy($this->passedArgs[0], $user['id'])) {
	            return true;
	        }   
        }
        
        return parent::isAuthorized($user);
    }
    
}
