<?php


class TransactionModel extends Model
{
    public function __construct() {
        parent::__construct();
    }

    public static function getTableName(): string
    {
        return  'transaction';
    }

    public const ID = 'id';
    public const TIMESTAMP = 'timestamp';
    public const NFT_ID = 'nft_id';
    public const USER_ID = 'user_id';
    public const PRICE = 'price';

    public static array $columns = [
        self::ID => 'SERIAL PRIMARY KEY',
        self::TIMESTAMP => 'TIMESTAMPTZ NOT NULL',
        self::NFT_ID => 'INT NOT NULL',
        self::USER_ID => 'INT NOT NULL',
        self::PRICE => 'FLOAT NOT NULL',
    ];

    public static array $relationships = [
        'nft' => ['belongsTo', self::NFT_ID, 'id'],
        'user' => ['belongsTo', self::USER_ID, 'id'],
    ];

    public static function getColumns(): array
    {
        return static::$columns;
    }

    public static function getRelationships(): array
    {
        return static::$relationships;
    }

}