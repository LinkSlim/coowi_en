<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * Offers Controller
 *
 * @property \App\Model\Table\OffersTable $Offers
 */
class OffersController extends AppController
{

    /**
     * Index method
     *
     * @return \Cake\Network\Response|null
     */
    public function index()
    {
    	// In a controller or table method.
    	$offers = $this->Offers->find('all', ['conditions' => ['Offers.user_id' => $this->Auth->user('id')]])->contain(['Users', 'Items']);
    	
    	foreach ($offers as $o) {
    		echo $o->user->username;
    	}
    	
        $this->paginate = [
            'contain' => ['Users', 'Items']
        ];
        $offers = $this->paginate($offers);

        $this->set(compact('offers'));
        $this->set('_serialize', ['offers']);
    }

    /**
     * View method
     *
     * @param string|null $id Offer id.
     * @return \Cake\Network\Response|null
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $offer = $this->Offers->get($id, [
            'contain' => ['Items']
        ]);

        $this->set('offer', $offer);
        $this->set('_serialize', ['offer']);
    }

    /**
     * Add method
     *
     * @return \Cake\Network\Response|void Redirects on successful add, renders view otherwise.
     */
    public function add($item_id = null)
    {
    	
    	$this->loadModel("Items");
    	$item = $this->Items->get($item_id, [
    			'contain' => ['Tags']
    	]);
    	
    	if(isset($_POST['cancel'])){
    		return $this->redirect(['controller' => 'Petitions', 'action' => 'look', $item->petition_id]);
    	}
    	
    	 
    	if($item->user_id == $this->Auth->user('id')){ //Si la oferta que se quiere crear es sobre un item que pertenece al propio usuario lo rechaza 
    		$this->Flash->error(__('You can not make an offer on your item.'));
    		return $this->redirect(['controller' => 'Petitions', 'action' => 'look', $item->petition_id]);
    	}
    	
    	
        $offer = $this->Offers->newEntity();
        if ($this->request->is('post')) {
            $offer = $this->Offers->patchEntity($offer, $this->request->data);
            $offer->user_id = $this->Auth->user('id');
            $offer->item_id = $offer->items;
            $offer->state = "activada";
            $offer->date = date("Y-m-d");            
            if ($this->Offers->save($offer)) {
                $this->Flash->success(__('The offer has been saved.'));
                $this->loadModel('Items');
                $item = $this->Items->get($offer->item_id);
                return $this->redirect(['controller' => 'Petitions', 'action' => 'look', $item->petition_id]);
            } else {
                $this->Flash->error(__('The offer could not be saved. Please, try again.'));
            }
        }
		$items = $this->Offers->Items->find('list', ['conditions' => ['id' => $item_id]]);		
		$this->set(compact('offer','items'));
        $this->set('_serialize', ['offer']);
    }

    /**
     * Edit method
     *
     * @param string|null $id Offer id.
     * @return \Cake\Network\Response|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
    	
        $offer = $this->Offers->get($id, [
            'contain' => []
        ]);
        
        if($offer->state == "contratada"){
        	$this->Flash->error(__('The offer can not be edited because it is contracted.'));
        	return $this->redirect(['controller' => 'Users', 'action' => 'view', $offer->user_id]);
        }
        
        
        if ($this->request->is(['patch', 'post', 'put'])) {
            $offer = $this->Offers->patchEntity($offer, $this->request->data);
            if ($this->Offers->save($offer)) {
                $this->Flash->success(__('The offer has been saved.'));
                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('The offer could not be saved. Please, try again.'));
            }
        }
        $items = $this->Offers->Items->find('list', ['limit' => 200]);
        $this->set(compact('offer', 'items'));
        $this->set('_serialize', ['offer']);
    }

    /**
     * Delete method
     *
     * @param string|null $id Offer id.
     * @return \Cake\Network\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
    	
    	$offer = $this->Offers->get($id, [
    			'contain' => []
    	]);
    	
    	if($offer->state == "contratada"){
    		$this->Flash->error(__('The offer can not be deleted because it is contracted.'));
    		return $this->redirect(['controller' => 'Offers', 'action' => 'index']);
    	}
    	
    	
    	if($offer->state == "contratada"){
    		$this->Flash->error(__('The offer can not be deleted because it is contracted.'));
    		return $this->redirect(['controller' => 'Users', 'action' => 'view', $offer->user_id]);
    	}
    	
        $this->request->allowMethod(['post', 'delete']);
        $offer = $this->Offers->get($id);
        if ($this->Offers->delete($offer)) {
            $this->Flash->success(__('The offer has been deleted.'));
        } else {
            $this->Flash->error(__('The offer could not be deleted. Please, try again.'));
        }
        return $this->redirect(['action' => 'index']);
    }
           
    
    public function contract()
    {
    	//     	$offer = $this->Offers->get($id, [
    	//     			'contain' => []
    	//     	]);
    	$idOfertas = $_REQUEST['idsOfertas']; //Los datos tambien pueden ser enviados por la variable de sesion, puede ser mas recomendable, por GET no es muy seguro
    	$offers = $this->getOffers($idOfertas);
    	//TODO Coger nombre del item
    	//TODO Coger precio de la oferta
    	//TODO Coger nombre y telefono de due�o de la oferta
    	$items = $this->Offers->Items->find('list', ['limit' => 200]);
    	//$this->set(compact('offers', 'items'));
    	$this->set(compact('offers'));
    	$this->set('_serialize', ['offers']);
    }
    
    
    public function isAuthorized($user) {
    
    	// All registered users can add, index and search petitions
    	if (($this->request->action === 'add') || ($this->request->action === 'index') || ($this->request->action === 'searchPetitions') || ($this->request->action === 'contract')) {
    		return true;
    	}
    
    	// The owner of an offer can view, edit and delete it
    	if (in_array($this->request->action, ['delete', 'view', 'viewOffers'])) {
    		$offerId = (int) $this->request->params['pass'][0];
    		if ($this->Offers->isOwnedBy($offerId, $user['id'])) {
    			return true;
    		}
    	}
    
    	return parent::isAuthorized($user);
    }
    
    
    private function getOffer($id = null){
    	return $this->Offers->get($id);
    	//return true;
    }    
    
    private function getOffers($arrayIdOfertas){
    	 
    	if($arrayIdOfertas == null){
    		return null;
    	}
    
    	$i = 0;
    	$basura = "";
    	$arrayConOfertas = array();
    	 
    	foreach ($arrayIdOfertas as $posicion => $valor){
    		array_push($arrayConOfertas, $this->getOffer($valor));
    	}
    	 
    	return $arrayConOfertas;
    }
    
    
    

    
    
    
}
