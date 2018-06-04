<?php
$config['db_user'] = 'umi_artumy';
$config['db_password'] = 'ladk5fkWi';
$config['db_base'] = 'umi_ilma';
$config['db_host'] = 'umi.mysql';
$config['db_charset'] = 'UTF-8';
define("MYSQL_USER", "umi_artumy");
define("MYSQL_PASSWORD", "ladk5fkWi");
define("MYSQL_DB", "umi_ilma");
define("MYSQL_SERVER", "umi.mysql");

$config['path_root'] = __DIR__;
$config['path_public'] = $config['path_root'] . '/../public';
$config['path_model'] = $config['path_root'] . '/../model';
$config['path_controller'] = $config['path_root'] . '/../controller';
$config['path_cache'] = $config['path_root'] . '/../cache';
$config['path_data'] = $config['path_root'] . '/../data';
$config['path_fixtures'] = $config['path_data'] . '/../fixtures';
$config['path_migrations'] = $config['path_data'] . '/../migrate';
$config['path_commands'] = $config['path_root'] . '/../lib/commands';
$config['path_libs'] = $config['path_root'] . '/../lib';
$config['path_templates'] = $config['path_root'] . '/../templates';

$config['path_logs'] = $config['path_root'] . '/../logs';

$config['sitename'] = 'Ilma';
$config['meteo_path'] = 'http://www.ftp.ncep.noaa.gov/data/nccf/com/gfs/prod/';
