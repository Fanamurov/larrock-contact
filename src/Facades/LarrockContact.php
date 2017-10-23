<?php

namespace Larrock\ComponentContact\Facades;

use Illuminate\Support\Facades\Facade;

class LarrockContact extends Facade
{
    /**
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'larrockcontact';
    }

}