<?php

class Page extends Model {
    protected static $table = 'pages';

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
