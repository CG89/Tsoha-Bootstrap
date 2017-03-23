<?php

  $routes->get('/', function() {
    HelloWorldController::index();
  });

  $routes->get('/hiekkalaatikko', function() {
    HelloWorldController::sandbox();
  });
  
  $routes->get('/muistilista',function() {
      HelloWorldController::chore_list();
  });
      
  $routes->get('/askare',function() {
  HelloWorldController::chore_show();
  });
  
  $routes->get('/muokkaus',function(){
  HelloWorldController::chore_edit();
  });
