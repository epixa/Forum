<?php
/**
 * Epixa - Forum
 */

namespace Post;

use Epixa\Application\Module\Bootstrap as ModuleBootstrap;

/**
 * Bootstrap the post module
 *
 * @category  Module
 * @package   Post
 * @copyright 2011 epixa.com - Court Ewing
 * @license   http://github.com/epixa/Epixa/blob/master/LICENSE New BSD
 * @author    Court Ewing (court@epixa.com)
 */
class Bootstrap extends ModuleBootstrap
{
    protected $viewHelperPath = 'View/Helper';
}