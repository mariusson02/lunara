<?php

require_once __DIR__ . '/../views/checkout/CheckoutView.php';

class CheckoutController extends Controller {

    public function index() {
        $model = new UserModel();
        $userId = Middleware::getUser();
        $user = null;
        if($userId !== -1) {
            $user = $model->find([UserModel::ID => $userId]);
        }

        $view = new CheckoutView();
        $view->setUser($user);
        $view->setTitle("Checkout - Lunara");
        $view->setStyle("checkout");
        $view->render("checkout");
    }

    /**
     * Retrieves NFT items for the shopping cart.
     *
     * Accepts a comma-separated list of NFT IDs via the `ids` query parameter.
     * Fetches the corresponding NFT data from the database and returns it as a JSON response.
     * Logs and returns a 500 Internal Server Error response if an exception occurs.
     *
     * @return void
     */
    public function getCardItems() {

        try {
            $nftIds = $_GET["ids"];
            error_log($nftIds);
            $nftIds = explode(",", $nftIds);
            error_log(print_r($nftIds, true));
            $model = new NftModel();
            $nfts = $model->getNftsByIds($nftIds);

            header('Content-type: application/json');
            echo json_encode($nfts);

        } catch (Exception $e) {
            header("HTTP/1.0 500 Internal Server Error");
            error_log("Error getting Card NFTs: " . $e->getMessage());
        }
    }

    /**
     * Processes the checkout operation for the shopping cart.
     *
     * Validates the shopping cart and user session:
     * - Retrieves NFT IDs from the `shoppingCart` cookie.
     * - Ensures each NFT is valid and not already owned.
     * - Creates a transaction for each NFT and updates its ownership.
     *
     * Outputs a JSON response indicating success or failure.
     * Logs errors and returns a 500 Internal Server Error response if an exception occurs.
     *
     * @return void
     */
    public function checkout() {

        if (Middleware::isLoggedIn()) {
            $success = false;
            try {
                $nftIds = json_decode($_COOKIE["shoppingCart"]);
                if (!is_array($nftIds) || count($nftIds) <= 0) {
                    throw new Exception("There are no items in the shopping cart.");
                }

                $userId = $_SESSION["USER_ID"] ?? null;
                if(!$userId) {
                    throw new Exception("UserID not found");
                }

                $transactionModel = new TransactionModel();
                $nftModel = new NftModel();

                $success = true;
                foreach ($nftIds as $nftId) {
                    $nft = $nftModel->find([NftModel::ID => $nftId]);
                    if($nft[NftModel::ID] === 0) {
                        throw new Exception("Nft not found");
                    }
                    if($nft[NftModel::OWNER_ID] !== null) {
                        throw new Exception("Nft with id ". $nft->getId() . " already has an owner");
                    }

                    $currentPrice = $nft[NftModel::PRICE];
                    $now = new DateTime('now', new DateTimeZone('UTC'));
                    $timestamp = $now->format('Y-m-d H:i:sP');

                    $insertTransactionParams = [
                        TransactionModel::USER_ID => $userId,
                        TransactionModel::NFT_ID => $nftId,
                        TransactionModel::PRICE => $currentPrice,
                        TransactionModel::TIMESTAMP => $timestamp
                    ];

                    $transactionSuccess = $transactionModel->insert($insertTransactionParams);
                    $changeOwnerSuccess = $nftModel->changeOwnerById($nftId, $userId);

                    if(!$transactionSuccess || !$changeOwnerSuccess) {
                        $success = false;
                    }
                }
                header('Content-type: application/json');
                echo json_encode(["success" => $success]);
            } catch (Exception $e) {
                header("HTTP/1.0 500 Internal Server Error");
                error_log("Error getting Card: " . $e->getMessage());
                echo json_encode(["success" => $success]);
            }

        }
    }
}