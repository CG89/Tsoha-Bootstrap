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

$routes->post('/uloskirjautuminen', function(){
  PersonController::logout();
});

//Luokan reitit.
$routes->get('/luokat', function(){
  CategoryController::index();
});
$routes->get('/luokka/uusi', function(){
  CategoryController::create();
});

$routes->get('/luokka/:id', function($id){
  CategoryController::show($id);
});

$routes->post('/luokka', function(){
  CategoryController::store();
});

$routes->get('/luokka/:id/muokkaus', function($id){
  CategoryController::edit($id);
});

$routes->post('/luokka/:id/muokkaus', function($id){
  CategoryController::update($id);
});

$routes->post('/luokka/:id/poista', function($id){
  CategoryController::destroy($id);
});