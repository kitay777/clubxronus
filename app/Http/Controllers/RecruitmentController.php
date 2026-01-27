<?php

namespace App\Http\Controllers;

use App\Models\Recruitment;

class RecruitmentController extends Controller
{
    public function index()
    {
        $recruits = Recruitment::orderBy('id')->get();
        return view('recruitments.index', compact('recruits'));
    }
}

