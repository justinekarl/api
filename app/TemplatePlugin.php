<?php

namespace App;


class TemplatePlugin
{

    public static function currentLocation()
    {
        $location="http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]/";
        return $location;
    }

    public static function rootLocation()
    {
        $location="http://$_SERVER[HTTP_HOST]/";
        return $location;
    }


}
