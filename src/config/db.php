<?php
class db{
    public function connect(){

        $host = "d6rii63wp64rsfb5.cbetxkdyhwsb.us-east-1.rds.amazonaws.com";
        $user = "q0v6mbhsskzgc8zz";
        $pass = "tf0kl6i2y1s5d8dx";
        $dbname = "bwsw7obf8qezy3ih";

        //Connect Database using PHP PDO CRUD
        $pdo = new PDO("mysql:host=$host;dbname=$dbname", $user, $pass);

        //Set Error Mode
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        //Set Default fetch mode from the DB
        $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE,PDO::FETCH_ASSOC);

        return $pdo;

    }
}