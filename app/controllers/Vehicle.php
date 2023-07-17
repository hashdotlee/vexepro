<?php
require_once _DIR_ROOT . '/app/services/VehicleService.php';
require_once _DIR_ROOT . '/app/services/AgencyService.php';
require_once _DIR_ROOT . '/app/services/VehicleTypeService.php';
require_once _DIR_ROOT . '/app/dao/VehicleDao.php';

class Vehicle extends Controller
{

    public function manage(): void
    {
        $agencyMap = [];
        $vehicles = [];
        $fields = Request::getFields();
        $search = (array_key_exists('search', $fields) && $fields['search'] != '') ? $fields['search'] : '';
        $vehicles = VehicleDao::search($search);
        $agencies = AgencyService::getAll();
        $vehicleTypes = VehicleTypeService::getAll();

        foreach ($agencies as $agency) {
            $agencyMap[$agency->id] = $agency->name;
        }
        $this->render('VehicleMana', ["msg" => "success", "vehicles" => $vehicles, "agencyMap" => $agencyMap, "vehicleTypes" => $vehicleTypes, "error" => $this->error]);
        $this->error = [];
    }

    public function add(): void
    {
        $data = Request::getFields();

        VehicleService::add($data);
    }

    public function genPlateNumbers($n): void
    {
        foreach (VehicleService::genPlateNumber($n) as $number) {
            echo $number . '<br>';
        };
    }


    public function update(): void
    {
        $data = Request::getFields();

        if (!array_key_exists('id', $data) || $data['id'] == '') {
            $this->error["vehicleUpdate"] = "Cannot find id";
            $this->redirect("/vexepro/vehicle/manage");
            return;
        } else {
            $vehicle = VehicleService::get("id", "=", $data['id']);
            if (count($vehicle) == 0) {
                $this->error["vehicleUpdate"] = "Cannot find vehicle";
                $this->redirect("/vexepro/vehicle/manage");
                return;
            }
        }

        VehicleService::update("agency_id", $data['agency_id'], $data['id']);
        VehicleService::update("type_id", $data['type_id'], $data['id']);
        VehicleService::update("plate_num", $data['plate_num'], $data['id']);

        $this->redirect("/vexepro/vehicle/manage");
    }

    public function delete(): void
    {
        $req = Request::getFields();

        VehicleService::delete($req['id']);
        $this->redirect("/vexepro/vehicle/manage");
    }
}
