<?php

use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;


//This Is used to Upload user Data to the API Endpoints
$app->post('/api/drugs/create', function (Request $request, Response $response, array $args) {

        //If It Corresponds, Start the SQL Operations
        create_drug($request, $response);
    }
);

function create_drug(Request $request, Response $response)
{
    //Getting the Body Input from the Request/FrontEnd
    $body = $request->getParsedBody();

    try {
        $db = new db(); //Create the db Object
        $pdo = $db->connect();

        $sql = "INSERT INTO drugs (id, name, type, vendor, price, size, product_id, constituents, dispensed_in, description, image_url) VALUES (?,?,?,?,?,?,?,?,?,?,?) ON DUPLICATE KEY UPDATE id = ?, name = ?, type = ?, vendor = ?, price = ?, size = ?, product_id = ?, constituents = ?, dispensed_in = ?, description = ?,image_url = ? ";
        // Connect to the database
        $stmt = $pdo->prepare($sql); //Prepare the Query
        //Execute the Query
        foreach ($body as $value) {
            $stmt->execute([$value['id'], $value['name'], $value['type'], $value['vendor'], $value['price'], $value['size'], $value['product_id'], $value['constituents'], $value['dispensed_in'], $value['description'], $value['image_url'], $value['id'], $value['name'], $value['type'], $value['vendor'], $value['price'], $value['size'], $value['product_id'], $value['constituents'], $value['dispensed_in'], $value['description'], $value['image_url']]);
        }
        //After Executing, Reset the PDO variable
        $pdo = null;

        //Creating a json object by passing an associative array
        $resp = json_encode(
            [
                "status" => 1,
                "message" => "Drug created"
            ]
        );
        //This is a way to pass the body via the response object
        $response->getBody()->write($resp);
        return $response;
    } catch (\PDOException $e) {
        $resp = json_encode(
            [
                "status" => 0,
                "message" => "An error occurred",
                "error"=>$e->getMessage()
            ]
        );
        $response->getBody()->write($resp);
        return $response;
    }
}


// Get Drugs
$app->get('/api/drugs/get', function (Request $request, Response $response, array $args) {
    get_drugs($request, $response);
});

function get_drugs(Request $request, Response $response)
{    
    // this gets the query passed from the frontend/request to the server and returns an associative array
    $query = $request->getQueryParams();
    try {
        $sql = "SELECT * FROM drugs";
        $db = new db();
        $pdo = $db->connect();
        $stmt = $pdo->query($sql);
        $drugs = $stmt->fetchAll();
        $pdo = null;

        //This is a way to pass the body via the response object
        $resp = json_encode(
            [
                "status" => 1,
                "drugs" => $drugs
            ]
        );
        $response->getBody()->write($resp);
        
        return $response;
    } catch (\PDOException $e) {
        $resp = json_encode(
            [
                "status" => 0,
                "message" => $e->getMessage()
            ]
        );
        $response->getBody()->write($resp);
        return $response;
    }
}

