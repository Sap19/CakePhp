<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\Network\Exception\UnauthorizedException;
use Cake\Utility\Security;
use Firebase\JWT\JWT;

class ArticlesController extends AppController
{
     public function initialize()
    {
        parent::initialize();
        $this->loadComponent('RequestHandler');
        $this->Auth-> allow(['index', 'view']);
    
    
    }
    
    public function index()
    {
        $this->paginate = [
            'contain' => ['Categories', 'Users']
        ];
        $article = $this->paginate($this->Articles);
        $this->set([
            'articles' => $article,
            '_serialize' => ['articles']
        ]);
    }
    public function view($id = null)
    {
        
        $article = $this->Articles->get($id, [
            'contain' => ['Users']
        ]);
        $this->set(compact('article'));

        $article = $this->Articles->get($id);
       
            
    }
    public function add()
    {
        $article = $this->Articles->newEntity();
        if ($this->request->is('post')) {
        
            $article = $this->Articles->patchEntity($article, $this->request->getData());
            
            $article->user_id = $this->Auth->user('id');
            if ($this->Articles->save($article)) {
                $this->Flash->success(__('Your article has been saved.'));
                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('Unable to add your article.'));
        }
        $this->set('article', $article);

        $categories = $this->Articles->Categories->find('treeList');
        $this->set(compact('categories'));
    }
    public function edit($id = null)
    {
        $article = $this->Articles->get($id);
        if ($this->request->is(['post','put']))
        {
            $this->Articles->patchEntity($article, $this->request->getData());
            if ($this->Articles->save($article))
            {
                $this->Flash->success(__('Your article has been updated!'));
                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('Unable to update article!'));
        }
        $this->set('article', $article);
    }
    public function delete($id)
    {
        $this->request->allowMethod(['post', 'delete']);

        $article = $this->Articles->get($id);
        if ($this->Articles->delete($article))
        {
            $this->Flash->success(__('The article id: {0} has been deleted!', h($id)));
            return $this->redirect(['action' => 'index']);
        }
    }
    public function isAuthorized($user)
    {

    if ($this->request->getParam('action') === 'add') {
        return true;
    }
    
    if (in_array($this->request->getParam('action'), ['edit', 'delete'])) 
    {
        $articleId = (int)$this->request->getParam('pass.0');
        if ($this->Articles->isOwnedBy($articleId, $user['id'])) {
            return true;
        }
    }

    return parent::isAuthorized($user);
    }
    
}