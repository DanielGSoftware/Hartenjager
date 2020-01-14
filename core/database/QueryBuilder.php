<?php

namespace App\Core\Database;

use Exception;
use PDO;

class QueryBuilder
{
    /**
     * The PDO instance
     * @var PDO
     */
    private PDO $pdo;

    /**
     * Create a new instace of QueryBuilder.
     *
     * @param PDO $pdo
     */
    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    /**
     * Select all rows from a database table.
     *
     * @param string $table
     * @param string $class
     * @return array
     */
    public function selectAll(string $table, string $class): array
    {
        $statement = $this->pdo->query("select * from {$table}");

        return $statement->fetchAll(PDO::FETCH_CLASS, $class);
    }


    /**
     * Insert a row into a table.
     *
     * @param  string $table
     * @param  array  $parameters
     */
    public function insert(string $table, array $parameters): void
    {
        $sql = sprintf(
            'insert into %s (%s) values (%s)',
            $table,
            implode(', ', array_keys($parameters)),
            ':' . implode(', :', array_keys($parameters))
        );

        try {
            $statement = $this->pdo->prepare($sql);

            $statement->execute($parameters);
        } catch (Exception $e) {
            //
        }
    }

    /**
     * Find a specific row in a database table.
     * @param string $table
     * @param int $id
     * @param string $class
     * @return array
     */
    public function find(string $table, int $id, string $class): array
    {
        $statement = $this->pdo->query("select * from {$table} where id = {$id}");

        return $statement->fetchAll(PDO::FETCH_CLASS, $class);
    }
}
