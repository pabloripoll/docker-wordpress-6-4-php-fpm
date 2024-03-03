<?php

namespace Plugin\Support;

class Http
{
    public function get($data)
    {
        $curl = curl_init();

        curl_setopt_array($curl, [
            CURLOPT_URL => $data->endpoint,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'GET',
            CURLOPT_HTTPHEADER => [
                'AUTHORIZATION: '.$data->key,
                'idusuario: '.$data->user
            ],
        ]);

        $response = curl_exec($curl);

        curl_close($curl);

        return $response;
    }

    public function post($data)
    {
        $curl = curl_init();

        curl_setopt_array($curl, [
            CURLOPT_URL => $data->endpoint,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => $data->body,
            CURLOPT_HTTPHEADER => [
                'AUTHORIZATION: '.$data->key,
                'idusuario: '.$data->user,
                'Content-Type: text/plain'
            ],
        ]);

        $response = curl_exec($curl);

        curl_close($curl);

        return $response;
    }

    public function put($data)
    {
        $curl = curl_init();

        curl_setopt_array($curl, [
            CURLOPT_URL => $data->endpoint,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'PUT',
            CURLOPT_POSTFIELDS => $data->body,
            CURLOPT_HTTPHEADER => [
                'AUTHORIZATION: '.$data->key,
                'idusuario: '.$data->user,
                'Content-Type: text/plain'
            ],
        ]);

        $response = curl_exec($curl);
        $response_status = curl_getinfo($curl, CURLINFO_HTTP_CODE);

        curl_close($curl);

        return $response_status;
    }
}