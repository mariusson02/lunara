<?php

require_once __DIR__ . "/../views/browse/BrowseView.php";

class BrowseController extends Controller {

    public function index() {
        $model = new NftModel();
        $types = $model->getAvailableTypes();

        $view = new BrowseView();
        $view->setTitle("Browse");
        $view->setStyle("browse");
        $view->setTypes($types);
        $view->render("browse");
    }

    /**
     * Retrieves a filtered list of NFTs.
     *
     * Accepts various query parameters to filter, sort, and paginate NFT data:
     * - `search`: Filter by keyword in names or descriptions.
     * - `type`: Filter by NFT type.
     * - `max_price` and `min_price`: Set price range for filtering.
     * - `available`: Filter by availability status.
     * - `sort`: Define the sorting order (e.g., price, name).
     * - `limit` and `offset`: Control pagination.
     *
     * Outputs a JSON response containing the filtered NFTs or an error message.
     * Returns HTTP 500 in case of an error.
     *
     * @return void
     */
    public function getNfts() {

        try {

            $search = $_GET["search"] ??  '';
            $type = $_GET["type"] ?? '';
            $max_price = $_GET["max_price"] ?? null;
            $min_price = $_GET["min_price"] ?? null;
            $available = $_GET["available"] ?? false;
            $sort = $_GET["sort"] ?? '';
            $limit = $_GET["limit"] ?? 20;
            $offset = $_GET["offset"] ?? 0;

            $model = new NftModel();

            $nfts = $model->filterByParams(
                $search,
                $type,
                $max_price,
                $min_price,
                $available,
                $sort,
                $limit,
                $offset
            );

            header('Content-type: application/json');
            echo json_encode($nfts);

        } catch (Exception $e) {
            header("HTTP/1.0 500 Internal Server Error");
            error_log("Error getting Nfts: " . $e->getMessage());
        }
    }
}