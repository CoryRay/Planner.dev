<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<link type="text/css" rel="stylesheet" href="css/todo_list.css"/>
		<title>Todo List</title>
	</head>
	<body>
		<div>	
			<h1>$_GET</h1>
			<?php var_dump($_GET); ?>

			<h1>$_POST</h1>
			<?php var_dump($_POST); ?>

			<h2>Todo List</h2>
			<ul>
				<li>Take the dog out</li>
				<li>Place mom's spaghetti on the cat</li>
				<li>Water the cat</li>
				<li>Rub Buddha's belly for luck</li>
					<?php foreach ($_POST as $key => $value) {
					echo "<li>" . $value . "</li>";
					// $value[] = $_POST
				}?>
			</ul>

			<h2>Form</h2>

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