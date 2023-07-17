<?php
require_once _DIR_ROOT.'/app/services/StationService.php';
require_once _DIR_ROOT.'/app/dao/StationDao.php';

class Station extends Controller {
    public function add() : void {
        $fields = Request::getFields();

        StationService::add($fields);
        $this->redirect("/vexepro/station/manage");
    }

    public function manage() : void {
        $fields = Request::getFields();
        if(array_key_exists('search', $fields) && $fields['search'] != '') $data['stations'] = StationDao::search($fields['search']);
        else{$data['stations'] = StationService::getAll();}
        $this->render('StationMana', $data);
    }

    public function delete() : void {
        $req = Request::getFields();

        StationService::delete($req['id']);
        $this->redirect("/vexepro/station/manage");
    }

}