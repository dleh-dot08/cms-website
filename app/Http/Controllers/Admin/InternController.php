<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Person;
use Illuminate\Http\Request;

class InternController extends BasePeopleController
{
    protected string $type = Person::TYPE_INTERN;
    protected string $label = 'Team Intern';
    protected string $routeBase = 'admin.interns';
}