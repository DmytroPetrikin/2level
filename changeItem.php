<?php
require_once 'config.php';

function changeItem(array $newTodoItem): array
{
    if (file_exists(TODO_FILE) && array_key_exists('id', $newTodoItem)) {
        $todolist = json_decode(file_get_contents(TODO_FILE), true);

        foreach ($todolist as &$todo) {
            if (in_array($newTodoItem['id'], $todo)) {
                $todo['text'] = $newTodoItem['text'];
                $todo['checked'] = $newTodoItem['checked'];
                file_put_contents(TODO_FILE, json_encode($todolist, JSON_PRETTY_PRINT));

                return ['ok'=> true];
            }
        }
    }

    throw new Exception('No record to change found');
}

$jsonData = file_get_contents('php://input');
changeItem(json_decode($jsonData, true));





