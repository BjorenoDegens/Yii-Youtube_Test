<?php

namespace app\helpers;

class FacebookHelper
{

    public static function vote(array $likes)
    {

        if (count($likes) === 0)
        {
            return "Niemand vind dit leuk";
        }
        elseif (count($likes) === 1 )
        {
            return $likes[0] . " vind dit leuk";
        }
        elseif (count($likes) === 2 )
        {
            return $likes[0] . " en " . $likes[1] .  " vinden dit leuk";
        }
        elseif (count($likes) === 3 )
        {
            return $likes[0] . " en " . $likes[1] . " en " . $likes[2] .   " vinden dit leuk";
        }
        elseif (count($likes) >= 4)
        {
            return $likes[0] . " en " . $likes[1] . " en " . (count($likes) -2) . " andere" . " vinden dit leuk";
        }
        else
        {
            return "Error";
        }
    }
}


