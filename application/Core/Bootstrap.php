<?php
/**
 * Epixa - Forum
 */

namespace Core;

use Epixa\Application\Module\Bootstrap as ModuleBootstrap,
    Epixa\Acl\AclManager,
    Zend_Acl as Acl,
    Core\Service\Acl as AclService,
    Epixa\Service\AbstractService;

/**
 * Bootstrap the core module
 *
 * @category  Module
 * @package   Core
 * @copyright 2010 epixa.com - Court Ewing
 * @license   http://github.com/epixa/Epixa/blob/master/LICENSE New BSD
 * @author    Court Ewing (court@epixa.com)
 */
class Bootstrap extends ModuleBootstrap
{
    /**
     * Set up the acl manager and store as the default for all services
     *
     * @return AclManager
     */
    public function _initAclManager()
    {
        $aclManager = new AclManager(new Acl(), new AclService());
        AbstractService::setDefaultAclManager($aclManager);

        return $aclManager;
    }
}