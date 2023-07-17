<?php
require_once _DIR_ROOT . '/app/services/RequestService.php';
require_once _DIR_ROOT . '/app/controllers/Home.php';
require_once _DIR_ROOT . '/app/dao/RequestDao.php';

class Requests extends Controller
{

    public function manage(): void
    {
        $fields = Request::getFields();
        $search =  (array_key_exists('search', $fields) && $fields['search'] != '') ? $fields['search'] : '';
        $status =  (array_key_exists('status', $fields) && $fields['status'] != '') ? $fields['status'] : '';
        $data['requests'] = RequestDao::search($search, $status);
        $this->render('RequestMana', $data);
    }

    public function update(): void
    {
        $data = Request::getFields();

        RequestService::update("status", $data['status'], $data['id']);
        $this->redirect("/vexepro/requests/manage");
    }

    public function add_c(): void
    {
        $data = Request::getFields();

        RequestService::add($data);
        $home = new Home();
        $this->redirect("/vexepro/home/me");
    }
}
