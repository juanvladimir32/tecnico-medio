<?php

declare(strict_types=1);

namespace Veterinaria\Http\Models;

use Veterinaria\Database\Database;

class ModelMascota
{
    private int $id;
    private string $nombre;
    private string $raza;
    private int $edad;
    private int $propietario_id;

    public static array $postAttributes = ['nombre', 'raza', 'edad', 'propietario_id'];
    public static array $putAttributes = ['nombre', 'raza', 'edad', 'propietario_id'];

    private Database $database;

    public function __construct()
    {
        $this->id = 0;
        $this->nombre = '';
        $this->raza = '';
        $this->edad = 0;
        $this->propietario_id = -1;

        $this->database = Database::getInstance();
    }

    public function setData(array $data): void
    {
        $this->id = \array_key_exists('id', $data) ? (int)$data['id'] : 0;
        $this->nombre = \array_key_exists('nombre', $data) ? $data['nombre'] : '';
        $this->raza = \array_key_exists('raza', $data) ? $data['raza'] : '';
        $this->edad = \array_key_exists('edad', $data) ? (int)$data['edad'] : 0;
        $this->propietario_id = \array_key_exists('propietario_id', $data) ? (int)$data['propietario_id'] : 0;
    }

    private function insert(): array
    {
        $sqlInsert = 'INSERT INTO mascota (nombre,raza,edad,propietario_id) values(?,?,?,?)';
        $values = [$this->nombre, $this->raza, $this->edad, $this->propietario_id];
        $row = $this->database->executeInsert($sqlInsert, 'ssii', $values);

        return array_key_exists('error', $row) ? $row :
            $this->findOne('id', $row['id']);
    }

    private function update(): array
    {
        $sqlUpdate = 'UPDATE mascota SET nombre=?, raza=?, edad=?, propietario_id=? WHERE id=?;';
        $values = [$this->nombre, $this->raza, $this->edad, $this->propietario_id, $this->id];
        $row = $this->database->executeUpdateOrDelete($sqlUpdate, 'ssiii', $values);

        return array_key_exists('error', $row) ? $row :
            $this->findOne('id', $this->id);
    }

    public function store(): array
    {
        return $this->id == 0 ? $this->insert() : $this->update();
    }

    public function destroy(string $column, $value): bool
    {
        $sql = "DELETE FROM mascota WHERE $column=?";
        $row = $this->database->executeUpdateOrDelete($sql, 's', [$value]);

        return !array_key_exists('error', $row);
    }

    public function findOne(string $column, $value): array
    {
        $sql = "SELECT * FROM mascota WHERE $column=?";
        $rows = $this->database->resultPrepare($sql, 's', [$value]);
        return count($rows) > 0 ? $rows[0] : [];
    }

    public function find(string $column, string $value): array
    {
        $sql = "SELECT * FROM mascota WHERE $column=?";
        return $this->database->resultPrepare($sql, 's', [$value]);
    }

    public function rows(): array
    {
        $sql = 'SELECT * FROM mascota';
        return $this->database->resultQuery($sql);
    }
}
