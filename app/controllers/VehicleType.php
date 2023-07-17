<?php
require_once _DIR_ROOT.'/app/services/VehicleTypeService.php';
require_once _DIR_ROOT.'/app/controllers/Vehicle.php';

class VehicleType extends Controller {

    public function add() : void {
        
        $data = Request::getFields();
        try {
            VehicleTypeService::add($data);
        } catch (\Throwable $th) {
        }
        $this->redirect("/vexepro/vehicle/manage");
    }
}