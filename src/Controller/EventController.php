<?php

namespace App\Controller;

use App\Repository\CalendarRepository;
use App\Repository\EventRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class EventController extends AbstractController
{

    #[Route("/events", name: "events", methods: ["GET"])]
    public function events(EventRepository $eventRepository) : Response {
        $events = $eventRepository->findAll();
        return $this->render('displays/event.html.twig',[
        "events" => $events]);
    }
    #[Route("/calendar", name: "calendar", methods: ["GET"])]
    public function calendar(CalendarRepository $calendarRepository) : Response {
        $calendar = $calendarRepository->findAll();
        return $this->render('displays/calendar.html.twig',[
            "calendar" => $calendar
        ]);
    }
}
