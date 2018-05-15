<?php

class Admin extends Model {
    protected static $table = 'pages';

    protected static function setProperties()
    {
        self::$properties['name'] = [
            'type' => 'varchar',
            'size' => 512
        ];

        self::$properties['price'] = [
            'type' => 'float'
        ];

        self::$properties['description'] = [
            'type' => 'text'
        ];

        self::$properties['category'] = [
            'type' => 'int'
        ];
    }

    public static function getPages($categoryId = 0)
    {
        $where = 'WHERE id_category = :category AND status=:status';
        if ($categoryId == 0) {
          $where = '';
        }
        return db::getInstance()->Select(
            'SELECT id, url, content, title, keywords, description, language FROM pages ' . $where,
            ['status' => Status::Active, 'category' => $categoryId]);
    }

    public static function getPage($pageId)
    {

        //var_dump($pageId);
        $where = 'WHERE id = :id';

        return db::getInstance()->Select(
            'SELECT id, url, content, title, keywords, description, language FROM pages ' . $where,
            ['id' => $pageId]);
    }

    public static function setPage($data)
    {

        //var_dump($pageId);
        $where = ' id=' .$data['id'];

        return db::getInstance()->Update('pages', $data['object'], $where );
    }

    public static function getGood($goodId)
    {
        return db::getInstance()->Select(
            'SELECT id, id_category, `name`, description, price FROM goods WHERE id = :good_id AND status=:status',
            ['status' => Status::Active, 'good_id' => $goodId]);
    }
}
