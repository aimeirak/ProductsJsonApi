<?php 
header("Access-Control-Allow-Origin:*");
header("Content-Type:application/json; charset=UTF-8");
header("Access-Allow-Methods:POST");
header("Access-Control-Max-Age:3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

include_once '../classes/product.php';
include_once '../config/database.php';

$database = new database();
$db = $database->getConnection();
$product = new Product($db);

$data = json_decode(file_get_contents("php://input"));

// id of product to be edited

$product->id = $data->id;

//set product property

$product->name = $data->name;
$product->price = $data->price;
$product->description = $data->description;
$product->category_id = $data->category_id;

if($product->update()){
    http_response_code(200);
    json_encode(array("Message"=>"Product Edited Successfully"));

}
else{
    http_response_code(503);
    json_encode(array("Message"=>"Product Failed to Update"));
}