<?php

$db = new DB();

$task_id = $_POST["task_id"];

if( empty( $task_id ) ) {
    $_SESSION['error'] = "Missing List";
    header( "Location: /");
    exit;
}

$db->delete(
    "DELETE FROM todo WHERE id = :id",
    [
        'id' => $task_id
    ]
);

header("Location: /");
exit;