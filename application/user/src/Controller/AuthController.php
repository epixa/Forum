<?php
/**
 * Epixa - Forum
 */

namespace User\Controller;

use Epixa\Controller\AbstractController,
    User\Form\Login as LoginForm,
    User\Service\User as UserService,
    Epixa\Exception\NotFoundException,
    Zend_Auth as Authenticator;

/**
 * User authentication controller
 *
 * @category   Module
 * @package    User
 * @subpackage Controller
 * @copyright  2011 epixa.com - Court Ewing
 * @license    http://github.com/epixa/Forum/blob/master/LICENSE New BSD
 * @author     Court Ewing (court@epixa.com)
 */
class AuthController extends AbstractController
{
    /**
     * Log in a user
     */
    public function loginAction()
    {
        $request = $this->getRequest();

        $form = new LoginForm();
        $this->view->form = $form;

        if (!$request->isPost() || !$form->isValid($request->getPost())) {
            return;
        }

        try {
            $service = new UserService();
            $session = $service->login($form->getValues());
        } catch (NotFoundException $e) {
            $form->addError('Could not find a user with those credentials');
            return;
        }

        Authenticator::getInstance()->getStorage()->write($session);

        $this->_helper->redirector->gotoUrlAndExit('/');
    }

    /**
     * Logs out the current user.
     */
    public function logoutAction()
    {
        Authenticator::getInstance()->clearIdentity();

        $this->_helper->redirector->gotoUrlAndExit('/');
    }
}