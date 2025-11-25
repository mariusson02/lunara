<?php

class AuthView extends View {

    private mixed $errors = [];
    private mixed $success = [];

    public function __construct() {
        parent::__construct('auth');
    }

    public function setErrors(array $errors) : void {
        $this->errors = $errors;
    }
    public function getErrors() {
        return $this->errors;
    }

    public function setSuccess(mixed $success) : void {
        $this->success = $success;
    }
    public function getSuccess() {
        return $this->success;
    }

}