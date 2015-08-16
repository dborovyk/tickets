<?php
namespace Multiple\Frontend\Controllers;

use EventSeats;
use Orders;
use Phalcon\Mvc\View;

class OrderController extends ControllerBase
{
    public function previewAction ($eventId) {
        $totalSum = 0;
        $eventSeats = $this->getSelfEventsSeats($eventId);

        foreach($eventSeats as $eventSeat) {
            $totalSum += $eventSeat->price;
            $eventSeat->last_reservation = new \DateTime(); // 15 минут для покупки билета
            $eventSeat->last_reservation = $eventSeat->last_reservation->format('Y-m-d H:i:s');
            $eventSeat->save();
        }

        $this->view->setVar('eventSeats', $eventSeats);
        $this->view->setVar('totalSum', $totalSum);
        $this->view->setVar('eventId', $eventId);

        $data = array(
            'version' => 3,
            'public_key' => $this->publicKey,
            'amount' => $totalSum,
            'currency' => 'UAH',
            'order_id' => $eventId, // TODO уникальное ID покупки
            'result_url' => 'http://circus.org.ua/order/payment/' . $eventId,
            'language' => 'ru',
            'sandbox' => 1
        );

        $data = base64_encode(json_encode(http_build_query($data)));
        $this->view->setVar('data', $data);
        $this->view->setVar('signature', sha1($this->privateKey . $data . $this->privateKey));
    }

    // сюда должно редиректить после успешной оплаты
    public function paymentAction ($eventId) {
        if (!$this->request->isPost()) {
            die('Вы попали на страницу ошибочным образом');
        }

        $name = $this->request->get('name');
        $email = $this->request->get('email');
        $phone = $this->request->get('phone');

        if(!empty($name) and !empty($email) and !empty($phone)) {
            $eventSeats = $this->getSelfEventsSeats($eventId);
            foreach($eventSeats as $eventSeat) {
                $order = new Orders();
                $order->assign(array(
                    "events_seat_id" => $eventSeat->id,
                    "user_name" => $name,
                    "user_email" => $email,
                    "user_phone" => $phone,
                    "date" => date("Y-m-d H:i:s"),
                ));
                if($order->save()) {
                    $eventSeat->is_purchased = 1;
                    $eventSeat->save();

                    $this->view->setVar('success', true);
                    $this->view->setVar('email', $email);
                    $this->view->setVar('name', $name);
                }
            }
        }
    }

    private function getSelfEventsSeats ($eventId) {
        $minDate = new \DateTime('-'.ControllerBase::RESERVATION_TIME.' minute');
        return EventSeats::find(array(
            "is_purchased = 0 AND event_id = :eventId:
                AND (last_reservation > :minDate: AND last_reservation_session_id = :sessionId:)",
            "bind" => array (
                "eventId" => $eventId,
                "minDate" => $minDate->format("Y-m-d H:i:s"),
                "sessionId" => session_id()
            )
        ));
    }

}
