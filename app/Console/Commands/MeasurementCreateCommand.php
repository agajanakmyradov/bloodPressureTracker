<?php

namespace App\Console\Commands;

use App\Models\Measurement;
use Illuminate\Console\Command;
use DateTime;

class MeasurementCreateCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'bp:create {date} {--user=1}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create measurements of a blood preasure';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $date = $this->argument('date');

        if ($this->validateDate($date, 'Y-m-d')) {
            $today = new DateTime();

            $givenDate = new DateTime($date);

            $interval = $givenDate->diff($today);

           $diff = intval($interval->format('%a'));

           for ($i=0; $i <= $diff; $i++) {
                Measurement::create([
                    'user_id' => $this->option('user'),
                    'date' => $givenDate->format('Y-m-d'),
                    'time' => '08:00',
                    'sys' => rand(60, 240),
                    'dia' => rand(30, 160),
                    'pulse' => rand(20, 200)
                ]);

                Measurement::create([
                    'user_id' => $this->option('user'),
                    'date' => $givenDate->format('Y-m-d'),
                    'time' => '20:00',
                    'sys' => rand(60, 240),
                    'dia' => rand(30, 160),
                    'pulse' => rand(20, 200)
                ]);

                $givenDate->modify('+1 day');
           }



        } else {
            $this->error("The date format is invalid. Please use the format: Y-m-d");
        }
    }

    private function validateDate($date, $format) {
        $d = DateTime::createFromFormat($format, $date);
        return $d && $d->format($format) === $date;

    }
}
