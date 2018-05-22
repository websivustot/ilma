<?php

class Meteo extends Model {
    protected static $table = 'meteo';

    protected static function setProperties()
    {
        self::$properties['name'] = [
            'type' => 'varchar',
            'size' => 512
        ];

        self::$properties['url'] = [
            'type' => 'varchar',
            'size' => 512
        ];
    }

    public static function getGribFileName()
    {
      $h = date(H);
      $d1 = date(d);
      $m1 = date(m);
      $y1 = date(Y);

      //$h = 1;
      //$d1 = 1;
      //$m1 = 2;
      //$y1 = date(Y);

      if ($h >= 12) {
        $h1 = $h - 6 - $h%6;
      }
      else if ($h >= 6){
        $h1 = 0;
      }
      else {
        $h1 = 18;
        if ($d1 != 1) $d1--;
        else if ($m1 != 1) {
          $m1--;
          $last_day_this_month = date("Y-m-d", mktime(0, 0, 0, $m1+1,0,date("Y")));
          var_dump($last_day_this_month);
          $d1  = explode("-", $last_day_this_month)[2]; //last day of month
        }
        else {
          $d1 = 31;
          $m1 = 12;
          $y1--;
        }
      }
      //return $y1.sprintf("%02d",$m1).sprintf("%02d",$d1).sprintf("%02d",$h1);
      return '2018040100';
      //http://www.ftp.ncep.noaa.gov/data/nccf/com/gfs/prod/gfs.2018043000/
    }


    public static function gribToSmall()
    {

      //exec("../data/wgrib2 ../data/biggrib.grb", $output, $var);
      exec("wget http://www.ftp.ncep.noaa.gov/data/nccf/com/gfs/prod/gfs.2018052206/gfs.t06z.pgrb2.0p25.f001.idx");
      //var_dump($output,$var);

    }


    public static function execWgrib2($cities)
    {
      foreach ($cities as $key => $value)
      {
        //var_dump($key,$value['lon']);
        $lon .= " -lon " . $value['lon'] . " " .$value['lat'];
      }
      $output = [""];
//      exec("../data/wgrib2 ../data/201804271200.small -match "."\":((U|V)GRD:10 m above ground|TMP:2 m above ground|PRES:surface|RH:2 m above ground):\""." -colon , -vt -lon 24.937500 60.170833" . $lon,$output);
      exec("../data/wgrib2 ../data/gfs.t00z.pgrb2.0p25.f000 -match "."\":((U|V)GRD:10 m above ground|TMP:2 m above ground|PRES:surface|RH:2 m above ground):\""." -colon , -vt -lon 24.937500 60.170833" . $lon,$output);

      // -match \":((U|V)GRD:10 m above ground|TMP:2 m above ground|PRES:surface|RH:2 m above ground):\" -colon , -vt -lon 24.937500 60.170833 -lon 25.744444 62.240278", $output);
      //var_dump($lon);
      $data = [$cities,$output];
      return $data;

    }

    public static function isMeteoData($time,$forecast = 0)
    {

      return db::getInstance()->Select(
          'SELECT id FROM data WHERE city_id = :city_id AND `time` = :time_data AND forecast = :forecast',
          ['city_id' => 1, 'time_data' => $time, 'forecast' => $forecast]);

    }

    public static function getMeteoData($time, $city_id = 1, $forecast = 0)
    {

      return db::getInstance()->Select(
          'SELECT temp, pres, hum, speed, dir FROM data WHERE city_id = :city_id AND `time` = :time_data AND forecast = :forecast',
          ['city_id' => $city_id, 'time_data' => $time, 'forecast' => $forecast]);

    }

    public static function roundMeteoData($meteo)
    {

      $meteo[0][temp] = round($meteo[0][temp] - 273.15);
      $meteo[0][pres] = ceil($meteo[0][pres]/100);
      $meteo[0][hum] = round($meteo[0][hum]);
      $meteo[0][speed] = ceil($meteo[0][speed]/2) * 2;
      $meteo[0][dir] = ceil($meteo[0][dir]/5) * 5;
      return $meteo;

    }

