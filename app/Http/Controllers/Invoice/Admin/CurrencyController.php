<?php

namespace App\Http\Controllers\Invoice\Admin;

use App\Models\Invoice\Currency;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CurrencyController extends Controller
{
    public function index() {
        $currencies = Currency::all();
        return view('invoice.admin.currency.index', compact('currencies'));
    }

    public function store(Request $request) {
        $arr = explode(',', $request->currency);

        foreach ($arr as $a){
            $currency = new Currency();
            $currency->name = $a;
            $currency->save();
        }

        return back()->with('success', 'Currency created successfully!');
    }

    public function delete(Request $request) {
        Currency::destroy($request->id);

        return response()->json(['status' => true, 'message' => 'You deleted currency!']);
    }
}
