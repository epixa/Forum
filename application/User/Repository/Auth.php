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
        $qb->innerJoin('a.user', 'u');
    }

    /**
     * Restrict the given query to results that match a specific loginid
     * 
     * @param QueryBuilder $qb
     * @param integer      $loginId
     */
    public function restrictToLoginId(QueryBuilder $qb, $loginId)
    {
        $qb->andWhere('a.loginid = :loginid')
           ->setParameter('loginid', $loginId);
    }

    /**
     * Restrict the given query to results that match a specific password
     * 
     * @param QueryBuilder $qb
     * @param integer      $password
     */
    public function restrictToPassword(QueryBuilder $qb, $password)
    {
        $model = new AuthModel();
        
        $qb->andWhere('a.passhash = :passhash')
           ->setParameter('passhash', $model->hashPassword($password));
    }
}