<?php
/**
 * Epixa - Forum
 */

use Epixa\Application\Bootstrap as BaseBootstrap,
    Epixa\Service\AbstractDoctrineService as DoctrineService;

/**
 * Bootstrap the application
 *
 * @category  Bootstrap
 * @copyright 2010 epixa.com - Court Ewing
 * @license   http://github.com/epixa/Epixa/blob/master/LICENSE New BSD
 * @author    Court Ewing (court@epixa.com)
 */
class Bootstrap extends BaseBootstrap
{
    /**
     * Set the default entity manager for doctrine services
     */
    public function _initDoctrineService()
    {
        $em = $this->bootstrap('doctrine')->getResource('doctrine');
        DoctrineService::setDefaultEntityManager($em);
    }
}