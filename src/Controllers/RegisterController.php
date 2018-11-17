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
    ) {
        $this->request = $request;
        $this->response = $response;
        $this->renderer = $renderer;
        $this->users = $users;
        $this->msg = $msg;
    }

    public function getRegister()
    {
        if ( $this->msg->hasMessages() ) {
            $this->msg->display();
        }
        $html = $this->renderer->render('register');

        $this->response->setContent($html);
    }

    public function postRegister( UserRepository $userRepository )
    {
        $params = $this->request->getParameters();
        if ( !$this->isFormValid( $params ) ) {
            $this->response->redirect('/register');
        } else {
            if ($userId =  $userRepository->saveUser( $params ) ) {
                $_SESSION['user_id'] = $userId;
                $this->msg->success('You have successfully registered.');
                $this->response->redirect('/');
            } else {
                $this->msg->error( 'A user with the specified email already exists' );
                $this->response->redirect('/register');
            }


        }
    }

    private function isFormValid( $params )
    {
        if ( empty($params['email']) || empty($params['name']) || empty($params['email2']) || empty( $params['password'] ) || empty( $params['password2'] ) ) {
            $this->msg->error('Email, Email Confirmation, Password, Password confirmation and Name are required fields');
            return false;
        }
        if ( $params['email'] != $params['email2'] ) {
            $this->msg->error('Your Email and Email confirmation must match.');
            return false;
        }
        if ( $params['password'] != $params['password2'] ) {
            $this->msg->error('Your Password and Password confirmation must match.');
            return false;
        }
        return true;

    }

}