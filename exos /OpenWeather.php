<?php

class OpenWeather
{
    private string $apiKey;

    public function __construct($apiKey)
    {
        $this->apiKey = $apiKey;
    }
    public function getForecast(string $local, string $lg): ?array
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
        $result = [];
        foreach ($cont['list'] as $value) {
            $result[] = [
                'date' => new DateTime('@' . $value['dt']),
                'descriptions' => $value['weather'][0]['description'],
                'temperature' => $value['main']['temp']
            ];

        }



        /*  if ($key === 'weather' && isset($value[0]['description'])) {
             $result['description'] = $value[0]['description'];
         }
         if ($key === 'dt_txt') {
             $dateTime = new DateTime('@' . $value);
             $dateTime->setTimezone(new DateTimeZone('UTC')); // Ajuster le fuseau horaire si nécessaire
             $result['date'] = $dateTime->format('Y-m-d H:i:s');
         }

         if ($key === 'name') {
             $result['city'] = $value;
         } */



        curl_close($curl);
        return $result;




    }

}