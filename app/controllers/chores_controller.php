<?php

class ChoreController extends BaseController {

    public static function index() {
        $chores = Chore::all(self::get_user_logged_in()->id);
        View::make('chore/chore_list.html', array('chores' => $chores));
    }

    public static function show($id) {
        $chore = Chore::find($id);
        View::make('chore/chore_show.html', array('chore' => $chore));
    }

    public static function create() {
        View::make('chore/new.html');
    }

    public static function store() {
        // POST-pyynnön muuttujat sijaitsevat $_POST nimisessä assosiaatiolistassa
        $params = $_POST;

        // Alustetaan uusi Chore-luokan olion käyttäjän syöttämillä arvoilla
        $attributes =array(
            'name' => $params['name'],
            'person_id' => $params['person_id'],
            'urgent' => $params['urgent'],
        );
        $chore=new Chore($attributes);
        $errors = $chore->errors();
        if (count($errors) == 0) {
            //askare on validi
            $chore->save();


            // Kutsutaan alustamamme olion save metodia, joka tallentaa olion tietokantaan
            // Ohjataan käyttäjä lisäyksen jälkeen pelin esittelysivulle
            Redirect::to('/askare/' . $chore->id, array('message' => 'Askare on lisätty muistilistaasi!'));
        }else{
            //askareessa oli jotain vikaa
            View::make('chore/new.html', array('errors'=>$errors, 'attributes'=>$attributes));
        }
    }
    
    // Askareen muokkaaminen (lomakkeen esittäminen)
  public static function edit($id){
    $chore = Chore::find($id);
    View::make('chore/chore_edit.html', array('attributes' => $chore));
  }

  // Askareen muokkaaminen (lomakkeen käsittely)
  public static function update($id){
    $params = $_POST;

    $attributes = array(
      'id' => $id,
      'name' => $params['name'],
      'person_id' => $params['person_id'],
      'urgent' => $params['urgent']
      
    );

    // Alustetaan Chore-olio käyttäjän syöttämillä tiedoilla
    $chore = new Chore($attributes);
    $errors = $chore->errors();

    if(count($errors) > 0){
      View::make('chore/chore_edit.html', array('errors' => $errors, 'attributes' => $attributes));
    }else{
      // Kutsutaan alustetun olion update-metodia, joka päivittää pelin tiedot tietokannassa
      $chore->update();

      Redirect::to('/askare/' . $id, array('message' => 'Askaretta on muokattu onnistuneesti!'));
    }
  }

  // Askareen poistaminen
  public static function destroy($id){
    // Alustetaan Chore-olio annetulla id:llä
    $chore = new Chore(array('id' => $id));
    // Kutsutaan Chore-malliluokan metodia destroy, joka poistaa pelin sen id:llä
    $chore->destroy();

    // Ohjataan käyttäjä askareiden listaussivulle ilmoituksen kera
    Redirect::to('/muistilista', array('message' => 'Askare on poistettu onnistuneesti!'));
  }
}


