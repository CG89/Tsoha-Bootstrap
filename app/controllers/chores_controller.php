<?php

class ChoreController extends BaseController {

    //Kutsuu näkymän, joka näyttää kirjautuneen käyttäjän muistilistan sisällön.
    public static function index() {
        self::check_logged_in();
        $chores = Chore::allWithCategories(self::get_user_logged_in()->id);
        
        View::make('chore/chore_list.html', array('chores' => $chores));
    }

    //Kutsuu näkymän, joka näyttää tietyn askareen tiedot.
    public static function show($id) {
        self::check_logged_in();
        $chore = Chore::find($id);
        View::make('chore/chore_show.html', array('chore' => $chore));
    }
    //Kutsuu näkymää, joka mahdollistaa uuden askareen tallentamisen tietokantaan.
    public static function create() {
        self::check_logged_in();
        $categories= Category::all(self::get_user_logged_in()->id);
        View::make('chore/new.html', array('categories' => $categories));
    }
    //Tarkistaa POST-pyynnön muuttujien validiteetin ja joko kutsuu Chore-luokan save-metodia ja ohjaa askareen esittelysivulle
    //tai jos virheitä löytyy, kutsuu uuden askareen luonti-näkymän ja antaa sille virheilmoitukset.
    public static function store() {
        self::check_logged_in();
        // POST-pyynnön muuttujat sijaitsevat $_POST nimisessä assosiaatiolistassa
        $params = $_POST;
        
       $categories=$params['categories'];
        

        // Alustetaan uusi Chore-luokan olion käyttäjän syöttämillä arvoilla
        $attributes = array(
            'name' => $params['name'],
            'person_id' => $params['person_id'],
            'urgent' => $params['urgent'],
            'categories' => array()
        );
        if($categories!=0){
        foreach ($categories as $category) {
            
            $attributes['categories'][]=$category;
        }}
        $chore = new Chore($attributes);
        $errors = $chore->errors();
        if (count($errors) == 0) {
            //askare on validi
            $chore->save();


            // Kutsutaan alustamamme olion save metodia, joka tallentaa olion tietokantaan
            // Ohjataan käyttäjä lisäyksen jälkeen pelin esittelysivulle
            Redirect::to('/muistilista', array('message' => 'Askare on lisätty muistilistaasi!'));
        } else {
            //askareessa oli jotain vikaa
            View::make('chore/new.html', array('errors' => $errors, 'attributes' => $attributes));
        }
    }

    // Askareen muokkaaminen (lomakkeen esittäminen).
    public static function edit($id) {
        self::check_logged_in();
        $chore = Chore::find($id);
        View::make('chore/chore_edit.html', array('attributes' => $chore));
    }

    // Askareen muokkaaminen (lomakkeen käsittely).
    public static function update($id) {
        self::check_logged_in();
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

        if (count($errors) > 0) {
            View::make('chore/chore_edit.html', array('errors' => $errors, 'attributes' => $attributes));
        } else {
            // Kutsutaan alustetun olion update-metodia, joka päivittää pelin tiedot tietokannassa
            $chore->update();

            Redirect::to('/askare/' . $id, array('message' => 'Askaretta on muokattu onnistuneesti!'));
        }
    }

    // Askareen poistaminen.
    public static function destroy($id) {
        self::check_logged_in();
        // Alustetaan Chore-olio annetulla id:llä
        $chore = new Chore(array('id' => $id));
        // Kutsutaan Chore-malliluokan metodia destroy, joka poistaa pelin sen id:llä
        $chore->destroy();

        // Ohjataan käyttäjä askareiden listaussivulle ilmoituksen kera
        Redirect::to('/muistilista', array('message' => 'Askare on poistettu onnistuneesti!'));
    }

}
