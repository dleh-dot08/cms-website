<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Person;
use Illuminate\Http\Request;

class MentorController extends BasePeopleController
{
    protected string $type = Person::TYPE_MENTOR;
    protected string $label = 'Mentor';
    protected string $routeBase = 'admin.mentors';
}