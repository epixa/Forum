<?php
/**
 * Epixa - Forum
 */

namespace Post\Repository;

use Doctrine\ORM\EntityRepository,
    Doctrine\ORM\QueryBuilder;

/**
 * @category   Module
 * @package    Post
 * @subpackage Repository
 * @copyright  2011 epixa.com - Court Ewing
 * @license    http://github.com/epixa/Epixa/blob/master/LICENSE New BSD
 * @author     Court Ewing (court@epixa.com)
 */
class Post extends EntityRepository
{
    /**
     * Restrict the given query to results that match a specific post id
     *
     * @param QueryBuilder $qb
     * @param integer      $id
     */
    public function restrictToId(QueryBuilder $qb, $id)
    {
        $qb->andWhere('p.id = :id')
           ->setParameter('id', $id);
    }
}