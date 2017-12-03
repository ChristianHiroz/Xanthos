<?php
namespace ECommerceBundle\Manager;

class DeliveryFeeManager
{
    public static function getDeliveryPrice($weight)
    {
        if($weight === 0) {
            return 0;
        }elseif ($weight <= 500) {
            return 4.55;
        }elseif ($weight <= 1000) {
            return 5.25;
        }elseif ($weight <= 2000) {
            return 5.95;
        }elseif ($weight <= 3000) {
            return 6.80;
        }elseif ($weight <= 5000) {
            return 8.00;
        }elseif ($weight <= 7000) {
            return 10.50;
        }elseif ($weight <= 10000) {
            return 12.75;
        }elseif ($weight <= 15000) {
            return 15.35;
        }elseif ($weight <= 30000) {
            return 19.10;
        }

        return 0;
    }
}