<?php

namespace App\Http\Controllers;

use App\Models\Person;

class LandingController extends Controller
{
    public function about()
    {
        // Ambil officer & mentor dari tabel people
        $officers = Person::query()
            ->where('type', Person::TYPE_OFFICER)
            ->orderBy('sort_order')
            ->get();

        $mentors = Person::query()
            ->where('type', Person::TYPE_MENTOR)
            ->orderBy('sort_order')
            ->get();

        return view('about', compact('officers', 'mentors'));
    }
}
