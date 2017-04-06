<?php

$routes->get('/', function() {
    HelloWorldController::index();
});

$routes->get('/hiekkalaatikko', function() {
    HelloWorldController::sandbox();
});

$routes->get('/muistilista', function() {
//      HelloWorldController::chore_list();
    ChoreController::index();
});

$routes->post('/askare', function() {
    ChoreController::store();
});

$routes->get('/askare/uusi', function() {
    ChoreController::create();
});

$routes->get('/askare/:id', function($id) {
//  HelloWorldController::chore_show();
    ChoreController::show($id);
});

$routes->get('/muokkaus', function() {
    HelloWorldController::chore_edit();
});

$routes->get('/askare/:id/muokkaus', function($id) {
    // Askareen muokkauslomakkeen esittäminen
    ChoreController::edit($id);
});
$routes->post('/askare/:id/muokkaus', function($id) {
    // Askareen muokkaaminen
    ChoreController::update($id);
});

$routes->post('/askare/:id/poista', function($id) {
    // Askareen poisto
    ChoreController::destroy($id);
});

$routes->get('/kirjautuminen', function() {
    // Kirjautumislomakkeen esittäminen
    PersonController::login();
});
$routes->post('/kirjautuminen', function() {
    // Kirjautumisen käsittely
    PersonController::handle_login();
});
