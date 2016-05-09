<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\Event\Event;
use Cake\I18n\Date;
use Cake\I18n\Time;

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
        $this->loadModel('Offers'); //Cargo el Modelo de Ofertas para poder acceder a los datos de la tabla Ofertas usando los metodos de dicho modelo.    
        //$ofertas = $this->Offers->find('all', ['conditions' => ['Offers.item_id' => 2]]);        

        $petition = $this->Petitions->get($id, [
            'contain' => ['Users', 'Items']
        ]);
        
        $this->set('petition', $petition);
        $this->set('_serialize', ['petition']);
        
        $array_ofertas = array();
        foreach ($petition->items as $items){            
             array_push($array_ofertas, $this->Offers->find('all', ['conditions' => ['Offers.item_id' => $items->id]]));
        }
        
        $data = array(
            'color' => 'pink',
            'type' => 'sugar',
            'base_price' => 23.95,
            'hay' => true,
            'ofertasDeItem' => $array_ofertas//->count()    
        );
        $this->set($data);
        
        
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

        // All registered users can add, index and search petitions
        if (($this->request->action === 'add') || ($this->request->action === 'index') || ($this->request->action === 'searchPetitions')) {
            return true;
        }

        // The owner of an petition can view, edit and delete it
        if (in_array($this->request->action, ['edit', 'delete', 'view', 'viewOffers'])) {
            $petitionId = (int) $this->request->params['pass'][0];
            if ($this->Petitions->isOwnedBy($petitionId, $user['id'])) {
                return true;
            }
        }

        return parent::isAuthorized($user);
    }
    
    
    public function searchPetitions()
    {
        $tag = null;
        $i = 0;
        $cond = "";
        $this->autoRender = false;
        
        $this->loadModel("Tags");
        $this->loadModel("Items");
        $this->loadModel("Items_tags");
        
        //Separo los tags introducidos por el usuario y los meto en la consulta
        if(!empty($this->request->query('inputTags'))){
            $tag = $this->request->query('inputTags');
            $tags = explode(' ', trim($tag));
            $tags = array_diff($tags, array('')); //Array con los tags introducidos por el usuario en el buscador
//             foreach ($tags as $tag) {
//                 if ($i > 0) {
//                     $cond = $cond . " OR ";
//                 }
//                 $cond = $cond . " " . "tags.name" . " LIKE '%" . $tag . "%' ";
//                 $i++;
//             }
        }
        
        //TODO adaptar para hacer busqueda con varias tags
        $query = $this->Petitions->find('all')->innerJoin(
        		['Items' => 'items'],//nombre tabla con la que hace JOIN
        		[
        				'Petitions.id = Items.petition_id'	//Condiciones JOIN
        		])->innerJoin(
        				['Items_tags' => 'items_tags'],
        				[
        						'Items.id = Items_tags.item_id'
        				]
        				)->innerJoin(
        						['Tags' => 'tags'],
        						[
        								'Items_tags.tag_id = Tags.id',	//Condiciones JOIN (se pueden poner varias separandolas por comas)
        								'Tags.name LIKE '."'%$tags[0]%'"
        						]
        						);
        
        // In a controller or table method.
        foreach ($query as $petition) {
        	//echo $petition->title;
        }
        
        
        $array_petitions = array();
        array_push($array_petitions, $query);
        $data = array('peticionesConTags' => $array_petitions);
        $this->set($data);
        
        
        $this->set(strtolower($this->name), $this->paginate());
        $this->render('results');          
    }
    
    
    public function viewOffers($id = null)
    {
    	$this->loadModel('Offers'); //Cargo el Modelo de Ofertas para poder acceder a los datos de la tabla Ofertas usando los metodos de dicho modelo.
    	//$ofertas = $this->Offers->find('all', ['conditions' => ['Offers.item_id' => 2]]);
    
    	$petition = $this->Petitions->get($id, [
    			'contain' => ['Users', 'Items']
    	]);
    	
    	//Si viene del formulario para contratar una oferta
    	if ($this->request->is(['patch', 'post', 'put'])) {    		
    		    		 
    		$arrayIdOfertas = $this->extraeIdOfertas($_POST);
    		$this->contrataOfertas($arrayIdOfertas);
//     		$petition = $this->Petitions->patchEntity($petition, $this->request->data); //Puede sobrar, las ofertas ya vienen en $_POST
//     		if ($this->Petitions->save($petition)) {
//     			$this->Flash->success(__('The petition has been saved.'));
//     			return $this->redirect(['action' => 'index']);
//     		} else {
//     			$this->Flash->error(__('The petition could not be saved. Please, try again.'));
//     		}
    	}
    
    	$this->set('petition', $petition);
    	$this->set('_serialize', ['petition']);
    
    	$array_ofertas = array();
    	foreach ($petition->items as $items){
    		array_push($array_ofertas, $this->Offers->find('all', ['conditions' => ['Offers.item_id' => $items->id]]));
    	}
    
    	$data = array(
    			//'color' => 'pink',
    			//'type' => 'sugar',
    			//'base_price' => 23.95,
    			//'hay' => true,
    			'ofertasDeItem' => $array_ofertas//->count()
    	);
    	$this->set($data);    
    }
    
    
    private function extraeIdOfertas($ofertasEnPost){
    	
    	if($ofertasEnPost == null){
    		return null;
    	}
    	    	
    	$i = 0;
    	$basura = "";
    	$arrayIdOfertas = array();
    	
    	foreach ($ofertasEnPost as $posicion => $valor){
    		//$j = $ofertasEnPost[$i];
    		if($i != 0){
    			array_push($arrayIdOfertas, $valor);
    		}
    		else{
    			$i = 1;
    		}
    	}
    	
    	return $arrayIdOfertas;    	
    }
    
    private function contrataOfertas($idOfertas = null){
    	if($idOfertas == null){
    		return null;
    	}
    	
    	$this->loadModel('Offers'); //Cargo el modelo Offers para poder sacar ofertas de la BBDD
    	
    	foreach ($idOfertas as $posicion => $valor){
    		$oferta = $this->Offers->get($valor, [ //Buscar oferta en la BBDD
            	'contain' => []
        	]);
    		$oferta->state = "contratada"; //Modifico sus valores
    		$oferta->date = date("Y-m-d"); 
    		if (!$this->Offers->save($oferta)) { //Grabar la oferta modificada    			
    			$this->Flash->error(__('The offers could not be hired. Please, try again.'));
    			return $this->redirect(['action' => 'index']);
    		}    		
    	}
    	$this->Flash->success(__('The offers have been hired.'));
    	return $this->redirect(['action' => 'index']);
    }
}
