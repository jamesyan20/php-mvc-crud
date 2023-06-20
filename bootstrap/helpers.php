<?php

function view( $name ,$data=[]) {
	render($name.'.twig',$data);
}


/*
 * custom dd (Die and Dump) method
 */
function dd( $data = [] ) {
    echo '<pre>';
    die( var_dump( $data ).'</pre>' );

}

/*
 * custom json status return method
 */
function jsonrp($status,$message = "OK"){
	http_response_code(201);
    header('Content-type:application/json');
	echo json_encode(["status"=>$status,"message"=>$message]);
	return 1;
}

function redirect($destination){
	header("Location: $destination");
	die();		
}
