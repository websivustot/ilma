<?php
class AdminController extends Controller
{

    protected $controls = [
        'pages' => 'Page',
        'orders' => 'Order',
        'categories' => 'Category',
        'goods' => 'Good'
    ];

    public $title = 'admin';

    public function index($data)
    {
        if (!isset($_SESSION['user_name'])) {
          header("Location: /users/login/");
          exit;
        }
        if (isset($_SESSION['user_name'])) {
          $pages = Admin::getPages($data['path']);
          //var_dump($data['path']);

          return ['user' => $_SESSION['user_name'], 'pages' => $pages];
        }
        return ['controls' => $this->controls];
    }

    public function edit($data)
    {
        if (!isset($_SESSION['user_name'])) {
          header("Location: /users/login/");
          exit;
        }
        else {
          if ($_SERVER['REQUEST_METHOD'] == 'POST')
            {
              if ($_POST['url']) $obj['url'] = $_POST['url'];
              if ($_POST['title']) $obj['title'] = $_POST['title'];
              if ($_POST['keywords']) $obj['keywords'] = $_POST['keywords'];
              if ($_POST['description']) $obj['description'] = $_POST['description'];
              if ($_POST['content']) $obj['content'] = $_POST['content'];
              $message = Admin::setPage(['object' => $obj, 'id' => $data['id'] ]);
            }
          $page = Admin::getPage($data['id']);
          return ['user' => $_SESSION['user_name'], 'page' => $page];
        }
        return ['controls' => $this->controls];
    }

    public function control($data)
    {
        // Сохранение
        $actionId = $this->getActionId($data);
        if ($actionId['action'] === 'save') {
            $fields = [];
            foreach ($_POST as $key => $value) {
                $field = explode('_', $key, 2);
                if ($field[0] == $actionId['id']) {
                    $fields[$field[1]] = $value;

                }
            }
        }

        if ($actionId['action'] === 'create') {
            $fields = [];
            foreach ($_POST as $key => $value) {
                if (substr($key, 0, 4) == 'new_') {
                    $fields[str_replace('new_', '', $key)] = $value;
                }
            }
        }

        switch($actionId['action']) {
            case 'create':
                $query = 'INSERT INTO ' . $data['id'] . ' ';
                $keys = [];
                $values = [];
                foreach ($fields as $key => $value) {
                    $keys[] = $key;
                    $values[] = '"' . $value . '"';
                }

                $query .= ' (' . implode(',', $keys) . ') VALUES ( ' . implode(',', $values) . ')';
                db::getInstance()->Query($query);
                break;
            case 'save':
                $query = 'UPDATE ' . $data['id'] . ' SET ';
                ;
                foreach ($fields as $field => $value) {
                    $query .= $field . ' = "' . $value . '",';
                }
                $query = substr($query, 0, -1) . ' WHERE id = :id';
                db::getInstance()->Query($query, ['id' => $actionId['id']]);
                break;
            case 'delete':
                db::getInstance()->Query('UPDATE ' . $data['id'] . ' SET status=:status WHERE id = :id', ['id' => $actionId['id'], 'status' => Status::Deleted]);
                break;
        }
        $fields = db::getInstance()->Select('desc ' . $data['id']);
        $_items = db::getInstance()->Select('select * from ' . $data['id']);
        $items = [];
        foreach ($_items as $item) {
            $items[] = new $this->controls[$data['id']]($item);
        }

        return ['fields' => $fields, 'items' => $items];
    }

    protected function getActionId($data)
    {
        foreach ($_POST as $key => $value) {
            if (strpos($key, '__save_') === 0) {
                $id = explode('__save_', $key)[1];
                $action = 'save';
                break;
            }
            if (strpos($key, '__delete_') === 0) {
                $id = explode('__delete_', $key)[1];
                $action = 'delete';
                break;
            }
            if (strpos($key, '__create') === 0) {
                $action = 'create';
                $id = 0;
            }
        }
        return ['id' => $id, 'action' => $action];
    }
}
