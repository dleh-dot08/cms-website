<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\Person;

class AboutController extends Controller
{
    public function index()
    {
        $team = Person::query()
            ->whereIn('type', [Person::TYPE_OFFICER, Person::TYPE_INTERN])
            ->where('is_active', 1)
            ->orderBy('sort_order')
            ->get();

        $mentors = Person::query()
            ->where('type', Person::TYPE_MENTOR)
            ->where('is_active', 1)
            ->orderBy('sort_order')
            ->get();

        return view('about', compact('team', 'mentors'));
    }
}
