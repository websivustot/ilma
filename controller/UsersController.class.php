<?php
class UsersController extends Controller
{

    public $view = 'users';

    public function index($data) // действие при /users/
    {

        if (!isset($_SESSION['user_name'])) {
          header("Location: /users/login/");
          exit;
        }
        //$user = User::getUser(isset($data['id']) ? $data['id'] : 0);
        $user = $_SESSION['user_name'];
        return ['user' => $user];
    }
    public function registration()
    {

      if ($_SERVER['REQUEST_METHOD'] == 'POST') {

        if ($_POST['newuser']) $login = $_POST['newuser'];
        if ($_POST['newpass']) $password = md5($_POST['newpass']);

        if(!User::isUser($login)){
          $user = User::createUser($login,$password);
          //var_dump($user);
          return ['user' => $user];
        }
        return  ['message' => 'The username $login already exists. Please use a different username.'];
      }


    }
    public function login()
    {

      if (isset($_SESSION['user_name'])) {
        header("Location: /admin/");
        exit;
      }
      if ($_SERVER['REQUEST_METHOD'] == 'POST') {

        if ($_POST['email']) $login = $_POST['email'];
        if ($_POST['pwd']) $password = md5($_POST['pwd']);

        $userData = User::getUser($login, $password);
          //var_dump($userData);
        if ($userData != null) {
          $_SESSION['user_name'] = $userData[0]['name'];
          header("Location: /admin/");
          exit;
          //return ['user' => $userData[0]['name']];
        }
        return  ['message' => 'Wrong username or password.'];
      }
    }

    public function logout()
    {
      if (isset($_SESSION['user_name'])) {

      unset($_SESSION['user_name']);
      return ['message' => 'You are logged out.'];

    }
      return  ['message' => 'We have not found this username'];
    }
}
?>
