<?php

class CategoryController extends BaseController {

    //Kutsuu näkymän, joka näyttää kirjautuneen käyttäjän tallennetut luokat.
    public static function index() {
        self::check_logged_in();
        $categories = Category::all(self::get_user_logged_in()->id);
        View::make('category/category_list.html', array('categories' => $categories));
    }

    //Kutsuu näkymän, joka näyttää tietyn luokan tiedot ja mahdollistaa muokkaamisen.
    public static function show($id) {
        self::check_logged_in();
        $category = Category::find($id);
        View::make('category/category_show.html', array('category' => $category));
    }

    //kutsuu näkymän, joka mahdollistaa uuden luokan tallentamisen tietokantaan.
    public static function create() {
        self::check_logged_in();
        View::make('category/category_new.html');
    }

    //Tarkistaa POST-pyynnön muuttujien validiteetin ja joko kutsuu Category-luokan save-metodia ja ohjaa luokkien esittelysivulle
    //tai jos virheitä löytyy, kutsuu uuden luokan luonti-näkymän ja antaa sille virheilmoitukset.
    public static function store() {
        self::check_logged_in();
        // POST-pyynnön muuttujat sijaitsevat $_POST nimisessä assosiaatiolistassa
        $params = $_POST;

        // Alustetaan uusi Chore-luokan olion käyttäjän syöttämillä arvoilla
        $attributes = array(
            'name' => $params['name'],
            'person_id' => $params['person_id']
        );
        $category = new Category($attributes);
        $errors = $category->errors();
        if (count($errors) == 0) {
            //askare on validi
            $category->save();


            // Kutsutaan alustamamme olion save metodia, joka tallentaa olion tietokantaan
            // Ohjataan käyttäjä lisäyksen jälkeen pelin esittelysivulle
            Redirect::to('/luokat', array('message' => 'Luokka on lisätty onnistuneesti!'));
        } else {
            //askareessa oli jotain vikaa
            View::make('category/category_new.html', array('errors' => $errors, 'attributes' => $attributes));
        }
    }

    //Kutsuu luokan muokkausnäkymää ja antaa sille luokan tiedot.
    public static function edit($id) {
        self::check_logged_in();
        $category = Category::find($id);
        View::make('category/category_edit.html', array('attributes' => $category));
    }

    // luokan muokkaaminen (lomakkeen käsittely).
    public static function update($id) {
        self::check_logged_in();
        $params = $_POST;

        $attributes = array(
            'id' => $id,
            'name' => $params['name'],
            'person_id' => $params['person_id']
        );

        // Alustetaan Category-olio käyttäjän syöttämillä tiedoilla
        $category = new Category($attributes);
        $errors = $category->errors();

        if (count($errors) > 0) {
            View::make('category/category_edit.html', array('errors' => $errors, 'attributes' => $attributes));
        } else {
            // Kutsutaan alustetun olion update-metodia, joka päivittää luokan tiedot tietokannassa
            $category->update();

            Redirect::to('/luokat', array('message' => 'Luokkaa on muokattu onnistuneesti!'));
        }
    }

    // Luokan poistaminen.
    public static function destroy($id) {
        self::check_logged_in();
        // Alustetaan Category-olio annetulla id:llä
        $category = new Category(array('id' => $id));
        // Kutsutaan Category-malliluokan metodia destroy, joka poistaa pelin sen id:llä
        $category->destroy();

        // Ohjataan käyttäjä luokkien listaussivulle ilmoituksen kera
        Redirect::to('/luokat', array('message' => 'Luokka on poistettu onnistuneesti!'));
    }

}
