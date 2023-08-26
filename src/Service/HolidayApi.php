<?php 
namespace App\Service;

use DateTime;
use DateTimeImmutable;
use Symfony\Component\HttpClient\HttpClient;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class HolidayApi
{
    private $httpClient;
    public function __construct(HttpClientInterface $httpClient) {
        $this->httpClient = $httpClient;
    }
    public function checkIfReservationTimeIsHoliday(DateTime $appointment_time):bool
    {
        $appointment_date = $appointment_time->format('Y-m-d');
        $holidays = json_decode($this->httpClient->request('POST', "https://holidayapi.com/v1/holidays",
        [
        'auth_bearer' => '0c2f768f-db31-4b70-bf04-22657fb8650d',
        'query' => ['key' => '0c2f768f-db31-4b70-bf04-22657fb8650d','country' => 'LT', 'year' => '2022']
        ])->getContent(),true)['holidays'];
        foreach ($holidays as $holiday)
        {
            $holiday_date = $holiday['observed'];
            //$appointment_date='2022-02-16';
            //dump($holiday_date, $appointment_date);
            if($holiday_date == $appointment_date)
            {
                return true;
            }
        }
        return false;
        
    }
}