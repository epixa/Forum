<?php
/**
 * Epixa - Forum
 */

namespace Post\Service;

use Epixa\Service\AbstractDoctrineService,
    Post\Model\Post as PostModel,
    InvalidArgumentException,
    Doctrine\ORM\NoResultException;

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
}