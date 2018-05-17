<?php

class IndexController extends Controller
{
    public $view = 'index';
    public $title;

    function __construct()
    {
        parent::__construct();
        $this->title .= ' | Главная';
    }

    public function index($data)
    {
      $cityId = Meteo::getCityId($data['id'])[0]['id'];
      $cities = Meteo::getCities();
//var_dump($cities);
      $page = Page::getPage("weather");
      $meteo = Meteo::getMeteoData(Meteo::getGribFileName(),$cityId);
      //var_dump($cities[$cityId - 1]);
      $page[0]['content'] .= "<h2>Kaupunki: ".$cities[$cityId -1]['name']."</h2>";
      $round_meteo = Meteo::roundMeteoData($meteo);
      return ['page' => $page, 'meteo' => $round_meteo, 'cities' => $cities];
    }


}
