<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Setting;

class SettingsController extends Controller
{
    public function index(Request $request){
        return Setting::all()->pluck('value', 'name');
    }
    public function update(Request $request, $name){
        $namesOfSettings = ['top' => 'padding-top', 'bottom' =>  'padding-bottom'];

        Setting::updateOrCreate(
            ['name' =>  $namesOfSettings['top']],
            ['value' => $request->top]
        );
        Setting::updateOrCreate(
            ['name' =>  $namesOfSettings['bottom']],
            ['value' => $request->bottom]
        );
    }
}
