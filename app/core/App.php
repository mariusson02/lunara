<?php

class App {

    const string CONTROLLER_PATH = '../app/controllers/';

    /**
     * Splits the URL from the request URI into an array of path segments.
     *
     * This method takes the current request URI, trims any leading and trailing slashes,
     * and splits the URI into components by the '/' character. It defaults to returning the
     * 'landing' controller if the URL is empty (i.e., the root URL).
     *
     * @return array An array containing the segments of the URL. If the URL is empty, it returns `['landing']`.
     */
    private function splitUrl(): array
    {
        if (!isset($_GET['url']) || $_GET['url'] === '') {
            return ['landing'];
        }

        return explode('/', trim($_GET['url'], '/'));
    }

    /**
     * Loads the controller and method based on the URL and invokes the method with arguments.
     *
     * This method extracts the URL segments using `splitUrl()`, loads the corresponding controller
     * file, and checks if the specified method exists. If the method is valid, it is called with any
     * remaining URL segments as arguments. If no valid controller or method is found, defaults to
     * the `ErrorController` or `index` method.
     *
     * @return void
     */
    public function loadController(): void
    {
        try {
            $url = $this->splitUrl();

            $controllerName = ucfirst($url[0]) . 'Controller';
            $controllerFile = self::CONTROLLER_PATH . $controllerName . '.php';

            if (!file_exists($controllerFile)) {
                throw new Exception("Ressource not found.", 404);
            }

            require_once $controllerFile;
            $controller = new $controllerName();

            $action = !empty($url[1]) ? $url[1] : 'index';
            if (!method_exists($controller, $action)) {
                throw new Exception("Not found.", 404);
            }

            call_user_func_array([$controller, $action], array_slice($url, 2));
        } catch (Exception $e) {
            require_once self::CONTROLLER_PATH . 'ErrorController.php';
            ErrorController::handleError($e);
        }
    }
}
