<?php

namespace App\Services\Impl;

use App\Services\TimeService;
use Illuminate\Support\Carbon;

class TimeServiceImpl implements TimeService
{

    public static function calculateCreatedAgoTime(string $createdAt): string
    {
        $currentDateTime = Carbon::now();
        $timeDifference = '';

        $diffInSeconds = $currentDateTime->diffInSeconds($createdAt);
        $diffInMinutes = $currentDateTime->diffInMinutes($createdAt);
        $diffInHours = $currentDateTime->diffInHours($createdAt);
        $diffInDays = $currentDateTime->diffInDays($createdAt);

        if ($diffInSeconds > 0 && $diffInMinutes === 0 && $diffInHours === 0 && $diffInDays === 0) {
            $timeDifference = $diffInSeconds . ' sec. ago';
        } elseif ($diffInMinutes > 0 && $diffInHours === 0 && $diffInDays === 0) {
            $timeDifference = $diffInMinutes . ' min. ago';
        } elseif ($diffInHours > 0 && $diffInDays === 0) {
            $timeDifference = $diffInHours . ' hr. ago';
        } elseif ($diffInDays > 0) {
            $timeDifference = $diffInDays . ' d. ago';
        }

        return $timeDifference;
    }
}
