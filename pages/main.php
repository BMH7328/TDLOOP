<?php 

    $tasks = [];

    $db = new DB();
    $auth = new Auth();
    $tasks = $db->fetchAll('SELECT * FROM todo');

    require "parts/header.php";
?>
  <div class="card rounded shadow-sm mx-auto my-4" style="max-width: 500px;">
        <div class="card-body">
            <h3 class="card-title mb-3">My Todo List</h3>
            <div class="d-flex gap-3">
                <?php if ( isset( $_SESSION["user"] ) ) { ?>
                    
                <?php } else { ?>
                    <a href="/login">Login</a>
                    <a href="/signup">Sign Up</a>
                <?php } ?>
            </div>

  <?php if ( isset( $_SESSION["user"] ) ) { ?>
        <ul class="list-group">
          <?php foreach ($tasks as $task) : ?>
            <li class="list-group-item d-flex justify-content-between align-items-center">
              <div>
                <form method="POST" action="/task/update">
                  <input 
                      type="hidden"
                      name="completed"
                      value="<?= $task["completed"]; ?>"
                      />
                      <input 
                        type="hidden"
                        name="task_id"
                        value="<?= $task["id"]; ?>"
                      />

                  <?php if($task['completed'] == 1) {
                      echo '<button class="btn btn-sm btn-success">'.'<i class="bi bi-check-square"></i>'.'</button>'.'<span class="ms-2 text-decoration-line-through">' . $task['task'] . '</span>';
                    } else {
                      echo '<button class="btn btn-sm btn-light">'.'<i class="bi bi-square"></i>'.'</button>'.'<span class="ms-2">' . $task['task'] . '</span>';                    
                      }
                    ?>
                </form>
                  </div>
                  <div>
                  <form method="POST" action="/task/delete">
                      <input 
                          type="hidden"
                          name="task_id"
                          value="<?= $task["id"]; ?>"
                          />
                          <button class="btn btn-sm btn-danger">
                      <i class="bi bi-trash"></i>
                    </button>
                  </form>
                  </div>
                </li>
                <?php endforeach ?>
              </ul>
              <div class="mt-4">
            <?php require "parts/message_error.php"; ?>
            <form method="POST" action="/task/add" class="d-flex justify-content-between align-items-center">
              <input
                type="text"
                class="form-control"
                placeholder="Add new item..."
                name="task_name"
                
              />
              <button class="btn btn-primary btn-sm rounded ms-2">Add</button>
            </form> 
            <div class="d-flex justify-content-center">
        <a href="/logout">LogOut</a>
          </div>
      <?php } ?>
   
<?php

    require "parts/footer.php";