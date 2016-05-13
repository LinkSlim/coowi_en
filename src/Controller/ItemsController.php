<?php
namespace App\Controller;

use App\Controller\AppController;
use App\Model\Entity\Petition;
use Cake\Log\Log;

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
            $item->state = "activada";
            $item->accessible('user_id', true);
            $item->user_id = $_SESSION['Auth']['User']['id'];
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
    	
    	if(isset($_POST['cancel'])){
    		//El admin se redirige a la misma lista de item
    		if($_SESSION['Auth']['User']['rol_id'] == AppController::ADMIN){
    			return $this->redirect(['action' => 'index']);
    		}
    		else{ //Usuarios con otros roles se redirige a la vista aqui indicada
    			return $this->redirect(['controller' => 'Petitions', 'action' => 'view-offers', 'petition_id' => $item->petition_id]);
    		}
    	}
    	
        
        if ($this->request->is(['patch', 'post', 'put'])) {
            $item = $this->Items->patchEntity($item, $this->request->data);
            if ($this->Items->save($item)) {
                $this->Flash->success(__('The item has been saved.'));
		        
		        //El admin se redirige a la misma lista de item
		        if($_SESSION['Auth']['User']['rol_id'] == AppController::ADMIN){
		        	return $this->redirect(['action' => 'index']);
		        }
		        else{ //Usuarios con otros roles se redirige a la vista aqui indicada       	
		        	return $this->redirect(['controller' => 'Petitions', 'action' => 'view-offers', 'petition_id' => $item->petition_id]);
		        }
		        
            } else {
                $this->Flash->error(__('The item could not be saved. Please, try again.'));
            }
        }
        
        $petitions = $this->Items->Petitions->find('list', ['limit' => 200, 'conditions' => ['Petitions.id' => $item->petition_id]]);
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
    	//TODO Eliminar ofertas relacionadas
    	//TODO Eliminar en la tabla items_tags
    	//TODO Eliminar el item
    	$query = $this->Items->query();
    	
    	
        $this->request->allowMethod(['post', 'delete']);
        $item = $this->Items->get($id);
        if ($this->Items->delete($item)) {
            $this->Flash->success(__('The item has been deleted.'));
        } else {
            $this->Flash->error(__('The item could not be deleted. Please, try again.'));
        }
        
        //El admin se redirige a la misma lista de item
        if($_SESSION['Auth']['User']['rol_id'] == AppController::ADMIN){
        	return $this->redirect(['action' => 'index']);
        }
        else{ //Usuarios con otros roles se redirige a la vista aqui indicada       	
        	return $this->redirect(['controller' => 'Petitions', 'action' => 'view-offers', 'petition_id' => $item->petition_id]);
        }
        
    }
    
    public function isAuthorized($user) {
    	
    	if (in_array($this->request->params['action'], ['create'])) {
    		return true;
    	}
    	

    	if(isset($this->request->params['pass'][0])){
    		$itemId = (int) $this->request->params['pass'][0];
    	}
    	

//     	$this->loadModel('Petitions');
//     	$query = $this->Petitions->find('all') ->innerJoin(
//     			['Items' => 'items'],//nombre tabla con la que hace JOIN
//     			[
//     					'Petitions.id = Items.petition_id',	//Condiciones JOIN (se pueden poner varias separandolas por comas)
//     					'Items.id = '.$itemId	//Condiciones JOIN
//     			])->toArray();	    
	    
	    
// 	    $petitionId = $query[0]->petition_id;
// 	    $userIdPetition = $query[0]->user_id;

	    //Un item es accesible por el usuario dueño de la peticion que lo contiene y por el creador de dicho item
        if (in_array($this->request->params['action'], ['edit', 'delete', 'view'])) {
        	//Si es el creador del item
            if ($this->Items->isOwnedBy($itemId, $user['id'])) {
                return true;
            }            
            //Si es el propietario de la peticion que contiene el item
//             if ($this->Items->itemBelongsToPetitionFromUser($user['id'], $userIdPetition)) {
//                 return true;
//             }
        }

        return parent::isAuthorized($user);
    }
    
    
    /**
     * Create method
     *
     * @param int|null $id Petition id.
     * @return \Cake\Network\Response|null Redirects to create view.    
     */    
    public function create($idPetition = null)
    {
    	    	
    	$item = $this->Items->newEntity();
    	
    	if ($this->request->is('post')) {
    		$item = $this->Items->patchEntity($item, $this->request->data);
    		$item->state = "activada";
    		$item->date = date("Y-m-d");
    		$item->accessible('user_id', true);
    		$item->user_id = $_SESSION['Auth']['User']['id'];
    		$item->petition_id = $idPetition;
    		
    		if ($this->Items->save($item)) {
    			$this->Flash->success(__('The item has been saved.'));
    			return $this->redirect(['controller' => 'Petitions', 'action' => 'view-offers', 'petition_id' => $idPetition]);
    		} else {
    			$this->Flash->error(__('The item could not be saved. Please, try again.'));
    			return $this->redirect(['controller' => 'Petitions', 'action' => 'index']);
    		}
    	}
    	
    	   	
    	$petitions = $this->Items->Petitions->find('list', ['limit' => 200, 'conditions' => ['Petitions.id' => $idPetition]]);
    	$tags = $this->Items->Tags->find('list', ['limit' => 200]);
    	$this->set(compact('item', 'petitions', 'tags'));
    	$this->set('_serialize', ['item']);
    }
    
}