    public static function insertGribToMysql($data)
    {
      if (!empty($data)) {

        foreach ($data[1] as $key => $value) {
          if (!empty($value)) {
            preg_match_all('/(vt=|val=)([+-]?([0-9]*[.])?[0-9]+)/',$value,$matches[$key]);
            //var_dump($matches[$key]);
          }

        }
        //var_dump($matches[0][1]);
        foreach ($data[0] as $key => $value) {
          $speed = sqrt($matches[4][2][$key + 2] ** 2 + $matches[5][2][$key + 2] ** 2);
          $r2d = 45/atan(1);
          $dir = atan2($matches[4][2][$key + 2],$matches[5][2][$key + 2]) * $r2d + 180;
          var_dump($key + 1, '***', $value['name'],$matches[1][2][0],$matches[1][2][$key + 2],$matches[2][2][$key + 2] - 273.15,$matches[3][2][$key + 2],$speed,$dir);
          $id = db::getInstance()->Insert("data",
              ['time' => $matches[1][2][0], 'city_id' => $key + 1, 'forecast' => '0',
               'temp' => $matches[2][2][$key + 2], 'pres' => $matches[1][2][$key + 2], 'hum' => $matches[3][2][$key + 2], 'speed' => $speed, 'dir' => $dir]);

        }

      }
      return $matches;
    }

    public static function getCities()
    {
      return db::getInstance()->Select(
          'SELECT id, `name`, lon, lat FROM cities ', []);
    }

    public static function getCityId($cityName)
    {

      return db::getInstance()->Select(
        'SELECT id FROM cities WHERE name = :cityName', [cityName => $cityName]);

    }

    public static function getSunriseTime($city,$date)
    {
      /* calculate the sunrise time for Lisbon, Portugal
      Latitude: 38.4 North
      Longitude: 9 West
      Zenith ~= 90
      offset: +1 GMT
      */
      $a = strptime($date,'%Y%m%d%H');
      $timestamp = mktime(0, 0, 0, $a['tm_mon']+1, $a['tm_mday'], $a['tm_year']+1900);
      return ([date_sunrise($timestamp, SUNFUNCS_RET_STRING, $city['lat'], $city['lon'], 90, 3),date_sunset($timestamp, SUNFUNCS_RET_STRING, $city['lat'], $city['lon'], 90, 3)]);
      //var_dump( date('d.m.Y',$timestamp) .' aurinko nousee tänään ' .date_sunrise($timestamp, SUNFUNCS_RET_STRING, $city['lat'], $city['lon'], 90, 3));
      //var_dump($city);

    }

    public static function getGrib($date)
    {
      return "grib is <a href=\"".Config::get('meteo_path')."gfs.".$date."/gfs.t00z.pgrb2.0p25.f001"."\">".Config::get('meteo_path')."gfs.".$date."/gfs.t00z.pgrb2.0p25.f001</a>";
      //http://www.ftp.ncep.noaa.gov/data/nccf/com/gfs/prod/gfs.2018043000/
    }

    public static function getPage($url)
    {
        return db::getInstance()->Select(
          'SELECT id, url, content, title, keywords, description, language FROM pages WHERE url = :url',
          [url => $url]);
    }

    public static function sendForm($form)
    {
        //var_dump($form['name']);

        $sent = mail("websivustot@gmail.com", "The form on www.ilma.info has been filled out", "
            Name: 	\n\r
            ".$form['name']."\n\r
            E-mail:	\n\r
            ".$form['email']."
            ", null, '-f websivustot@gmail.com');



        //var_dump($sent);
        if ($sent) return 'Thank you for your message!';

        return 'The message hasn\'t been sent';
    }
}
