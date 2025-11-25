<?php

/**
 * User Model
 */
class UserModel extends Model {

    public function __construct() {
        parent::__construct();
    }

    public static function getTableName(): string {
        return "user";
    }

    public const string ID = 'id';
    public const string USERNAME = 'username';
    public const string PASS_HASH = 'pass_hash';
    public const string SALT = 'salt';
    public const string EMAIL = 'email';
    public const string WALLET = 'wallet';
    public const string ROLE_ID = 'role_id';

    private static array $columns = [
        self::ID => 'SERIAL PRIMARY KEY',
        self::USERNAME => 'VARCHAR(255) UNIQUE NOT NULL',
        self::PASS_HASH => 'VARCHAR(255) NOT NULL',
        self::SALT => 'VARCHAR(255) NOT NULL',
        self::EMAIL => 'VARCHAR(255) UNIQUE NOT NULL',
        self::WALLET => 'VARCHAR(255) UNIQUE',
        self::ROLE_ID => 'INT NOT NULL',
    ];

    private static array $relationships = [
        'role' => ['belongsTo', 'role_id', 'id'],
        'nft' => ['hasMany', 'user_id', 'id'],
        'favorite' => ['hasMany', 'user_id', 'id'],
        'transaction' => ['hasMany', 'user_id', 'id'],
    ];

    public static function getColumns(): array
    {
        return static::$columns;
    }
    public static function getRelationships(): array
    {
        return static::$relationships;
    }

    public function hashPassword(string $password, string $salt): string {
        return password_hash($password . $salt, PASSWORD_DEFAULT);
    }

    /**
     * Authenticates a user based on the provided username and password.
     *
     * This method queries the database for a user with the given username and verifies the password
     * against the stored password hash (with the salt). If authentication is successful, session
     * variables are set with the user's details.
     *
     * @param string $username The username of the user attempting to authenticate.
     * @param string $password The password provided for authentication.
     *
     * @return UserDto|null Returns a `UserDto` object if authentication is successful, or `null` if it fails.
     */
    public function authenticate(string $username, string $password): ?UserDto {
        $sql = "SELECT * FROM public." . self::getTableName() . " WHERE " . self::USERNAME . " = :" .self::USERNAME;
        $query = self::$db->prepare($sql);
        $query->execute([self::USERNAME => $username]);
        $userData = $query->fetch(PDO::FETCH_ASSOC);

        if ($userData) {
            $user = new UserDto($userData);
            if (password_verify($password . $user->getSalt(), $user->getPassHash())) {
                $_SESSION['USER_ID'] = $user->getId();
                $_SESSION['USERNAME'] = $user->getUsername();
                $_SESSION['ROLE'] = $user->getRoleId();
                return $user;
            }
        }
        return null;
    }

}