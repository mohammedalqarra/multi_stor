<?php

function  load_class($classname){
    include  __DIR__ . "/{$classname}.php";

}

spl_autoload_register('load_class'); //Go Back تمرير function ل function
