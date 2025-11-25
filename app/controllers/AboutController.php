<?php

require_once __DIR__ . "/../views/about/AboutView.php";

class AboutController extends Controller {
    public function index() {
        $view = new AboutView();
        $view->setStyle('about');
        $view->render('about');
    }
}