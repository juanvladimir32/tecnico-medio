<?php

/**
 * @author Juan Vladimir <juanvladimir13@gmail.com>
 * @link https://github.com/juanvladimir13
 */

declare(strict_types=1);

namespace Veterinaria\Http\Views;

class ViewMascota
{
    public function showIndex(array $mascotas): void
    {
        $title = 'Home mascota';
        $error = array_key_exists('error', $mascotas);
        $content = '../templates/mascota/index.html';
        include '../templates/layouts/astro.html';
    }

    public function showForm(array $propietarios, array $mascota = []):void
    {
        $title = 'Registrar Mascota';
        $error = array_key_exists('error', $mascota);
        $content = '../templates/mascota/form.html';
        include '../templates/layouts/base.html';
    }

    public function showStore(array $mascota, array $propietarios): void
    {
        $error = array_key_exists('error', $mascota);
        $content = '../templates/mascota/form.html';
        include '../templates/layouts/base.html';
    }
}
