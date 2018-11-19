<?php

namespace Quantox\Controllers;

use Http\Request;
use Http\Response;
use Quantox\Helpers\FlashMessages;
use Quantox\Repositories\UserRepository;
use Quantox\Templates\Renderer;

class RegisterController
{
    protected $request;
    protected $response;
    protected $renderer;
    protected $users;
    protected $msg;

    public function __construct(
        Request $request,
        Response $response,
        Renderer $renderer,
        UserRepository $users,
        FlashMessages $msg
    )
    {
        $this->request = $request;
        $this->response = $response;
        $this->renderer = $renderer;
        $this->users = $users;
        $this->msg = $msg;
    }

    public function getRegister()
    {
        $html = $this->renderer->render('register');
        $this->response->setContent($html);
    }

    public function postRegister(UserRepository $userRepository)
    {
        $params = $this->request->getParameters();
        $this->validateForm($params);
        $userId = $userRepository->saveUser($params);
        $userId ? ($_SESSION['user_id'] = $userId) : $this->msg->add('A user with this email already exists', FlashMessages::ERROR);

        if ($this->msg->hasErrors()) {
            $this->response->redirect('/register');
        } else {
            $this->msg->add( 'You have successfully registered.', FlashMessages::SUCCESS );
            $this->response->redirect('/');
        }
    }

    private function validateForm($params)
    {
        !empty($params['email'])                      ?: $this->msg->add('Email field is required', FlashMessages::ERROR);
        !empty($params['email2'])                     ?: $this->msg->add('Email Confirmation field is required', FlashMessages::ERROR);
        !empty($params['name'])                       ?: $this->msg->add('Name field is required', FlashMessages::ERROR);
        !empty($params['password'])                   ?: $this->msg->add('Password field is required', FlashMessages::ERROR);
        !empty($params['password2'])                  ?: $this->msg->add('Password Confirmation field is required', FlashMessages::ERROR);
        ($params['email'] == $params['email2'])       ?: $this->msg->add('Emails don\'t match', FlashMessages::ERROR);
        ($params['password'] == $params['password2']) ?: $this->msg->add('Passwords don\'t match', FlashMessages::ERROR);

    }

}