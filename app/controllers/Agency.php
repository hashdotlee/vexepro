<?php
require_once _DIR_ROOT . '/app/services/AgencyService.php';
require_once _DIR_ROOT . '/app/dao/AgencyDao.php';

class Agency extends Controller
{
    public function add(): void
    {
        $fields = Request::getFields();

        AgencyService::add($fields);
        $this->redirect("/vexepro/agency/manage");
    }

    public function manage(): void
    {
        $fields = Request::getFields();
        $search = (array_key_exists('search', $fields) && $fields['search'] != '') ? $fields['search'] : '';
        $data['agencies'] = AgencyDao::search($search);

        $this->render('AgencyMana', $data);
    }

    public function delete(): void
    {
        $req = Request::getFields();

        AgencyService::delete($req['id']);
        $this->redirect("/vexepro/agency/manage");
    }

    public function update(): void
    {
        $req = Request::getFields();

        AgencyService::update('name', $req['name'], $req['id']);
        $this->redirect("/vexepro/agency/manage");
    }
}
