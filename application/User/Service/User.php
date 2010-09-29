<?php
/**
 * Epixa - Forum
 */

namespace User\Service;

use Epixa\Service\AbstractDoctrineService,
    User\Model\Session,
    Epixa\Exception\NotFoundException,
    InvalidArgumentException,
    Doctrine\ORM\NoResultException;

/**
 * @category   Module
 * @package    User
 * @subpackage Service
 * @copyright  2010 epixa.com - Court Ewing
 * @license    http://github.com/epixa/Epixa/blob/master/LICENSE New BSD
 * @author     Court Ewing (court@epixa.com)
 */
class User extends AbstractDoctrineService
{
    /**
     * Attempt to login with the given credentials
     * 
     * @param  array $credentials
     * @return Session
     * @throws InvalidArgumentException If insufficent crendetials are provided
     * @throws NotFoundException If no user is found with those credentials
     */
    public function login(array $credentials)
    {
        if (!isset($credentials['username'])
            || !isset($credentials['password'])) {
            throw new InvalidArgumentException(
                'A username and password are required for login'
            );
        }

        $em   = $this->getEntityManager();
        $repo = $em->getRepository('User\Model\Auth');

        $qb = $repo->createQueryBuilder('ua');
        
        $repo->includeUser($qb);
        $repo->restrictToLoginId($qb, $credentials['username']);

        try {
            $auth = $qb->getQuery()->getSingleResult();
            if (!$auth->comparePassword($credentials['password'])) {
                // TODO: Failed login attempts
                throw new NoResultException('Password does not match');
            }
        } catch (NoResultException $e) {
            throw new NotFoundException('Invalid credentials', null, $e);
        }

        return new Session($auth->user);
    }
}