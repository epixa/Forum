<?php
/**
 * Epixa - Forum
 */

namespace User;

use Epixa\Application\Module\Bootstrap as ModuleBootstrap,
    User\Model\Auth,
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
     * Set up the default phpass object to be used in authentication models
     */
    public function _initPhpass()
    {
        $options = $this->getOptions();

        $iterations = isset($options['phpassIterations']) 
                    ? $options['phpassIterations']
                    : 8;
        $phpass = new Phpass($iterations);
        Auth::setDefaultPhpass($phpass);
    }
}