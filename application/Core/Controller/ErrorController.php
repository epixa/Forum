<?php
/**
 * Epixa - Forum
 */

namespace Core\Controller;

/**
 * Error controller
 *
 * @category   Module
 * @package    Core
 * @subpackage Controller
 * @copyright  2010 epixa.com - Court Ewing
 * @license    http://github.com/epixa/Forum/blob/master/LICENSE New BSD
 * @author     Court Ewing (court@epixa.com)
 */
class ErrorController extends \Epixa\Controller\AbstractController
{
    /**
     * Handle all application level exceptions
     */
    public function errorAction()
    {
        $error = $this->_getParam('error_handler', null);
        if (null !== $error) {
            var_dump($error->exception);
        }
        
        die('<p>Core\Controller\ErrorController::errorAction()</p>');
    }
}