<?php
class NeedFactory
{
    public static function CreateNeed($need)
    {
        switch (strtolower($need)) {
            case 'food':
                require_once 'FoodNeed.php';
                return new FoodNeed();
            case 'drugs':
                require_once 'DrugsNeed.php';
                return new DrugsNeed();
            case 'medical':
                require_once 'MedicalNeed.php';
                return new MedicalNeed();
            case 'cash':
                require_once 'CashNeed.php';
                return new CashNeed();
            case 'clothing':
                require_once 'ClothingNeed.php';
                return new ClothingNeed();
            case 'shelter':
                require_once 'ShelterNeed.php';
                return new ShelterNeed();

            default:
                throw new Exception("Unknown need type: " . $need);
        }
    }
}
