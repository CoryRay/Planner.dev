<?php 

require_once '../address_dbconnect.php';
require_once 'inc/address_data_store.php';

$ads = new AddressDataStore('data/contacts.csv');

//ADDS NEW CONTACT OR OUTPUTS AN ERROR
if (!empty($_POST)) {
    // $required = ['newName', 'newAddress', 'newCity', 'newState', 'newZip'];
    // $error = false;
    
    // foreach($required as $form) {
    //     if (strlen($_POST[$form]) > 125) {
    //         throw new Exception("Please keep your entries below 125 characters.");
    //     }
    //     else {
    //         $newContact[] = $_POST[$form];
    //     }
    // }
    // if (!$error) {
    //     $contacts[] = $newContact;
    //     $ads->write($contacts);
    // } 
     
    $ads->write_name_db($_POST);
    
    // header('location: address_book.php');
    // exit;
}


//UPLOADED CONTACT LIST
if (count($_FILES) > 0 && $_FILES['UploadedCsv']['error'] == 0) {
    $upload_dir = 'uploads/';
    $filename = basename($_FILES['UploadedCsv']['error']);
    $saved_filename = $upload_dir . $filename;
    move_uploaded_file($_FILES['UploadedCsv']['tmp_name'], $saved_filename);

    $new_contacts = $ads->read($saved_filename);
    $contacts = array_merge($contacts, $new_contacts);
    $ads->write($contacts);

    header('location: address_book.php');
    exit;
}
var_dump($dbc);

?>

<?php include 'header.php'; ?>

<div class="container">
	<h2>Add a New Contact</h2>
	<hr>

<!-- ADD NEW CONTACT FORM -->
    <div class="row">
        <div class="col-sm-6">
            <h3>Add New:</h3>
            <form method="POST" action="address_book_create.php" role='form'>
                <div class='form-group'>
                    <label for="newName"class="sr-only">First and Last Name</label>
                    <input type="text" id="newName" name="newName" placeholder='First and last name'>
                </div>
                <div class='form-group'>
                    <label for="newAddress"class="sr-only">Street Address</label>
                    <input type="text" id="newAddress" name="newAddress" placeholder='Address'>
                </div>
                <div class='form-group'>
                    <label for="newCity" class="sr-only">City</label>
                    <input type="text" id="newCity" name="newCity" placeholder='City'>
                </div>
                <div class='form-group'>
                    <label for="newState"class="sr-only">State</label>
                    <input type="text" maxlength='2' id="newState" name="newState" placeholder='State'>
                </div>
                <div class='form-group'>
                    <label for="newZip"class="sr-only">Zip Code</label>
                    <input type="number" id="newZip" name="newZip" placeholder='Zip Code'>
                </div>
                <div class="form-group">
                    <button class="btn btn-success">Add Contact</button>
                </div>
            </form>
        </div>
        <div class="col-sm-6">
            <h3>Add with Existing Address:</h3>
            <form method="POST" action="address_book.php" role='form'>
                <div class="form-group">
                    <label for="newName"class="sr-only">First and Last Name</label>
                    <input type="text" id="newName" name="newName" placeholder='First and last name' required>
                </div>
                <div class="form-group">
                    <select name="address" id="address">
                    	<option value="test">Existing Address Here</option>
                    </select>
                </div>
                <div class="form-group">
                    <button class="btn btn-success">Add Contact</button>
                </div>
            </form>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-12">
            <h3>Add a New Address Book:</h3>
            <form method="POST" enctype="multipart/form-data" action="address_book.php">
                <p>
                    <label for="UploadedCsv">Upload a CSV file: </label>
                    <input type="file" name="UploadedCsv" id="UploadedCsv">
                    <p><input type="submit" value="Upload"></p>
                </p>
            </form>
		    <?= isset($saved_filename) ? '<div class="alert alert-info" role="alert">Upload Successful!</div>' : "" ; ?>
        </div>
    </div>

</div>

<?php include 'footer.php'; ?>