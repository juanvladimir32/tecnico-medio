<?php

/**
 * @author Juan Vladimir <juanvladimir13@gmail.com>
 * @link https://github.com/juanvladimir13
 */

declare(strict_types=1);

namespace Veterinaria\Http\Controllers;

use Veterinaria\Http\Views\ViewPropietario;
use Veterinaria\Http\Models\ModelPropietario;

class ControllerPropietario
{
    private ModelPropietario $modelPropietario;
    private ViewPropietario $viewPropietario;

    public function __construct()
    {
        $this->modelPropietario = new ModelPropietario();
        $this->viewPropietario = new ViewPropietario();
    }

    public function index(): void
    {
        $propietarios = $this->modelPropietario->rows();
        $columns = ModelPropietario::$postAttributes;
        $this->viewPropietario->showIndex($propietarios, $columns);
    }

    public function create():void
    {
        $this->viewPropietario->showForm();
    }

    public function store(array $request): void
    {
        $this->modelPropietario->setData($request);
        $values = $this->modelPropietario->store();
        $this->viewPropietario->showStore($values);
    }

    public function destroy(int $id): void
    {
        $isDeleted = $this->modelPropietario->destroy('id', $id);
        if ($isDeleted) {
            header('Location: /propietario', true, 301);
            exit();
        }
    }

    public function edit(int $id):void
    {
        $values = $this->modelPropietario->findOne('id', $id);
        $this->viewPropietario->showForm($values);
    }
}
