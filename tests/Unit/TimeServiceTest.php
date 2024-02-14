<?php

namespace Tests\Unit;

use App\Services\Impl\TimeServiceImpl;
use Illuminate\Support\Carbon;
use Tests\TestCase;

class TimeServiceTest extends TestCase
{

    protected function tearDown(): void
    {
        Carbon::setTestNow();
    }

    public function testCalculateCreatedAgoTime()
    {
        $createdAt = '2022-01-01 12:00:00';

        $customCurrentDateTime = Carbon::create(2022, 01, 01, 14, 30, 00);
        Carbon::setTestNow($customCurrentDateTime);

        $result = TimeServiceImpl::calculateCreatedAgoTime($createdAt);

        $this->assertEquals('2 hr. ago', $result);
    }
}
