<?php
/**
 * Epixa - Forum
 */

namespace Post\Service;

use Epixa\Service\AbstractDoctrineService,
    Post\Model\Post as PostModel,
    Post\Form\Post as PostForm,
    InvalidArgumentException,
    LogicException,
    RuntimeException,
    Doctrine\ORM\NoResultException,
    Zend_Auth as Auth;

/**
 * @category   Module
 * @package    Post
 * @subpackage Service
 * @copyright  2011 epixa.com - Court Ewing
 * @license    http://github.com/epixa/Epixa/blob/master/LICENSE New BSD
 * @author     Court Ewing (court@epixa.com)
 */
class Post extends AbstractDoctrineService
{
    const BASE_FORM_NAMESPACE = 'Post\\Form\\Post';
    const BASE_MODEL_NAMESPACE = 'Post\\Model\\Post';
    
    
    /**
     * Get a specific form object by the given type
     * 
     * @param  string $type
     * @return PostForm
     */
    public function getFormByType($type)
    {
        if (strpos($type, '\\') !== false) {
            throw new InvalidArgumentException('Form type cannot contain backslashes');
        }
        
        $className = $this->_getFormClassNameByType($type);
        
        $form = new $className();
        $baseFormNamespace = self::BASE_FORM_NAMESPACE;
        if (!$form instanceof $baseFormNamespace) {
            throw new RuntimeException(sprintf('Form is not of type `%s`', $baseFormNamespace));
        }
        
        return $form;
    }
    
    /**
     * Get from the database the post that is identified by the given id
     * 
     * @param  integer $id
     * @return null|PostModel
     * @throws InvalidArgumentException If id is not valid
     */
    public function get($id)
    {
        if (!$id) {
            throw new InvalidArgumentException('Cannot retrieve a post without an id');
        }
        
        $em   = $this->getEntityManager();
        $repo = $em->getRepository('Post\Model\Post');
        
        $qb = $repo->createQueryBuilder('p');

        $repo->restrictToId($qb, $id);

        try {
            $post = $qb->getQuery()->getSingleResult();
        } catch (NoResultException $e) {
            $post = null;
        }

        return $post;
    }
    
    /**
     * Add a new post with the given data
     * 
     * @param  array $data
     * @return PostModel
     */
    public function add(array $data)
    {
        $auth = Auth::getInstance();
        if (!$auth->hasIdentity()) {
            throw new LogicException('Cannot add a new post without being logged in');
        }
        
        if (!isset($data['type'])) {
            throw new InvalidArgumentException('Cannot create a new post without a type');
        }
        
        $data['createdBy'] = $auth->getIdentity();
        
        $className = $this->_getModelClassNameByType($data['type']);
        $post = new $className($data);
        
        $baseModelClass = self::BASE_MODEL_NAMESPACE;
        if (!$post instanceof $baseModelClass) {
            throw new RuntimeException(sprintf('Model is not of type `%s`', $baseModelClass));
        }
        
        $em = $this->getEntityManager();
        $em->persist($post);
        $em->flush();
        
        return $post;
    }
    
    /**
     * Edit the given post with the provided data
     * 
     * @param PostModel $post
     * @param array     $data 
     */
    public function edit(PostModel $post, array $data)
    {
        $post->populate($data);
        
        $em = $this->getEntityManager();
        $em->persist($post);
        $em->flush();
    }
    
    /**
     * Delete the given post from the database
     * 
     * @param PostModel $post
     */
    public function delete(PostModel $post)
    {
        $em = $this->getEntityManager();
        $em->remove($post);
        $em->flush();
    }
    
    
    /**
     * Get the name of the post form class for a given form type
     * 
     * @param  string $type
     * @return string
     */
    protected function _getFormClassNameByType($type)
    {
        $className = self::BASE_FORM_NAMESPACE;
        if ($type != 'standard') {
            $className .= '\\' . ucfirst($type);
        }
        
        return $className;
    }
    
    /**
     * Get the name of the post model class for a given form type
     * 
     * @param  string $type
     * @return string
     */
    protected function _getModelClassNameByType($type)
    {
        $className = self::BASE_MODEL_NAMESPACE;
        if ($type != 'standard') {
            $className .= '\\' . ucfirst($type);
        }
        
        return $className;
    }
}