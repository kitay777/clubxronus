<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PointEvent;
use Illuminate\Http\Request;
use Carbon\Carbon;

class PointEventController extends Controller
{
    /**
     * イベントポイント一覧
     */
    public function index()
    {
        $events = PointEvent::orderByDesc('start_at')->get();

        return view('admin.points.events.index', compact('events'));
    }

    /**
     * イベント追加画面
     */
    public function create()
    {
        return view('admin.points.events.create');
    }

    /**
     * イベント登録処理（30時対応）
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'name'        => 'required|string|max:100',
            'event_date'  => 'required|date',
            'start_time'  => 'required|date_format:H:i',
            'end_hour'    => 'required|integer|min:0|max:30',
            'rate'        => 'required|numeric|min:0',
            'is_active'   => 'nullable|boolean',
        ]);

        // イベント日
        $eventDate = Carbon::parse($data['event_date']);

        // 開始日時（例：2026-02-01 19:00）
        $startAt = Carbon::parse(
            $data['event_date'] . ' ' . $data['start_time']
        );

        // 終了日時（30時＝翌日06:00）
        $endAt = $eventDate->copy()->addHours((int) $data['end_hour']);

        PointEvent::create([
            'name'      => $data['name'],
            'start_at'  => $startAt,
            'end_at'    => $endAt,
            'rate'      => $data['rate'],
            'is_active' => $request->boolean('is_active'),
        ]);

        return redirect()
            ->route('admin.points.events.index')
            ->with('success', 'イベントポイントを登録しました');
    }

    /**
     * イベント編集画面
     */
    public function edit(PointEvent $event)
    {
        // UI 用に「30時表記」に戻す
        $eventDate = $event->start_at->copy()->startOfDay();
        $endHour   = $eventDate->diffInHours($event->end_at);

        return view('admin.points.events.edit', [
            'event'      => $event,
            'eventDate' => $event->start_at->toDateString(),
            'startTime' => $event->start_at->format('H:i'),
            'endHour'   => $endHour, // 0〜30
        ]);
    }

    /**
     * イベント更新処理（30時対応）
     */
    public function update(Request $request, PointEvent $event)
    {
        $data = $request->validate([
            'name'        => 'required|string|max:100',
            'event_date'  => 'required|date',
            'start_time'  => 'required|date_format:H:i',
            'end_hour'    => 'required|integer|min:0|max:30',
            'rate'        => 'required|numeric|min:0',
            'is_active'   => 'nullable|boolean',
        ]);

        $eventDate = Carbon::parse($data['event_date']);

        $startAt = Carbon::parse(
            $data['event_date'] . ' ' . $data['start_time']
        );

        $endAt = $eventDate->copy()->addHours((int) $data['end_hour']);

        $event->update([
            'name'      => $data['name'],
            'start_at'  => $startAt,
            'end_at'    => $endAt,
            'rate'      => $data['rate'],
            'is_active' => $request->boolean('is_active'),
        ]);

        return redirect()
            ->route('admin.points.events.index')
            ->with('success', 'イベントポイントを更新しました');
    }

    /**
     * 有効 / 無効 切り替え
     */
    public function toggle(PointEvent $event)
    {
        $event->update([
            'is_active' => ! $event->is_active,
        ]);

        return back()->with('success', 'イベントの有効状態を切り替えました');
    }
}
