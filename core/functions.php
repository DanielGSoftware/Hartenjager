<?php

/**
 * Require a html file.
 *
 * @param string $name
 * @param array $data
 * @return mixed
 */
function view(string $name, $data = [])
{
    extract($data, EXTR_OVERWRITE);

    return require "App/views/{$name}.view.php";
}