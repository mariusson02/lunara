<?php

class CheckoutView extends View {

    private $user = null;

    public function __construct() {
        parent::__construct('checkout');
    }

    public function setUser($user) {
        $this->user = $user;
    }

    public function getUser() {
        return $this->user;
    }

}