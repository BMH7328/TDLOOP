<?php

class Task
{
    public function add()
    {
        // init DB class
        $db = new DB();

        $task_name = $_POST['task_name'];

        // 1. check whether the $_POST['student_name'] is not empty. If is empty, show display error
        if (empty($task_name)){
            // store the error message in session
            $_SESSION['error'] = "Missing List";
            header("Location: /");
            exit;
        }
        
        // 2. add $_POST['student_name'] to database
        // recipe
        $sql = 'INSERT INTO todo (`task`,`completed`) VALUES (:task, :completed)';
        // OOP method
        $db->insert( $sql, [
            'task' => $task_name,
            'completed' => 0
        ] );
        
        // 3. redirect the user back to /
        header("Location: /");
        exit;
    }

    public function update()
    {
        // init DB class
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
    
        }


    public function delete()
    {
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
         }
    }
