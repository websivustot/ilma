<?php
class MeteoController extends Controller
{

    public $view = 'meteo';

    public function index($data)
    {
        //$grib_file_name = Meteo::getGribFileName();
        //$meteo = Meteo::getGrib($grib_file_name);
        $isMeteoData = Meteo::isMeteoData('2018040100');
        var_dump($isMeteoData);
        Meteo::gribToSmall();
        if (!$isMeteoData) {
          $cities = Meteo::getCities();
          $meteo = Meteo::execWgrib2($cities);
          //$vars = Meteo::insertGribToMysql($meteo);
          return ['meteo' => 'meteo data is added for '.count($cities).' cities'];
        }


        //var_dump($cities);
        $gribFileName = Meteo::getGribFileName();
        return ['meteo' =>'data of '.$gribFileName.' already exists'];
    }
}
?>
