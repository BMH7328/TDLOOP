<?php
    $db = new DB();

    $completed = $_POST['completed'];
    $task_id = $_POST['task_id'];

    if( $completed == 0){
        $completed = 1;
    }else if( $completed == 1){
        $completed = 0;
    }

    if (empty( $task_id )){
        $_SESSION['error'] = "Please insert something";
        header("Location: /");
        exit;
    }
    

        $db->update(
            'UPDATE todo set completed = :completed WHERE id = :id',
            [
                'completed' => $completed,
                'id' => $task_id
            ]
        );
       
        header("Location: /");
        exit;

    
    