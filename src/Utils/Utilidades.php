<?php

namespace App\Utils;

use Symfony\Component\DependencyInjection\ContainerInterface;

class Utilidades
{

    public function generateShortUrlTiny($url)
    {
        $urlFinal = 'https://tinyurl.com/api-create.php?url='.$url;

        $curl = curl_init();
        $timeout = 10;

        curl_setopt($curl, CURLOPT_CONNECTTIMEOUT, $timeout);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_URL, $urlFinal);

        $new_url = curl_exec($curl);
        curl_close($curl);

        return $new_url;
    }

}