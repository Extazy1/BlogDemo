<?php

namespace frontend\models;

class DynamicModel {
    private $attributes = [];

    public function __set($name, $value) {
        $this->attributes[$name] = $value;
    }

    public function __get($name) {
        return $this->attributes[$name] ?? null;
    }
}

?>