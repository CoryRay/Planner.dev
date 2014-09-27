<?php 

require_once '../address_dbconnect.php';
require_once 'inc/address_data_store.php';

$ads = new AddressDataStore('data/contacts.csv', $dbc);

//ADDS NEW CONTACT
if (!empty($_POST)) { 
     
    $ads->write_address_db($_POST);
    
    // header('location: address_book.php');
    // exit;
}

//UPLOADED CONTACT LIST
if (count($_FILES) > 0 && $_FILES['UploadedCsv']['error'] == 0) {
    

    header('location: address_book.php');
    exit;
}

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
                    <input type="text" id="newName" name="newName" placeholder='First and last name' required>
                </div>
                <div class='form-group'>
                    <label for="newAddress"class="sr-only">Street Address</label>
                    <input type="text" id="newAddress" name="newAddress" placeholder='Address' required>
                </div>
                <div class='form-group'>
                    <label for="newCity" class="sr-only">City</label>
                    <input type="text" id="newCity" name="newCity" placeholder='City' required>
                </div>
                <div class='form-group'>
                    <label for="newState"class="sr-only">State</label>
                    <input type="text" maxlength='2' id="newState" name="newState" placeholder='State' required>
                </div>
                <div class='form-group'>
                    <label for="newZip"class="sr-only">Zip Code</label>
                    <input type="number" id="newZip" name="newZip" placeholder='Zip Code' required>
                </div>
                <div class='form-group'>
                    <label for="isPrimary">Is this your primary address?</label>
                    <input type="checkbox" id="isPrimary" name="isPrimary" value="1">
                </div>
                <div class="form-group">
                    <button class="btn btn-sm btn-success">Add Contact</button>
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
                    <button class="btn btn-sm btn-success">Add Contact</button>
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