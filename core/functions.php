<?php

function view(string $name, $data = [])
{
    extract($data, EXTR_OVERWRITE);

    return require "App/views/{$name}.view.php";
}