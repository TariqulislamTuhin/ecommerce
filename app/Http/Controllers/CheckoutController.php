<?php

namespace App\Http\Controllers;

use App\Models\Profile;
use Igaster\LaravelCities\Geo;
use Illuminate\Http\Request;

class CheckoutController extends Controller
{
    public function __construct()
    {
        $this->middleware('customer');
    }

    public function index()
    {
        if (!auth()->id()) {
            return redirect()->route('customer.auth.index');
        }
        $profile = Profile::with('user')->where('user_id', auth()->id())->first();
        $cities = Geo::getCountry('bd')->level(Geo::LEVEL_1)->orderBy('population', 'DESC')->get();
        return view('frontend.pages.checkout', compact('profile', 'cities'));
    }
}
