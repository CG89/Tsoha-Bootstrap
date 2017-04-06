<?php

class Person extends BaseModel {

    public $id, $name, $password;

    public function __construct($attributes) {
        parent::__construct($attributes);
        $this->validators = array('validate_name');
    }

    public static function all() {
        $query = DB::connection()->prepare('SELECT * FROM Person');
        $query->execute();
        $rows = $query->fetchAll();
        $persons = array();
        foreach ($rows as $row) {
            $persons[] = new Person(array(
                'id' => $row['id'],
                'name' => $row['name'],
                'password' => $row['password']
            ));
        }
        return $persons;
    }

    public static function find($id) {
        $query = DB::connection()->prepare('SELECT * FROM Person WHERE id = :id LIMIT 1');
        $query->execute(array('id' => $id));
        $row = $query->fetch();

        if ($row) {
            $person = new Person(array(
                'id' => $row['id'],
                'name' => $row['name'],
                'password' => $row['password']
            ));

            return $person;
        }

        return null;
    }

    public static function authenticate($name, $password) {
        $query = DB::connection()->prepare('SELECT * FROM Person WHERE name=:name AND password=:password LIMIT 1');
        $query->execute(array('name'=>$name,'password'=>$password));
        $row = $query->fetch();

        if ($row) {
            $person = new Person(array(
                'id' => $row['id'],
                'name' => $row['name'],
                'password' => $row['password']
            ));

            return $person;
        }

        return null;
    }
    
        public function validate_name() {
        $errors = array();
        if ($this->name == '' || $this->name == null) {
            $errors[] = 'Käyttäjätunnus-kenttä ei saa olla tyhjä!';
        }
        if (strlen($this->name) < 3) {
            $errors[] = 'Käyttäjätunnuksen pituuden tulee olla vähintää kolme merkkiä!';
        }
        if (strlen($this->name)>50){
            $errors[]='käyttäjätunnus saa olla enintää 50 merkkiä pitkä!';
        }
        return $errors;
    }

}
