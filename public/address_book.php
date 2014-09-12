<?php

//$filename = '';

//NEW CLASS
require_once 'inc/address_data_store';

//CREATE NEW INSTANCE OF THE CLASS
//this new particular instance is called $ads
//from $ads, we can call any method/function inside the class
$ads = new AddressDataStore();


//this sets the returned value of method read_address_book to $contacts
$contacts = $ads->read_address_book();

/////////CHECKS IF A NEW CONTACT WAS ADDED FROM FORM
if (!empty($_POST)) {
    $required = ['newName', 'newAddress', 'newCity', 'newState', 'newZip'];
    $error = false;
    
    foreach($required as $form) {
        if (empty($_POST[$form])) {
            $error = true;
        }
        else {
            $newContact[] = $_POST[$form];
        }
    }
    if (!$error) {
        $contacts[] = $newContact;
        $ads->write_address_book($contacts);
    } 
} //END IF STATEMENT

//UPLOADED CONTACT LIST
if (count($_FILES) > 0 && $_FILES['UploadedCsv']['error'] == 0) {
    $upload_dir = 'uploads/';
    $filename = basename($_FILES['UploadedCsv']['error']);
    $saved_filename = $upload_dir . $filename;
    move_uploaded_file($_FILES['UploadedCsv']['tmp_name'], $saved_filename);

    // open that saved_filname with the method from our object we've created
    // add that data, to our existing array of contacts
    // save to file
    $new_contacts = $ads->read_address_book($saved_filename);
    $contacts = array_merge($contacts, $new_contacts);
    $ads->write_address_book($contacts);
}



//REMOVE CONTACTS FROM ADDRESSBOOK
if (isset($_GET['remove'])) {
    // Define variable $keyToRemove according to value
    $keyToRemove = $_GET['remove'];
    // Remove item from array according to key specified
    unset($contacts[$keyToRemove]);
    // Numerically reindex values in array after removing item
    $contacts = array_values($contacts);
    //save the file
    $ads->write_address_book($contacts);
} //END IF STATEMENT

?>
<!doctype html>
<html>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Address Book</title>
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap.min.css">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap-theme.min.css">
        <link type="text/css" rel="stylesheet" href="css/address_book.css"/>
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
                        <a href=?remove=<?= $key; ?> class='btn btn-danger'>Remove Contact</a>
                    <?php endforeach; ?>
                    </dl>

        <!-- ADD NEW CONTACT FORM -->
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
                    <?php if (!empty($error)) { echo "<p>All fields are required.</p>"; } ?>
                    <button class="btn btn-success">Add Contact</button>
                </form>

            <h3>Add a New Address Book:</h3>
            <form method="POST" enctype="multipart/form-data" action="address_book.php">
                <p>
                    <label for="UploadedCsv">Upload a CSV file: </label>
                    <input type="file" name="UploadedCsv" id="UploadedCsv">
                    <p><input type="submit" value="Upload"></p>
                </p>
            </form>
             <?php 
            // VERIFY UPLOAD SUCCESSFUL
                // Check if we uploaded a file
                if (isset($saved_filename)) {
                    // If we did, show a link to the uploaded file
                    echo "<p>Upload Successful!</p>";
                }
            ?>
        </div>
         
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/js/bootstrap.min.js"></script>
    </body>
</html>