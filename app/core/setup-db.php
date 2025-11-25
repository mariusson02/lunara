<?php

require_once __DIR__ ."/init.php";

$models = [
    RoleModel::class,
    UserModel::class,
    NftModel::class,
    FavoriteModel::class,
    TransactionModel::class,
];

$pdo = DatabaseConnection::getInstance();

dropTables($models, $pdo);
createTables($models, $pdo);
executeSqlFile( __DIR__ . '/../../docs/sql/nft_planets.sql', $pdo);
executeSqlFile( __DIR__ . '/../../docs/sql/role_user.sql', $pdo);

function createTables(array $models, PDO $pdo): void {

    foreach ($models as $model) {

        $model = new $model();

        $columns = $model->getColumns();
        $relationships = $model->getRelationships();

        $columnDefs = [];

        foreach ($columns as $name => $definition) {
            $columnDefs[] = "$name $definition";
        }

        foreach ($relationships as $relation => [$type, $foreignKey, $ownerKey]) {
            $relatedTable = "\"" . $model::getTableName() . "\"";
            if ($type === 'belongsTo') {
                $columnDefs[] = "CONSTRAINT fk_$relation FOREIGN KEY ($foreignKey) REFERENCES public.\"$relation\"($ownerKey)";
            }
        }

        $columnsSql = implode(",\n", $columnDefs);
        $sql = "CREATE TABLE IF NOT EXISTS \"" . $model::getTableName() . "\" (\n$columnsSql\n)";

        $pdo->exec($sql);
        error_log("Table '" . $model::getTableName() . "' created");
    }
    echo "Database migrated successfully.\n";
}

function dropTables(array $models, PDO $pdo): void {
    foreach ($models as $model) {
        $model = new $model();
        $tableName = $model::getTableName();

        $sql = "DROP TABLE IF EXISTS \"$tableName\" CASCADE;";
        $pdo->exec($sql);
    }
}

function executeSqlFile(string $filePath, PDO $pdo): void {
    if (file_exists($filePath)) {
        $sql = file_get_contents($filePath);

        if($sql) {
            $statements = array_filter(array_map('trim', explode(';', $sql)));

            try {
                foreach ($statements as $statement) {
                    if (!empty($statement)) {
                        $pdo->exec($statement);
                    }
                }
                echo "SQL file " . $filePath . " executed.\n";
            } catch (PDOException $e) {
                error_log("Failed to execute SQL: " . $e->getMessage());
            }
        }
    }

}