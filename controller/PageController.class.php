<?php
class PageController extends Controller
{

    public $view = 'page';

    public function index($data)
    {
        function clean($value = "") {
            $value = trim($value);
            $value = stripslashes($value);
            $value = strip_tags($value);
            $value = htmlspecialchars($value);

            return $value;
        }
        if ($_SERVER['REQUEST_METHOD'] == 'POST')
        {
            if ($_POST['name']) $form['name'] = clean($_POST['name']);
            if ($_POST['email']) $form['email'] = clean($_POST['email']);
            $message = Page::sendForm($form);


        }
        //var_dump($form);

        $page = Page::getPage($data['path']);
        var_dump($data);
        //var_dump($page);
        return ['page' => $page, 'message' => $message];
    }
}
?>
