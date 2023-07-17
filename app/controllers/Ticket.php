<?php
require_once _DIR_ROOT . '/app/controllers/Home.php';
require_once _DIR_ROOT . '/app/services/TicketService.php';
require_once _DIR_ROOT . '/app/controllers/User.php';
require_once _DIR_ROOT . '/app/controllers/Trip.php';

class Ticket extends Controller
{

    public function book(): void
    {
        $home = new Home();
        $data = Request::getFields();

        $ticket['user_id'] = $_SESSION['userObj']->id;
        $ticket['trip_id'] = $data['trip_id'];
        $ticket['status'] = 'pending';
        $ticket['seat'] = $data['row'] . $data['level'] . $data['seat'];
        $ts = TicketService::getByUserId($_SESSION['userObj']->id);
        for ($i = 0; $i < count($ts); $i++) {
            $t = $ts[$i];
            if ($t->trip_id == $data['trip_id'] && $t->seat == ($data['row'] . $data['level'] . $data['seat'])) {
                $this->error["bookTicket"] = "Vé này bạn đã đặt trước đó";
                $this->redirect("/vexepro/trip/search?errorBookTicket=".$this->error["bookTicket"]);
                return;
            }
        }
        TicketService::add($ticket);
        TripService::decreaseRemainingSlots($data['trip_id'], 1);
        $home->me();
    }

    public function cancel(): void
    {
        $data = Request::getFields();
        $ticketID = Request::getFields()['ticket_id'];

        TicketService::cancel($ticketID);
        TripService::increaseRemainingSlots($data['trip_id'], 1);
        $home = new Home();
        $home->me();
    }

    public function manage(): void
    {
        $fields = Request::getFields();
        if (array_key_exists('id', $fields) && $fields['id'] != '') $data['tickets'] = TicketService::get("id", "=", $fields['id']);
        else {
            $data['tickets'] = TicketService::getAll();
        }
        $this->render('TicketMana', $data);
    }

    public function update(): void
    {
        $req = Request::getFields();

        TicketService::update('status', $req['status'], $req['id']);
        $this->redirect("/vexepro/ticket/manage");
    }
}
