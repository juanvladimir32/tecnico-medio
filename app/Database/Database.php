<?php

/**
 * @author Juan Vladimir <juanvladimir13@gmail.com>
 * @link https://github.com/juanvladimir13
 */

declare(strict_types=1);

namespace Veterinaria\Database;

class Database
{
    private static $database;
    private \mysqli $mysqli;

    private function __construct()
    {
        $credentials = require '../.env.php';
        $this->mysqli = $this->getConnection($credentials);
    }

    private function getConnection(array $credentials): ?\mysqli
    {
        $host = $credentials['host'];
        $user = $credentials['user'] ?? 'root';
        $password = $credentials['password'] ?? '';
        $databaseName = $credentials['databaseName'] ?? 'sys';
        $port = $credentials['port'] ?? 3306;

        $mysqli = new \mysqli(
            $host,
            $user,
            $password,
            $databaseName,
            $port
        );

        if ($mysqli->connect_errno) {
            return null;
        }

        return $mysqli;
    }

    public static function getInstance()
    {
        if (!self::$database instanceof self) {
            self::$database = new self();
        }

        return self::$database;
    }

    public function resultQuery(string $querySql, int $typeResult = MYSQLI_ASSOC): array
    {
        try {
            $rows = $this->mysqli->query($querySql);
            return $rows->fetch_all($typeResult);
        } catch (\Exception $exception) {
            return ['error' => $this->mysqli->error];
        }
    }

    public function resultPrepare(string $querySql, string $paramDataType = '',
                                  array  $values = [], int $typeResult = MYSQLI_ASSOC): array
    {
        try {
            $sentence = $this->mysqli->prepare($querySql);
        } catch (\Exception $exception) {
            return ['error' => $this->mysqli->error];
        }

        try {
            $error = $sentence->bind_param($paramDataType, ...$values);
            if ($error === false) {
                return ['error' => $sentence->error];
            }
        } catch (\Exception $exception) {
            return ['error' => $sentence->error];
        }

        try {
            $sentence->execute();
        } catch (\Exception $exception) {
            return ['error' => $sentence->error];
        }

        $rows = $sentence->get_result();
        if (!$rows) {
            return ['error' => $this->mysqli->error];
        }
        return $rows->fetch_all($typeResult);
    }

    public function executeUpdateOrDelete(string $querySql, string $paramDataType, array $values): array
    {
        $sentence = false;
        try {
            $sentence = $this->mysqli->prepare($querySql);
        } catch (\Exception $exception) {
            return ['error' => $this->mysqli->error];
        }

        try {
            $error = $sentence->bind_param($paramDataType, ...$values);
            if ($error === false) {
                return ['error' => $sentence->error];
            }
        } catch (\Exception $exception) {
            return ['error' => $sentence->error];
        }

        try {
            $sentence->execute();
        } catch (\Exception $exception) {
            return ['error' => $sentence->error];
        }

        $affected_rows = $this->mysqli->affected_rows !== '' && $this->mysqli->affected_rows > 0;
        $sentence->close();

        return $affected_rows ? [] : ['error' => 'Error update'];
    }

    public function executeInsert(string $querySql, string $paramDataType, array $values): array
    {
        $sentence = false;
        try {
            $sentence = $this->mysqli->prepare($querySql);
        } catch (\Exception $exception) {
            return ['error' => $this->mysqli->error];
        }

        try {
            $error = $sentence->bind_param($paramDataType, ...$values);
            if ($error === false) {
                return ['error' => $sentence->error];
            }
        } catch (\Exception $exception) {
            return ['error' => $sentence->error];
        }

        try {
            $sentence->execute();
        } catch (\Exception $exception) {
            return ['error' => $sentence->error];
        }

        $pk = $this->mysqli->insert_id;
        $sentence->close();
        return $pk === '' ? ['error' => 'Error insert'] : ['id' => $pk];
    }

    public function eagerLoadin(string $sql, int $type = MYSQLI_ASSOC)
    {
        $this->mysqli->real_query($sql);
        $rows = $this->mysqli->use_result();
        return $rows->fetch_all($type);
    }
}
