<?php

return [
    ['GET', '/', ['Quantox\Controllers\HomeController', 'getIndex']],
    ['GET', '/login', ['Quantox\Controllers\LoginController', 'getLogin']],
    ['POST', '/login', ['Quantox\Controllers\LoginController', 'postLogin']],
];
