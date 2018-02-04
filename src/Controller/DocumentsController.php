<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * Documents Controller
 *
 * @property \App\Model\Table\DocumentsTable $Documents
 *
 * @method \App\Model\Entity\Document[] paginate($object = null, array $settings = [])
 */
class DocumentsController extends AppController
{
    public function initialize() {
        parent::initialize();
        $this->loadModel('Users');
    }
    /**
     * Index method
     *
     * @return \Cake\Http\Response|void
     */
    public function index(...$path)
    {
        $this->paginate = [
            'contain' => ['ParentDocuments', 'Users']
        ];
        $root=$this->findDocumentByPath($path);
        if($root!=NULL){
            $documents = $this->paginate($this->Documents->find('children', ['for'=>$root['id']]));
        }else{
            $documents = $this->paginate($this->Documents);
        }
        $this->set(compact('documents','root'));
        $this->set('Documents', $this->Documents);
        $this->set('title', __('Documents'));
        $this->set('_serialize', ['documents']);
        $this->set('admin', parent::isAdmin($this->Auth->identify()['id']));
    }

    /**
     * View method
     *
     * @param string|null $id Document id.
     * @return \Cake\Http\Response|void
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
/*        $document = $this->Documents->get($id, [
            'contain' => ['ParentDocuments', 'Users', 'ChildDocuments']
        ]);

        $this->set('title', $document->title);
        $this->set('document', $document);
        $this->set('documents', $this->Documents);
        $this->set('_serialize', ['document']);*/
        return $this->show($this->toPath($id));
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $document = $this->Documents->newEntity();
        if ($this->request->is('post')) {
            $document = $this->Documents->patchEntity($document, $this->request->getData());
            $document->user_id=$this->Auth->user()['id'];
            if ($this->Documents->save($document)) {
                $this->Flash->success(__('The document has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The document could not be saved. Please, try again.'));
        }
        $parentDocuments = $this->Documents->ParentDocuments->find('list', ['limit' => 200]);
        $users = $this->Documents->Users->find('list', ['limit' => 200]);
        $this->set(compact('document', 'parentDocuments', 'users'));
        $this->set('_serialize', ['document']);
    }

    /**
     * Edit method
     *
     * @param string|null $id Document id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $document = $this->Documents->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $document = $this->Documents->patchEntity($document, $this->request->getData());
            if ($this->Documents->save($document)) {
                $this->Flash->success(__('The document has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The document could not be saved. Please, try again.'));
        }
        $parentDocuments = $this->Documents->ParentDocuments->find('list', ['limit' => 200]);
        $users = $this->Documents->Users->find('list', ['limit' => 200]);
        $this->set(compact('document', 'parentDocuments', 'users'));
        $this->set('_serialize', ['document']);
    }
    public function translate($id = null)
    {
        $document = $this->Documents->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $data = $this->request->getData();
            $document->_locale=$data['locale'];
            $document->title=$data['title'];
            $document->body=$data['body'];
            if ($this->Documents->save($document)) {
                $this->Flash->success(__('The translation has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The translation could not be saved. Please, try again.'));
        }
        $parentDocuments = $this->Documents->ParentDocuments->find('list', ['limit' => 200]);
        $users = $this->Documents->Users->find('list', ['limit' => 200]);
        $this->set(compact('document', 'parentDocuments', 'users'));
        $this->set('_serialize', ['document']);
    }
    /**
     * Delete method
     *
     * @param string|null $id Document id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $document = $this->Documents->get($id);
        if ($this->Documents->delete($document)) {
            $this->Flash->success(__('The document has been deleted.'));
        } else {
            $this->Flash->error(__('The document could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
    public function display($root,$remain=null) {
        $path=$remain?explode('/', $remain):(is_null($remain)?[]:['']);
        array_unshift($path,$root);
        if (!$path[sizeof($path) - 1]) {
            unset($path[sizeof($path) - 1]);
            $this->index(...$path);
            $this->render('index');
        } else {
            $this->show($path);
        }
    }
    public function show($path){
        $document=$this->findDocumentByPath($path);
        if($document!=null){
            $document->user= $this->Users->get($document->user_id);
            $this->set('title', $document->title);
            $this->set('document', $document);
            $this->set('documents', $this->Documents);
            $this->set('_serialize', ['document']);
            $this->set('admin', parent::isAdmin($this->Auth->identify()['id']));
            $this->render('view');
        }else{
            return $this->redirect(['action'=>'index'],301);
        }
    }
    private function findDocumentByPath($path) {
        $len=sizeof($path);
        if($len>0){
            $i=0;
            $curr= $this->Documents->findBySlug($path[$i++])->where('parent_id IS NULL')->first();
            if($curr==null){
                $this->Flash->error(__('{0} not found',$path[$i-1]));
                $this->response->statusCode(404);
                return NULL;
            }
            while($i<$len){
                $tmp=$this->Documents->findBySlug($path[$i++])->where(['parent_id'=>$curr->id])->first();
                if($tmp==NULL){
                    $this->Flash->error(__('{0} not found',$path[$i-1]));
                    $this->response->statusCode(404);
                    break;
                }
                $curr=$tmp;
            }
            return $curr;
        }else{
            return NULL;
        }
    }
}
