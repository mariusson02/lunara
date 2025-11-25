<?php

class RoleModel extends Model
{
    public function __construct() {
        parent::__construct();
    }

    public static function getTableName(): string
    {
        return 'role';
    }

    public const ID = 'id';
    public const NAME = 'name';

    /**
     * integer values that represent the roles based on the database entries (the int is the role_id)
     */
    public const ROLE_GUEST = 0;
    public const ROLE_USER = 1;
    public const ROLE_ADMIN = 2;

    public static array $columns = [
        self::ID => 'INT PRIMARY KEY',
        self::NAME => 'VARCHAR(255)',
    ];

    public static array $relationships = [
        'user' => ['hasMany', self::ID, 'role_id'],
    ];

    public static function getColumns(): array
    {
        return static::$columns;
    }

    public static function getRelationships(): array
    {
        return static::$relationships;
    }

    public static function mapRoleIdToName(int $roleId): string {
        return match ($roleId) {
            0 => 'Guest',
            1 => 'User',
            2 => 'Admin',
            default => 'Unknown',
        };
    }
}