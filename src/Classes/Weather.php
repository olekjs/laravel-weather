<?php

namespace Olekjs\Weather\Classes;

class Weather
{
    /**
     * API URL.
     *
     * @var string
     */
    private $url = 'https://api.openweathermap.org/data/2.5/';

    /**
     * API APPID.
     *
     * @var string
     */
    private $appid;

    /**
     * API units type.
     *
     * @var string
     */
    private $units = 'metric';

    /**
     * Set client APPID.
     *
     */
    public function __construct()
    {
        $this->appid = env('WEATHER_APP_ID');
    }

    /**
     * Get weather by city name.
     *
     * @param  string $city
     * @return string
     */
    public function getByCity($city)
    {
        $url = $this->url."find?q={$city}";

        return $this->response($url);
    }

    /**
     * Get weather by coords.
     *
     * @param  integer $lat
     * @param  integer $lon
     * @return string
     */
    public function getByCoords($lat, $lon)
    {
        $url = $this->url."find?lat={$lat}&lon={$lon}";

        return $this->response($url);
    }

    /**
     * Get contents from wetaher API.
     *
     * @param  string $url
     * @return object
     */
    private function response($url)
    {
        $args = collect([
            'units' => '&units='.$this->units,
            'appid' => '&appid='.$this->appid,
        ]);

        $url = $url.$args->get('units').$args->get('appid');

        $response = json_decode(file_get_contents($url), true);

        return $this->prepareResponse(collect($response));
    }

    /**
     * Prepare response to array.
     *
     * @param  collection $response
     * @return array
     */
    private function prepareResponse($response)
    {
        $responseCode = $response->get('cod');

        if ($responseCode != 200) {
            return $this->WrongResponse($responseCode);
        } elseif ($response->get('list') == null) {
            return 'No results';
        }

        // Weather Properties
        $wp = $response->get('list')[0];

        $data = [
            'name'            => $wp['name'],
            'country'         => $wp['sys']['country'],
            'temperature'     => $wp['main']['temp'],
            'pressure'        => $wp['main']['pressure'],
            'max_temperature' => $wp['main']['temp_max'],
            'min_temperature' => $wp['main']['temp_min'],
            'wind_speed'      => $wp['wind']['speed'],
            'description'     => $wp['weather'][0]['description'],
            'icon'            => $wp['weather'][0]['icon'],

        ];

        return $data;
    }

    /**
     * Throw wrong response.
     *
     * @param  integer $responseCode
     * @return array
     */
    private function WrongResponse($responseCode)
    {
        $data = [
            'code'    => $responseCode,
            'message' => "Problem with API {$responseCode}",
        ];

        return $data;
    }
}
