<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\App;


class LanguageController extends Controller
{
    
    public function switchLang($lang)
    {
        
        if (array_key_exists($lang, Config::get('languages'))) {
            App::setLocale($lang);
            Session::put('applocale', $lang);
            session(['my_locale'=>$lang]);
        }
        // dd(App::getLocale());
        return redirect()->back();
    }
}