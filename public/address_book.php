<?php
// THIS CHECKS THAT ALL FIELDS ARE FILLED IN
	$required = ['newName', 'newAddress', 'newCity', 'newState', 'newZip'];
	$error = false;
	foreach($required as $form) {
	  if (isset($_POST[$form])) {
	    $error = true;
	  }
	}

//CHECKS IF A NEW CONTACT WAS ADDED
	if (!empty($_POST['newName'])) {
		add_new_contact();
		// save_file($contacts);
	}

	//REMOVE ITEMS FROM LIST [[FROM TODOLIST]]
	if (isset($_GET['remove'])) {
		// Define variable $keyToRemove according to value
		$keyToRemove = $_GET['remove'];
		// Remove item from array according to key specified
		unset($contacts[$keyToRemove]);
		// Numerically reindex values in array after removing item
		$contacts = array_values($contacts);
		//file_put_contents adds data as a string so, the array must be imploded
		$string = implode(PHP_EOL, $contacts);
		// Save to file
		save_file($contacts);
	}

	$contacts = array_map('str_getcsv', file('data/contacts.csv'));
//OR
		// $handle = fopen('data/contacts.csv', 'r');
		// $contacts = [];
		// while(!feof($handle)) {
		// 	$contacts[] = fgetcsv($handle);
		// }
		// fclose($handle);

	var_dump($_POST);

	function add_new_contact() {
		//take in input
		//	$_POST
		$new_contact = $_POST;
		//open file
		$handle = fopen('data/contacts.csv', 'a');
		//write to file
		fputcsv($handle, $new_contact);
		fclose($handle);
	}



?>
<!doctype html>
<html>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Address Book</title>
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap.min.css">
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap-theme.min.css">
		<link type="text/css" rel="stylesheet" href="css/todo_list.css"/>
		<link rel="shortcut icon" href="img/book.ico" type="image/x-icon"/>
	</head>
    <body>
    	<div class='container'>
	    	<h2>Address Book</h2>
			<!-- DISPLAYS ADDRESS BOOK IN DEFINITION LIST -->
				<dl>
					<?php foreach($contacts as $key => $person): ?>
					<dt><?= $person[0]; ?></dt>
						<dd><?= $person[1]; ?></dd>
						<dd><?= $person[2] . ', ' . $person[3]; ?></dd>
						<dd><?= $person[4] . PHP_EOL; ?></dd>
						<button class='btn btn-danger'><?= "<a href=?remove=$key>Remove Contact</a>"; ?></button>
					<?php endforeach; ?>
					</dl>

		<!-- ADDING NEW CONTACTS -->
			<h3>Add a New Contact:</h3>
			<form method="POST" action="address_book.php" role='from'>
					<p>
						<label for="newName"></label>
						<input type="text" id="newName" name="newName" placeholder='First and last name'>
					</p>
					<p>
						<label for="newAddress"></label>
						<input type="text" id="newAddress" name="newAddress" placeholder='Address'>
					</p>
					<p>
						<label for="newCity"></label>
						<input type="text" id="newCity" name="newCity" placeholder='City'>
					</p>
					<p>
						<label for="newState"></label>
						<input type="text" maxlength='2' id="newState" name="newState" placeholder='State'>
					</p>
					<p>
						<label for="newZip"></label>
						<input type="number" id="newZip" name="newZip" placeholder='Zip Code'>
					</p>
					<?php if ($error) { echo "<p>All fields are required.</p>"; } ?>
					<button class="btn btn-success">Add Contact</button>
				</form>

		</div>
         
		<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/js/bootstrap.min.js"></script>
    </body>
</html>