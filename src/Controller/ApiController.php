<?php

namespace App\Controller;

use App\Utils\Utilidades;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ApiController extends BaseApiController
{

    #[Route('/api/v1/short-url', name: 'api_v1_short_url', methods: 'POST')]
    public function shortUrl(Request $request, Utilidades $utilidades)
    {

        $this->validateBearerToken($request);

        if(!$request->get('url')){
            return new JsonResponse(['message' => 'Parámetro url vacio'], 400);
        }

        if(!filter_var($request->get('url'), FILTER_VALIDATE_URL)){
            return new JsonResponse(['message' => 'Formato url incorrecta'], 400);
        }

        $newUrl = $utilidades->generateShortUrlTiny($request->get('url'));

        return new JsonResponse(['url' => $newUrl], 200);

    }
}