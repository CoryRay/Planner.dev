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
			<h1>$_GET</h1>
			<?php var_dump($_GET); ?>

			<h1>$_POST</h1>
			<?php var_dump($_POST); ?>

			<h2>Todo List</h2>

			<ol>
 					<?php

 				    function writeToFile() {

 				    };

					$todo_items = [ //Original html hardcoded array
						'Place mom\'s spaghetti on the cat',
						'Water the cat',
						'Rub Buddha\'s belly for luck'
					];

					//opens txt file and merges it with original array
 				    $addl_items = file('data/todo_list.txt', FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
 				        $todo_items = array_merge($todo_items, $addl_items);

					foreach ($todo_items as $value) { // echoes out the original array
						echo "<li>" . $value . "</li>";
					};

					foreach ($_POST as $key => $value) { //echoes out 
						echo "<li>" . $value . "</li>";
						// $value[] = $_POST;
					};

					?>
			</ol>

			<h2>Add Item</h2>

			<form method="POST" action="todo_list.php">
				<p>
					<label for="newItem">Enter new todo item [limit one]:</label>
					<input type="text" id="newItem" name="newItem">
				</p>
				<button>Add Item</button>
			</form>
		</div>
	</body>	
</html>