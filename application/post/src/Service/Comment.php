<?php
/**
 * Epixa - Forum
 */

namespace Post\Service;

use Epixa\Service\AbstractDoctrineService,
    Post\Model\Comment as CommentModel,
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
class Comment extends AbstractDoctrineService
{
    /**
     * Get from the database the comment that is identified by the given id
     * 
     * @param  integer $id
     * @return null|CommentModel
     * @throws InvalidArgumentException If id is not valid
     */
    public function get($id)
    {
        if (!$id) {
            throw new InvalidArgumentException('Cannot retrieve a comment without an id');
        }
        
        $em   = $this->getEntityManager();
        $repo = $em->getRepository('Post\Model\Comment');
        
        $qb = $repo->createQueryBuilder('pc');

        $repo->restrictToId($qb, $id);

        try {
            $comment = $qb->getQuery()->getSingleResult();
        } catch (NoResultException $e) {
            $comment = null;
        }

        return $comment;
    }
    
    /**
     * Add a new comment with the given data
     * 
     * @param  array $data
     * @return CommentModel
     */
    public function add(array $data)
    {
        $auth = Auth::getInstance();
        if (!$auth->hasIdentity()) {
            throw new LogicException('Cannot add a new comment without being logged in');
        }
        
        $data['createdBy'] = $auth->getIdentity();
        
        $comment = new CommentModel($data);
        
        $em = $this->getEntityManager();
        $em->persist($comment);
        $em->flush();
        
        return $comment;
    }
    
    /**
     * Edit the given comment with the provided data
     * 
     * @param CommentModel $comment
     * @param array        $data 
     */
    public function edit(CommentModel $comment, array $data)
    {
        $em = $this->getEntityManager();
        if (!$em->contains($comment)) {
            throw new InvalidArgumentException('Comment is not managed by the entity manager');
        }
        
        $comment->populate($data);
        
        $em->flush();
    }
    
    /**
     * Delete the given comment from the database
     * 
     * @param CommentModel $comment
     */
    public function delete(CommentModel $comment)
    {
        $em = $this->getEntityManager();
        $em->remove($comment);
        $em->flush();
    }
}