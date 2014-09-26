<?php

require_once '../address_dbconnect.php';
require_once 'inc/address_data_store.php';

//CREATE NEW INSTANCE OF THE CLASS
$ads = new AddressDataStore('data/contacts.csv', $dbc);

//this sets the returned value of method read to $contacts
$contacts = $ads->read();


//REMOVE CONTACTS FROM ADDRESSBOOK
if (isset($_GET['remove'])) {
    // Define variable $keyToRemove according to value
    $keyToRemove = $_GET['remove'];
    // Remove item from array according to key specified
    unset($contacts[$keyToRemove]);
    // Numerically reindex values in array after removing item
    $contacts = array_values($contacts);
    //save the file
    $ads->write($contacts);
}
?>

<?php include 'header.php'; ?>

<div class='container'>
    <h2>My Address Book</h2>
    <hr>

<!-- DISPLAYS ADDRESS BOOK IN DEFINITION LIST -->
    <div class="row">
        <?php foreach($contacts as $key => $person): ?>
        <div class="col-md-2">
            <dl>
                <dt><?= htmlspecialchars(strip_tags($person[0])); ?></dt>
                <dd><?= htmlspecialchars(strip_tags($person[1])); ?></dd>
                <dd><?= htmlspecialchars(strip_tags($person[2])) . ', ' . $person[3]; ?></dd>
                <dd><?= htmlspecialchars(strip_tags($person[4])) . PHP_EOL; ?></dd>
                <dd><a href=?remove=<?= $key; ?> class='btn-xs btn-danger'>Remove Contact</a></dd>
            </dl>
        </div>
        <?php endforeach; ?>

<?php include 'footer.php'; ?>