<?php

namespace Veterinaria\Http\Controllers;

use Veterinaria\Http\Models\ModelMascota;
use Veterinaria\Http\Models\ModelPropietario;
use Veterinaria\Http\Views\ViewMascota;

class ControllerMascota
{
    private ViewMascota $viewMascota;
    private ModelMascota $modelMascota;
    private ModelPropietario $modelPropietario;

    public function __construct()
    {
        $this->viewMascota = new ViewMascota();
        $this->modelMascota = new ModelMascota();
        $this->modelPropietario = new ModelPropietario();
    }

    public function index(): void
    {
        $mascotas = $this->modelMascota->rows();
        $this->viewMascota->showIndex($mascotas);
    }

    public function create():void
    {
        $propietarios = $this->modelPropietario->rows();
        $this->viewMascota->showForm($propietarios);
    }

    public function store(array $request): void
    {
        $this->modelMascota->setData($request);
        $values = $this->modelMascota->store();
        $propietarios = $this->modelPropietario->rows();
        $this->viewMascota->showStore($values, $propietarios);
    }

    public function destroy(int $id): void
    {
        $isDeleted = $this->modelMascota->destroy('id', $id);
        if ($isDeleted) {
            header('Location: /mascota', true, 301);
            exit();
        }
    }

    public function edit(int $id):void
    {
        $values = $this->modelMascota->findOne('id', $id);
        $propietarios = $this->modelPropietario->rows();
        $this->viewMascota->showForm($propietarios, $values);
    }
}
