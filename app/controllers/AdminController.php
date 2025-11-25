<?php

require_once __DIR__ . "/../views/admin/AdminView.php";
class AdminController extends Controller {

    private array $user = [];

    public function __construct() {
        if (!Middleware::isLoggedIn() && !Middleware::isAdmin()) {
            throw new Exception("You do not have permission to access this page.", 403);
        }
        $userID = Middleware::getUser();
        $model = new UserModel();
        $this->user = $model->find([UserModel::ID => $userID]);
    }
    public function index() {
        redirect('admin/users');
    }
    public function users() {
        $model = new UserModel();
        $users = $model->findAll([]);

        $view = new AdminView();
        $view->setUser($this->user);
        $view->setUsers($users);
        $view->setStyle('admin');
        $view->render('users');
    }
    public function nfts() {
        $userTableName = UserModel::getTableName();
        $nftTableName = NftModel::getTableName();

        $model = new NftModel();
        $nfts = $model->join(
            [$nftTableName, $userTableName],
            [['table' => $userTableName, 'on' => $userTableName . '.' . UserModel::ID . ' = public.' . $nftTableName . '.' . NftModel::OWNER_ID]],
            [$nftTableName . '.' . NFTModel::ID, $nftTableName . '.' . NFTModel::NAME, $nftTableName . '.' . NFTModel::TYPE, $nftTableName . '.' . NFTModel::PRICE, $nftTableName . '.' . NFTModel::OWNER_ID, $userTableName . '.' . UserModel::USERNAME],
            'LEFT'
        );

        $view = new AdminView();
        $view->setUser($this->user);
        $view->setNfts($nfts);
        $view->setStyle('admin');
        $view->render('nfts');
    }
    public function transactions() {
        $transactionTableName = TransactionModel::getTableName();
        $userTableName = UserModel::getTableName();
        $nftTableName = NftModel::getTableName();

        $model = new TransactionModel();
        $transactions = $model->join(
            [$transactionTableName, $userTableName, $nftTableName],
            [
                ['table' => $userTableName, 'on' => $userTableName . '.' . UserModel::ID . ' = public.' . $transactionTableName . '.' . TransactionModel::USER_ID],
                ['table' => $nftTableName, 'on' => $nftTableName . '.' . NftModel::ID . ' = public.' . $transactionTableName . '.' . TransactionModel::NFT_ID]
            ],
            [$transactionTableName. '.' .TransactionModel::ID, $transactionTableName. '.' .TransactionModel::TIMESTAMP, $transactionTableName. '.' .TransactionModel::NFT_ID, $transactionTableName. '.' .TransactionModel::USER_ID, $userTableName. '.' .UserModel::USERNAME, $nftTableName. '.' .NftModel::NAME]
        );

        $view = new AdminView();
        $view->setUser($this->user);
        $view->setTransactions($transactions);
        $view->setStyle('admin');
        $view->render('transactions');
    }
    public function editUser() {
        if (!self::isAjaxRequest() && !Middleware::isAdmin()) {
            echo json_encode([
                'success' => false,
                'message' => 'You are not allowed to access this page.'
            ]);
            exit;
        }
        if (empty($_POST['actionSelect'])) {
            echo json_encode([
                'success' => false,
                'message' => 'Invalid action.'
            ]);
            exit;
        }

        $targetUser = $_POST['userId'];
        $currentUser = $this->user['id'];
        $username = $_POST['username'];
        $email = $_POST['email'];

        if ($targetUser == $currentUser) {
            echo json_encode([
                'success' => false,
                'message' => 'Please use the account page to update your information.'
            ]);
            exit;
        }

        $model = new UserModel();
        try {
            $user = $model->find([UserModel::ID => $targetUser]);
            if (!$user) {
                echo json_encode([
                    'success' => false,
                    'message' => 'User does not exist.'
                ]);
                exit;
            }

            $model->update(['id' => $targetUser], [UserModel::USERNAME => $username, UserModel::EMAIL => $email]);

            echo json_encode([
                'success' => true,
                'message' => 'User successfully updated.'
            ]);
        }
        catch (Exception $e) {
            echo json_encode([
                'success' => false,
                'message' => 'Action could not be completed. Please, try again.'
            ]);
        }
    }
    public function changeRole() {
        if (!self::isAjaxRequest() && !Middleware::isAdmin()) {
            echo json_encode([
                'success' => false,
                'message' => 'You are not allowed to access this page.'
            ]);
            exit;
        }
        if (empty($_POST['actionSelect'])) {
            echo json_encode([
                'success' => false,
                'message' => 'Invalid action.'
            ]);
            exit;
        }

        $targetUser = $_POST['userId'];
        $currentUser = $this->user['id'];
        $roleId = $_POST['role'];

        if ($targetUser == $currentUser) {
            echo json_encode([
                'success' => false,
                'message' => 'You cannot do actions on your own account.'
            ]);
            exit;
        }

        $model = new UserModel();
        try {
            $user = $model->find([UserModel::ID => $targetUser]);
            if (!$user) {
                echo json_encode([
                    'success' => false,
                    'message' => 'User does not exist.'
                ]);
                exit;
            }

            $model->update(['id' => $targetUser], [UserModel::ROLE_ID => $roleId]);

            echo json_encode([
                'success' => true,
                'message' => 'User role successfully updated.'
            ]);
        }
        catch (Exception $e) {
            echo json_encode([
                'success' => false,
                'message' => 'Action could not be completed. Please, try again.'
            ]);
        }
    }
    public function handleUserAction() {
        if (!self::isAjaxRequest() && !Middleware::isAdmin()) {
            echo json_encode([
                'success' => false,
                'message' => 'You are not allowed to access this page.'
            ]);
            exit;
        }
        if (empty($_POST['actionSelect'])) {
            echo json_encode([
                'success' => false,
                'message' => 'Invalid action.'
            ]);
            exit;
        }

        $action = $_POST['action'];
        $targetUser = $_POST['userId'];
        $currentUser = $this->user['id'];

        if ($targetUser == $currentUser) {
            echo json_encode([
                'success' => false,
                'message' => 'You cannot do actions on your own account.'
            ]);
            exit;
        }

        $model = new UserModel();
        try {
            $user = $model->find([UserModel::ID => $targetUser]);
            if (!$user) {
                echo json_encode([
                    'success' => false,
                    'message' => 'User does not exist.'
                ]);
                exit;
            }

            switch ($action) {
                case 'deactivate':
                    $currentHash = $user[UserModel::PASS_HASH];
                    if (!str_starts_with($currentHash, '!')) {
                        $currentHash = '!' . $currentHash;
                    }

                    $model->update(['id' => $targetUser], [UserModel::PASS_HASH => $currentHash]);
                    $message = 'User successfully deactivated.';
                    break;
                case 'reactivate':
                    $currentHash = $user[UserModel::PASS_HASH];
                    if (str_starts_with($currentHash, '!')) {
                        $currentHash = substr($currentHash, 1);
                    }

                    $model->update(['id' => $targetUser], [UserModel::PASS_HASH => $currentHash]);
                    $message = 'User successfully activated.';
                    break;
                case 'delete':
                    $model->delete($targetUser);
                    $message = 'User deleted successfully.';
                    break;
                default: {
                    echo json_encode([
                        'success' => false,
                        'message' => 'Invalid action.'
                    ]);
                }
            }

            echo json_encode([
                'success' => true,
                'message' => $message
            ]);
        }
        catch (Exception $e) {
            echo json_encode([
                'success' => false,
                'message' => 'Action could not be completed. Please, try again.'
            ]);
        }
    }

    public function addUser() {
        if (!self::isAjaxRequest() && !Middleware::isAdmin()) {
            echo json_encode([
                'success' => false,
                'message' => 'You are not allowed to access this page.'
            ]);
            exit;
        }

        $username = $_POST['username'];
        $email = $_POST['email'];
        $role = $_POST['role'];
        $password = $_POST['password'];

        if (empty($username) || empty($email) || empty($role) || empty($password)) {
            echo json_encode([
                'success' => false,
                'message' => 'Please fill out all fields.'
            ]);
            exit;
        }

        require_once 'AuthController.php';
        $salt = bin2hex(random_bytes(16));
        $hash = AuthController::hashPassword($password, $salt);

        $model = new UserModel();
        try {
            $inserts = [UserModel::USERNAME => $username,
                UserModel::EMAIL => $email,
                UserModel::PASS_HASH => $hash,
                UserModel::SALT => $salt,
                UserModel::ROLE_ID => $role];

            $model->insert($inserts);

            echo json_encode([
                'success' => true,
                'message' => 'User successfully added.'
            ]);
        }
        catch (Exception $e) {
            echo json_encode([
                'success' => false,
                'message' => 'Action could not be completed. Please, try again.'
            ]);
        }
    }
}