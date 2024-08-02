<?php

$router->get('/', 'HomeController@index');
$router->get('/listings', 'ListingController@index');
$router->get('/listings/create', 'ListingController@create',['auth']);
$router->get('/listings/edit/{id}', 'ListingController@edit',['auth']);
$router->get('/listings/{id}', 'ListingController@show');

$router->get('/artworks', 'ArtworkController@index');
$router->get('/artworks/create', 'ArtworkController@create');
$router->get('/artworks/{id}', 'ArtworkController@show');
$router->get('/artworks/edit/{id}', 'ArtworkController@edit');


$router->get('/artworks/images', 'FileController@upload');

$router->post('/listings', 'ListingController@store',['auth']);
$router->put('/listings/{id}', 'ListingController@update',['auth']);
$router->delete('/listings/{id}', 'ListingController@destroy',['auth']);

$router->post('/artworks', 'ArtworkController@store');
$router->put('/artworks/{id}', 'ArtworkController@update');
$router->delete('/artworks/{id}', 'ArtworkController@destroy');

$router->get('/auth/register', 'UserController@create',['guest'] );
$router->get('/auth/login', 'UserController@login',['guest']);


$router->post('/auth/register', 'UserController@store',['guest'] );
$router->post('/auth/logout', 'UserController@logout' ,['auth']);
$router->post('/auth/login', 'UserController@authenticate' ,['guest']);


