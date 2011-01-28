<?php
/**
 * Epixa - Forum
 */

namespace Post\Controller;

use Epixa\Controller\AbstractController,
    Post\Service\Post as PostService,
    Post\Model\Post as PostModel,
    Post\Form\Post as PostForm;

/**
 * Manage post functionality
 *
 * @category   Module
 * @package    Post
 * @subpackage Controller
 * @copyright  2011 epixa.com - Court Ewing
 * @license    http://github.com/epixa/Forum/blob/master/LICENSE New BSD
 * @author     Court Ewing (court@epixa.com)
 */
class PostController extends AbstractController
{
    /**
     * View a specific post
     */
    public function viewAction()
    {
        $post = $this->getCurrentPost();
        
        $this->view->post = $post;
    }
    
    /**
     * Create a new post
     */
    public function addAction()
    {
        $request = $this->getRequest();
        
        if (!$request->isPost()) {
            $this->view->standardForm = new PostForm();
            $this->view->linkForm = new PostForm\Link();
            return;
        }
        
        $type = $request->getPost('type', null);
        $this->_helper->assert->isset($type);
        $this->_helper->assert->isAjax($request);
        
        $service = new PostService();
        $form = $service->getFormByType($type);
        
        if (!$form->isValid($request->getPost())) {
            $this->_helper->ajax->invalid($form);
        }
        
        $post = $service->add($form->getValues());
        
        $this->_helper->ajax->success(array(
            'post' => array(
                'id'    => $post->id,
                'title' => $post->title
            )
        ));
    }
    
    /**
     * Edit an existing post
     */
    public function editAction()
    {
        $post = $this->getCurrentPost();
        
        $service = new PostService();
        $form = $service->getFormByType($post->type);
        
        $request = $this->getRequest();
        
        if (!$request->isPost()) {
            $this->view->form = $form->populate($post->toArray());
            $this->view->post = $post;
            return;
        }
        
        $this->_helper->assert->isAjax($request);
        
        if (!$form->isValid($request->getPost())) {
            $this->_helper->ajax->invalid($form);
        }
        
        $service->edit($post, $form->getValues());
        
        $this->_helper->ajax->success(array(
            'post' => array(
                'id'    => $post->id,
                'title' => $post->title
            )
        ));
    }
    
    /**
     * Delete an existing post
     */
    public function deleteAction()
    {
        $post = $this->getCurrentPost();
        
        $request = $this->getRequest();
        
        $this->_helper->assert->isAjax($request);
        $this->_helper->assert->isPost($request);
        
        $service = new PostService();
        $service->delete($post);
        
        $this->_helper->ajax->success(array(
            'post' => array(
                'title' => $post->title
            )
        ));
    }
    
    
    /**
     * Get the current post by the id from the request
     * 
     * @return PostModel
     */
    public function getCurrentPost()
    {
        $service = new PostService();
        $post = $service->get($this->getRequest()->getParam('id', null));
        
        $this->_helper->assert->isset($post, 'Epixa\Exception\NotFoundException');
        
        return $post;
    }
}