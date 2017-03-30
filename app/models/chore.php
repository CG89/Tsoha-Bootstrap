<?php

class Chore extends BaseModel{
    
    public $id, $person_id, $name, $urgent;
    
    public function __construct($attributes) {
        parent::__construct($attributes);
    }
    
    public static function all(){
        $query = DB::connection()->prepare('SELECT * FROM Chore');
        $query->execute();
        $rows=$query->fetchAll();
        $chores=array();
        foreach($rows as $row){
            $chores[]=new Chore(array(
                'id' => $row['id'],
                'person_id' => $row['person_id'],
                'name' => $row['name'],
                'urgent' => $row['urgent']
            ));
        }
        return $chores;
    }
    
    public static function find($id){
        $query=DB::connection()->prepare('SELECT * FROM Chore WHERE id = :id LIMIT 1');
        $query->execute(array('id'=> $id));
        $row=$query->fetch();
        
        if($row){
            $chore =new Chore(array(
                'id' => $row['id'],
                'person_id' => $row['person_id'],
                'name' => $row['name'],
                'urgent' => $row['urgent']
            ));
            
            return $chore;
        }
        
        return null;
    }
         public function save(){
    // Lisätään RETURNING id tietokantakyselymme loppuun, niin saamme lisätyn rivin id-sarakkeen arvon
    $query = DB::connection()->prepare('INSERT INTO Chore (name, person_id, urgent) VALUES (:name, :person_id, :urgent) RETURNING id');
    // Muistathan, että olion attribuuttiin pääse syntaksilla $this->attribuutin_nimi
    $query->execute(array('name' => $this->name, 'person_id' => $this->person_id, 'urgent' => $this->urgent));
    // Haetaan kyselyn tuottama rivi, joka sisältää lisätyn rivin id-sarakkeen arvon
    $row = $query->fetch();
    // Asetetaan lisätyn rivin id-sarakkeen arvo oliomme id-attribuutin arvoksi
    $this->id = $row['id'];
  }     
            
}