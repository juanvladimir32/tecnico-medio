<?php

/**
 * @author Juan Vladimir <juanvladimir13@gmail.com>
 * @link https://github.com/juanvladimir13
 */

declare(strict_types=1);

namespace Veterinaria\Api\V1\Controlles;

use Veterinaria\Api\Request;
use Veterinaria\Api\V1\Views\ViewPropietario;
use Veterinaria\Http\Models\ModelPropietario;

class ControllerPropietario
{
    private ModelPropietario $model;
    private ViewPropietario $view;

    public function __construct()
    {
        $this->model = new ModelPropietario();
        $this->view = new ViewPropietario();
    }

    public function index(): string
    {
        $values = $this->model->rows();
        return $this->view->showIndex($values);
    }

    public function find(int $id): string
    {
        $values = $this->model->findOne('id', $id);
        return $this->view->showFind($values);
    }

    public function delete(int $id): string
    {
        $value = $this->model->destroy('id', $id);
        return $this->view->showDelete($value);
    }

    public function post(Request $request): string
    {
        if ($request->getError()) {
            return $this->view->showError(['error' => 'Error decode']);
        }

        if (!$request->existsColumns(ModelPropietario::$postAttributes)) {
            return $this->view->showError(['error' => 'Columns no valid']);
        }

        $this->model->setData($request->getBody());
        $values = $this->model->insert();
        return $this->view->showInsert($values);
    }

    public function put(Request $request, int $id): string
    {
        if ($request->getError()) {
            return $this->view->showError(['error' => 'Error decode']);
        }

        if (!$request->existsColumns(ModelPropietario::$putAttributes)) {
            return $this->view->showError(['error' => 'Columns no valid']);
        }

        $this->model->setData($request->getBody());
        $this->model->setId($id);
        $values = $this->model->update();
        return $this->view->showUpdate($values);
    }
}
