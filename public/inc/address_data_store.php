<?php

require 'inc/filestore.php';

class AddressDataStore extends Filestore {

    public $dbc;
    public $previouslyExistingName = FALSE;
    
    public function __construct($filename, $dbc) {
        parent::__construct(strtolower($filename));
        $this->dbc = $dbc;
    }

    public function read_name_db() { //WORKS
        $stmt = $this->dbc->query("SELECT names.name, addresses.address FROM names 
                                   JOIN addresses ON addresses.id = names.address_id
                                   WHERE addresses.is_primary = 1;");

        return $names_row = $stmt->fetchall(PDO::FETCH_ASSOC);
    }

    public function read_address_db() { //UNFINISHED - may not be needed
        $stmt = $this->dbc->query("SELECT *
                             FROM address");

        return $addresses_row = $stmt->fetchall(PDO::FETCH_ASSOC);
    }

    public function write_address_db() {
        if (isset($_POST['isPrimary'])) {
            $isPrimary = true;
        } else {
            $isPrimary = false;
        }

        $query = "INSERT INTO addresses (address, city, state, zip, is_primary)
                  VALUES (:address, :city, :state, :zip, :isPrimary)";

        $prepare_to_add = $this->dbc->prepare($query);
        $prepare_to_add->bindValue(':address',   $_POST['newAddress'], PDO::PARAM_STR);
        $prepare_to_add->bindValue(':city',      $_POST['newCity'],    PDO::PARAM_STR);
        $prepare_to_add->bindValue(':state',     $_POST['newState'],   PDO::PARAM_STR);
        $prepare_to_add->bindValue(':zip',       $_POST['newZip'],     PDO::PARAM_INT);
        $prepare_to_add->bindValue(':isPrimary', $isPrimary,  PDO::PARAM_BOOL);

        $prepare_to_add->execute();
        
        $this->write_name_db();   
    }
    
    public function write_name_db() {
        $query = "INSERT INTO names (name, address_id)
                  VALUES (:name, :addressId)";

        $prepare_to_add = $this->dbc->prepare($query);
        $prepare_to_add->bindValue(':name',      $_POST['newName'],          PDO::PARAM_STR);
        $prepare_to_add->bindValue(':addressId', $this->dbc->lastInsertId(), PDO::PARAM_STR);

        $prepare_to_add->execute();

    }
}

?>