<?php
/**
 * Epixa - Forum
 */

namespace User;

use Epixa\Application\Module\Bootstrap as ModuleBootstrap,
    User\Model\Auth as AuthModel,
    Zend_Auth as Authenticator,
    Epixa\Auth\Storage\Doctrine as DoctrineStorage,
    Epixa\Phpass;

/**
 * Bootstrap the user module
 *
 * @category  Module
 * @package   User
 * @copyright 2010 epixa.com - Court Ewing
 * @license   http://github.com/epixa/Epixa/blob/master/LICENSE New BSD
 * @author    Court Ewing (court@epixa.com)
 */
class Bootstrap extends ModuleBootstrap
{
    /**
     * Initialize the doctrine auth identity storage
     */
    public function _initAuthStorage()
    {
        $bootstrap = $this->getApplication()->bootstrap('doctrine');
        $em = $bootstrap->getResource('doctrine');

        $storage = new DoctrineStorage($em, 'User\Model\Session');
        Authenticator::getInstance()->setStorage($storage)->getIdentity();
    }

    /**
     * Set up the default phpass object to be used in authentication models
     */
    public function _initPhpass()
    {
        $options = $this->getOptions();

        $iterations = isset($options['phpassIterations']) 
                    ? $options['phpassIterations']
                    : 8;
        $phpass = new Phpass($iterations);
        AuthModel::setDefaultPhpass($phpass);
    }
}