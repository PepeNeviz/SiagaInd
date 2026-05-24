<?php

namespace App\Http\Controllers;

use App\Models\TasSiaga;
use App\Models\TasItem;
use Illuminate\Http\Request;

class TasItemController extends Controller
{
    /** Tambah item ke tas aktif */
    public function store(Request $request)
    {
        $data = $request->validate([
            'tas_id'    => 'required|exists:tas_siaga,id',
            'nama_item' => 'required|string|max:100',
            'zona'      => 'required|in:sangat_penting,penting,cukup_penting',
            'jumlah'    => 'integer|min:1',
            'satuan'    => 'nullable|string|max:30',
        ]);

        // Pastikan tas milik session ini
        $tas = TasSiaga::findOrFail($data['tas_id']);
        abort_if($tas->session_id !== $request->session()->getId(), 403);

        // Mencegah duplikasi item yang sama di dalam satu tas
        $item = TasItem::updateOrCreate(
            [
                'tas_id'    => $data['tas_id'],
                'nama_item' => $data['nama_item']
            ],
            [
                'zona'      => $data['zona'],
                'jumlah'    => $data['jumlah'] ?? 1,
                'satuan'    => $data['satuan'] ?? 'pcs'
            ]
        );

        return response()->json(['success' => true, 'item' => $item]);
    }

    /** Update zona item (saat drag-drop) */
    public function updateZona(Request $request, TasItem $tasItem)
    {
        $data = $request->validate([
            'zona' => 'required|in:sangat_penting,penting,cukup_penting',
        ]);

        // Pastikan item milik session ini
        abort_if(!$tasItem->tas || $tasItem->tas->session_id !== $request->session()->getId(), 403);

        $tasItem->update(['zona' => $data['zona']]);

        return response()->json(['success' => true]);
    }

    /** Hapus item */
    public function destroy(Request $request, TasItem $tasItem)
    {
        // Pastikan item milik session ini
        abort_if(!$tasItem->tas || $tasItem->tas->session_id !== $request->session()->getId(), 403);

        $tasItem->delete();

        return response()->json(['success' => true]);
    }
}