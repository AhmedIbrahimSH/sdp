<?php
class SimpleNeedFactory
{
    public static function CreateNeed($needType, $initParams = [])
    {
        switch (strtolower($needType)) {
            case 'food':
                require_once 'FoodNeed.php';
                return new FoodNeed(...self::extractParams($initParams)); // Call the constructor with the extracted parameters (optional)

            case 'drug':
                require_once 'DrugNeed.php';
                return new DrugNeed(...self::extractParams($initParams));

            case 'medical':
                require_once 'MedicalNeed.php';
                return new MedicalNeed(...self::extractParams($initParams));

            case 'cash':
                require_once 'CashNeed.php';
                return new CashNeed(...self::extractParams($initParams));

            case 'clothing':
                require_once 'ClothingNeed.php';
                return new ClothingNeed(...self::extractParams($initParams));

            case 'shelter':
                require_once 'ShelterNeed.php';
                return new ShelterNeed(...self::extractParams($initParams));

            default:
                throw new Exception("Unknown need type: " . $needType);
        }
    }

    private static function extractParams($params)
    {
        // Define the expected parameter order for the constructor
        $paramOrder = [
            'allocationID',
            'BeneficiaryID',
            'Amount',
            'isAllocated',
            'isAccepted',
            'RegisterDate',
            'purpose'
        ];

        // Extract parameters in the correct order
        $orderedParams = [];
        foreach ($paramOrder as $key) {
            $orderedParams[] = $params[$key] ?? null; // Use null as default if the key is missing
        }

        return $orderedParams;
    }
}
