<?php
require_once 'config.php';

function deleteItem(array $idItem): array
{
    if (checkFileTodo() && array_key_exists('id', $idItem)) {
        $todoList = json_decode(file_get_contents(TODO_FILE), true);

        foreach ($todoList as $key => &$todoItem) {

            if ($todoItem['id'] == $idItem['id']) {
                unset($todoList[$key]);
            }

            if ($todoItem['id'] > $idItem['id']) {
                $todoItem['id']--;
            }

        }
        reduceLastId();
        file_put_contents(TODO_FILE, json_encode($todoList, JSON_PRETTY_PRINT));
        
        return ['ok' => true];
    }
    throw new Exception('Could not delete');
}

function checkFileTodo()
{
    return file_exists(TODO_FILE) && filesize(TODO_FILE) != 2;
}

function reduceLastId()
{
    if (intval(file_get_contents(ID_FILE)) != 0) {
        $lastId = intval(file_get_contents(ID_FILE));
        file_put_contents(ID_FILE, --$lastId);
    }
}

$jsonData = file_get_contents('php://input');
deleteItem(json_decode($jsonData, true));