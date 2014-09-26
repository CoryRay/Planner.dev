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
var_dump($names_row);
?>

<?php include 'header.php'; ?>

<div class='container'>
    <h2>My Address Book</h2>
    <hr>

<!-- DISPLAYS ADDRESS BOOK IN DEFINITION LIST -->
    <div class="row">
        <?php foreach($names_row as $key => $name): ?>
        <div class="col-md-2">
            <dl>
                <dt><?= htmlspecialchars(strip_tags($name['name'])); ?></dt>
                <dd><?= htmlspecialchars(strip_tags($addresses['address'])); ?></dd>
                <dd><?= htmlspecialchars(strip_tags($addresses['city'])) . ', ' . $addresses['state']; ?></dd>
                <dd><?= htmlspecialchars(strip_tags($addresses['zip'])) . PHP_EOL; ?></dd>
                <dd><a href=?remove=<?= $key; ?> class='btn-xs btn-danger'>Remove Contact</a></dd>
            </dl>
        </div>
        <?php endforeach; ?>

<?php include 'footer.php'; ?>