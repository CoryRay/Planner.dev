
<?php 

    // Get new instance of PDO object
    $dbc = new PDO('mysql:host=127.0.0.1;dbname=address_book_db', 'codeup', 'codeuprocks');

    // Tell PDO to throw exceptions on error
    $dbc->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Create the query and assign to var
    $query = 'CREATE TABLE address_name (
              id INT UNSIGNED NOT NULL AUTO_INCREMENT,
              name_id INT NOT NULL,
              address_id INT NOT NULL,
              FOREIGN KEY (name_id) REFERENCES name(id),
              FOREIGN KEY (address_id) REFERENCES address(id),
              PRIMARY KEY (id)
              )';

    // Run query, if there are errors they will be thrown as PDOExceptions
    $dbc->exec($query);