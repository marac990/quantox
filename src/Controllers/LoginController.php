<?php

namespace Quantox\Controllers;

use Http\Request;
use Http\Response;
use Quantox\Helpers\FlashMessages;
use Quantox\Repositories\UserRepository;
use Quantox\Templates\Renderer;

class LoginController
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

    public function getLogin()
    {
        $html = $this->renderer->render('login');
        $this->response->setContent($html);
    }

    public function postLogin( UserRepository $userRepository )
    {
        $params = $this->request->getParameters();
        !empty( $params['email'] ) ?: $this->msg->add( 'You have to provide us with an email.', FlashMessages::ERROR );
        !empty( $params['password'] ) ?: $this->msg->add( 'You have to provide us with a password.', FlashMessages::ERROR );
        if ( $user = $userRepository->getUserByEmailAndPassword( $params['email'], $params['password'] ) ) {
            $_SESSION['user_id'] = $user['id'];
            $this->msg->success( 'You successfully logged in.' );
        } else {
            $this->msg->add( 'There is no user with the provided email and password', FlashMessages::ERROR );
        }

        $this->msg->hasErrors() ? $this->response->redirect( '/login' ) : $this->response->redirect( '/' );
    }

}