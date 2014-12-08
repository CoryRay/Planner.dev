<?php

require_once '../address_dbconnect.php';
require_once 'inc/address_data_store.php';

//CREATE NEW INSTANCE OF THE CLASS
$ads = new AddressDataStore('data/contacts.csv', $dbc);

//this sets the returned value of method read to $contacts
$names_row = $ads->read_name_db();
// $addresses_row = $ads->read_address_db();


//REMOVE CONTACTS FROM ADDRESSBOOK
if (isset($_GET['remove'])) {
    // $keyToRemove = $_GET['remove'];

    // unset($contacts[$keyToRemove]);

    // $contacts = array_values($contacts);

    // $ads->write($contacts);
}

?>

<?php include 'header.php'; ?>

<div class='container'>
    <h2>My Address Book</h2>
    <hr>

<!-- DISPLAYS ADDRESS BOOK IN DEFINITION LIST -->
    <div class="row">
        <?php foreach($names_row as $key => $person): ?>
        <div class="col-md-2">
            <dl>
                <dt><a href=""></a><?= htmlspecialchars(strip_tags($person['name'])); ?></dt>
                <dd><?= htmlspecialchars(strip_tags($person['address'])); ?></dd>
                <dd><a href=?remove=<?= $key; ?> class='btn btn-xs btn-default'>More Info</a></dd>
            </dl>
        </div>
        <?php endforeach; ?>
    </div>
</div>

<?php include 'footer.php'; ?>