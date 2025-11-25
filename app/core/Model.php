<?php

abstract class Model {

    protected static PDO $db;

    abstract static function getTableName();

    protected function __construct() {
        if(!isset(static::$db)) {
            static::$db = DatabaseConnection::getInstance();
        }
    }

    abstract public static function getColumns(): array;
    abstract public static function getRelationships(): array;

    protected static function buildPredicate(array $searchParams): string {
        $columns = array_keys(static::getColumns());
        $table = static::getTableName();
        $conditions = [];

        foreach ($searchParams as $key => $value) {
            if(in_array($key, $columns)) {
                $conditions[] = "public.{$table}.{$key} = :$key";
            }
        }
        return $conditions ? ' WHERE ' . implode(' AND ', $conditions) : '';
    }

    public function find(array $searchParams): mixed {
        try {
            $sql = 'SELECT * FROM public.' . static::getTableName();
            $conditions = static::buildPredicate($searchParams);
            $query = static::$db->prepare($sql . $conditions);
            if ($query->execute($searchParams)) {
                $result = $query->fetch(PDO::FETCH_ASSOC);
                return $result ?: [];
            }
            else {
                throw new Exception('There was a problem loading your data. Please try again later.');
            }
        }
        catch (PDOException $e) {
            error_log("PDOException in Database: " . $e->getMessage() . " at " . $e->getFile() . " line " . $e->getLine());
            throw new Exception("There was a problem loading your data. Please try again later.", 500);
        }
        catch (Exception $e) {
            throw $e;
        }
    }

    public function findAll(array $searchParams) : mixed {
        try {
            $sql = 'SELECT * FROM public.' . static::getTableName();
            $conditions = static::buildPredicate($searchParams);
            $query = static::$db->prepare($sql . $conditions);
            if ($query->execute($searchParams)) {
                $result = $query->fetchAll(PDO::FETCH_ASSOC);
                return $result ?: [];
            }
            else {
                throw new Exception('There was a problem loading your data. Please try again later.');
            }
        }
        catch (PDOException $e) {
            error_log("PDOException in Database: " . $e->getMessage() . " at " . $e->getFile() . " line " . $e->getLine());
            throw new Exception("There was a problem loading your data. Please try again later.", 500);
        }
        catch (Exception $e) {
            throw $e;
        }
    }

    public function insert(array $data): bool {
        $columns = array_keys(static::getColumns());
        $keys = [];
        $placeholders = [];
        $values = [];

        foreach ($data as $key => $value) {
            if (in_array($key, $columns)) {
                $keys[] = $key;
                $placeholders[] = ":$key";
                $values[$key] = $value;
            }
        }

        $keysString = implode(', ', $keys);
        $placeholdersString = implode(', ', $placeholders);
        $sql = "INSERT INTO public." . static::getTableName() . " ($keysString) VALUES ($placeholdersString)";
        error_log($sql);
        $query = static::$db->prepare($sql);
        return $query->execute($values);
    }

    /**
     * Updates records in a given table with specified values and conditions.
     * @param array $searchParams has to be at least the id of the target value to be updated
     * @param array $updateFields An associative array of columns and their new values (e.g., `['username' => 'new_user', 'email' => 'test@example.com']`).
     * @return bool True if the update was successful, false otherwise.
     * @throws Exception If there is an error during the update.
     */
    public static function update(array $searchParams, array $updateFields): bool
    {
        try {
            $setClauses = [];
            foreach ($updateFields as $column => $value) {
                $setClauses[] = "$column = :$column";
            }
            $setClause = implode(', ', $setClauses);

            $conditions = static::buildPredicate($searchParams);

            $sql = 'UPDATE public.' . static::getTableName() . ' SET ' . $setClause . $conditions;

            $query = static::$db->prepare($sql);
            $params = array_merge(array_values($updateFields), array_values($searchParams));

            return $query->execute($params);
        }
        catch (PDOException $e) {
            error_log("PDOException in Database::update: " . $e->getMessage() . " at " . $e->getFile() . " line " . $e->getLine());
            throw new Exception("There was a problem updating your data. Please try again later.", 500);
        }
        catch (Exception $e) {
            throw $e;
        }
    }

    public function delete(int $id) {
        try {
            $sql = 'DELETE FROM public.' . static::getTableName() . ' WHERE id = :id';

            $query = static::$db->prepare($sql);
            $query->bindParam(':id', $id, PDO::PARAM_INT);

            if ($query->execute()) {
                return $query->rowCount() > 0;
            } else {
                throw new Exception('Delete operation failed. No rows were affected.');
            }
        } catch (PDOException $e) {
            error_log("PDOException in deleteById: " . $e->getMessage() . " at " . $e->getFile() . " line " . $e->getLine());
            throw new Exception("There was a problem deleting the entry. Please try again later.", 500);
        } catch (Exception $e) {
            throw $e;
        }
    }

    public function belongsTo($relatedModel, $foreignKey, $ownerKey) {
        // TODO
    }

    public function hasMany($relatedModel, $foreignKey, $localKey) {
        // TODO
    }

    /**
     * Executes a dynamic SQL query with multiple table joins and conditions.
     *
     * @param array $tables  An array of tables involved in the query. The first element is the main table,
     *                       and subsequent tables can be referenced in the joins. Each table can include an alias
     *                       (e.g., `'Transactions t'` or `'Users u'`).
     * @param array $columns An array of columns to select in the query. Columns should be prefixed with their table or alias
     *                       (e.g., `'t.id'`, `'u.username'`, `'n.name AS nft_name'`).
     * @param array $joins   An array of join definitions. Each join is an associative array with the following keys:
     *                       - `'table'`: The name of the table to join, optionally with an alias (e.g., `'Users u'`).
     *                       - `'on'`: The ON clause for the join, specifying how the tables are related
     *                                  (e.g., `'t.user_id = u.id'`).
     * @param ?string $type represents the join type e.g. left, inner ...
     * @param ?array $searchParams
     * @return array The result set as an associative array. Returns an empty array if no results are found.
     * @throws Exception If there is an error executing the query.
     */

    public function join(array $tables, array $joins, array $columns, ?string $type = 'INNER', ?array $searchParams = []) : array {
        try {
            $fromTable = 'public.' . array_shift($tables);

            $selectedColumns = implode(', ', array_map(function ($column) {
                return !str_contains($column, 'public.') ? preg_replace('/^([a-zA-Z_]+)\./', 'public.$1.', $column) : $column;
            }, $columns));

            $joinClauses = [];
            foreach ($joins as $join) {
                $joinClauses[] = ' ' . strtoupper($type) . ' JOIN public.' . $join['table'] . ' ON ' . 'public.' . $join['on'];
            }

            $conditions = static::buildPredicate($searchParams);

            $sql = 'SELECT ' . $selectedColumns . ' FROM ' . $fromTable . implode(' ', $joinClauses) . $conditions;
            $query = static::$db->prepare($sql);
            if ($query->execute($searchParams)) {
                $result = $query->fetchAll(PDO::FETCH_ASSOC);
                return $result ?: [];
            } else {
                throw new Exception('There was a problem loading your data. Please try again later.');
            }
        }
        catch (PDOException $e) {
            error_log("PDOException in Database: " . $e->getMessage() . " at " . $e->getFile() . " line " . $e->getLine());
            throw new Exception("There was a problem loading your data. Please try again later.", 500);
        }
        catch (Exception $e) {
            throw $e;
        }
    }
}