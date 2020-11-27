<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Currency;
use App\Models\CurrencyHistory;

class CurrencyController extends Controller
{
    public function list(Request $request)
    {
        if (!isset($request->page_size) && (!isset($request->page))) {
            return response()->json([
                'status' => 'error',
                'data' => []
            ]);
        }
        return response()->json([
            'status' => 'success',
            'data' => Currency::limit($request->page)->paginate($request->page_size)
        ]);
    }

    public function currencyHistory(Request $request)
    {
        if (!isset($request->currency_id)) {
            return response()->json([
                'status' => 'error',
                'data' => []
            ]);
        }
        $dataHistory = CurrencyHistory::where('currency_id', $request->currency_id)->get();
        $dataCurrency = Currency::where('NumCode', $request->currency_id)->first();

        return response()->json([
            'status' => 'success',
            'data' => [
                'history' => $dataHistory,
                'currency' => $dataCurrency,
            ]
        ]);
        
    }

    public function currencyCalculation(Request $request)
    {              
        if (isset($request->date) && isset($request->base_currency_id)) {
            $min =  CurrencyHistory::whereBetween('currency_date', [ now() , $request->date])
                ->where('currency_id', $request->base_currency_id)
                ->min('price');
            $max =  CurrencyHistory::whereBetween('currency_date', [ now() , $request->date])
            ->where('currency_id', $request->base_currency_id)
            ->max('price');

            $avg =  CurrencyHistory::whereBetween('currency_date', [ now() , $request->date])
            ->where('currency_id', $request->base_currency_id)
            ->avg('price');
        } elseif (isset($request->base_currency_id)) {
            $min = CurrencyHistory::where('currency_id', $request->base_currency_id)
                ->min('price');
            $max = CurrencyHistory::where('currency_id', $request->base_currency_id)
                ->max('price');
            $avg = CurrencyHistory::where('currency_id', $request->base_currency_id)
                ->avg('price');
        } else {
            return response()->json([
                'status' => 'error',
                'data' => []
            ]);
        }

        return response()->json([
            'status' => 'success',
            'data' => [
                'min' => $min,
                'max' => $max,
                'avg' => $avg,
            ]
        ]);

    }

}
