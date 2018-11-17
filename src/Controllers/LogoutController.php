<?php

namespace Quantox\Controllers;

use Http\Request;
use Http\Response;
use Quantox\Helpers\FlashMessages;
use Quantox\Templates\Renderer;

class LogoutController
{
    protected $request;
    protected $response;
    protected $renderer;
    protected $msg;

    public function __construct(
        Request $request,
        Response $response,
        Renderer $renderer,
        FlashMessages $msg
    ) {
        $this->request = $request;
        $this->response = $response;
        $this->renderer = $renderer;
        $this->msg = $msg;
    }

    public function postLogout()
    {
        $_SESSION['user_id'] = '';
        $this->msg->success( 'You successfully loged out.' );
        $this->response->redirect( '/' );
    }

}