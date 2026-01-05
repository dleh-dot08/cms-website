<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Person;
use Illuminate\Http\Request;

class OfficerController extends BasePeopleController
{
    protected string $type = Person::TYPE_OFFICER;
    protected string $label = 'Officer';
    protected string $routeBase = 'admin.officers';
}

