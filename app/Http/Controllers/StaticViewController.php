<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use Inertia\Response;

class StaticViewController extends Controller
{
    public function homepage(): Response
    {
        return Inertia::render('Public/Index');
    }
}
