<?php

use Random\RandomException;

require_once __DIR__ . "/../views/auth/AuthView.php";
require_once __DIR__ . "/../views/nft/NftView.php";

require_once __DIR__ . "/../models/dto/UserDto.php";

class AuthController extends Controller {

    public function index(): void {
        if(Middleware::isLoggedIn()) {
            redirect('landing');
        }
        $view = new AuthView();
        $view->setStyle("login");
        $view->render('login', fullPage: false);
    }

    /**
     * Handles user signup requests.
     *
     * Processes both GET and POST requests for user registration.
     * - GET: Displays the signup page.
     * - POST: Validates input, creates a new user, and redirects to the NFT page upon success.
     *
     * @return void
     * @throws RandomException
     */
    public function signup(): void {
        if(Middleware::isLoggedIn()) {
            redirect('landing');
        }
        if($_SERVER['REQUEST_METHOD'] === 'GET') {
            $view = new AuthView();
            $view->setStyle("signup");
            $view->setTitle("Sign up - Lunara");
            $view->render('signup', fullPage: false);
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $username = sanitize($_POST['username']);
            $email = sanitize($_POST['email']);
            $password = $_POST['password'];
            $confirm_password = $_POST['confirm_password'];

            $errors = [];

            if (empty($username) || empty($email) || empty($password)) {
                $errors[] = "Please fill out all fields.";
            }

            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $errors[] = 'Invalid email format.';
            }

            if ($password !== $confirm_password) {
                $errors[] = 'Passwords do not match.';
            }

            $model = new UserModel();
            $user = $model->find([UserModel::USERNAME => $username, UserModel::EMAIL => $email]);
            if(!empty($user)) {
                $errors[] = 'User already exists.';
            }

            if (!empty($errors)) {
                $view = new AuthView();
                $view->setErrors($errors);
                $view->setStyle("signup");
                $view->setTitle("Sign up - Lunara");
                $view->render('signup', false);
                return;
            }
            $salt = bin2hex(random_bytes(16));
            $hashedPassword = $model->hashPassword($password, $salt);

            $inserts = [UserModel::USERNAME => $username,
                UserModel::EMAIL => $email,
                UserModel::PASS_HASH => $hashedPassword,
                UserModel::SALT => $salt,
                UserModel::ROLE_ID => RoleModel::ROLE_USER];

            try {
                $success = $model->insert($inserts);

                if($success) {
                    $model->authenticate($username, $password);

                    redirect('browse');
                }
            } catch (PDOException $e) {
                if ($e->getCode() === '23000') { // Duplicate entry
                    die('Username or email already exists.');
                }
                die('Database error: ' . $e->getMessage());
            }
        }

    }

    /**
     * Handles user login requests.
     *
     * Processes POST requests to authenticate the user. If authentication fails,
     * renders the login page with error messages.
     *
     * @return void
     */
    public function login(): void
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $username = sanitize($_POST['username']);
            $password = $_POST['password'];

            $errors = [];

            if (empty($username) || empty($password)) {
                $view = new AuthView();
                $errors[] = "Please fill out all fields.";
                $view->setErrors($errors);
                $view->setStyle("login");
                $view->render('login', false);
                return;
            }

            if (!empty($errors)) {
                $view = new AuthView();
                $view->setErrors($errors);
                $view->setStyle("login");
                $view->render('login', false);
                return;
            }

            $model = new UserModel();
            $user = $model->authenticate($username, $password);
            if ($user) {
                redirect('browse');
            } else {
                $view = new AuthView();
                $errors[] = "Invalid username or password.";
                $view->setErrors($errors);
                $view->setStyle("login");
                $view->render('login', false);
            }

        } else {
            if(Middleware::isLoggedIn()) {
                redirect('landing');
            }
            $view = new AuthView();
            $view->setStyle("login");
            $view->setTitle("Login - Lunara");
            $view->render('login', fullPage: false);
        }
    }

    /**
     * Logs out the user and displays the logout page.
     *
     * Destroys the session and renders the logout view with a success or error message.
     *
     * @return void
     */
    public function logout(): void
    {
        $view = new AuthView();

        $success = session_destroy();
        $view->setSuccess($success);
        $view->setStyle("logout");
        $view->setTitle("Logout - Lunara");
        $view->render('logout', false);
    }

    /**
     * Hashes a password with a salt.
     *
     * Combines the given password with a salt and hashes the result using the
     * `password_hash` function with the default algorithm.
     *
     * @param string $password The plain text password.
     * @param string $salt A randomly bundles salt.
     * @return string The hashed password.
     */
    public static function hashPassword(string $password, string $salt): string {
        return password_hash($password . $salt, PASSWORD_DEFAULT);
    }

    public static function changePassword(int $userId, string $currentPassword, string $newPassword) : array {
        if (!Middleware::isLoggedIn()) {
            throw new Exception('Unauthorized Access', 403);
        }

        $currentPassword = sanitize($currentPassword);
        $newPassword = sanitize($newPassword);

        $model = new UserModel();
        try {
            $user = $model->find([UserModel::ID => $userId]);
            if (!$user) {
                return ['success' => false, 'message' => 'User not found.'];
            }

            $hash = $user[UserModel::PASS_HASH];
            $salt = $user[UserModel::SALT];

            if(!password_verify($currentPassword . $salt, $hash)) {
                return [ 'success' => false, 'message' => 'Password is incorrect.' ];
            }

            $newSalt = bin2hex(random_bytes(16));
            $newHash = self::hashPassword($newPassword, $newSalt);

            $model->update(['id' => $userId], [UserModel::SALT => $newSalt, UserModel::PASS_HASH => $newHash]);

            return [ 'success' => true, 'message' => 'Password successfully changed!' ];
        }
        catch (Exception $e) {
            return [ 'success' => false, 'message' => 'Password could not be updated. Please, try again.' ];
        }
    }
}