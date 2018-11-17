<?php

namespace Quantox\Templates;

interface Renderer
{
    public function render($template, $data = []);
}