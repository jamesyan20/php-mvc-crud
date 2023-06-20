<?php

//some routes
Router::get('','PageController@home');
Router::get('cart','PageController@cart');
Router::get('add','PageController@add');
Router::get('edit','PageController@edit');
Router::get('product','PageController@product');


Router::post('save','PageController@save');
Router::post('change','PageController@change');
Router::post('delete','PageController@delete');

?>
