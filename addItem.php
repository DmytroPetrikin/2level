<?php
require_once 'config.php';

//створюю файл де буду зберігати останній id + 1
if (!file_exists(ID_FILE)) {
    file_put_contents(ID_FILE, 0);
}

//створюю .json файл для зберігання тудушок
if (!file_exists(TODO_FILE)) {
    touch(TODO_FILE);
}

function addItem(array $array): array
{
    if (array_key_exists('text', $array)) {
        $todoList = json_decode(file_get_contents(TODO_FILE), true) ?? [];
        $id = getId();
        $todoList[] = [
            'id' => $id,
            'text' => $array['text'],
            'checked' => false,
        ];
        //записую тудушку в файл
        file_put_contents(TODO_FILE, json_encode($todoList, JSON_PRETTY_PRINT));

        return ['id' => $id];
    }
    throw new Exception('Text not found');
}

function getId()
{
    $id = intval(file_get_contents(ID_FILE))+1;
    file_put_contents(ID_FILE, $id);

    return $id;
}

$jsonData = file_get_contents('php://input');
addItem(json_decode($jsonData, true));