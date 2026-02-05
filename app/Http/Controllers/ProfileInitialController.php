<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ProfileInitialController extends Controller
{
    //
    public function store(Request $request)
    {
        $user = auth()->user();

        if ($user->shimei !== null) {
            abort(403);
        }

        $request->validate([
            'shimei' => 'required|string|max:255',
            'age' => 'required|integer|min:1',
            'blood_type' => 'nullable|string|max:3',
            'residence' => 'nullable|string|max:255',
        ]);

        $user->update([
            'shimei' => $request->shimei,
            'is_approved' => true,
        ]);

        $user->profile()->updateOrCreate(
            ['user_id' => $user->id],
            [
                'age' => $request->age,
                'blood_type' => $request->blood_type,
                'residence' => $request->residence,
            ]
        );


return redirect('/dashboard')
    ->with('pending_approval', true);
    }
}
