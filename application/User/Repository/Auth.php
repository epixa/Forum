<?php
/**
 * Epixa - Forum
 */

namespace User\Repository;

use Doctrine\ORM\EntityRepository,
    Doctrine\ORM\QueryBuilder,
    User\Model\Auth as AuthModel;

/**
 * @category   Module
 * @package    User
 * @subpackage Repository
 * @copyright  2010 epixa.com - Court Ewing
 * @license    http://github.com/epixa/Epixa/blob/master/LICENSE New BSD
 * @author     Court Ewing (court@epixa.com)
 */
class Auth extends EntityRepository
{
    /**
     * Include with the supplied query the means to retrieve the user details
     * along with the authentication details
     * 
     * @param QueryBuilder $qb
     */
    public function includeUser(QueryBuilder $qb)
    {
        $qb->innerJoin('ua.user', 'u')
           ->addSelect('u');
    }

    /**
     * Restrict the given query to results that match a specific loginid
     * 
     * @param QueryBuilder $qb
     * @param integer      $loginId
     */
    public function restrictToLoginId(QueryBuilder $qb, $loginId)
    {
        $qb->andWhere('ua.loginId = :loginid')
           ->setParameter('loginid', $loginId);
    }
}