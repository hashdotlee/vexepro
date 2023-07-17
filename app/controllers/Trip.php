<?php
require_once _DIR_ROOT . '/app/services/TripService.php';
require_once _DIR_ROOT . '/app/services/StationService.php';
require_once _DIR_ROOT . '/app/services/VehicleService.php';
require_once _DIR_ROOT . '/app/services/TicketService.php';

class Trip extends Controller
{

    public function search(): void
    {
        $filter = Request::getFields();
        date_default_timezone_set('Asia/Ho_Chi_Minh');
        $dateNow = date('Y/m/d', time());

        // Default filter
        if (!array_key_exists('price_low', $filter) || $filter['price_low'] == '') $filter['price_low'] = 0;
        if (!array_key_exists('price_high', $filter) || $filter['price_high'] == '') $filter['price_high'] = 10000000;
        $trips = TripService::search($filter);

        foreach ($trips as $trip) {
            $tickets = TicketDao::getUnavailableSeats($trip->id);
            $trip->tickets = $tickets;
        }
        $data['provinces'] = StationService::getProvinces();
        $data['trips'] = $trips;
        $this->render('Search', $data);
    }

    public function seed(string $n): void
    {
        echo 'Seeding...';
        TripService::seed(intval($n));
        echo '<br>Done!';
    }

    public function manage(): void
    {
        $fields = Request::getFields();
        $search =  (array_key_exists('search', $fields) && $fields['search'] != '') ? $fields['search'] : '';
        $data['trips'] = TripDao::search_2($search);

        $data['stations'] = StationService::getAll();
        $data['vehicles'] = VehicleService::getAllWithDetails();
        $this->render('TripMana', $data);
    }

    public function add(): void
    {
        $fields = Request::getFields();
        $fields['remaining_slots'] = VehicleService::getCapacity($fields['vehicle_id']);

        TripService::add($fields);
        $this->redirect("/vexepro/trip/manage");
    }

    public function delete(): void
    {
        $req = Request::getFields();

        TripService::delete($req['id']);
        $this->redirect("/vexepro/trip/manage");
    }

    public function update(): void
    {
        $req = Request::getFields();

        TripService::updateMany($req, ["id" => $req['id']]);
        $this->redirect("/vexepro/trip/manage");
    }
}
