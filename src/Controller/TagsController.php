<?php
namespace App\Controller;

use App\Controller\AppController;


/**
 * Tags Controller
 *
 * @property \App\Model\Table\TagsTable $Tags
 */
class TagsController extends AppController
{

    /**
     * Index method
     *
     * @return \Cake\Network\Response|null
     */
    public function index()
    {
        $tags = $this->paginate($this->Tags);

        $this->set(compact('tags'));
        $this->set('_serialize', ['tags']);
    }

    /**
     * View method
     *
     * @param string|null $id Tag id.
     * @return \Cake\Network\Response|null
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {              
        $tag = $this->Tags->get($id, [
            'contain' => ['Items']
        ]);

        $this->set('tag', $tag);
        $this->set('_serialize', ['tag']);
    }

    /**
     * Add method
     *
     * @return \Cake\Network\Response|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $tag = $this->Tags->newEntity();
        if ($this->request->is('post')) {
            $tag = $this->Tags->patchEntity($tag, $this->request->data);
            if ($this->Tags->save($tag)) {
                $this->Flash->success(__('The tag has been saved.'));
                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('The tag could not be saved. Please, try again.'));
            }
        }
        $items = $this->Tags->Items->find('list', ['limit' => 200]);
        $this->set(compact('tag', 'items'));
        $this->set('_serialize', ['tag']);
    }

    /**
     * Edit method
     *
     * @param string|null $id Tag id.
     * @return \Cake\Network\Response|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $tag = $this->Tags->get($id, [
            'contain' => ['Items']
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $tag = $this->Tags->patchEntity($tag, $this->request->data);
            if ($this->Tags->save($tag)) {
                $this->Flash->success(__('The tag has been saved.'));
                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('The tag could not be saved. Please, try again.'));
            }
        }
        $items = $this->Tags->Items->find('list', ['limit' => 200]);
        $this->set(compact('tag', 'items'));
        $this->set('_serialize', ['tag']);
    }

    /**
     * Delete method
     *
     * @param string|null $id Tag id.
     * @return \Cake\Network\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $tag = $this->Tags->get($id);
        if ($this->Tags->delete($tag)) {
            $this->Flash->success(__('The tag has been deleted.'));
        } else {
            $this->Flash->error(__('The tag could not be deleted. Please, try again.'));
        }
        return $this->redirect(['action' => 'index']);
    }
    
    
    public function isAuthorized($user) {

        // All registered users can add, index and search petitions
        if (($this->request->action === 'searchPetitions')) {
            return true;
        }

        // The owner of an petition can view, edit and delete it
        if (in_array($this->request->action, ['edit', 'delete', 'view'])) {
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
        
        if(!empty($this->request->query('inputTags'))){
            $tag = $this->request->query('inputTags');
            $tags = explode(' ', trim($tag));
            $tags = array_diff($tags, array(''));
            foreach ($tags as $tag) {
                if ($i > 0) {
                    $cond = $cond . " OR ";
                }
                $cond = $cond . " " . $this->modelClass . ".name" . " LIKE '%" . $tag . "%' ";
                $i++;
            }
        }
        $conditions = array('conditions'=> $cond);
        $this->paginate = $conditions;
        
        
        $this->loadModel("Petitions");
        $array_petitions = array();
        array_push($array_petitions, $this->Petitions->getPetitionsByTags());
        $data = array('peticionesConTags' => $array_petitions);
        $this->set($data);
        
        
        $this->set(strtolower($this->name), $this->paginate());
        $this->render('results');        
    }
}
