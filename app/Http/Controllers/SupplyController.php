<?php

namespace App\Http\Controllers;

use App\Models\TasSiaga;
use Illuminate\Http\Request;

class SupplyController extends Controller
{
    /** Halaman Sesudah — baca supply dari tas aktif */
    public function index(Request $request)
    {
        $sessionId   = $request->session()->getId();
        $activeTasId = $request->session()->get('active_tas_id');

        $tas   = $activeTasId ? TasSiaga::where('session_id', $sessionId)->find($activeTasId) : null;
        $items = $tas ? $tas->items()->get() : collect();

        $supply = [
            'minum' => $items->filter(fn($i) => str_contains(strtolower($i->nama_item), 'air') || str_contains(strtolower($i->nama_item), 'minum'))->isNotEmpty(),
            'p3k'   => $items->filter(fn($i) => str_contains(strtolower($i->nama_item), 'p3k') || str_contains(strtolower($i->nama_item), 'obat'))->isNotEmpty(),
            'alat'  => $items->filter(fn($i) => str_contains(strtolower($i->nama_item), 'senter') || str_contains(strtolower($i->nama_item), 'tali'))->isNotEmpty(),
        ];

        return view('sesudah.index', compact('tas', 'items', 'supply'));
    }
}
