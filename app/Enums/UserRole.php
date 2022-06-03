<?php
/**
 * Created by PhpStorm.
 * User: dipok
 * Date: 17/4/20
 * Time: 12:47 PM
 */

namespace App\Enums;

interface UserRole
{
    const ADMIN       = 5;
    const CUSTOMER    = 10;
    const SHOPOWNER   = 15;
    const DELIVERYBOY = 20;
}
