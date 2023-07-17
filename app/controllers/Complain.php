<?php
require_once _DIR_ROOT . '/app/services/ComplainService.php';
require_once _DIR_ROOT . '/app/services/MessageService.php';
require_once _DIR_ROOT . '/app/dao/MessageDao.php';

class Complain extends Controller
{

    public function index($message = ""): void
    {
        $data['complains'] = ComplainService::get("user_id", "=", $_SESSION['userObj']->id);

        $data['message'] = $message;
        $this->render('Contact', $data);
    }

    public function detail(): void
    {
        $fields = Request::getFields();
        $data['complains'] = ComplainService::get("user_id", "=", $_SESSION['userObj']->id);
        $data['messages'] = MessageDao::getByComplain($fields['id']);
        $complain = ComplainService::get("id", "=", $fields['id']);
        if (count($complain) > 0) $data['complain'] = $complain[0];
        $this->render('Contact', $data);
    }

    public function detail_admin(): void
    {
        $fields = Request::getFields();
        $data['complains'] = ComplainService::get("user_id", "=", $_SESSION['adminObj']->id);
        $data['messages'] = MessageDao::getByComplain( $fields['id']);
        $complain = ComplainService::get("id", "=", $fields['id']);
        if (count($complain) > 0) $data['complain'] = $complain[0];
        $this->render('ComplainMana', $data);
    }

    public function update(): void
    {
        $data = Request::getFields();
        ComplainService::update("status", $data['status'], $data['id']);
    }

    public function manage(): void
    {
        $fields = Request::getFields();
        if (array_key_exists('id', $fields) && $fields['id'] != '') $data['complains'] = ComplainService::get("id", "=", $fields['id']);
        else {
            $data['complains'] = ComplainService::getAll();
        }
        $this->render('ComplainMana', $data);
    }
    public function add_c(): void
    {
        $fields = Request::getFields();
        try {
            ComplainService::add($fields);
            $this->index("Thành công");
            $this->error = [];
        } catch (\Throwable $th) {
            $this->error['complainAdd'] = $th;
            $this->render('Contact', ["message" => "Thất bại"]);
        }
    }

    public function add_m(): void
    {
        $fields = Request::getFields();
        MessagesService::add($fields);
        $this->redirect("/vexepro/complain/detail?id=" . $fields["complain_id"]);
    }
    public function add_m_admin(): void
    {
        $fields = Request::getFields();
        MessagesService::add($fields);
        $this->redirect("/vexepro/complain/detail_admin?id=" . $fields["complain_id"]);
    }
}
