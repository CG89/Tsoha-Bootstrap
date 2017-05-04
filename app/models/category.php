<?php

class Category extends BaseModel {

    public $id, $name, $person_id;

    public function __construct($attributes) {
        parent::__construct($attributes);
        $this->validators = array('validate_name');
    }

    public static function all($person_id) {
        $query = DB::connection()->prepare('SELECT * FROM Category WHERE person_id=:person_id');
        $query->execute(array('person_id' => $person_id));
        $rows = $query->fetchAll();
        $categories = array();
        foreach ($rows as $row) {
            $categories[] = new Category(array(
                'id' => $row['id'],
                'name' => $row['name'],
                'person_id' => $row['person_id']
            ));
        }
        return $categories;
    }

    public static function find($id) {
        $query = DB::connection()->prepare('SELECT * FROM Category WHERE id = :id LIMIT 1');
        $query->execute(array('id' => $id));
        $row = $query->fetch();

        if ($row) {
            $category = new Category(array(
                'id' => $row['id'],
                'name' => $row['name'],
                'person_id' => $row['person_id']
            ));

            return $category;
        }

        return null;
    }

    public function save() {
        $query = DB::connection()->prepare('INSERT INTO Category (name, person_id) VALUES (:name, :person_id) RETURNING id');
        $query->execute(array('name' => $this->name, 'person_id' => $this->person_id));
        $row = $query->fetch();
        $this->id = $row['id'];
    }

    public function update() {
        $query = DB::connection()->prepare('UPDATE Category SET name=:name, person_id=:person_id WHERE id=:id');
        $query->execute(array('name' => $this->name, 'person_id' => $this->person_id, 'id' => $this->id));
    }

    public function destroy() {
        $attributes = array(
            'chore_id' => 0,
            'category_id' => $this->id
        );
        $chorecategory = new ChoreCategory($attributes);
        $chorecategory->destroyCategory();
        $query = DB::connection()->prepare('DELETE FROM Category WHERE id=:id');
        $query->execute(array('id' => $this->id));
    }

    public function validate_name() {

        $errors = array();
        if ($this->name == '' || $this->name == null) {
            $errors[] = 'Luokka-kenttä ei saa olla tyhjä!';
        }
        if (strlen($this->name) < 2) {
            $errors[] = 'Luokan pituuden tulee olla vähintää kaksi merkkiä!';
        }
        if (strlen($this->name) > 20) {
            $errors[] = 'Luokka saa olla enintää 20 merkkiä pitkä!';
        }
        return $errors;
    }

}
