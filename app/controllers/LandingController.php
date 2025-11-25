<?php

require_once __DIR__ . "/../views/landing/LandingView.php";

/**
 * Landing Controller
 */
class LandingController extends Controller {

    public function index() {
        $view = new LandingView();
        $view->render("landing", fullPage: false);
    }
}

