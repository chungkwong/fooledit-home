<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * Registry Controller
 *
 * @property \App\Model\Table\RegistryTable $Registry
 *
 * @method \App\Model\Entity\Registry[] paginate($object = null, array $settings = [])
 */
class RegistryController extends AppController
{
	public function initialize() {
		parent::initialize();
		$this->Auth->allow(['query']);
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
        $registry = $this->paginate($this->Registry);

        $this->set(compact('registry'));
        $this->set('_serialize', ['registry']);
        $this->set('admin', parent::isAdmin($this->Auth->identify()['id']));
    }

    /**
     * View method
     *
     * @param string|null $id Registry id.
     * @return \Cake\Http\Response|void
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $registry = $this->Registry->get($id, [
            'contain' => ['Users']
        ]);

        $this->set('registry', $registry);
        $this->set('_serialize', ['registry']);
        $this->set('admin', parent::isAdmin($this->Auth->identify()['id']));
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $registry = $this->Registry->newEntity();
        if ($this->request->is('post')) {
            $registry = $this->Registry->patchEntity($registry, $this->request->getData());
            $registry->user_id=$this->Auth->user()['id'];
			if ($this->Registry->save($registry)) {
                $this->Flash->success(__('The entry has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The entry could not be saved. Please, try again.'));
        }
        $users = $this->Registry->Users->find('list', ['limit' => 200]);
        $this->set(compact('registry', 'users'));
        $this->set('_serialize', ['registry']);
    }

    /**
     * Edit method
     *
     * @param string|null $id Registry id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $registry = $this->Registry->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $registry = $this->Registry->patchEntity($registry, $this->request->getData());
            $registry->user_id=$this->Auth->user()['id'];
			if ($this->Registry->save($registry)) {
                $this->Flash->success(__('The entry has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The entry could not be saved. Please, try again.'));
        }
        $users = $this->Registry->Users->find('list', ['limit' => 200]);
        $this->set(compact('registry', 'users'));
        $this->set('_serialize', ['registry']);
    }

    /**
     * Delete method
     *
     * @param string|null $id Registry id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $registry = $this->Registry->get($id);
        if ($this->Registry->delete($registry)) {
            $this->Flash->success(__('The entry has been deleted.'));
        } else {
            $this->Flash->error(__('The entry could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
	public function query(){
		$since = $this->request->getQuery('since');
		if(!$since){
	        $registry = $this->Registry->find()->toArray();
		}else{
			$registry = $this->Registry->find()->where("id>=$since")->toArray();
		}
        $this->set(compact('registry'));
        $this->set('_serialize', ['registry']);
        $this->render('query','ajax');
    }
}
