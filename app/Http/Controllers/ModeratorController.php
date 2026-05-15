<?php

namespace App\Http\Controllers;

use Illuminate\View\View;

class ModeratorController extends Controller
{
    /**
     * Display the moderator dashboard.
     */
    public function index(): View
    {
        return view('admin.moderator.index');
    }
}
