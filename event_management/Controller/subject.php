

<?php

    interface subject
    {
        public function register(observer $observer);
        public function unregister(observer $observer);
        public function notify();

    }

