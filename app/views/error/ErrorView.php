<?php

class ErrorView extends View {
    private $error = "An unknown error occurred.";

    public function __construct() {
        parent::__construct('error');
    }

    public function setError(string $error): void {
        $this->error = $error;
    }

    public function getError(): string {
        return $this->error;
    }
}
