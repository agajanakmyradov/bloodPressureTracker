<?php

namespace App\Http\Controllers;

use App\Models\Measurement;
use Illuminate\Http\Request;
use DateTime;

class MeasurementController extends Controller
{
    public function getMonth() {
        $measurement = Measurement::orderBy('date')->first();
        $startDate = $measurement->date;
        $today = new DateTime();
        $endDate = $today->format('Y-m-d');

        $months = $this->getMonthsBetweenDates($startDate, $endDate);

        
    }

    public function getMonthsBetweenDates($startDate, $endDate) {
        $start = new DateTime($startDate);
        $end = new DateTime($endDate);
        $end->modify('first day of next month');

        $ukrainianMonths = [
            1 => "Січень",
            2 => "Лютий",
            3 => "Березень",
            4 => "Квітень",
            5 => "Травень",
            6 => "Червень",
            7 => "Липень",
            8 => "Серпень",
            9 => "Вересень",
            10 => "Жовтень",
            11 => "Листопад",
            12 => "Грудень"
        ];

        $months = [];
        while ($start < $end) {
            $year = $start->format('Y');
            $month = $start->format('n');
            $formattedMonth = $ukrainianMonths[$month];
            $key = "$year $formattedMonth";
            $value = $start->format('Y-m');
            $months[$key] = $value;
            $start->modify('first day of next month');
        }

        return $months;
    }
}
