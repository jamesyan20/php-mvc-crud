<?php


Router::get('api/products','api/ProductController@fetch');
Router::post('api/products','api/ProductController@add');

