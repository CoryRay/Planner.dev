<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<link type="text/css" rel="stylesheet" href="bootstrap/css/bootstrap.min.css"/>
		<link type="text/css" rel="stylesheet" href="css/todo_list.css"/>
		<title>Todo List</title>
	</head>
	<body>
		<div class='container-fluid'>	
			<h2>Todo List</h2>

			<ol id='list'>
 					<?php

						function save_file() {
						    $handle = fopen('data/todo_list.txt', 'w');
						    $string = implode("\n", $todo_items);
						    trim(fwrite($handle, $string));
						}

	 				    function writeToFile() {

	 				    };

						//opens txt file and merges it with original array
	/* 				    $addl_items = file('data/todo_list.txt', FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
	 				        $todo_items = array_merge($todo_items, $addl_items);
	*/
	 				    //USE IF NO TODO ITEMS ARE DEFINED IN HTML
	 				    $todo_items = file('data/todo_list.txt', FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);

						foreach ($todo_items as $value) { // echoes out the original array
							echo "<li>" . $value . "</li>";
						};

/*						foreach ($_POST as $key => $value) { //echoes out 
							echo "<li>" . $value . "</li>";
							// $value[] = $_POST;
						};
*/

						if (!empty($_POST['newItem'])) {
							file_put_contents('data/todo_list.txt', $_POST['newItem']);
							$todo_items = file('data/todo_list.txt', FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
						}

					?>
			</ol>

			<h2>Add Item</h2>

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