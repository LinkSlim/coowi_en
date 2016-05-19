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

        $petition = $this->Petitions->get($id, [
            'contain' => ['Users', 'Items']
        ]);
        
        if($petition->state == "contratada"){        	
        	return $this->redirect(['action' => 'contract', $id]);
        }
        
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
    	if(isset($_POST['cancel'])){    		
    		return $this->redirect(['controller' => 'Petitions', 'action' => 'index']);
    	}
    	
        $petition = $this->Petitions->newEntity();
        if ($this->request->is('post')) {
            $petition = $this->Petitions->patchEntity($petition, $this->request->data);
            // Added this line            
            $petition->user_id = $this->Auth->user('id'); //Establece el id del usuario logueado en el campo user_id de la peticion, para que se guarde que la peticion perteneciendo al usuario logueado
            $petition->creation_date = date("Y-m-d");
            $petition->state = "activada";
            if ($this->Petitions->save($petition)) {
                $this->Flash->success(__('The petition has been saved.'));
                return $this->redirect(['action' => 'viewOffers', $petition->id]);
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
    	if(isset($_POST['cancel'])){
    		return $this->redirect(['controller' => 'Petitions', 'action' => 'index']);
    	}
    	
        $petition = $this->Petitions->get($id, [
            'contain' => []
        ]);
        
        if($petition->state == "contratada"){
        	$this->Flash->error(__('The petition can not be edited because it is contracted.'));
        	return $this->redirect(['action' => 'index']);
        }
        
        
        
        
        if ($this->request->is(['patch', 'post', 'put'])) {
            $petition = $this->Petitions->patchEntity($petition, $this->request->data);
            if ($this->Petitions->save($petition)) {
                $this->Flash->success(__('The petition has been saved.'));
                return $this->redirect(['action' => 'viewOffers', $id]);
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
    	
    	$petition = $this->Petitions->get($id, [
    			'contain' => []
    	]);
    	
    	if($petition->state == "contratada"){
        	$this->Flash->error(__('The petition can not be deleted because it is contracted.'));
        	return $this->redirect(['action' => 'index']);
        }
    	
    	//Gracias al Delete Cascade en la base de datos, al borrar una peticion se borrara todo lo que este por debajo de esta
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
        if (($this->request->action === 'add') || ($this->request->action === 'index') || ($this->request->action === 'searchPetitions') || ($this->request->action === 'contract') || ($this->request->action === 'look')) {
            return true;
        }

        // The owner of an petition can view, edit and delete it
        if (in_array($this->request->action, ['edit', 'delete', 'viewOffers'])) {
        	        
        	//Pequeño Parche (Mejorar el paso de parametros, en algunos sitios se hace de una forma y en otros de otra)
        	if(!empty($this->request->params['pass'])){
        		$petitionId = $this->request->params['pass'][0]; //El id de la peticion es pasado de diferentes formas en varias partes del codigo, por eso lo tenemos asegurarnos y comprobar en todas las posibles variables en las que puede venir dicho id de la peticion
        	}
        	else{
        		$petitionId = null;
        	}
            
            
            //El id de la peticion es pasado de diferentes formas en varias partes del codigo, por eso lo tenemos asegurarnos y comprobar en todas las posibles variables en las que puede venir dicho id de la peticion
            if($petitionId == null && $_REQUEST['petition_id'] != null){
            	$petitionId = $_REQUEST['petition_id'];
            }
            
            if(!isset($_REQUEST['petition_id'])){  //Parche para que esta variable este establecida en la vista de administrador y no aparezca un pequeño error
            	$_REQUEST['petition_id'] = -1;
            }
            if ($this->Petitions->isOwnedBy($petitionId, $user['id']) || $this->Petitions->isOwnedBy($_REQUEST['petition_id'], $user['id'])) {
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
        //TODO adaptar para buscar peticiones que no son del usuario que busca
        $query = $this->Petitions->find('all')->innerJoin( //Buscamos peticiones con items que tienen asociado el tag escrito en el campo de busqueda, no contratadas, y las cuales no son del usuario que busca 
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
        								'Tags.name LIKE '."'%$tags[0]%'",
        								'Petitions.state != "contratada"',
        								'Petitions.user_id != '.$this->Auth->user('id')
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
    	if(isset($_POST['cancel'])){
    		return $this->redirect(['controller' => 'Petitions', 'action' => 'index']);
    	}
    	
    	$this->loadModel('Offers'); //Cargo el Modelo de Ofertas para poder acceder a los datos de la tabla Ofertas usando los metodos de dicho modelo.    	
    	$this->loadModel('Items');
    	
    	//El id de la peticion es pasado de diferentes formas en varias partes del codigo, por eso lo tenemos asegurarnos y comprobar en todas las posibles variables en las que puede venir dicho id de la peticion
    	if($id == null && $_REQUEST['petition_id'] != null){ 
    		$id = $_REQUEST['petition_id'];
    	}
    	
    	$petition = $this->Petitions->get($id, [
    			'contain' => ['Users', 'Items']
    	]);
    	
    	//Si viene del formulario para contratar una oferta
    	if ($this->request->is(['patch', 'post', 'put'])) {    		
    		    		 
    		$arrayIdOfertas = $this->extraeIdOfertas($_POST);    		
     		//$petition = $this->Petitions->patchEntity($petition, $this->request->data); //Puede sobrar, las ofertas ya vienen en $_POST
    		if ($this->contrataOfertas($arrayIdOfertas)) {
    			$petition->state="contratada";
    			$this->Petitions->save($petition);
    			$arrayIdItems = array();
    			$arrayIdItems = $this->getArrayIdsDeItemsDeCadaOferta($arrayIdOfertas);    			
    			foreach($petition->items as $item){    			    			
    				if(in_array($item->name, $arrayIdItems)){
    					$item->state = "contratada";
    					$this->Items->save($item);
    				}
    				
    			}
    			$this->Flash->success(__('The offers have been hired.'));
    			return $this->redirect(['controller' => 'Petitions', 'action' => 'contract', 'idsOfertas' => $arrayIdOfertas, 'idPeticion' => $id]);
    		} else {
    			$this->Flash->error(__('The offers could not be hired. Please, try again.'));
    		}
    	}
    
    	//Si los items de la peticion tienen ofertas
    	$this->set('petition', $petition);
    	$this->set('_serialize', ['petition']);
    
    	$array_query_ofertas = array();
    	foreach ($petition->items as $item){    		
    		array_push($array_query_ofertas, $this->Offers->find('all', ['conditions' => ['Offers.item_id' => $item->id]])->contain(['Users']));
    	}
   
    	$data = array(
    			//'color' => 'pink',
    			//'type' => 'sugar',
    			//'base_price' => 23.95,
    			//'hay' => true,
    			'ofertasDeItem' => $array_query_ofertas//->count()
    	);
    	$this->set($data);    
    	
    	//Si los items de la peticion no tienen ofertas
    }
    
    
    public function contract($id = null)
    {
    	//     	$offer = $this->Offers->get($id, [
    	//     			'contain' => []
    	//     	]);
    	if($id==null){
    		$petition = $this->Petitions->get($_REQUEST['idPeticion'], [
    				'contain' => ['Users', 'Items']
    		]);
    		$this->set('petition', $petition);
    		$this->set('_serialize', ['petition']);
    		 
    		$idOfertas = $_REQUEST['idsOfertas']; //Los datos tambien pueden ser enviados por la variable de sesion, puede ser mas recomendable, por GET no es muy seguro
    		$offers = $this->getOfertasContratadas($idOfertas);
    		$this->set('offers', $offers);
    		$this->set('_serialize', ['offers']);
    	}
    	else{
    		$petition = $this->Petitions->get($id, [
    				'contain' => ['Users', 'Items']
    		]);
    		$arrayConIdsDeOfertas = array();
    		foreach($petition->items as $item){ 
    			if($item->state == "contratada"){
    				array_push($arrayConIdsDeOfertas, $item->id);
    			}
    			
    		}    		
    		$offers = $this->getOfertasContratadas($arrayConIdsDeOfertas);
    		$this->set('offers', $offers);
    		$this->set('petition', $petition);
    		$this->set('_serialize', ['petition']);
    	}
    	
    }
    
    
    public function look($id = null)
    {
    	$this->loadModel('Offers'); //Cargo el Modelo de Ofertas para poder acceder a los datos de la tabla Ofertas usando los metodos de dicho modelo.
    
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
    			//$this->Flash->error(__('The offers could not be hired. Please, try again.'));
    			//return $this->redirect(['action' => 'index']);
    			return false;
    		}    		
    	}    	
    	$this->grabaRelacionUsuarios($oferta->user_id);
    	return true;
    }
    
    
    private function getOffersUsingIdsWithExtraInfo($arrayIdOfertas){
    	
    	$this->loadModel('Offers');
    	$this->loadModel('Items');
    	$this->loadModel('Users');
    	if($arrayIdOfertas == null){
    		return null;
    	}
    
    	$arrayConOfertas = array();
    
    	foreach ($arrayIdOfertas as $posicion => $valor){    		
    		$of = $this->Offers->get($valor); //Extraigo oferta
    		$item = $this->Items->get($of->item_id); //Extraigo item con el item_id que contiene la oferta
    		$of->item_id = $item->name; //En la oferta cambio el valor del campo item_id por el nombre al que hace referencia dicho item_id
    		$user = $this->Users->get($of->user_id); //Extraigo user con el user_id que contiene la oferta
    		$of->user_id = ["id" => $of->user_id, "name" => $user->name, "phone" => $user->phone]; //En la oferta cambio el valor del campo user_id por el nombre del usuario al que hace referencia dicho user_id
    		array_push($arrayConOfertas, $of);
    	}
    
    	return $arrayConOfertas;
    }

    private function getOffersUsingArrayOffersWithExtraInfo($arrayOfertas){
    	 
    	$this->loadModel('Users');
    	if($arrayOfertas == null){
    		return null;
    	}
    
    	$arrayConOfertas = array();
    	
    	foreach ($arrayOfertas as $oferta){
    		$of = $oferta->select('user_id');
    	}
    
    	foreach ($arrayOfertas as $oferta){
    		$id = $oferta['user_id'];
    		$user = $this->Users->get($id); //Extraigo user con el user_id que contiene la oferta
    		$oferta->user_id = ["id" => $oferta->user_id, "name" => $user->name, "phone" => $user->phone]; //En la oferta cambio el valor del campo user_id por el nombre del usuario al que hace referencia dicho user_id
    		array_push($arrayConOfertas, $oferta);
    	}
    
    	return $arrayConOfertas;
    }
    
    private function getArrayIdsDeItemsDeCadaOferta($arrayIdOfertas){
    	$arrayConOfertas = array();
    	$arrayConIdsDeOfertas = array();
    	$arrayConOfertas = $this->getOffersUsingIdsWithExtraInfo($arrayIdOfertas);
    	foreach ($arrayConOfertas as $oferta){
    		array_push($arrayConIdsDeOfertas, $oferta->item_id);
    	}
    	return $arrayConIdsDeOfertas;
    }
    
    private function getOfertasContratadas($arrayConIdsDeItemsContratados){
    	
    	$this->loadModel("Items");
    	$this->loadModel("Offers");
    	foreach($arrayConIdsDeItemsContratados as $idItem){
    		$item = $this->Items->get($idItem, [ //Recupero un item con sus ofertas
    				'contain' => ['Offers']
    		]);
    		
    		$arrayOfertas = array();
    		foreach($item->offers as $oferta){ //Para cada oferta
    			if($oferta->state == "contratada"){
    				$oferta2 = $this->Offers->get($oferta->id, [ // Recupero info del usuario propietario de la oferta
    						'contain' => ['Users']
    				]);
    				$oferta->propietario = $oferta2->user->name;
    				$oferta->telefono = $oferta2->user->phone;
    				$oferta->nombreItem = $item->name;
    				array_push($arrayOfertas, $oferta);
    			}    			
    		}
    	}
    	
    	return $arrayOfertas;    	
    }
    
    private function grabaRelacionUsuarios($idUsuarioOfertor){
    	
    	$this->loadModel("Rates");
    	$rates = $this->Rates->newEntity();
    	$rates->user1_id = $this->Auth->user('id');
    	$rates->user2_id = $idUsuarioOfertor;
    	$rates->comment = "";
    	$rates->rate = 0.0;
    	$rates->date = date("Y-m-d");
    	$rates->state = "contratada"; 
    	$rates->date = date("Y-m-d");
    	if (!$this->Rates->save($rates)) { //Grabar la relacion de contrato entre usuarios, mas adelante se podra calificar y commentar y se cambiaran los campos al respect    	
    		return false;
    	}
    	
    	return true;
    }
    
}
