<?php

class BrowseView extends View {

    private $types = [];

    public function __construct() {
        parent::__construct('browse');
    }

    public function setTypes($types) {
        $this->types = $types;
    }
    public function getTypes() {
        return $this->types;
    }

}