<?php


/**
 * Base Controller Class
 */
class Controller {
    public static function isAjaxRequest() : bool {
        return $_SERVER['REQUEST_METHOD'] === 'POST' && isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'ajax';
    }
}