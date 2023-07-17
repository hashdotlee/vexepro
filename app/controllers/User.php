<?php
require_once _DIR_ROOT . '/app/controllers/Home.php';
require_once _DIR_ROOT . '/app/services/UserService.php';
require_once _DIR_ROOT . '/app/dao/UserDao.php';

class User extends Controller
{
    private Home $home;
    public function __construct()
    {
        $this->home = new Home();
    }

    public function login(): void
    {
        $data = Request::getFields();
        $users = UserService::get('username', '=', $data['username']);
        if (count($users) == 0) {
            $this->error["login"] = "Tên đăng nhập không tồn tại";
            $this->render('Login');
            return;
        } else {
            $user = $users[0];
            if ($user && password_verify($data['password'], $user->password)) {
                unset($_SESSION['userObj']);
                unset($_SESSION['adminObj']);
                if ($user->role == 'customer') {
                    $_SESSION['userObj'] = $user;
                    if(array_key_exists("redirectUrl", $data)){
                        $this->redirect($data["redirectUrl"]);
                    }
                    else {
                        $this->redirect("/vexepro/home/index");
                    }
                }
                if ($user->role == 'admin') {
                    $_SESSION['adminObj'] = $user;
                    if(array_key_exists("redirectUrl", $data)){
                        $this->redirect($data["redirectUrl"]);
                    }
                    else {
                        $this->redirect("/vexepro/user/manage");
                    }
                }
            } else {
                $this->error["login"] = "Mật khẩu hoặc tên đăng nhập không đúng";
                $this->render('Login');
                return;
            }
        }
    }



    public function signup(): void
    {
        $data = Request::getFields();
        $data['role'] = 'customer';
        $data['password'] = password_hash($data['password'], PASSWORD_BCRYPT);
        $user = UserService::get('username', 'like', $data['username']);
        if (!$user) {
            $userService = new UserService();
            $userService->add($data);

            $this->render('Login');
        } else $this->render('Register', ["error" => "Tên đăng nhập đã tồn tại"]); // username exists
    }

    public function logout(): void
    {
        unset($_SESSION['userObj']);
        unset($_SESSION['adminObj']);
        $this->redirect("/vexepro/home/index");
    }

    public function info(): void
    {

        $id = $_SESSION['userObj']->id;
        $tickets = TicketService::get('id', 'equal', $id);
        $this->render('userinfo');
    }

    public function manage(): void
    {
        $fields = Request::getFields();
        $search =  (array_key_exists('search', $fields) && $fields['search'] != '') ? $fields['search'] : '';
        $status =  (array_key_exists('status', $fields) && $fields['status'] != '') ? $fields['status'] : '';
        $data['users'] = UserDao::search($search, $status);
        $this->render('UserMana', $data);
    }

    public function add(): void
    {
        $fields = Request::getFields();
        $rawPw = $fields['password'];
        $hashPw = password_hash($rawPw, PASSWORD_BCRYPT);
        $fields['password'] = $hashPw;
        UserService::add($fields);
        $this->redirect("/vexepro/user/manage");
    }

    public function deactivate(): void
    {
        $req = Request::getFields();

        UserService::deactivate($req['id']);
        $this->redirect("/vexepro/user/manage");
    }

    public function activate(): void
    {
        $req = Request::getFields();

        UserService::activate($req['id']);
        $this->redirect("/vexepro/user/manage");
    }

    public function update(): void
    {
        $req = Request::getFields();

        UserService::update('name', $req['name'], $req['id']);
        $this->redirect("/vexepro/user/manage");
    }
}
