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
        if ( $this->msg->hasErrors() ) {
            $this->msg->display();
        }
        $html = $this->renderer->render('login');

        $this->response->setContent($html);
    }

    public function postLogin( UserRepository $userRepository )
    {
        $params = $this->request->getParameters();
        if ( empty( $params['email'] ) || empty( $params['password'] ) ) {
            $this->msg->error( 'Email and Password fields are required' );
            $this->response->redirect( '/login' );
        } elseIf ( !( $user = $userRepository->getUserByEmailAndPassword( $params['email'], $params['password'] ) ) ) {
           $this->msg->error('Verify that you typed the email and password correctly. A user with this email and password doesn\'t exist');
            $this->response->redirect( '/login' );
        } else {
            $user = $userRepository->getUserByEmailAndPassword( $params['email'], $params['password'] );
            $_SESSION['user_id'] = $user['id'];
            $this->msg->success( 'You successfully logged in.' );
            $this->response->redirect( '/' );
        }
    }

}