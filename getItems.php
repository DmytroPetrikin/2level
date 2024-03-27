<?php
require_once 'config.php';

function getItems()
{
    if (file_exists(TODO_FILE)){
        $jsonFile = file_get_contents(TODO_FILE);

        return ['items' => json_decode($jsonFile, true)];
    }

    throw new Exception('Todo list not found');
}

var_dump(getItems());