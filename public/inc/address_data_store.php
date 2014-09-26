<?php

require 'inc/filestore.php';

class AddressDataStore extends Filestore {

    public $dbc;
    
    public function __construct($filename, $dbc) {
        parent::__construct(strtolower($filename));
        $this->dbc = $dbc;
    }

    public function read_name_db() {
        $stmt = $dbc->query("SELECT * 
                             FROM name");
        $row = $stmt->fetchall();
    }

    public function read_address_db() {
        $stmt = $dbc->query("SELECT * 
                             FROM address");
        $row = $stmt->fetchall();
    }

    public function write_name_db($dbc) {
        $new_contact = $_POST;

        $query = "INSERT INTO name (name)
                  VALUES (:name)";

        $prepare_to_add = $this->dbc->prepare($query);
        $prepare_to_add->bindValue(':name', $_POST['newName'], PDO::PARAM_STR);


        $prepare_to_add->execute();

        $this->write_address_db();

        //write_db
        //if name||address already exists, call different functions depending
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













