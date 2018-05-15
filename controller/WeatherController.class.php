<?php
class WeatherController extends Controller
{

    public $view = 'weather';

    public function index()
    {
        $page = Page::getPage("weather");
        $meteo = Meteo::getMeteoData(Meteo::getGribFileName());
        //var_dump($meteo);
        $round_meteo = Meteo::roundMeteoData($meteo);
        return ['page' => $page, 'meteo' => $round_meteo];
    }

    public function today($data)
    {

        $cityId = Meteo::getCityId($data['id'])[0]['id'];
        $cities = Meteo::getCities();
//var_dump($cities);
        $page = Page::getPage("weather");
        $meteo = Meteo::getMeteoData(Meteo::getGribFileName(),$cityId);
        var_dump($cities[$cityId - 1]);
        $page[0]['content'] .= "<h2>Kaupunki: ".$cities[$cityId -1]['name']."</h2>";
        $round_meteo = Meteo::roundMeteoData($meteo);
        return ['page' => $page, 'meteo' => $round_meteo];
    }
}
?>
