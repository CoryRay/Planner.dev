<?php

require_once '../todo_dbconnect.php';

$offset = isset($_GET['offset']) ? intval($_GET['offset']) : 0;

////PERFORM ALL DATABASE ACTIONS BEFORE DISPLAYING IT
//ADDING TO THE DATABASE
if (!empty($_POST)) {

    $new_item = $_POST;

    $query = "INSERT INTO todo_list (todo_item)
    VALUES (:todo_item)";

    $prepare_to_add = $dbc->prepare($query);

    $prepare_to_add->bindValue(':todo_item', $_POST['newItem'], PDO::PARAM_STR);

    $prepare_to_add->execute();
}

//REMOVING FROM DATABASE
if (isset($_GET['remove'])) {
    // Define variable $keyToRemove according to value
    $keyToRemove = $_GET['remove'];

    $dbc->exec("DELETE FROM todo_list
        WHERE id = $keyToRemove");
}

//UPLOAD FILE AND ADD TO DATABASE
if (count($_FILES) > 0 && $_FILES['file1']['error'] == 0) {
    $upload_dir = 'uploads/';

    $filename = basename($_FILES['file1']['name']);

    $saved_filename = $upload_dir . $filename;

    move_uploaded_file($_FILES['file1']['tmp_name'], $saved_filename);

    $uploaded_item = file($saved_filename, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);

    $insertQuery = "INSERT INTO todo_list (todo_item)
    VALUES (:uploaded_items)";

    $prepare = $dbc->prepare($insertQuery);

    foreach ($uploaded_item as $line) {
        $prepare->bindValue(':uploaded_items', $line, PDO::PARAM_STR);

        $prepare->execute();
    }


}

//READING FROM DATABASE, SHOULD BE LAST
$stmt = $dbc->query("SELECT *
 FROM todo_list LIMIT 10 OFFSET $offset");
$row = $stmt->fetchall();

?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <link type="text/css" rel="stylesheet" href="bootstrap/css/bootstrap.min.css"/>
    <link type="text/css" rel="stylesheet" href="bootstrap/css/bootstrap-theme.min.css"/>
    <link type="text/css" rel="stylesheet" href="css/todo_list.css"/>
    <title>Todo List</title>
</head>
<body>
    <div class='container'>
        <div class="row">
            <div class="col-md-6">
                <h2>Todo List</h2>

                <!-- DISPLAY TODO LIST -->
                <ul id='list'>
                    <? foreach ($row as $key => $value) : ?>
                    <li>
                        <a href="?remove=<?= $value['id']; ?>">Complete</a> - <?= htmlspecialchars(strip_tags($value['todo_item'])); ?>
                    </li>
                    <? endforeach; ?>
                </ul>
            </div>
            <div class="col-md-6">
                <!-- ADDING ITEMS TO TODO LIST -->
                <h3>Add Item</h3>

                <form method="POST" action="todo_list.php">
                    <div class='form-group'>
                        <label for="newItem">Enter new todo item:</label>
                        <input type="text" id="newItem" class='form-control' name="newItem" autofocus required>
                    </div>
                    <div class="form-group">
                        <button class='btn btn-default'>Add Item</button>
                    </div>
                </form>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6">
                <!-- UGLY PAGINATOR -->
                <ul class="pager">
                    <? if ($offset > 0):
                    echo "<li><a href='?offset=" . ($offset - 10) . "'>Previous</a></li>";
                    else:
                        echo "<li><a class='disabled' href='#'>Previous</a></li>";
                    endif;
                    ?>
                    <? if ($offset <= count($row)):
                    echo "<li><a href='?offset=" . ($offset + 10) . "'>Next</a></li>";
                    else:
                        echo "<li><a class='disabled' href='#'>Next</a></li>";
                    endif;
                    ?>
                </ul>
            </div>
            <div class="col-md-6">
                <!-- UPLOADING A NEW LIST -->
                <h3>Upload a Todo List</h3>

                <form method="POST" enctype="multipart/form-data" action="todo_list.php">
                    <div class='form-group'>
                        <label for="file1">File to upload: </label>
                        <input type="file" id="file1" name="file1" required>
                    </div>
                    <div class="form-group">
                        <button class='btn btn-default'>Upload</button>
                    </div>
                </form>

                <?= isset($saved_filename) ? '<div class="alert alert-info" role="alert">Upload Successful!</div>' : "" ; ?>

            </div>
        </div>
    </div>
    <script src="/bootstrap/js/bootstrap.min.js"></script>
</body>
</html>