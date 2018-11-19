<?php
/**
 * Created by PhpStorm.
 * User: marac
 * Date: 11/19/2018
 * Time: 7:41 PM
 */

namespace Quantox\Model;

class HomePage
{
    public function getMessage( FlashMessages $msg )
    {
        return $msg->display();
    }
}