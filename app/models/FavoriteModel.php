<?php

class FavoriteModel extends Model
{
    public function __construct() {
        parent::__construct();
    }

    public static function getTableName(): string
    {
        return "favorite";
    }

    public const ID = 'id';
    public const NFT_ID = 'nft_id';
    public const USER_ID = 'user_id';

    public static array $columns = [
        self::ID => 'SERIAL PRIMARY KEY',
        self::NFT_ID => 'INT NOT NULL',
        self::USER_ID => 'INT NOT NULL',
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

    public function isFavorited(int $userId, int $nftId): bool {
        $sql = "SELECT COUNT(*) FROM public." . self::getTableName() . " WHERE user_id = :user_id AND nft_id = :nft_id";
        $query= $this->prepareAndExecute($sql, $userId, $nftId);
        error_log($sql);
        try {
            $result = $query->fetch(PDO::FETCH_ASSOC);
            return isset($result['count']) && $result['count'];
        } catch (PDOException $e) {
            error_log($e->getMessage());
        }
        return false;
    }

    public function addFavorite(int $userId, int $nftId): void{
        $sql = "INSERT INTO public." . self::getTableName() . " (user_id, nft_id) VALUES (:user_id, :nft_id)";
        $this->prepareAndExecute($sql, $userId, $nftId);
    }

    public function removeFavorite(int $userId, int $nftId): void{
        $sql = "DELETE FROM public." . self::getTableName() . " WHERE user_id = :user_id AND nft_id = :nft_id";
        $this->prepareAndExecute($sql, $userId, $nftId);
    }

    private function prepareAndExecute(string $sql, int $userId, int $nftId)
    {
        $query = self::$db->prepare($sql);
        $query->execute([self::USER_ID => $userId, self::NFT_ID => $nftId]);
        return $query;
    }

    public function getNftIdsByUserId(int $userId)
    {
        $sql = "SELECT nft_id FROM public." . self::getTableName() . " WHERE user_id = :user_id";
        $query = self::$db->prepare($sql);
        $query->execute([self::USER_ID => $userId]);
        return $query->fetchAll(PDO::FETCH_COLUMN);
    }

}