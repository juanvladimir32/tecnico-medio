<?php

/**
 * @author Juan Vladimir <juanvladimir13@gmail.com>
 * @link https://github.com/juanvladimir13
 */

declare(strict_types=1);

namespace Veterinaria\Api;

class Response
{
    public function getBody(int $response_code, array $body = []): string
    {
        $responseBody = [
            'data' => $body
        ];

        $encodeData = \json_encode($responseBody, JSON_UNESCAPED_SLASHES);
        $error = $encodeData === false;

        if ($error) {
            $response_code = 400;
            $encodeData = ['error' => 'Error encoding'];
        }

        \http_response_code($response_code);
        \header('Content-Type: application/json; charset=UTF-8');
        return $encodeData;
    }
}
