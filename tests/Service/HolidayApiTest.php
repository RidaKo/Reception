<?php

namespace App\Tests\Service;

use App\Service\HolidayApi;
use DateTime;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class HolidayApiTest extends KernelTestCase
{
    public function testSomething(): void
    {
        $kernel = self::bootKernel();

        $this->assertSame('test', $kernel->getEnvironment());
        // $routerService = static::getContainer()->get('router');
        // $myCustomService = static::getContainer()->get(CustomService::class);
        $holiday_api = static::getContainer()->get(HolidayApi::class);
        
        $this->assertTrue($holiday_api->checkIfReservationTimeIsHoliday(new DateTime('2022-02-16')));
    }
}
