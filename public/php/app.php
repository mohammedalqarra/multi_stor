<?php


include __DIR__ . '/person.php'; // __ نبدأ وتنتهي __ #magic constant php#

// namespace مجرد فصلل للكود


$person =  new Person;

$person->name = 'Mohammed';

$person::$country = 'Palestine';

var_dump($person);

echo Person::$country;
