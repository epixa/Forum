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
        $form = new PostForm();
        
        $this->view->form = $form;
    }
    
    /**
     * Edit an existing post
     */
    public function editAction()
    {
        $post = $this->getCurrentPost();
        
        $this->view->post = $post;
    }
    
    /**
     * Delete an existing post
     */
    public function deleteAction()
    {
        $post = $this->getCurrentPost();
        
        $request = $this->getRequest();
        
        $this->_helper->assert->isAjax($request, 'RuntimeException');
        
        $service = new PostService();
        $service->delete($post);
        
        $this->_helper->viewRenderer->setNoRender(true);
        echo $this->view->json(array(
            'status' => 'success',
            'data' => array(
                'post' => array(
                    'title' => $post->title
                )
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