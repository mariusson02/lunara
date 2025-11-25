<?php

require_once __DIR__ ."/../models/FavoriteModel.php";
class FavoriteController extends Controller
{

    /**
     * Toggles the favorite status of an NFT for the current user.
     *
     * Processes a JSON payload containing the `nft_id`:
     * - If the NFT is already favorited by the user, it removes it from favorites.
     * - If not, it adds the NFT to the user's favorites.
     *
     * Returns a JSON response with the updated favorite status:
     * - `favorited`: Boolean indicating the new status.
     *
     * Sends a 500 Internal Server Error response if an exception occurs.
     *
     * @return void
     */
    public function toggleFavorite(){
        try {
            $input = file_get_contents('php://input');
            $data = json_decode($input, true);

            $nftId = $data["nft_id"] ?? null;
            if (!$nftId) {
                throw new Exception("NFT ID is required.");
            }

            $userId = $_SESSION["USER_ID"] ?? null;
            if (!$userId) {
                throw new Exception("User must be logged in.");
            }

            $model = new FavoriteModel();
            $isFavorited = $model->isFavorited($userId, $nftId);

            $response = ["favorited" => !$isFavorited];

            if ($isFavorited) {
                $model->removeFavorite($userId, $nftId);
            } else {
                $model->addFavorite($userId, $nftId);
            }

            header('Content-type: application/json');
            echo json_encode($response);

        } catch (Exception $e) {
            header("HTTP/1.0 500 Internal Server Error");
            error_log("Error: " . $e->getMessage());
        }
    }

    /**
     * Retrieves the favorite NFTs of the current user.
     *
     * Checks the user's session for a valid user ID and fetches all favorited NFT IDs
     * associated with that user from the database.
     *
     * Returns a JSON response containing an array of NFT IDs.
     * Sends a 500 Internal Server Error response if an exception occurs.
     *
     * @return void
     */
    public function getUserFavorites(){
        try {
            $userId = $_SESSION["USER_ID"] ?? null;
            if (!$userId) {
                throw new Exception("User must be logged in.");
            }
            $model = new FavoriteModel();
            $favorites = $model->getNftIdsByUserId($userId);

            header('Content-type: application/json');
            echo json_encode($favorites);
        } catch (Exception $e) {
            header("HTTP/1.0 500 Internal Server Error");
            error_log("Error: " . $e->getMessage());
        }
    }

}