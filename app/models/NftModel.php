<?php

class NftModel extends Model {

    public function __construct() {
        parent::__construct();
    }

    public static function getTableName(): string
    {
        return "nft";
    }

    public const ID = 'id';
    public const NAME = 'name';
    public const SUBTITLE = 'subtitle';
    public const DESCRIPTION = 'description';
    public const SECTION1 = 'section1';
    public const SECTION2 = 'section2';
    public const SECTION3 = 'section3';
    public const TYPE = 'type';
    public const PRICE = 'price';
    public const IMG = 'img';
    public const OWNER_ID = 'owner_id';
    public const SCALE = 'model_scale';

    private static array $columns = [
        self::ID => 'SERIAL PRIMARY KEY',
        self::NAME => 'VARCHAR(255) NOT NULL',
        self::SUBTITLE => 'VARCHAR(255) NOT NULL',
        self::DESCRIPTION => 'VARCHAR NOT NULL',
        self::SECTION1 => 'VARCHAR NOT NULL',
        self::SECTION2 => 'VARCHAR NOT NULL',
        self::SECTION3 => 'VARCHAR NOT NULL',
        self::TYPE => 'VARCHAR(255)',
        self::PRICE => 'DOUBLE PRECISION',
        self::IMG => 'VARCHAR(255)',
        self::OWNER_ID => 'INT',
        self::SCALE => 'DOUBLE PRECISION',
    ];

    private static array $relationships = [
        'user' => ['belongsTo', self::OWNER_ID, 'id'],
        'favorite' => ['hasMany', self::ID, 'nft_id'],
        'transaction' => ['hasMany', self::ID, 'nft_id'],
    ];

    public static function getColumns(): array
    {
        return static::$columns;
    }

    public static function getRelationships(): array
    {
        return static::$relationships;
    }

    /**
     * Filters NFTs based on the provided parameters.
     *
     * @param string $name Optional name filter (case-insensitive).
     * @param string $type Optional type filter.
     * @param float|null $max_price Optional maximum price filter.
     * @param float|null $min_price Optional minimum price filter.
     * @param bool $available Optional filter for available NFTs only.
     * @param string $sort Column name for sorting results.
     * @param int $limit Maximum number of results to return.
     * @param int $offset Number of results to skip.
     *
     * @return array Filtered list of NFTs.
     */
    public function filterByParams(
        string $name = '',
        string $type = '',
        float $max_price = null,
        float $min_price = null,
        bool $available = false,
        string $sort = '',
        int $limit = 20,
        int $offset = 0
    ): array {

        $sql = "SELECT * FROM public." . self::getTableName() ;

        $conditions = [];
        $params = [];

        if ($name) {
            // in postgres, ILIKE ignores casing
            $conditions[] = self::NAME . ' ILIKE :'. self::NAME;
            $params[self::NAME] = "%$name%";
        }
        if ($type) {
            $conditions[] = self::TYPE . ' = :'. self::TYPE;
            $params[self::TYPE] = $type;
        }
        if ($max_price !== null) {
            $conditions[] = self::PRICE . ' <= :' . self::PRICE . '_max';
            $params[self::PRICE . '_max'] = $max_price;
        }
        if ($min_price !== null) {
            $conditions[] = self::PRICE . ' >= :' . self::PRICE . '_min';
            $params[self::PRICE . '_min'] = $min_price;
        }
        if ($available === true) {
            $conditions[] = self::OWNER_ID . ' IS NULL';
        }

        if (!empty($conditions)) {
            $sql .= ' WHERE ' . implode(' AND ', $conditions);
        }


        $valid_columns = self::getColumns();
        if ($sort && in_array($sort, $valid_columns)) {
            $sql .= ' ORDER BY ' . $sort;
        } else {
            $sql .= ' ORDER BY ' . self::ID;
        }

        $sql .= ' LIMIT :limit OFFSET :offset';
        $params["limit"] = $limit;
        $params["offset"] = $offset;

        $query = self::$db->prepare($sql);
        error_log($sql);
        error_log(print_r($params, true));
        $query->execute($params);
        return $query->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getAvailableTypes() {
        $sql = "SELECT DISTINCT " . NftModel::TYPE . " FROM public." . self::getTableName();
        $query = self::$db->prepare($sql);
        error_log($sql);
        $query->execute();
        $types = $query->fetchAll(PDO::FETCH_COLUMN);
        error_log(print_r($types, true));
        return $types;
    }

    public function getNftsByIds(mixed $ids): array {
        if(empty($ids) || !is_array($ids)) {
            return [];
        }

        $sanitizedIds = [];
        foreach($ids as $id) {
            $sanitizedIds[] = sanitize($id);
        }
        if(empty($sanitizedIds)) return [];

        $sql = "SELECT * FROM public." . self::getTableName();
        $sql .= " WHERE " . self::ID . " IN ('" . implode("','", $sanitizedIds) . "')";
        $query = self::$db->prepare($sql);
        $query->execute();
        $nfts = $query->fetchAll(PDO::FETCH_ASSOC);
        return $nfts;
    }


    public function changeOwnerById(int $nftId, $userId): bool {
        $sql = "UPDATE public." . self::getTableName() . " SET " . self::OWNER_ID . " = :" . self::OWNER_ID;
        $sql .= " WHERE " . self::ID . " = :" . self::ID;
        $params = [self::OWNER_ID => $userId, self::ID => $nftId];
        $query = self::$db->prepare($sql);
        return $query->execute($params);
    }

}