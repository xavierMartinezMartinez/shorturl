<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\UnauthorizedHttpException;

class BaseApiController extends AbstractController
{
    protected function validateBearerToken(Request $request)
    {
        $authHeader = $request->headers->get('Authorization');

        if (!$authHeader || strpos($authHeader, 'Bearer') !== 0) {
            throw new UnauthorizedHttpException('Bearer', 'Authorization header es vacio o invalido');
        }

        $token = substr($authHeader, strlen('Bearer '));

        if (!$this->validateFormatToken($token)) {
            throw new UnauthorizedHttpException('Bearer', 'Formato invalido del token');
        }
    }

    private function validateFormatToken($token)
    {
        $stack = array();
        $map = array(
            ')' => '(',
            '}' => '{',
            ']' => '['
        );
        for ($i = 0; $i < strlen($token); $i++) {
            $char = $token[$i];
            if (in_array($char, array('(', '{', '['))) {
                array_push($stack, $char);
            } elseif (in_array($char, array(')', '}', ']'))) {
                if (count($stack) == 0) {
                    return false;
                }
                $last = array_pop($stack);
                if ($last != $map[$char]) {
                    return false;
                }
            }
        }
        return count($stack) == 0;
    }

}