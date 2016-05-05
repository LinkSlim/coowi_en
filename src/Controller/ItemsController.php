<?php
namespace App\Controller;

use App\Controller\AppController;
use App\Model\Entity\Petition;

/**
 * Items Controller
 *
 * @property \App\Model\Table\ItemsTable $Items
 */
class ItemsController extends AppController
{

    /**
     * Index method
     *
     * @return \Cake\Network\Response|null
     */
    public function index()
    {
        $this->paginate = [
            'contain' => ['Petitions']
        ];
        $items = $this->paginate($this->Items);

        $this->set(compact('items'));
        $this->set('_serialize', ['items']);
    }

    /**
     * View method
     *
     * @param string|null $id Item id.
     * @return \Cake\Network\Response|null
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $item = $this->Items->get($id, [
            'contain' => ['Petitions', 'Tags', 'Offers']
        ]);

        $this->set('item', $item);
        $this->set('_serialize', ['item']);
    }

    /**
     * Add method
     *
     * @return \Cake\Network\Response|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $item = $this->Items->newEntity();
        if ($this->request->is('post')) {
            $item = $this->Items->patchEntity($item, $this->request->data);
            if ($this->Items->save($item)) {
                $this->Flash->success(__('The item has been saved.'));
                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('The item could not be saved. Please, try again.'));
            }
        }
        $petitions = $this->Items->Petitions->find('list', ['limit' => 200]);
        $tags = $this->Items->Tags->find('list', ['limit' => 200]);
        $this->set(compact('item', 'petitions', 'tags'));
        $this->set('_serialize', ['item']);
    }

    /**
     * Edit method
     *
     * @param string|null $id Item id.
     * @return \Cake\Network\Response|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $item = $this->Items->get($id, [
            'contain' => ['Tags']
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $item = $this->Items->patchEntity($item, $this->request->data);
            if ($this->Items->save($item)) {
                $this->Flash->success(__('The item has been saved.'));
                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('The item could not be saved. Please, try again.'));
            }
        }
        $petitions = $this->Items->Petitions->find('list', ['limit' => 200]);
        $tags = $this->Items->Tags->find('list', ['limit' => 200]);
        $this->set(compact('item', 'petitions', 'tags'));
        $this->set('_serialize', ['item']);
    }

    /**
     * Delete method
     *
     * @param string|null $id Item id.
     * @return \Cake\Network\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $item = $this->Items->get($id);
        if ($this->Items->delete($item)) {
            $this->Flash->success(__('The item has been deleted.'));
        } else {
            $this->Flash->error(__('The item could not be deleted. Please, try again.'));
        }
        return $this->redirect(['action' => 'index']);
    }
    
    public function isAuthorized($user) {

    	$itemId = (int) $this->request->params['pass'][0];

    	$this->loadModel('Petitions');
    	$query = $this->Petitions->find('all') ->innerJoin(
    			['Items' => 'items'],//nombre tabla con la que hace JOIN
    			[
    					'Petitions.id = Items.petition_id',	//Condiciones JOIN (se pueden poner varias separandolas por comas)
    					'Items.id = '.$itemId	//Condiciones JOIN
    			])->toArray();	    
	    
	    
	    $petitionId = $query[0]->petition_id;
	    $userIdPetition = $query[0]->user_id;

	    //Un item es accesible por el usuario dueño de la peticion que lo contiene y por el creador de dicho item
        if (in_array($this->request->action, ['edit', 'delete', 'view'])) {
        	//Si es el creador del item
            if ($this->Items->isOwnedBy($itemId, $user['id'])) {
                return true;
            }            
            //Si es el propietario de la peticion que contiene el item
            if ($this->Items->itemBelongsToPetitionFromUser($user['id'], $userIdPetition)) {
                return true;
            }
        }

        return parent::isAuthorized($user);
    }
    
    
}
