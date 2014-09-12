<?php

class AddressDataStore {

    public $filename = '';

    public function __construct($filename = 'data/contacts.csv') {
        $this->filename = $filename;
    }

    //i would call this funtion by:
    //$variable = AddressDataStore->read_address_book();
    function read_address_book()
    {
        return array_map('str_getcsv', file($this->filename));
        ////OR
        // $handle = fopen('data/contacts.csv', 'r');
        // $contacts = [];
        // while(!feof($handle)) {
        //  $contacts[] = fgetcsv($handle);
        // }
        // fclose($handle);
    }

    function write_address_book($contacts)
    {
        $handle = fopen($this->filename, 'w');
        foreach ($contacts as $key => $person) {
            fputcsv($handle, $person);
        }
        fclose($handle);
    }

}