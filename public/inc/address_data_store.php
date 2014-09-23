<?php

require 'inc/filestore.php';

class AddressDataStore extends Filestore {
    
    public function __construct($filename) {
        parent::__construct(strtolower($filename));
    }

    // //i would call this funtion by:
    // //$variable = AddressDataStore->read_address_book();
    // function read_address_book()
    // {
    //     return array_map('str_getcsv', file($this->filename));
    //     ////OR
    //     // $handle = fopen('data/contacts.csv', 'r');
    //     // $contacts = [];
    //     // while(!feof($handle)) {
    //     //  $contacts[] = fgetcsv($handle);
    //     // }
    //     // fclose($handle);
    // }

    // function write_address_book($contacts)
    // {
    //     $handle = fopen($this->filename, 'w');
    //     foreach ($contacts as $key => $person) {
    //         fputcsv($handle, $person);
    //     }
    //     fclose($handle);
    // }

}