<?php


class Person
{
    public $name;
    protected $gender;
    private $age;

    public static $country;

    public function setAge($age){
        $this->age = $age;
        return $this;
        // $this عبارة عن reference لل object إلي بننشئه داخل هذا ال class  وعبارة عن variable يبدأ بال $
    }

    // static method ما بينفع أستخدم بداخلها $this  لانوا دائما" تعود على ال reference
    // في حال ال static properties  لازم أضع ال $

    public static function setCountry($country){
            salf::$country = $country;
        }

}

?>
