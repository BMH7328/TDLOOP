<?php

$db = new DB();

$task_name = $_POST['task_name'];

if(empty($task_name)){
    $_SESSION['error'] = "Missing List, Please Type Something Into the List";
    header("Location: /");
    exit;
}

$sql = 'INSERT INTO todo (`task`, `completed`) VALUES(:task, :completed)';

$db->insert( $sql, [
    'task'=> $task_name,
    'completed' => 0
] );

header("Location: /");
    exit;