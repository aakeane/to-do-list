<?php
// Connect to database
$newDb = mysqli_connect("localhost", "root", "", "to_do_list");

// Add new task to table and database
// Create error if task is entered blank
if (isset($_POST['submit'])) {
  if (!$_POST['task']) {
    $errorMsg = "Please fill in a task";
  } else {
    $task = $_POST['task'];
    $sql = "INSERT INTO tasks (task) Values ('$task')";
    mysqli_query($newDb, $sql);
    header('location: index.php');
  }
}

// Delete task
if (isset($_GET['del_task'])) {
  $id = $_GET['del_task'];
  mysqli_query($newDb, "DELETE FROM tasks WHERE id=$id");
  header('location: index.php');
}

// Import tasks from databse
$tasks = mysqli_query($newDb, "SELECT * FROM tasks");

?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-giJF6kkoqNQ00vy+HMDP7azOuL0xtbfIcaT9wjKHr8RbDVddVHyTfAAsrekwKmP1" crossorigin="anonymous">
  <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
  <link rel="stylesheet" href="style.css">
  <title>To Do List</title>
</head>

<body>
  <form action="index.php" method="POST" class="container d-flex justify-content-evenly">
    <div>
      <input type="text" name="task" placeholder="Enter task..." id="new-task" class="form-control mt-5">
    </div>
    <div>
      <button type="submit" name="submit" class="btn btn-primary mt-5">Add New Task</button>
    </div>
  </form>


  <table class="table table-primary table-striped table-bordered container text-center my-5">
    <thead class="table-dark">
      <tr>
        <th>No.</th>
        <th>Task</th>
        <th>Action</th>
      </tr>
    </thead>

    <!-- Populate table with tasks from database -->
    <tbody>
      <?php
      $i = 1;
      while ($row = mysqli_fetch_array($tasks)) { ?>
        <tr>
          <td> <?php echo $i; ?> </td>
          <td class="task"> <?php echo $row['task']; ?> </td>
          <td class="delete">
            <a href="index.php?del_task=<?php echo $row['id']; ?>"><span class="material-icons">
                highlight_off
              </span></a>
          </td>
        </tr>
      <?php $i++;
      } ?>
    </tbody>
  </table>

  <!-- Error message if task input is entered blank -->
  <?php
  if ($errorMsg) {
    echo "<div class=\"text-center bg-danger lead p-2\"> $errorMsg </div>";
  }
  ?>

</body>

</html>