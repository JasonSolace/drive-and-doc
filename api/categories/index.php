<?php 
// HEADERS
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
$method = $_SERVER['REQUEST_METHOD'];  // get the HTTP method
if ($method === 'OPTIONS') {
    header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE');
    header('Access-Control-Allow-Headers: Origin, Accept, Content-Type, X-Requested-With');
    return;
}

// IMPORTS
include_once '../../config/Database.php';
include_once '../../models/Category.php';

// Instantiate DB object
$database = new Database();
$db = $database->connect();

// Instantiate Category object
$category_obj = new Category($db);
$category_obj->id = intval($_GET["id"]);
// Categories GET 
if ($method === 'GET' && !isset($_GET["id"])) {
    $result = $category_obj->read();
    $num = $result->rowCount();

    if ($num > 0) {
        $category_arr = array();
        while($row = $result->fetch(PDO::FETCH_ASSOC)) {
            extract($row);

            $category_item = array(
                'id' => $id,
                'category' => $category
            ); 
            // push category to data 
            array_push($category_arr, $category_item);
        }
        echo json_encode($category_arr);

    } 
    else {
        echo json_encode(
            array('message'=>"categoryId Not Found")
        );
    }
}
// CATEGORY GET SINGLE
if ($method === 'GET' && isset($_GET["id"])) {
    $category_obj->read_single();
    $category_item = array(
        'id' => $category_obj->id,
        'category' => $category_obj->category
    ); 

    if (empty($category_obj->category)) {
        echo json_encode(
            array('message'=>"categoryId Not Found")
        );
    } else {
    echo json_encode($category_item);
    }
}
// CATEGORY POST
if ($method === 'POST') {
    // get posted data
    $data = json_decode(file_get_contents("php://input"));
    $category_obj->category = $data->category;

    // validate request
    if (empty($category_obj->category)) {
        echo json_encode(
            array('message'=>'Missing Required Parameters')
        );
        return;
    }

    // create the category
    if ($category_obj->create()) {
        $category_item = array(
            'id' => $category_obj->id,
            'category' => $category_obj->category
        ); 
        echo(json_encode($category_item));

    }
}

// CATEGORY PUT
if ($method === 'PUT') {
    // get posted data
    $data = json_decode(file_get_contents("php://input"));
    $category_obj->id = $data->id;
    $category_obj->category = $data->category;

    // validate request
    if (empty($category_obj->id) || empty($category_obj->category)) {
        echo json_encode(
            array('message'=>'Missing Required Parameters')
        );
        return;
    }

    // create the post
    if ($category_obj->update()) {
        $category_item = array(
            'id' => $category_obj->id,
            'category' => $category_obj->category
        ); 
        echo(json_encode($category_item));
    }
}

// CATEGORY DELETE
if ($method === 'DELETE') {
    // get posted data
    $data = json_decode(file_get_contents("php://input"));
    $category_obj->id = $data->id;

    // validate request
    if (empty($category_obj->id)) {
        echo json_encode(
            array('message'=>'Missing Required Parameters')
        );
    }

    // create the post
    if ($category_obj->delete()) {
        $category_item = array(
            'id' => $category_obj->id
        ); 
        echo(json_encode($category_item));

    }
}

?>