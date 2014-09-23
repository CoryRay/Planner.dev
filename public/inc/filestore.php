<?php

class Filestore {

    public $filename = '';
    public $is_csv = FALSE;

    function __construct($filename = '') {

        // Sets $this->filename
        $this->filename = $filename;

        $fileExtension = substr($this->filename, -3);
        if ($fileExtension == "csv") {
            $this->is_csv = TRUE;
        }
    }

    public function read() {
        if ($this->is_csv) {
            return $this->read_csv();
        } else {
            return $this->read_lines();
        }
        
    }

    public function write($array) {
        if ($this->is_csv) {
            $this->write_csv($array);
        } else {
            $this->write_lines($array);
        }
    }

    /*
     Returns array of lines in $this->filename
    */
    private function read_lines() {
        return $array = file($this->filename, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
    }

    /*
     Writes each element in $array to a new line in $this->filename
    */
    private function write_lines($array) {
        $array = implode(PHP_EOL, $array);
        file_put_contents($this->filename, $array);
    }

    /*
     Reads contents of csv $this->filename, returns an array
    */
    private function read_csv() {
        return array_map('str_getcsv', file($this->filename));
        ////OR
        // $handle = fopen('$this->filename', 'r');
        // $contacts = [];
        // while(!feof($handle)) {
        //  $contacts[] = fgetcsv($handle);
        // }
        // fclose($handle); 
    }

    /*
     Writes contents of $array to csv $this->filename
    */
    private function write_csv($array) {
        $handle = fopen($this->filename, 'w');
        foreach ($array as $key => $row) {
            fputcsv($handle, $row);
        }
        fclose($handle);
    }

}