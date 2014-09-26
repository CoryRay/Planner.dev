<?php

require 'inc/filestore.php';

class AddressDataStore extends Filestore {

    public $dbc;
    public $previouslyExistingName = FALSE;
    
    public function __construct($filename, $dbc) {
        parent::__construct(strtolower($filename));
        $this->dbc = $dbc;
    }

    public function read_name_db() { //UNFINISHED
        $stmt = $this->dbc->query("SELECT name.name, address.address FROM name 
                                   JOIN address_name ON name.id = address_name.name_id
                                   JOIN address ON address_name.address_id = address.id
                                   WHERE address.is_primary = 1;");

        return $names_row = $stmt->fetchall(PDO::FETCH_ASSOC);
    }

    public function read_address_db() { //UNFINISHED
        $stmt = $this->dbc->query("SELECT *
                             FROM address");

        return $addresses_row = $stmt->fetchall(PDO::FETCH_ASSOC);
    }

    public function write_name_db() {
        $new_contact = $_POST;

        $query = "INSERT INTO name (name)
                  VALUES (:name)";

        $prepare_to_add = $this->dbc->prepare($query);
        $prepare_to_add->bindValue(':name', $_POST['newName'], PDO::PARAM_STR);


        $prepare_to_add->execute();

        $this->write_address_db();   
    }
    
    public function write_address_db() {
        $query = "INSERT INTO address (address, city, state, zip)
                  VALUES (:address, :city, :state, :zip)";

        $prepare_to_add = $this->dbc->prepare($query);
        $prepare_to_add->bindValue(':address', $_POST['newAddress'], PDO::PARAM_STR);
        $prepare_to_add->bindValue(':city',    $_POST['newCity'],    PDO::PARAM_STR);
        $prepare_to_add->bindValue(':state',   $_POST['newState'],   PDO::PARAM_STR);
        $prepare_to_add->bindValue(':zip',     $_POST['newZip'],     PDO::PARAM_INT);

        $prepare_to_add->execute();
    }
}

?>













