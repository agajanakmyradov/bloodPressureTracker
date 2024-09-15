<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\MeasurementStoreRequest;
use App\Http\Resources\MeasurementResource;
use App\Models\Measurement;
use Illuminate\Http\Request;
use DateTime;

class MeasurementController extends Controller
{
    public function index(Request $request) {
        try {
            $query = Measurement::where('user_id', $request->user()->id)->orderBy('date');

            if ($request->has('start_date') && $request->input('start_date') != "") {
                $query->where('date', '>=', $request->input('start_date'));
            }

            if ($request->has('end_date') && $request->input('end_date') != "") {
                $query->where('date', '<=', $request->input('end_date'));
            }

            $bps = $query->paginate($request->input('limit', 10));

            return response()->json([
                    'success' => true,
                    'data' => $bps
                ]);
        } catch (\Throwable $th) {
            return response()->json([
                'success' => false,
                'error' => $th->getMessage()
            ]);
        }
    }

    public function show(Request $request, $id) {
        $bp = Measurement::find($id);

        if (!$bp || $bp->user_id != $request->user()->id) {
            return response()->json(['error' => 'Помилка, не вдалося знайти дані']);
        }

        return response()->json([
            'success' => true,
            'data' => new MeasurementResource($bp)
        ]);
    }

    public function destroy( $id) {
        try {
            Measurement::find($id)->delete();

            return response()->json(['success' => true]);
        } catch (\Throwable $th) {
            return response()->json(['success' => false]);
        }

    }

    public function store(MeasurementStoreRequest $request) {
        try {
            $data = $request->validated();
            $data['user_id'] = $request->user()->id;

            Measurement::create($data);

            return response()->json(['success' => true]);
        } catch (\Throwable $th) {
            return response()->json(['success' => false, 'error' => $th->getMessage()]);
        }
    }

    public function getMonths(Request $request) {
        try {
            $measurement = Measurement::where('user_id', $request->user()->id)->orderBy('date')->first();

            $startDate = $measurement->date;
            $today = new DateTime();
            $endDate = $today->format('Y-m-d');

            $months = $this->getMonthsBetweenDates($startDate, $endDate);

            return response()->json(['success' => true, 'months' => $months]);
        } catch (\Throwable $th) {
            return response()->json(['success' => false, 'error' => $th->getMessage()]);
        }

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
            $months[] = $key;
            $start->modify('first day of next month');
        }

        return $months;
    }
}

