<?php

namespace App\Http\Controllers;

use App\Models\Room;
use Illuminate\View\View;

class HomeController extends Controller
{
    /**
     * Display the Luxora homepage with active rooms from MySQL.
     */
    public function index(): View
    {
        $rooms = Room::query()
            ->where('is_active', true)
            ->orderBy('price')
            ->get();

        return view('home', compact('rooms'));
    }
}
