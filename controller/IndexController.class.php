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

    public function index()
    {
        $page = Page::getPage("");
        $meteo = Meteo::getMeteoData(Meteo::getGribFileName());
        //var_dump($meteo);
        $round_meteo = Meteo::roundMeteoData($meteo);
        return ['page' => $page, 'meteo' => $round_meteo];
    }


}
