<?php

namespace Quantox\Controllers;

use Http\Request;
use Http\Response;
use Quantox\Repositories\UserRepository;
use Quantox\Templates\Renderer;

class LoginController
{
    protected $request;
    protected $response;
    protected $renderer;
    protected $users;

    public function __construct(Request $request,
                                Response $response,
                                Renderer $renderer,
                                UserRepository $users)
    {
        $this->request = $request;
        $this->response = $response;
        $this->renderer = $renderer;
        $this->users = $users;
    }

    public function getLogin() {
        $html = $this->renderer->render('login');

        $this->response->setContent($html);
    }

    public function postLogin()
    {
        //echo $this->request->getParameter('email');
        $this->response->redirect('');
    }

}