<?php 
//required headers
header("Access-Control-Allow-Origin:*");
header("Content-type: application/json;charset=UTF-8");

//Database connection will be here
 include_once '../config/database.php';
 include_once '../classes/product.php';

 $database = new database();
 $db = $database->getConnection();

 //initialize Object
 $product = new Product($db);

 //query product

 $stmt = $product->read();
 $num = $stmt->rowCount();
 if($num>0){
     //product array
     $products_arr=array();
    $products_arr["records"]=array();
     // retrieve our table contents
     while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
         // extract row
        extract($row);
        $product_item = array(
            "id" => $id,
            "name" => $name,
            "description" => html_entity_decode($description),
            "price" => $price,
            "category_id" => $category_id,
            "category_name" => $category_name
        );
        array_push($products_arr["records"], $product_item);
        //set response code -200 OK 
        echo json_encode($products_arr);

     }
 }
 else
 {
   //set response code t -404 not found
   http_response_code(404);
   echo json_decode(array("message"=>"No Product Found."));
 }
