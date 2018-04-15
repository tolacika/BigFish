<?php
/**
 * Created by PhpStorm.
 * User: Tolacika
 * Date: 2018. 04. 15.
 * Time: 14:19
 */

namespace App;


class stdObject {
    function __get($name) { return property_exists($this, $name) ? $this->$name : null; }

    function __set($name, $value) { return $this->$name = $value; }

    function __isset($name) { return property_exists($this, $name); }

    function __unset($name) {
        if (property_exists($this, $name)) {
            unset($this->$name);
        }
    }
}