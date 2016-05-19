<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * Rates Controller
 *
 * @property \App\Model\Table\RatesTable $Rates
 */
class RatesController extends AppController
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
        $rates = $this->paginate($this->Rates);

        $this->set(compact('rates'));
        $this->set('_serialize', ['rates']);
    }

    /**
     * View method
     *
     * @param string|null $id Rate id.
     * @return \Cake\Network\Response|null
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $rate = $this->Rates->get($id, [
            'contain' => ['Users']
        ]);

        $this->set('rate', $rate);
        $this->set('_serialize', ['rate']);
    }

    /**
     * Add method
     *
     * @return \Cake\Network\Response|void Redirects on successful add, renders view otherwise.
     */
	public function add()
    {
        $rate = $this->Rates->newEntity();
        if ($this->request->is('post')) {
            $rate = $this->Rates->patchEntity($rate, $this->request->data);
            if ($this->Rates->save($rate)) {
                $this->Flash->success(__('The rate has been saved.'));
                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('The rate could not be saved. Please, try again.'));
            }
        }
        $users = $this->Rates->Users->find('list', ['limit' => 200]);
        $this->set(compact('rate', 'users'));
        $this->set('_serialize', ['rate']);
    }

    /**
     * Edit method
     *
     * @param string|null $id Rate id.
     * @return \Cake\Network\Response|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
//     public function edit($id = null)
//     {
//     		$rate = $this->Rates->get($id, [
//             'contain' => []
//         ]);
//         if ($this->request->is(['patch', 'post', 'put'])) {
//             $rate = $this->Rates->patchEntity($rate, $this->request->data);
//             if ($this->Rates->save($rate)) {
//                 $this->Flash->success(__('The rate has been saved.'));
//                 return $this->redirect(['action' => 'index']);
//             } else {
//                 $this->Flash->error(__('The rate could not be saved. Please, try again.'));
//             }
//         }
//         $users = $this->Rates->Users->find('list', ['limit' => 200]);
//         $this->set(compact('rate', 'users'));
//         $this->set('_serialize', ['rate']);
//     }
    
    //Mantengo el edit orginial por si quiero usarlo en otro momento
    public function edit($id = null)
    {
    	if(isset($_POST['cancel'])){
    		return $this->redirect(['controller' => 'Petitions', 'action' => 'index']);
    	}
    	
    	if ($this->request->is(['patch', 'post', 'put'])) {
	    	$rates = $this->Rates->find('list', ['conditions' => ['user1_id' => $this->Auth->user('id'), 'user2_id' => $id, 'rate' => '0.0']]);    	
	    	foreach ($rates as $r){
	    		$rate = $this->Rates->get($r, [
	    				'contain' => []
	    		]);
	    	}
    		$rate = $this->Rates->patchEntity($rate, $this->request->data);
    		$rate->state = "valorado";
    		$rate->date = date("Y-m-d");
    		if ($this->Rates->save($rate)) {
    			$this->Flash->success(__('The rate has been saved.'));
    			return $this->redirect(['controller' => 'Petitions','action' => 'index', $this->Auth->user('id')]);
    		} else {
    			$this->Flash->error(__('The rate could not be saved. Please, try again.'));
    			return $this->redirect(['controller' => 'Petitions','action' => 'index', $this->Auth->user('id')]);
    		}
    	}
    	    	
    	
    	$rates = $this->Rates->find('list', ['conditions' => ['user1_id' => $this->Auth->user('id'), 'user2_id' => $id, 'rate' => '0.0']]);
    	$r = null;
    	foreach ($rates as $r){
    		$rate = $this->Rates->get($r, [
    				'contain' => []
    		]);
    	}
    	
    	if($r == null){
    		$this->Flash->error(__('The user has already been valued by this contract.'));
    		return $this->redirect(['controller' => 'Petitions','action' => 'index', $this->Auth->user('id')]);
    	}
    	
    	$users = $this->Rates->Users->find('list', ['conditions' => ['id' => $id]]);
    	$this->set(compact('rate', 'users'));
    	$this->set('_serialize', ['rate']);
    }

    /**
     * Delete method
     *
     * @param string|null $id Rate id.
     * @return \Cake\Network\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $rate = $this->Rates->get($id);
        if ($this->Rates->delete($rate)) {
            $this->Flash->success(__('The rate has been deleted.'));
        } else {
            $this->Flash->error(__('The rate could not be deleted. Please, try again.'));
        }
        return $this->redirect(['action' => 'index']);
    }
    
    
    public function isAuthorized($user) {
    
    	if (in_array($this->request->action, ['edit', 'view'])) {
    		if ($this->Rates->isOwnedBy($user['id'], $this->passedArgs[0])) {
    			return true;
    		}
    	}
    
    	return parent::isAuthorized($user);
    }
}
