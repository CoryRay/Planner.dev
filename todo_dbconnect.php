<?php 
$dbc = new PDO('mysql:host=127.0.0.1;dbname=todo_db', 'codeup', 'codeuprocks');
$dbc->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
?>