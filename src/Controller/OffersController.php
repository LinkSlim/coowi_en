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
    	$query = $this->Offers->find('all')->contain(['Users']);
    	foreach ($query as $o) {
    		echo $o->user->username;
    	}
    	
        $this->paginate = [
            'contain' => ['Items']
        ];
        $offers = $this->paginate($this->Offers);

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
    public function add()
    {
        $offer = $this->Offers->newEntity();
        if ($this->request->is('post')) {
            $offer = $this->Offers->patchEntity($offer, $this->request->data);
            $offer->state = "contratada";
            $offer->date = date("Y-m-d");
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
    	//TODO Coger nombre y telefono de dueño de la oferta
    	$items = $this->Offers->Items->find('list', ['limit' => 200]);
    	//$this->set(compact('offers', 'items'));
    	$this->set(compact('offers'));
    	$this->set('_serialize', ['offers']);
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
    
    
    
    public function isAuthorized($user) {
    
    	// All registered users can add, index and search petitions
    	if (($this->request->action === 'add') || ($this->request->action === 'index') || ($this->request->action === 'searchPetitions') || ($this->request->action === 'contract')) {
    		return true;
    	}
    
    	// The owner of an offer can view, edit and delete it
    	if (in_array($this->request->action, ['edit', 'delete', 'view', 'viewOffers'])) {
    		$petitionId = (int) $this->request->params['pass'][0];
    		if ($this->Offers->isOwnedBy($offerId, $user['id'])) {
    			return true;
    		}
    	}
    
    	return parent::isAuthorized($user);
    }
    
    
    
}
