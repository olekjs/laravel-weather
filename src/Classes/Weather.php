<?php

namespace Olekjs\Weather\Classes;

class Weather
{
	private $url = 'https://api.openweathermap.org/data/2.5/';

	private $appid;

	private $units = 'metric';

	public function __construct()
	{
		$this->appid = env('WEATHER_APP_ID');
	}

	public function getByCity($city)
	{
		$url = $this->url."find?q={$city}";

		return $this->response($url);
	}

	private function response($url)
	{
		$args = collect([
			'units' => '&units='.$this->units,
			'appid' => '&appid='.$this->appid,
		]);

		$url = $url.$args->get('units').$args->get('appid');

		return $json = json_decode(file_get_contents($url), true);
	}
}
