<?php

class Chore extends BaseModel {

    public $id, $person_id, $name, $urgent, $categories;

    public function __construct($attributes) {
        parent::__construct($attributes);
        $this->validators = array('validate_name');
    }

    public static function all($person_id) {
        $query = DB::connection()->prepare('SELECT * FROM Chore WHERE person_id=:person_id');
        $query->execute(array('person_id' => $person_id));
        $rows = $query->fetchAll();
        $chores = array();
        foreach ($rows as $row) {
            $chores[] = new Chore(array(
                'id' => $row['id'],
                'person_id' => $row['person_id'],
                'name' => $row['name'],
                'urgent' => $row['urgent']
            ));
        }
        return $chores;
    }

    public static function find($id) {
        $query = DB::connection()->prepare('SELECT * FROM Chore WHERE id = :id LIMIT 1');
        $query->execute(array('id' => $id));
        $row = $query->fetch();

        if ($row) {
            $chore = new Chore(array(
                'id' => $row['id'],
                'person_id' => $row['person_id'],
                'name' => $row['name'],
                'urgent' => $row['urgent']
            ));

            return $chore;
        }

        return null;
    }

    public static function allWithCategories($person_id) {
        
        $query = DB::connection()->prepare('SELECT * FROM Chore WHERE person_id=:person_id');
        $query->execute(array('person_id' => $person_id));
        $rows = $query->fetchAll();
        $chores = array();
        
        foreach ($rows as $row) {
            $query = DB::connection()->prepare('SELECT Category.name AS category FROM Chore, ChoreCategory, Category'
                    . ' WHERE Chore.id=:chore_id AND Chore.id=ChoreCategory.chore_id AND ChoreCategory.category_id=Category.id');
            $query->execute(array('chore_id' => $row['id']));
            $categories = array();
            $categories = $query->fetchAll();
            
            $chores[] = new Chore(array(
            'id' => $row['id'],
            'person_id' => $row['person_id'],
            'name' => $row['name'],
            'urgent' => $row['urgent'],
            'categories' => $categories
            ));
        }
        
//        $query = DB::connection()->prepare('SELECT * FROM Category WHERE person_id=:person_id');
//        $query->execute(array('person_id' => $person_id));
        return $chores;
    }

    public function save() {
        // Lisätään RETURNING id tietokantakyselymme loppuun, niin saamme lisätyn rivin id-sarakkeen arvon
        $query = DB::connection()->prepare('INSERT INTO Chore (name, person_id, urgent) VALUES (:name, :person_id, :urgent) RETURNING id');
        // Muistathan, että olion attribuuttiin pääse syntaksilla $this->attribuutin_nimi
        $query->execute(array('name' => $this->name, 'person_id' => $this->person_id, 'urgent' => $this->urgent));
        // Haetaan kyselyn tuottama rivi, joka sisältää lisätyn rivin id-sarakkeen arvon
        $row = $query->fetch();
        // Asetetaan lisätyn rivin id-sarakkeen arvo oliomme id-attribuutin arvoksi
        $this->id = $row['id'];
        
        foreach ($this->categories as $category) {
            if($category!=0){
                $attributes = array(
                    'chore_id' => $this->id,
                    'category_id' => $category
                        );
                $chorecategory = new ChoreCategory($attributes);
                $chorecategory->save();
        }}
        }
    

    public function update() {
        $query = DB::connection()->prepare('UPDATE Chore SET name=:name, person_id=:person_id, urgent=:urgent WHERE id=:id');
        $query->execute(array('name' => $this->name, 'person_id' => $this->person_id, 'urgent' => $this->urgent, 'id' => $this->id));
//        $row = $query->fetch();
//        $this->id = $row['id'];
    }

    public function destroy() {
        $attributes= array(
            'chore_id'=>$this->id,
            'category_id'=>0
        );
        $chorecategory= new ChoreCategory($attributes);
        $chorecategory->destroy();
        $query = DB::connection()->prepare('DELETE FROM Chore WHERE id=:id');
        $query->execute(array('id' => $this->id));
        
//        $row = $query->fetch();
//        $this->id = $row['id'];
    }

    public function validate_name() {
        $errors = array();
        if ($this->name == '' || $this->name == null) {
            $errors[] = 'Askare-kenttä ei saa olla tyhjä!';
        }
        if (strlen($this->name) < 2) {
            $errors[] = 'Askareen pituuden tulee olla vähintää kaksi merkkiä!';
        }
        if (strlen($this->name) > 50) {
            $errors[] = 'Askare saa olla enintää 50 merkkiä pitkä!';
        }
        return $errors;
    }

}
