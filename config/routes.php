<?php

  $routes->get('/', function() {
    HelloWorldController::index();
  });

  $routes->get('/hiekkalaatikko', function() {
    HelloWorldController::sandbox();
  });
  
  $routes->get('/muistilista',function() {
//      HelloWorldController::chore_list();
    ChoreController::index();
  });
  
  $routes->post('/askare', function(){
  ChoreController::store();
  });
  
  $routes->get('/askare/uusi', function(){
  ChoreController::create();
});
      
  $routes->get('/askare/:id',function($id) {
//  HelloWorldController::chore_show();
    ChoreController::show($id);
  });
  
  $routes->get('/muokkaus',function(){
  HelloWorldController::chore_edit();
  });
