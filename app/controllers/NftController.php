<?php

require_once __DIR__ . "/../views/nft/NftView.php";

class NftController extends Controller {

    public function __construct() {
    }

    public function index(...$uri) {

        if (!empty($_GET) && isset($_GET['id'])) {
            $model = new NftModel();
            $nft = $model->find([NftModel::ID => $_GET['id']]);
            $view = new NftView();
            $view->setNft($nft);
            $view->setStyle("detail");
            $view->render("nft");
        }
        else {
            throw new Exception('Ressource not found.', 404);
        }
    }

}