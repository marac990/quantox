<?php

return [
    ['GET', '/', ['Quantox\Controllers\HomeController', 'getIndex']],
    ['GET', '/login', ['Quantox\Controllers\LoginController', 'getLogin']],
    ['POST', '/login', ['Quantox\Controllers\LoginController', 'postLogin']],
    ['GET', '/register', ['Quantox\Controllers\RegisterController', 'getRegister']],
    ['POST', '/register', ['Quantox\Controllers\RegisterController', 'postRegister']],
    ['GET', '/logout', ['Quantox\Controllers\LogoutController', 'postlogout']]
];
