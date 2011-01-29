<?php
/**
 * Epixa - Forum
 */

namespace Post\Controller;

use Epixa\Controller\AbstractController,
    Post\Service\Post as PostService,
    Post\Service\Comment as CommentService,
    Post\Model\Comment as CommentModel,
    Post\Form\Comment as CommentForm;

/**
 * Manage comment functionality
 *
 * @category   Module
 * @package    Post
 * @subpackage Controller
 * @copyright  2011 epixa.com - Court Ewing
 * @license    http://github.com/epixa/Forum/blob/master/LICENSE New BSD
 * @author     Court Ewing (court@epixa.com)
 */
class CommentController extends AbstractController
{
    /**
     * Create a new comment
     */
    public function addAction()
    {
        $request = $this->getRequest();
        
        $this->_helper->assert->isAjax($request);
        $this->_helper->assert->isPost($request);
        
        $form = new CommentForm();
        if (!$form->isValid($request->getPost())) {
            $this->_helper->ajax->invalid($form);
            return;
        }
        
        $service = new PostService();
        $post = $service->get($request->getPost('id', null));
        $this->_helper->assert->isset($post);
        
        $comment = $service->add($form->getValues(), $post);
        
        $this->_helper->ajax->success(array(
            'comment' => array(
                'id' => $comment->id
            )
        ));
    }
    
    /**
     * Edit an existing comment
     */
    public function editAction()
    {
        $request = $this->getRequest();
        
        $this->_helper->assert->isAjax($request);
        $this->_helper->assert->isPost($request);
        
        $comment = $this->getCurrentComment();
        
        $form = new CommentForm();
        if (!$form->isValid($request->getPost())) {
            $this->_helper->ajax->invalid($form);
            return;
        }
        
        $service = new CommentService();
        $service->edit($comment, $form->getValues());
        
        $this->_helper->ajax->success(array(
            'comment' => array(
                'id' => $comment->id
            )
        ));
    }
    
    /**
     * Delete an existing comment
     */
    public function deleteAction()
    {
        $comment = $this->getCurrentComment();
        
        $request = $this->getRequest();
        
        $this->_helper->assert->isAjax($request);
        $this->_helper->assert->isPost($request);
        
        $service = new CommentService();
        $service->delete($comment);
        
        $this->_helper->ajax->success();
    }
    
    
    /**
     * Get the current comment by the id from the request
     * 
     * @return CommentModel
     */
    public function getCurrentComment()
    {
        $service = new CommentService();
        $post = $service->get($this->getRequest()->getParam('id', null));
        
        $this->_helper->assert->isset($post, 'Epixa\Exception\NotFoundException');
        
        return $post;
    }
}