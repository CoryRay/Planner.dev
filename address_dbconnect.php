<?php 
$dbc = new PDO('mysql:host=127.0.0.1;dbname=address_book_db', 'codeup', 'codeuprocks');
$dbc->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
?>