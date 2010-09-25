<?php
/**
 * Epixa - Forum
 */

namespace User\Controller;

use User\Form\Login as LoginForm,
    User\Service\User as UserService,
    Epixa\Exception\NotFoundException;

/**
 * User authentication controller
 *
 * @category   Module
 * @package    User
 * @subpackage Controller
 * @copyright  2010 epixa.com - Court Ewing
 * @license    http://github.com/epixa/Forum/blob/master/LICENSE New BSD
 * @author     Court Ewing (court@epixa.com)
 */
class AuthController extends \Epixa\Controller\AbstractController
{
    /**
     * Log in a user
     */
    public function loginAction()
    {
        $request = $this->getRequest();

        $form = LoginForm();
        $this->view->form = $form;

        if (!$request->isPost() || $form->isValid($request->getPost())) {
            return;
        }

        try {
            $service = new UserService();
            $user = $service->login($form->getValues());
        } catch (NotFoundException $e) {
            $msg = 'Could not find a user with those credentials';
            $form->setErrorMessage($msg);
            return;
        }

        Zend_Auth::getInstance()->getStorage()->write($user);

        $this->_helper->redirector->gotoUrlAndExit('/');
    }

    /**
     * Logs out the current user.
     */
    public function logoutAction()
    {
        Zend_Auth::getInstance()->clearIdentity();

        $this->_helper->redirector->gotoUrlAndExit('/');
    }
}