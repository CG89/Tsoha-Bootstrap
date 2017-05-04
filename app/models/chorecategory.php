<?php

class ChoreCategory extends BaseModel {

    public $chore_id, $category_id;

    public function __construct($attributes) {
        parent::__construct($attributes);
//        $this->validators = array('validate_name');
    }

    public static function all() {
        $query = DB::connection()->prepare('SELECT * FROM ChoreCategory');
        $query->execute();
        $rows = $query->fetchAll();
        $chorecategories = array();
        foreach ($rows as $row) {
            $chorecategories[] = new ChoreCategory(array(
                'chore_id' => $row['chore_id'],
                'category_id' => $row['category_id']
            ));
        }
        return $chorecategories;
    }

    public static function find($chore_id) {
        $query = DB::connection()->prepare('SELECT * FROM ChoreCategory WHERE chore_id = :chore_id');
        $query->execute(array('chore_id' => $chore_id));
        $rows = $query->fetchALL();

        if ($rows) {
            foreach ($rows as $row) {
                $chorecategories[] = new ChoreCategory(array(
                    'chore_id' => $row['chore_id'],
                    'category_id' => $row['category_id']
                ));
            }
            return $chorecategories;
        }

        return null;
    }

    public static function findCategories($chore_id) {
        $query = DB::connection()->prepare('SELECT Category.name AS name FROM ChoreCategory, Category WHERE  ChoreCategory.chore_id = :chore_id AND ChoreCategory.category_id=Category.id');
        $query->execute(array('chore_id' => $chore_id));
        $rows = $query->fetchALL();

        if ($rows) {
//            foreach ($rows as $row){
//            $chorecategories[] = new Category(array(
//                'chore_id' => $row['chore_id'],
//                'category_id' => $row['category_id']
//            ));
//            }
            return $rows;
        }

        return null;
    }

    public function save() {
        if (is_array($this->category_id)) {
            foreach ($this->category_id as $category_id) {


                $query = DB::connection()->prepare('INSERT INTO ChoreCategory (chore_id, category_id) VALUES (:chore_id, :category_id)');
                // Muistathan, että olion attribuuttiin pääse syntaksilla $this->attribuutin_nimi

                $query->execute(array('chore_id' => $this->chore_id, 'category_id' => $category_id));
            }
        } else {
            $query = DB::connection()->prepare('INSERT INTO ChoreCategory (chore_id, category_id) VALUES (:chore_id, :category_id)');
            $query->execute(array('chore_id' => $this->chore_id, 'category_id' => $this->category_id));
        }
    }


    public function destroy() {
        $query = DB::connection()->prepare('DELETE FROM ChoreCategory WHERE chore_id=:chore_id');
        $query->execute(array('chore_id' => $this->chore_id));

    }
    
        public function destroyCategory() {
        $query = DB::connection()->prepare('DELETE FROM ChoreCategory WHERE category_id=:category_id');
        $query->execute(array('category_id' => $this->category_id));

    }

//    public function validate_name() {
//        $errors = array();
//        if ($this->name == '' || $this->name == null) {
//            $errors[] = 'Askare-kenttä ei saa olla tyhjä!';
//        }
//        if (strlen($this->name) < 2) {
//            $errors[] = 'Askareen pituuden tulee olla vähintää kaksi merkkiä!';
//        }
//        if (strlen($this->name) > 50) {
//            $errors[] = 'Askare saa olla enintää 50 merkkiä pitkä!';
//        }
//        return $errors;
//    }
}
