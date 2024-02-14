<?php

/**
 * @author Juan Vladimir <juanvladimir13@gmail.com>
 * @link https://github.com/juanvladimir13
 */

declare(strict_types=1);

namespace Veterinaria\Http\Models;

use Veterinaria\Database\Database;

class ModelPropietario
{
    private int $id;
    private string $nombrecompleto;
    private string $celular;
    private string $email;
    private string $genero;
    // Atributo solo de lectura, no se deberia poder modificar
    public static array $postAttributes = ['nombrecompleto', 'celular', 'email', 'genero'];
    // Atributo solo de lectura, no se deberia poder modificar
    public static array $putAttributes = ['nombrecompleto', 'celular', 'email', 'genero'];

    private Database $database;

    public function __construct()
    {
        $this->id = 0;
        $this->nombrecompleto = '';
        $this->celular = '';
        $this->email = '';
        $this->genero = 'M';

        $this->database = Database::getInstance();
    }

    public function setId(int $id): void
    {
        $this->id = $id;
    }

    public function setData(array $data): void
    {
        $this->id = \array_key_exists('id', $data) ? (int)$data['id'] : 0;
        $this->nombrecompleto = \array_key_exists('nombrecompleto', $data) ? $data['nombrecompleto'] : '';
        $this->celular = \array_key_exists('celular', $data) ? $data['celular'] : '';
        $this->email = \array_key_exists('email', $data) ? $data['email'] : '';
        $this->genero = \array_key_exists('genero', $data) ? $data['genero'] : '';
    }

    public function insert(): array
    {
        $sqlInsert = 'INSERT INTO propietario (nombrecompleto,celular,email,genero) values(?,?,?,?)';
        $values = [$this->nombrecompleto, $this->celular, $this->email, $this->genero];
        $row = $this->database->executeInsert($sqlInsert, 'ssss', $values);

        return array_key_exists('error', $row) ? $row :
            $this->findOne('id', $row['id']);
    }

    public function update(): array
    {
        $sqlUpdate = 'UPDATE propietario SET nombrecompleto=?, celular=?, email=?, genero=? WHERE id=?;';
        $values = [$this->nombrecompleto, $this->celular, $this->email, $this->genero, $this->id];
        $row = $this->database->executeUpdateOrDelete($sqlUpdate, 'ssssi', $values);

        return array_key_exists('error', $row) ? $row :
            $this->findOne('id', $this->id);
    }

    public function store(): array
    {
        return $this->id == 0 ? $this->insert() : $this->update();
    }

    public function destroy(string $column, $value): bool
    {
        $sql = "DELETE FROM propietario WHERE $column=?";
        $row = $this->database->executeUpdateOrDelete($sql, 's', [$value]);

        return !array_key_exists('error', $row);
    }

    public function findOne(string $column, $value): array
    {
        $sql = "SELECT * FROM propietario WHERE $column=?";
        $rows = $this->database->resultPrepare($sql, 's', [$value]);
        return count($rows) > 0 ? $rows[0] : [];
    }

    public function find(string $column, string $value): array
    {
        $sql = "SELECT * FROM propietario WHERE $column=?";
        return $this->database->resultPrepare($sql, 's', [$value]);
    }

    public function rows(): array
    {
        $sql = 'SELECT * FROM propietario';
        return $this->database->resultQuery($sql);
    }
}
