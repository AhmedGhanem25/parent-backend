<?php

namespace App\Enums;

class DataProviderYStatuses
{
    const AUTHORIZED = 100;
    const DECLINE = 200;
    const REFUNDED = 300;
    const AUTHORIZED_STATUS_NAME = 'authorised';
    const DECLINE_STATUS_NAME = 'decline';
    const REFUNDED_STATUS_NAME = 'refunded';

    public static function getStatusEquivalentInteger(string $statusName): int
    {
        if ($statusName == self::DECLINE_STATUS_NAME)
            return self::DECLINE;

        if ($statusName == self::REFUNDED_STATUS_NAME)
            return self::REFUNDED;

        return self::AUTHORIZED;

    }
    public static function getStatusEquivalentString(int $statusId): string
    {
        if ($statusId == self::DECLINE)
            return self::DECLINE_STATUS_NAME;

        if ($statusId == self::REFUNDED)
            return self::REFUNDED_STATUS_NAME;

        return self::AUTHORIZED_STATUS_NAME;

    }
}

