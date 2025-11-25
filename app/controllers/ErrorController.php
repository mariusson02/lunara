<?php

require_once __DIR__ . "/../views/error/ErrorView.php";

class ErrorController extends Controller {

    /**
     * Handles application errors and displays the error page.
     *
     * Processes exceptions and sets the appropriate HTTP status code based on the error:
     * - 404: Not Found
     * - 403: Forbidden
     * - 500: Internal Server Error (default)
     *
     * Renders an error view with the error code and message.
     *
     * @param Exception $exception The exception containing the error details.
     * @return void
     */
    public static function handleError($exception) {
        $errorCode = $exception->getCode();
        $errorMessage = $exception->getMessage();

        switch ($errorCode) {
            case 404:
                header("HTTP/1.1 404 Not Found");
                break;
            case 403:
                header("HTTP/1.1 403 Forbidden");
                break;
            default:
                header("HTTP/1.1 500 Internal Server Error");
                break;
        }

        $errorView = new ErrorView();
        $errorView->setError("$errorCode - $errorMessage");
        $errorView->render("error");
    }
}
