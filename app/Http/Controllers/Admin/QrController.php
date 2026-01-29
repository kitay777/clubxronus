<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

class QrController extends Controller
{
    public function register()
    {
        return view('admin.qr.register', [
            'url' => 'https://clubxronus.com/register',
        ]);
    }
}
