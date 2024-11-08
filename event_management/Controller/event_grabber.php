<?php

require_once 'subject.php';
class event_grabber implements subject
{

    private $event_observers = [];

//
    public function register(observer $observer)
    {
        $this->event_observers[] = $observer;
        print_r("new observer added");
    }

    public function unregister(observer $observer)
    {
        array_pop($this->event_observers);
        $key = array_search($observer, $this->event_observers, true);
        if ($key !== false) {
            unset($this->event_observers[$key]);
        }

        print_r("observer is deleted");
    }

    public function notify()
    {
        foreach ($this->event_observers as $in_loop_observer)
            $in_loop_observer.update($in_loop_observer);

    }

}