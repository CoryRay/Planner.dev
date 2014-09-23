<?php

require_once 'inc/filestore.php';

$todo = new Filestore('data/todo_list.txt');

$todo_items = $todo->read();

//FILE UPLOAD AND WRITE TO 
if (count($_FILES) > 0 && $_FILES['file1']['error'] == 0) {
    // Set the destination directory for uploads
    $upload_dir = 'uploads/';

    // Grab the filename from the uploaded file by using basename
    $filename = basename($_FILES['file1']['name']);

    // Create the saved filename using the file's original name and our upload directory
    $saved_filename = $upload_dir . $filename;

    // Move the file from the temp location to our uploads directory
    move_uploaded_file($_FILES['file1']['tmp_name'], $saved_filename);

    //need to grab the contents of the uploaded file
    //merge with $todo_items
    //save the new todo list
    $uploaded_items = file($saved_filename, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
    $todo_items = array_merge($todo_items, $uploaded_items);
    $todo->write($todo_items);
}

//ADDING NEW ITEM TO THE FILE
if (!empty($_POST['newItem'])) {
    array_push($todo_items, $_POST['newItem']);
    $todo->write($todo_items);
}

//file_get_contents — Reads entire file into a string
//may use later ^

//REMOVE ITEMS FROM LIST
if (isset($_GET['remove'])) {
    // Define variable $keyToRemove according to value
    $keyToRemove = $_GET['remove'];
    // Remove item from array according to key specified
    unset($todo_items[$keyToRemove]);
    // Numerically reindex values in array after removing item
    $todo_items = array_values($todo_items);
    //file_put_contents adds data as a string so, the array must be imploded
    $string = implode(PHP_EOL, $todo_items);
    // Save to file
    $todo->write($todo_items);
}

?>

<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <link type="text/css" rel="stylesheet" href="bootstrap/css/bootstrap.min.css"/>
        <link type="text/css" rel="stylesheet" href="css/todo_list.css"/>
        <title>Todo List</title>
        <link rel="shortcut icon"
            href="img/donkey.ico"
            type="image/x-icon" />

    </head>
    <body>
        <div class='container-fluid'>
            <h2>Todo List</h2>

            <ol id='list'>
                <?php
                    //DISPLAYS FILE CONTENTS
                    foreach ($todo_items as $key => $value) {
                        echo "<li> <a href=" . "?remove=$key" . '>Complete</a> - ' . htmlspecialchars(strip_tags($value)) . "</li>";
                    }
                ?>
            </ol>

    <!-- ADDING ITEMS TO TODO LIST -->
            <h3>Add Item</h3>

            <form method="POST" action="todo_list.php">
                <p>
                    <label for="newItem">Enter new todo item:</label>
                    <input type="text" id="newItem" name="newItem" required>
                </p>
                <button>Add Item</button>
            </form>

    <!-- UPLOADING A NEW LIST -->
            <h3>Upload a Todo List</h3>

            <form method="POST" enctype="multipart/form-data" action="todo_list.php">
                <p>
                    <label for="file1">File to upload: </label>
                    <input type="file" id="file1" name="file1" required>
                   <p><input type="submit" value="Upload"></p>
                </p>
            </form>
            <?php 
            // VERIFY UPLOAD SUCCESSFUL
                // Check if we uploaded a file
                if (isset($saved_filename)) {
                    // If we did, show a link to the uploaded file
                    echo "Upload Successful!";
                }
            ?>
        </div>
    </body> 
</html>