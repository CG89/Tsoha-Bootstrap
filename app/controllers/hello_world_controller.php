<?php



class HelloWorldController extends BaseController {

    public static function index() {
        // make-metodi renderöi app/views-kansiossa sijaitsevia tiedostoja
        View::make('home.html');
    }

    public static function sandbox() {
        // Testaa koodiasi täällä
//        View::make('helloworld.html');
        $pyykki=Chore::find(1);
        $chores=Chore::all();
        Kint::dump($chores);
        Kint::dump($pyykki);
    }

    public static function chore_list() {
        View::make('chore_list.html');
    }

    public static function chore_show() {
        View::make('chore_show.html');
    }

    public static function chore_edit() {
        View::make('chore_edit.html');
    }

}
