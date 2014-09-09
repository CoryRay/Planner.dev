<?php 
	function save_file() {
    $handle = fopen('data/todo_list.txt', 'w');
    $string = implode("\n", $todo_items);
    trim(fwrite($handle, $string));
	}

    function writeToFile() {

    };

    $todo_items = file('data/todo_list.txt', FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
 ?>
<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<link type="text/css" rel="stylesheet" href="bootstrap/css/bootstrap.min.css"/>
		<link type="text/css" rel="stylesheet" href="css/todo_list.css"/>
		<title>Todo List</title>
		<link rel="shortcut icon"
		    href="favicon.ico"
		    type="image/x-icon" />

	</head>
	<body>
		<div class='container-fluid'>	
			<h2>Todo List</h2>

			<ol id='list'>
 					<?php

						//opens txt file and merges it with original array (if defined in html)
	 				    //$addl_items = file('data/todo_list.txt', FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
	 				    //   $todo_items = array_merge($todo_items, $addl_items);

						//ADDING TO THE FILE
						if (!empty($_POST['newItem'])) {
							//refactor to make it more efficient
							file_put_contents('data/todo_list.txt', PHP_EOL . $_POST['newItem'], FILE_APPEND);
							$todo_items = file('data/todo_list.txt', FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
						} //the file_put_contents function opens, writes and closes a file

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
							// Save to file
							$string = implode(PHP_EOL, $todo_items);
							//file_put_contents adds data as a string so, the array must be imploded
							file_put_contents('data/todo_list.txt', $string);
						}

						//DISPLAYS FILE CONTENTS
						foreach ($todo_items as $key => $value) {
							echo "<li> <a href=" . "?remove=$key" . '>Complete</a> - ' . $value . "</li>";
						};
					?>
			</ol>

			<h3>Add Item</h3>

			<form method="POST" action="todo_list.php">
				<p>
					<label for="newItem">Enter new todo item:</label>
					<input type="text" id="newItem" name="newItem">
				</p>
				<button>Add Item</button>
			</form>
		</div>
	</body>	
</html>