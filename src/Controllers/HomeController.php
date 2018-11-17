<?php

namespace Quantox\Controllers;

use Http\Request;
use Http\Response;
use Quantox\Repositories\UserRepository;
use Quantox\Templates\Renderer;

class HomeController
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

    public function getIndex()
    {
        $data = [
            'users' => $this->users->getUsers(),
        ];
        $html = $this->renderer->render('home', $data);

        $this->response->setContent($html);
    }
}