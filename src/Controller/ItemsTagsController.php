<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * ItemsTags Controller
 *
 * @property \App\Model\Table\ItemsTagsTable $ItemsTags
 */
class ItemsTagsController extends AppController
{

    /**
     * Index method
     *
     * @return \Cake\Network\Response|null
     */
    public function index()
    {
        $this->paginate = [
            'contain' => ['Tags', 'Items']
        ];
        $itemsTags = $this->paginate($this->ItemsTags);

        $this->set(compact('itemsTags'));
        $this->set('_serialize', ['itemsTags']);
    }

    /**
     * View method
     *
     * @param string|null $id Items Tag id.
     * @return \Cake\Network\Response|null
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $itemsTag = $this->ItemsTags->get($id, [
            'contain' => ['Tags', 'Items']
        ]);

        $this->set('itemsTag', $itemsTag);
        $this->set('_serialize', ['itemsTag']);
    }

    /**
     * Add method
     *
     * @return \Cake\Network\Response|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $itemsTag = $this->ItemsTags->newEntity();
        if ($this->request->is('post')) {
            $itemsTag = $this->ItemsTags->patchEntity($itemsTag, $this->request->data);
            if ($this->ItemsTags->save($itemsTag)) {
                $this->Flash->success(__('The items tag has been saved.'));
                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('The items tag could not be saved. Please, try again.'));
            }
        }
        $tags = $this->ItemsTags->Tags->find('list', ['limit' => 200]);
        $items = $this->ItemsTags->Items->find('list', ['limit' => 200]);
        $this->set(compact('itemsTag', 'tags', 'items'));
        $this->set('_serialize', ['itemsTag']);
    }

    /**
     * Edit method
     *
     * @param string|null $id Items Tag id.
     * @return \Cake\Network\Response|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $itemsTag = $this->ItemsTags->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $itemsTag = $this->ItemsTags->patchEntity($itemsTag, $this->request->data);
            if ($this->ItemsTags->save($itemsTag)) {
                $this->Flash->success(__('The items tag has been saved.'));
                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('The items tag could not be saved. Please, try again.'));
            }
        }
        $tags = $this->ItemsTags->Tags->find('list', ['limit' => 200]);
        $items = $this->ItemsTags->Items->find('list', ['limit' => 200]);
        $this->set(compact('itemsTag', 'tags', 'items'));
        $this->set('_serialize', ['itemsTag']);
    }

    /**
     * Delete method
     *
     * @param string|null $id Items Tag id.
     * @return \Cake\Network\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $itemsTag = $this->ItemsTags->get($id);
        if ($this->ItemsTags->delete($itemsTag)) {
            $this->Flash->success(__('The items tag has been deleted.'));
        } else {
            $this->Flash->error(__('The items tag could not be deleted. Please, try again.'));
        }
        return $this->redirect(['action' => 'index']);
    }
}
