<?php

namespace Quantox\Controllers;

use Http\Request;
use Http\Response;
use Quantox\Helpers\FlashMessages;
use Quantox\Repositories\UserRepository;
use Quantox\Templates\Renderer;

class HomeController
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

    public function getIndex( FlashMessages $msg, UserRepository $userRepository )
    {
        if ( $msg->hasMessages() ) {
            $msg->display();
        }
        if (!empty($_SESSION['user_id'])) {
            $user = $userRepository->getUser( $_SESSION['user_id'] );
        } else {
            $user = false;
        }

        if ( ( $keyword = $this->request->getParameter('search') ) ) {
            $users = $userRepository->getUsers( $keyword );
        }  else {
            $users = false;
        }

        if ( ( $this->request->getParameter('search') ) && !$user ) {
            $this->msg->error('You must be logged in to see the registered users');
        }
        $data = [
            'users' => $users,
            'user' => $user
        ];
        $html = $this->renderer->render('home', $data);

        $this->response->setContent($html);
    }
}