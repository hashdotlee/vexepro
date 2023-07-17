<?php

require_once _DIR_ROOT . '/app/services/StationService.php';
require_once _DIR_ROOT . '/app/services/TicketService.php';
require_once _DIR_ROOT . '/app/services/TripService.php';

class Home extends Controller
{

    public function index(): void
    {
        $provinces = StationService::getProvinces();
        $trips = TripService::getPopularWithDetails();
        $data['provinces'] = $provinces;
        $data['trips'] = $trips;

        $this->render('Home', $data);
    }

    public function me(): void
    {
        $uid = $_SESSION['userObj']->id;
        $tickets = TicketService::getByUserId($uid);
        $data['tickets'] = $tickets;

        $this->render('Me', $data);
    }
}
