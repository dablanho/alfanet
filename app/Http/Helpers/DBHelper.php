<?php


    namespace App\Http\Helpers;

    class DBHelper
    {
        public static function testSchema($schema)
        {

            $schemax=config("database.connections.".config("database.default").".schema");

            if($schema==$schemax)
                return true;
            return false;
        }


    }
