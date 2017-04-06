<?php


class PersonController extends BaseController{
  public static function login(){
      View::make('person/login.html');
  }
  public static function handle_login(){
    $params = $_POST;

    $person = Person::authenticate($params['käyttäjätunnus'], $params['salasana']);

    if($person==null){
      View::make('person/login.html', array('error' => 'Väärä käyttäjätunnus tai salasana!', 'käyttäjätunnus' => $params['käyttäjätunnus']));
    }else{
      $_SESSION['person'] = $person->id;

      Redirect::to('/muistilista', array('message' => 'Tervetuloa takaisin ' . $person->name . '!'));
    }
  }
}