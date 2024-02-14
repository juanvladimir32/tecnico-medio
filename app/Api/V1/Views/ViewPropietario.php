<?php

/**
 * @author Juan Vladimir <juanvladimir13@gmail.com>
 * @link https://github.com/juanvladimir13
 */

declare(strict_types=1);

namespace Veterinaria\Api\V1\Views;

use Veterinaria\Api\Response;

class ViewPropietario
{
    public function showIndex(array $values): string
    {
        $status = count($values) > 0 ? 200 : 204;
        $response = new Response();
        return $response->getBody($status, $values);
    }

    public function showFind(array $values): string
    {
        $status = count($values) > 0 ? 200 : 404;
        $response = new Response();
        return $response->getBody($status, $values);
    }

    public function showDelete(bool $value): string
    {
        $status = $value ? 204 : 404;
        $response = new Response();
        return $response->getBody($status);
    }

    public function showInsert(array $values): string
    {
        $status = array_key_exists('error', $values) ? 404 : 201;
        $response = new Response();
        return $response->getBody($status, $values);
    }

    public function showUpdate(array $values): string
    {
        $status = array_key_exists('error', $values) ? 404 : 200;
        $response = new Response();
        return $response->getBody($status, $values);
    }

    public function showError(array $values): string
    {
        $response = new Response();
        return $response->getBody(404, $values);
    }
}
