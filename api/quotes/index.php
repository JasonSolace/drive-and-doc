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
include_once '../../models/Quote.php';

// Instantiate DB object
$database = new Database();
$db = $database->connect();

// Instantiate Quote object
$quote_obj = new Quote($db);
$quote_obj->id = intval($_GET["id"]);
// Quotes GET 
if ($method === 'GET' && !isset($_GET["id"])) {
    $result;
    if (isset($_GET["authorId"]) && isset($_GET["categoryId"]) ) {
        $quote_obj->categoryId = $_GET["categoryId"];
        $quote_obj->authorId = $_GET["authorId"];
        $result = $quote_obj->read_with_author_and_category();
    } elseif (isset($_GET["authorId"])) {
        $quote_obj->authorId = $_GET["authorId"];
        $result = $quote_obj->read_with_author();
    } elseif (isset($_GET["categoryId"])) {
        $quote_obj->categoryId = $_GET["categoryId"];
        $result = $quote_obj->read_with_category();
    } else {
        $result = $quote_obj->read();
    }
    $num = $result->rowCount();

    if ($num > 0) {
        $quote_arr = array();
        while($row = $result->fetch(PDO::FETCH_ASSOC)) {
            extract($row);

            $quote_item = array(
                'id' => $id,
                'quote' => $quote,
                'author' => $author,
                'category' => $category
            ); 
            // push quote to data 
            array_push($quote_arr, $quote_item);
        }
        echo json_encode($quote_arr);

    } 
    else {
        echo json_encode(
            array('message'=>"No Quotes Found")
        );
    }
}
// QUOTE GET SINGLE
if ($method === 'GET' && isset($_GET["id"])) {
    $quote_obj->read_single();
    $quote_item = array(
        'id' => $quote_obj->id,
        'quote' => $quote_obj->quote,
        'author' => $quote_obj->author,
        'category' => $quote_obj->category
    ); 

    if (empty($quote_obj->quote)) {
        echo json_encode(
            array('message'=>"No Quotes Found")
        );

    } else {
    echo json_encode($quote_item);
    }
}
// QUOTE POST
if ($method === 'POST') {
    // get posted data
    $data = json_decode(file_get_contents("php://input"));
    $quote_obj->quote = $data->quote;
    $quote_obj->authorId = $data->authorId;
    $quote_obj->categoryId = $data->categoryId;

    // validate request
    if (empty($quote_obj->quote) || empty($quote_obj->categoryId) || empty($quote_obj->authorId)) {
        echo json_encode(
            array('message'=>'Missing Required Parameters')
        );
        return;
    }
    if ( !$quote_obj->categoryIsValid()) {
        echo json_encode(
            array('message'=>'categoryId Not Found')
        );
        return;
    }
    if (!$quote_obj->authorIsValid()) {
        echo json_encode(
            array('message'=>'authorId Not Found')
        );
        return;
    }

    // create the quote
    if ($quote_obj->create()) {
        $quote_item = array(
            'id' => $quote_obj->id,
            'quote' => $quote_obj->quote,
            'authorId' => $quote_obj->authorId,
            'categoryId' => $quote_obj->categoryId,
        ); 
        echo(json_encode($quote_item));

    }
}

// QUOTE PUT
if ($method === 'PUT') {
    // get posted data
    $data = json_decode(file_get_contents("php://input"));
    $quote_obj->id = $data->id;
    $quote_obj->quote = $data->quote;
    $quote_obj->authorId = $data->authorId;
    $quote_obj->categoryId = $data->categoryId;

    // validate request
    if (empty($quote_obj->id) || empty($quote_obj->quote) || empty($quote_obj->categoryId) || empty($quote_obj->authorId)) {
        echo json_encode(
            array('message'=>'Missing Required Parameters')
        );
        return;
    }
    if ( !$quote_obj->categoryIsValid()) {
        echo json_encode(
            array('message'=>'categoryId Not Found')
        );
        return;
    }
    if (!$quote_obj->authorIsValid()) {
        echo json_encode(
            array('message'=>'authorId Not Found')
        );
        return;
    }
    if (!$quote_obj->quoteIsValid()) {
        echo json_encode(
            array('message'=>'No Quotes Found')
        );
        return;
    }


    // update the quote
    if ($quote_obj->update()) {
        $quote_item = array(
            'id' => $quote_obj->id,
            'quote' => $quote_obj->quote,
            'authorId' => $quote_obj->authorId,
            'categoryId' => $quote_obj->categoryId,
        ); 
        echo(json_encode($quote_item));
    } else {
        echo json_encode(
            array('message'=>"No Quotes Found")
        );
    }
}

// QUOTE DELETE
if ($method === 'DELETE') {
    // get posted data
    $data = json_decode(file_get_contents("php://input"));
    $quote_obj->id = $data->id;

    // validate request
    if (empty($quote_obj->id)) {
        echo json_encode(
            array('message'=>'Missing Required Parameters')
        );
    }

    // create the post
    if ($quote_obj->delete()) {
        $quote_item = array(
            'id' => $quote_obj->id
        ); 
        echo(json_encode($quote_item));

    } else {
        echo json_encode(
            array('message'=>'No Quotes Found')
        );    
    }
}

?>