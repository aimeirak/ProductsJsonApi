<?php 
//required header
header("Access-Control-Allow-Origin:*");
header("Content-Type:Application/json; charsert=UTF-8");
header("Access-Control-Allow-Methods:POST");
header("Access-Control-Max-Age:3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

include_once '../config/database.php';
include_once '../classes/product.php';

$database = new database();
$db = $database->getConnection();

$product = new Product($db);

//get posted data 
$data = json_decode(file_get_contents("php://input"));
if(!empty($data->name) && !empty($data->price) && !empty($data->description) && !empty($data->category_id))
{
    //set product property values
    $product->name = $data->name;
    $product->price = $data->price;
    $product->description = $data->description;
    $product->category_id = $data->category_id;
    $product->created = date('Y-m-d H:i:s');
    if($product->create()){
      http_response_code(201);
      echo json_encode(array("Message"=>"Product Inserted Successfully."));
    }
    else{
        //tell user the service unvailable
        http_response_code(503);
        echo json_encode(array("Message"=>"Unable to Insert The Product"));
    }
}
else{
    http_response_code(400);
    echo json_encode(array("Message" => "Unable to create Product. Data is Incomplete"));
}