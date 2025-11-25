<?php

require_once __DIR__ . "/../views/account/AccountView.php";

class AccountController extends Controller {

    private array $user;

    public function __construct() {
        if (!Middleware::isLoggedIn()) {
            throw new Exception("You must be logged in to access this page.", 403);
        }
        $userID = Middleware::getUser();
        $model = new UserModel();
        $this->user = $model->find([UserModel::ID => $userID]);
    }
    public function index() {
        redirect('account/edit');
    }
    public function edit() {
        $view = new AccountView();
        $view->setUser($this->user);
        $view->setStyle('account');
        $view->render('edit');
    }
    public function myNfts() {
        if (Middleware::isAdmin()) {
            throw new Exception("You are not allowed to access this page.", 403);
        }
        $userID = $this->user['id'];
        $model = new NftModel();
        $myNfts = $model->findAll([NftModel::OWNER_ID => $userID]);

        $view = new AccountView();
        $view->setUser($this->user);
        $view->setMyNfts($myNfts);
        $view->setStyle('account');
        $view->render('myNfts');
    }
    public function wallet() {
        if (Middleware::isAdmin()) {
            throw new Exception("You are not allowed to access this page.", 403);
        }
        $userID = $this->user['id'];

        $transactionTableName = TransactionModel::getTableName();
        $userTableName = UserModel::getTableName();
        $nftTableName = NftModel::getTableName();

        $model = new UserModel();
        $transactions = $model->join(
            [$transactionTableName, $userTableName, $nftTableName],
            [
                ['table' => $userTableName, 'on' => $userTableName . '.' . UserModel::ID . ' = public.' . $transactionTableName . '.' . TransactionModel::USER_ID],
                ['table' => $nftTableName, 'on' => $nftTableName . '.' . NftModel::ID . ' = public.' . $transactionTableName . '.' . TransactionModel::NFT_ID]
            ],
            [$transactionTableName. '.' .TransactionModel::ID, $transactionTableName. '.' .TransactionModel::TIMESTAMP, $nftTableName. '.' .NftModel::NAME, $nftTableName. '.' .NftModel::SUBTITLE, $nftTableName. '.' .NftModel::PRICE],
            searchParams: [UserModel::ID => $userID]
        );

        $view = new AccountView();
        $view->setUser($this->user);
        $view->setTransactions($transactions);
        $view->setStyle('account');
        $view->render('wallet');
    }
    public function favorites() {
        if (Middleware::isAdmin()) {
            throw new Exception("You are not allowed to access this page.", 403);
        }

        $userID = $this->user['id'];

        $favoritesTableName = FavoriteModel::getTableName();
        $nftTableName = NftModel::getTableName();

        $model = new FavoriteModel();
        $favorites = $model->join(
            [$favoritesTableName, $nftTableName],
            [
                ['table' => $nftTableName, 'on' => $nftTableName . '.' . NftModel::ID . ' = public.' . $favoritesTableName . '.' . FavoriteModel::NFT_ID]
            ],
            [$nftTableName . '.' . NftModel::ID, $nftTableName . '.' . NftModel::NAME, $nftTableName . '.' . NftModel::SUBTITLE, $nftTableName . '.' . NftModel::IMG],
            searchParams: [FavoriteModel::USER_ID => $userID]
        );
        error_log(print_r($favorites, true));
        $view = new AccountView();
        $view->setUser($this->user);
        $view->setFavorites($favorites);
        $view->setStyle('account');
        $view->render('favorites');
    }
    public function changeUsername() {
        if (!self::isAjaxRequest()) {
            echo json_encode([
                'success' => false,
                'message' => 'You are not allowed to access this page.'
            ]);
            exit;
        }
        if (empty($_POST['username'])) {
            echo json_encode([
                'success' => false,
                'message' => 'Bad Gateway'
            ]);
            exit;
        }
        $username = sanitize($_POST['username']);

        $model = new UserModel();
        try {
            $model->update(['id' => $this->user['id']], [UserModel::USERNAME => $username]);
            echo json_encode([
                'success' => true,
                'message' => 'Successfully changed your username!'
            ]);
        }
        catch (Exception $e) {
            $message = 'Username could not be updated. Please, try again.';
            if ($e->getCode() == 23000) {
                $message = 'Username could not be updated. A user with that username already exists.';
            }
            echo json_encode([
                'success' => false,
                'message' => $message,
            ]);
        }
    }
    public function changeEmail() {
        if (!self::isAjaxRequest()) {
            echo json_encode([
                'success' => false,
                'message' => 'You are not allowed to access this page.'
            ]);
            exit;
        }
        if (empty($_POST['email'])) {
            echo json_encode([
                'success' => false,
                'message' => 'Bad Gateway'
            ]);
            exit;
        }
        $email = sanitize($_POST['email']);

        $model = new UserModel();
        try {
            $model->update(['id' => $this->user['id']], [UserModel::EMAIL => $email]);
            echo json_encode([
                'success' => true,
                'message' => 'Successfully changed your email address!'
            ]);
        }
        catch (Exception $e) {
            $message = 'Email could not be updated. Please, try again later.';
            if ($e->getCode() == 23000) {
                $message = 'Email could not be updated. Email address is already linked to an existing account.';
            }
            echo json_encode([
                'success' => false,
                'message' => $message,
            ]);
        }
    }
    public function changeWallet() {
        if (!self::isAjaxRequest()) {
            echo json_encode([
                'success' => false,
                'message' => 'You are not allowed to access this page.'
            ]);
            exit;
        }
        if (empty($_POST['wallet'])) {
            echo json_encode([
                'success' => false,
                'message' => 'Bad Gateway'
            ]);
            exit;
        }
        $wallet = sanitize($_POST['wallet']);

        $model = new UserModel();
        try {
            $model->update(['id' => $this->user['id']], [UserModel::WALLET => $wallet]);
            echo json_encode([
                'success' => true,
                'message' => 'Successfully changed your wallet address!'
            ]);
        }
        catch (Exception $e) {
            $message = 'Wallet address could not be updated. Please, try again.';
            if ($e->getCode() == 23000) {
                $message = 'Wallet address could not be updated. Wallet address is already linked to an existing account.';
            }
            echo json_encode([
                'success' => false,
                'message' => $message,
            ]);
        }
    }
    public function changePassword() {
        if (!self::isAjaxRequest()) {
            echo json_encode([
                'success' => false,
                'message' => 'You are not allowed to access this page.'
            ]);
            exit;
        }
        if (empty($_POST['password'] || empty($_POST['newPassword']))) {
            echo json_encode([
                'success' => false,
                'message' => 'Bad Gateway'
            ]);
            exit;
        }

        require_once 'AuthController.php';
        $result = AuthController::changePassword($this->user['id'], $_POST['password'], $_POST['newPassword']);
        echo json_encode($result);
    }

