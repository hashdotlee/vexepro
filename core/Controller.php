<?php
require_once _DIR_ROOT . '/app/services/TripService.php';
require_once _DIR_ROOT . '/app/services/VehicleService.php';
require_once _DIR_ROOT . '/app/services/StationService.php';
require_once _DIR_ROOT . '/app/services/AgencyService.php';

abstract class Controller
{
    protected array $error = [];

    public function model($model)
    {
        if (file_exists(_DIR_ROOT . '/app/models/' . $model . ".php")) {
            require_once _DIR_ROOT . '/app/models/' . $model . ".php";
            if (class_exists($model)) {
                return new $model();
            }
        }
        return null;
    }

    private function getFooterData()
    {
        $footer['vehicles'] = VehicleService::getAll();
        $footer['trips'] = TripService::getAllWithDetails();
        $footer['stations'] = StationService::getAll();
        $footer['agencies'] = AgencyService::getAll();
        return $footer;
    }

    public function render($view, $data = [])
    {
        $footer = $this->getFooterData();
        $error = $this->error;
        array_push($data, ['error' => $error, 'footer' => $footer]);
        extract($data);
        if (file_exists(_DIR_ROOT . '/app/views/' . $view . '.php')) {
            require_once _DIR_ROOT . '/app/views/' . $view . '.php';
            if (!str_ends_with($view, "Mana") && !in_array($view, ["Login", "Register", "Me"])) require_once _DIR_ROOT . '/app/views/' . 'Footer' . '.php';
        }
    }
    public function redirect($url, $statusCode = 303)
    {
        header('Location: ' . $url, true, $statusCode);
        die();
    }
}
