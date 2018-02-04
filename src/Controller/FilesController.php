<?php
namespace App\Controller;

use App\Controller\AppController;

const UPLOAD_PATH=TMP . 'uploaded' . DS;

/**
 * Files Controller
 *
 * @property \App\Model\Table\FilesTable $Files
 *
 * @method \App\Model\Entity\File[] paginate($object = null, array $settings = [])
 */
class FilesController extends AppController
{
    public function initialize() {
        parent::initialize();
        $this->Auth->allow(['fetch']);
    }
    /**
     * Index method
     *
     * @return \Cake\Http\Response|void
     */
    public function index()
    {
        $this->paginate = [
            'contain' => ['Users']
        ];
        $files = $this->paginate($this->Files);

        $this->set(compact('files'));
        $this->set('_serialize', ['files']);
    }

    /**
     * View method
     *
     * @param string|null $id File id.
     * @return \Cake\Http\Response|void
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $file = $this->Files->get($id, [
            'contain' => ['Users']
        ]);

        $this->set('file', $file);
        $this->set('_serialize', ['file']);
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $file = $this->Files->newEntity();
        if ($this->request->is('post')) {
            $file = $this->Files->patchEntity($file, $this->request->getData());
            $uploaded= $this->request->getData()['file'];
            $file->filesize=$uploaded['size'];
            $file->filename= basename(tempnam(UPLOAD_PATH,'file_'));
            $file->user_id=$this->Auth->user('id');
            $location=$file->filename;
            if(move_uploaded_file($uploaded['tmp_name'], UPLOAD_PATH . $location)
                    &&$this->Files->save($file)){
                $this->Flash->success(__('The file has been saved.'));
                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The file could not be saved. Please, try again.'));
        }
        $users = $this->Files->Users->find('list', ['limit' => 200]);
        $this->set(compact('file', 'users'));
        $this->set('_serialize', ['file']);
    }
    public function upload() {
        foreach($this->request->getData() as $key=>$uploaded){
            if(!is_array($uploaded)||!array_key_exists('tmp_name',$uploaded)){
                continue;
            }
            $file = $this->Files->newEntity();
            $file->filesize=$uploaded['size'];
            $file->mimetype=$uploaded['type'];
            $file->title=$uploaded['name'];
            $file->filename= basename(tempnam(UPLOAD_PATH,'file_'));
            $file->user_id=$this->Auth->user('id');
            $location=$file->filename;
            if(move_uploaded_file($uploaded['tmp_name'], UPLOAD_PATH . $location)
                    &&$this->Files->save($file)){
                $this->set('location','/files/fetch/'. $location);
            }
        }
        //$file->filename=;
        //$file->filesize=;
        return $this->render('upload','ajax');
    }
    public function fetch($filename) {
        $file = $this->Files->findByFilename($filename)->first();
        return $this->response->withFile(UPLOAD_PATH . $filename)->withType($file->mimetype);
    }
    /**
     * Edit method
     *
     * @param string|null $id File id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $file = $this->Files->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $file = $this->Files->patchEntity($file, $this->request->getData());
            if ($this->Files->save($file)) {
                $this->Flash->success(__('The file has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The file could not be saved. Please, try again.'));
        }
        $users = $this->Files->Users->find('list', ['limit' => 200]);
        $this->set(compact('file', 'users'));
        $this->set('_serialize', ['file']);
    }

    /**
     * Delete method
     *
     * @param string|null $id File id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $file = $this->Files->get($id);
        if ($this->Files->delete($file)) {
            $this->Flash->success(__('The file has been deleted.'));
        } else {
            $this->Flash->error(__('The file could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