    /** Changes ownership of an NFT via the account user settings.
     *  Sells the nft if no $newOwner is set.
     *  $newOwner is null by default
     *
     * @param null $newOwner
     */
    public function changeOwnership($newOwner = null) {

        $userId = Middleware::getUser();

        if (!self::isAjaxRequest() || $userId === -1) {
            echo json_encode([
                'success' => false,
                'message' => 'You are not allowed to access this page.'
            ]);
            exit;
        }

        if (empty($_POST['nftId'])) {
            echo json_encode([
                'success' => false,
                'message' => 'Bad Gateway'
            ]);
            exit;
        }
        $nftId = sanitize($_POST['nftId']);

        $transactionModel = new TransactionModel();
        $nftModel = new NftModel();
        try {
            $nftToSell = $nftModel->find([NftModel::ID => $nftId]);
            if($nftToSell[NftModel::ID] !== -1 && $nftToSell[NftModel::OWNER_ID] === $userId) {
                $currentPrice = $nftToSell[NftModel::PRICE];
                $now = new DateTime('now', new DateTimeZone('UTC'));
                $timestamp = $now->format('Y-m-d H:i:sP');

                $insertTransactionParams = [
                    TransactionModel::USER_ID => $userId,
                    TransactionModel::NFT_ID => $nftId,
                    TransactionModel::PRICE => $currentPrice,
                    TransactionModel::TIMESTAMP => $timestamp
                ];

                $transactionModel->insert($insertTransactionParams);
                $nftModel->changeOwnerById($nftId, $newOwner);

                echo json_encode([
                    'success' => true,
                    'message' => 'Successfully sold ' . $nftToSell[NftModel::NAME],
                ]);
            } else {
                echo json_encode([
                    'success' => false,
                    'message' => 'Bad Gateway'
                ]);
            }
        }
        catch (Exception $e) {
            error_log("Failed to sell nft: " . $e->getMessage());
            echo json_encode([
                'success' => false,
                'message' => 'Nft could not be sold.',
            ]);
        }
    }
}