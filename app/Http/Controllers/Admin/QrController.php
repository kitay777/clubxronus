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
    public function castRegister()
    {
        dd('test');
        return view('admin.qr.castregister', [
            'url' => 'https://clubxronus.com/cast/register',
        ]);
    }
}
