<?php

namespace App\Services;

interface TimeService
{
    public static function calculateCreatedAgoTime(string $createdAt): string;
}
