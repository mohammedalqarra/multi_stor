<?php


class Person
{
    public $name;
    protected $gender;
    private $age;

    public function setAge($age){
        $this->age = $age;
        return $this;
        // $this عبارة عن reference لل object إلي بننشئه داخل هذا ال class  وعبارة عن variable يبدأ بال $
    }
}

?>
