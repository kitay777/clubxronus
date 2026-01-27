<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Ticker;

class TickerController extends Controller
{
    public function index()
    {
        $tickers = Ticker::orderBy('order')->get();
        return view('admin.tickers.index', compact('tickers'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'text' => 'required|string|max:255'
        ]);

        Ticker::create([
            'text' => $request->text,
            'order' => Ticker::max('order') + 1,
        ]);

        return back()->with('success', 'テロップを追加しました');
    }

    public function destroy(Ticker $ticker)
    {
        $ticker->delete();
        return back()->with('success', '削除しました');
    }
}
