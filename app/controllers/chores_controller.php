<?php

class ChoreController extends BaseController {

    public static function index() {
        $chores = Chore::all();
        View::make('chore/chore_list.html', array('chores' => $chores));
    }

    public static function show($id) {
        $chore = Chore::find($id);
        View::make('chore/chore_show.html', array('chore'=>$chore));
                
    }
    
    public static function create(){
        View::make('chore/new.html');
    }

    public static function store(){
    // POST-pyynnön muuttujat sijaitsevat $_POST nimisessä assosiaatiolistassa
    $params = $_POST;
    
    // Alustetaan uusi Game-luokan olion käyttäjän syöttämillä arvoilla
    $chore = new Chore(array(
      'name' => $params['name'],
      'person_id' => $params['person_id'],
      'urgent' => $params['urgent'],
      
    ));

    // Kutsutaan alustamamme olion save metodia, joka tallentaa olion tietokantaan
    $chore->save();

    // Ohjataan käyttäjä lisäyksen jälkeen pelin esittelysivulle
    Redirect::to('/askare/' . $chore->id, array('message' => 'Askare on lisätty muistilistaasi!'));
  }
}

