<?php
class WeatherController extends Controller
{

    public $view = 'weather';

    public function index($data)
    {
      $cityId = Meteo::getCityId($data['id'])[0]['id'];
      $cities = Meteo::getCities();
//var_dump($cities);
      $page = Page::getPage("weather");
      $gribFileName = Meteo::getGribFileName();
      $meteo = Meteo::getMeteoData($gribFileName,$cityId);
      //var_dump($cities[$cityId - 1]);
      $page[0]['content'] .= "<h2>Kaupunki: ".$cities[$cityId -1]['name']."</h2>";
      $round_meteo = Meteo::roundMeteoData($meteo);
      $sunrise = Meteo::getSunriseTime($cities[$cityId -1],$gribFileName);
      return ['page' => $page, 'meteo' => $round_meteo, 'cities' => $cities, 'sunrise' => $sunrise];
    }

    public function today($data)
    {

        $cityId = Meteo::getCityId($data['id'])[0]['id'];
        $cities = Meteo::getCities();
//var_dump($cities);
        $page = Page::getPage("weather");
        $gribFileName = Meteo::getGribFileName();
        $meteo = Meteo::getMeteoData($gribFileName,$cityId);
        //var_dump($cities[$cityId - 1]);
        $page[0]['content'] .= "<h2>Kaupunki: ".$cities[$cityId -1]['name']."</h2>";
        $round_meteo = Meteo::roundMeteoData($meteo);
        $sunrise = Meteo::getSunriseTime($cities[$cityId -1],$gribFileName);
        return ['page' => $page, 'meteo' => $round_meteo, 'cities' => $cities, 'sunrise' => $sunrise];
    }
}
?>
