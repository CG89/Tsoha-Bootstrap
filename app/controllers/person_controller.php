<?php

class PersonController extends BaseController {

    //Kutsuu sisäänkirjautumisnäkymän.
    public static function login() {
        View::make('person/login.html');
    }

    //Käsittelee sisäänkirjautumisen ja aloittaa session ja ohjaa käyttäjän muistilistaansa tai palauttaa virheilmoituksen.
    public static function handle_login() {
        $params = $_POST;

        $person = Person::authenticate($params['käyttäjätunnus'], $params['salasana']);

        if ($person == null) {
            View::make('person/login.html', array('error' => 'Väärä käyttäjätunnus tai salasana!', 'käyttäjätunnus' => $params['käyttäjätunnus']));
        } else {
            $_SESSION['person'] = $person->id;

            Redirect::to('/muistilista', array('message' => 'Tervetuloa takaisin ' . $person->name . '!'));
        }
    }

    //Päättää session ja ohjaa kirjautumisnäkymään.
    public static function logout() {
        $_SESSION['person'] = null;
        Redirect::to('/kirjautuminen', array('message' => 'Olet kirjautunut ulos!'));
    }

}
