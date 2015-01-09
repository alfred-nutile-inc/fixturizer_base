<?php
/**
 * Created by PhpStorm.
 * User: alfrednutile
 * Date: 11/29/14
 * Time: 3:19 PM
 */

namespace AlfredNutileInc\Fixturizer;


use Illuminate\Support\Facades\Facade;

class FixturizerReader extends Facade {

    /**
     * Get the registered name of the component.
     * @see \AlfredNutileInc\Fixturizer\Reader
     * @return string
     */
    protected static function getFacadeAccessor() { return 'fixturize.reader'; }
} 