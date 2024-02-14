<?php

/**
 * @author Juan Vladimir <juanvladimir13@gmail.com>
 * @link https://github.com/juanvladimir13
 */

declare(strict_types=1);

namespace Veterinaria\Http\Views;

class ViewPropietario
{
    public function showIndex(array $propietarios, array $columns): void
    {
        $title = 'Home propietario';
        $error = array_key_exists('error', $propietarios);
        $content = '../templates/propietario/index.html';
        include '../templates/layouts/base.html';
    }

    public function showForm(array $propietario = []):void
    {
        $title = 'Registrar Propietario';
        $error = false;
        $content = '../templates/propietario/form.html';
        include '../templates/layouts/base.html';
    }

    public function showStore(array $propietario): void
    {
        $error = array_key_exists('error', $propietario);
        $content = '../templates/propietario/form.html';
        include '../templates/layouts/base.html';
    }
}
