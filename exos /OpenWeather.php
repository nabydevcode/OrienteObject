<?php

class OpenWeather
{
    private string $apiKey;

    public function __construct($apiKey)
    {
        $this->apiKey = $apiKey;
    }
    public function getForecast(string $lg): ?array
    {
        $cont = $this->callApi($lg);
        $result = [];
        foreach ($cont['list'] as $value) {
            $result[] = [
                'date' => new DateTime('@' . $value['dt']),
                'descriptions' => $value['weather'][0]['description'],
                'temperature' => $value['main']['temp']
            ];
        }
        return $result;
    }

    public function callApi(string $lg): ?array
    {
        $curl = curl_init("http://api.openweathermap.org/data/2.5/forecast?id=524901&appid={$this->apiKey}&units=metric&lang={$lg}");
        curl_setopt_array($curl, [
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_TIMEOUT => 1
        ]);
        $data = curl_exec($curl);
        if ($data === false || curl_getinfo($curl, CURLINFO_HTTP_CODE) !== 200) {
            return null;
        }
        $cont = json_decode($data, true);
        curl_close($curl);
        return $cont;
    }

}