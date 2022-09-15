<?php
namespace app\helpers;
class User
{
    public $gebruiker;

    public function __construct($gebruiker)
    {
        $this->gebruiker = $gebruiker;
    }

    public function __toString()
    {
        return $this->gebruiker;
    }
}