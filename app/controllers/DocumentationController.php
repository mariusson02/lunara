<?php


require_once  __DIR__ . '/../views/documentation/DocumentationView.php';
class DocumentationController extends Controller {

    public function index(){
        $view = new DocumentationView('documentation');
        $view->setTitle('Documentation');
        $view->setStyle('documentation');
        $view->render('documentation');
    }

    public function impressum(){
        $view = new DocumentationView('documentation');
        $view->setTitle('Impressum');
        $view->setStyle('documentation');
        $view->render('impressum');
    }
}