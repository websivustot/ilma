<?php

class User extends Model {
    protected static $table = 'users';

    protected static function setProperties()
    {
        self::$properties['name'] = [
            'type' => 'varchar',
            'size' => 512
        ];

        self::$properties['password'] = [
            'type' => 'text',
        ];

        self::$properties['status'] = [
            'type' => 'int',
        ];
    }

    public static function createUser($user,$password)
    {
        $id = db::getInstance()->Insert("users",
            ['status' => Status::Active, 'name' => $user, 'password' => $password]);
        if ($id) {
          return $user;
        }

    }

    public static function getUser($login, $password)
    {
        return db::getInstance()->Select(
            'SELECT id, name FROM users WHERE status=:status AND name = :name AND password = :password',
            ['status' => Status::Active, 'name' => $login, 'password' => $password]);

    }
    public static function isUser($userName)
    {
      return db::getInstance()->Select('SELECT id, name FROM users WHERE name = :name',
      ['name' => $userName]);
    }
}
