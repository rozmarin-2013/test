<?php

namespace App\Response;

use Symfony\Component\HttpFoundation\JsonResponse;

class AjaxResponse extends JsonResponse
{
    public function __construct(bool $success, $data = null, int $status = 200, array $headers = [], bool $json = false){
        $data = [
            'success' => $success,
            'data' => $data,
        ];

        return parent::__construct($data, $status, $headers, $json);
    }
}