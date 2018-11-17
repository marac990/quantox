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
        $user = $userRepository->getUserIfLoggedIn();
        $keyword = $this->request->getParameter('search');
        $users = $userRepository->getUsers( $keyword );

        $data = [
            'users' => $users,
            'user' => $user,
            'search_has_records' => $users ? true : false,
            'search' => $keyword
        ];
        $html = $this->renderer->render('home', $data);

        $this->response->setContent($html);
        if ( $msg->hasMessages() ) {
            $msg->display();
        }
    }
}