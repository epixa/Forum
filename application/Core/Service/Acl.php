<?php
/**
 * Epixa - Forum
 */

namespace Core\Service;

use Epixa\Service\AbstractDoctrineService,
    Epixa\Acl\AclService,
    Core\Model\AclRule;

/**
 * @category   Module
 * @package    Core
 * @subpackage Service
 * @copyright  2010 epixa.com - Court Ewing
 * @license    http://github.com/epixa/Epixa/blob/master/LICENSE New BSD
 * @author     Court Ewing (court@epixa.com)
 */
class Acl extends AbstractDoctrineService implements AclService
{
    /**
     * Load the specific resource information and related rules into the acl
     *
     * @param  \Zend_Acl $acl
     * @param  string     $resource
     */
    public function loadResourceRules(\Zend_Acl $acl, $resource)
    {
        if (!$acl->has($resource)) {
            $acl->addResource($resource);
        }
        
        $em   = $this->getEntityManager();
        $repo = $em->getRepository('Core\Model\Acl');

        $qb = $repo->createQueryBuilder('ca');

        $repo->restrictToResource($qb, $resource);

        foreach ($qb->getQuery()->getResults() as $rule) {
            $acl->allow(
                $rule->roleId,
                $rule->resourceId,
                $rule->privilege,
                $rule->assertion
            );
        }
    }
}