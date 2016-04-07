<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\Event\Event;

/**
 * Petitions Controller
 *
 * @property \App\Model\Table\PetitionsTable $Petitions
 */
class PetitionsController extends AppController
{
    
    public function beforeFilter(Event $event) {
        parent::beforeFilter($event);
    }
    
//    public function initialize() {
//        parent::initialize();
//        // Set the layout
//        $this->layout = 'default_custom';
//    }

    /**
     * Index method
     *
     * @return \Cake\Network\Response|null
     */
    public function index()
    {
//        $this->paginate = [
//            'contain' => ['Users']
//        ];
        $this->paginate = [
            'conditions' => [
            'Petitions.user_id' => $this->Auth->user('id'),
            ]
        ];
        $petitions = $this->paginate($this->Petitions);

        $this->set(compact('petitions'));
        $this->set('_serialize', ['petitions']);
    }

    /**
     * View method
     *
     * @param string|null $id Petition id.
     * @return \Cake\Network\Response|null
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $petition = $this->Petitions->get($id, [
            'contain' => ['Users', 'Items']
        ]);

        $this->set('petition', $petition);
        $this->set('_serialize', ['petition']);
    }

    /**
     * Add method
     *
     * @return \Cake\Network\Response|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $petition = $this->Petitions->newEntity();
        if ($this->request->is('post')) {
            $petition = $this->Petitions->patchEntity($petition, $this->request->data);
            // Added this line
            $petition->user_id = $this->Auth->user('id'); //Establece el id del usuario logueado en el campo user_id de la peticion, para que se guarde que la peticion perteneciendo al usuario logueado 
            if ($this->Petitions->save($petition)) {
                $this->Flash->success(__('The petition has been saved.'));
                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('The petition could not be saved. Please, try again.'));
            }
        }
        $users = $this->Petitions->Users->find('list', ['limit' => 200]);
        $this->set(compact('petition', 'users'));
        $this->set('_serialize', ['petition']);
    }

    /**
     * Edit method
     *
     * @param string|null $id Petition id.
     * @return \Cake\Network\Response|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $petition = $this->Petitions->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $petition = $this->Petitions->patchEntity($petition, $this->request->data);
            if ($this->Petitions->save($petition)) {
                $this->Flash->success(__('The petition has been saved.'));
                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('The petition could not be saved. Please, try again.'));
            }
        }
        $users = $this->Petitions->Users->find('list', ['limit' => 200]);
        $this->set(compact('petition', 'users'));
        $this->set('_serialize', ['petition']);
    }

    /**
     * Delete method
     *
     * @param string|null $id Petition id.
     * @return \Cake\Network\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $petition = $this->Petitions->get($id);
        if ($this->Petitions->delete($petition)) {
            $this->Flash->success(__('The petition has been deleted.'));
        } else {
            $this->Flash->error(__('The petition could not be deleted. Please, try again.'));
        }
        return $this->redirect(['action' => 'index']);
    }

    
    
    public function isAuthorized($user) {

        // All registered users can add articles
        if (($this->request->action === 'add') || ($this->request->action === 'index')) {
            return true;
        }

        // The owner of an article can edit and delete it
        if (in_array($this->request->action, ['edit', 'delete', 'view'])) {
            $petitionId = (int) $this->request->params['pass'][0];
            if ($this->Petitions->isOwnedBy($petitionId, $user['id'])) {
                return true;
            }
        }

        return parent::isAuthorized($user);
    }

    

}
