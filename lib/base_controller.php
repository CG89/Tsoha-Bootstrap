<?php

class BaseController {

    public static function get_user_logged_in() {
        // Katsotaan onko person-avain sessiossa
        if (isset($_SESSION['person'])) {
            $person_id = $_SESSION['person'];
            // Pyydetään User-mallilta käyttäjä session mukaisella id:llä
            $person = Person::find($person_id);

            return $person;
        }

        // Käyttäjä ei ole kirjautunut sisään
        return null;
    }

      public static function check_logged_in(){
    if(!isset($_SESSION['person'])){
      Redirect::to('/kirjautuminen', array('error' => 'Kirjaudu ensin sisään!'));
    }
  }

}
