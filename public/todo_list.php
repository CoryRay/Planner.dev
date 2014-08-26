<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<title>Todo List</title>
	</head>
	<body>
		<h1>$_GET</h1>
		<?php var_dump($_GET); ?>

		<h1>$_POST</h1>
		<?php var_dump($_POST); ?>

		<h1>Todo List</h1>
		<ul>
			<li>Take the dog out</li>
			<li>Place mom's spaghetti on the cat</li>
			<li>Water the cat</li>
			<li>Rub Buddha's belly for luck</li>
			<li><?php foreach ($_POST as $key => $value) {
				echo $value;
			}?></li>
		</ul>

		<h2>Form</h2>

		<form method="POST" action="todo_list.php">
			<p>
				<label for="newItem">Enter new todo item:</label>
				<input type="text" id="newItem" name="newItem">
			</p>
			<button>Add Item</button>
		</form>
</html>