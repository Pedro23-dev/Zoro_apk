<?php
namespace App\Helpers;

use App\Models\Configuation;

class Config{
    public static function getAppname(){
        //deuxieme façon de recuperer la valeur sans passer par first()
        $appName = Configuation::where('type', 'APP_NAME')->value('value');
        return $appName;
    }
}
