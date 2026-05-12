<?php

namespace App\Http\Controllers;

use App\Models\TasSiaga;
use App\Models\TasItem;
use Illuminate\Http\Request;

class TasSiagaController extends Controller
{
    /**
     * Data rekomendasi item per kategori (nanti bisa dipindah ke DB/seeder)
     */
    private array $rekomendasi = [
        'semua' => [
            ['nama_item' => 'Air Minum',       'satuan' => 'botol (600ml)', 'jumlah' => 3, 'zona_saran' => 'sangat_penting'],
            ['nama_item' => 'P3K',             'satuan' => 'set',           'jumlah' => 1, 'zona_saran' => 'sangat_penting'],
            ['nama_item' => 'Senter',          'satuan' => 'buah',          'jumlah' => 1, 'zona_saran' => 'sangat_penting'],
            ['nama_item' => 'Peluit darurat',  'satuan' => 'buah',          'jumlah' => 1, 'zona_saran' => 'sangat_penting'],
            ['nama_item' => 'Masker',          'satuan' => 'buah',          'jumlah' => 5, 'zona_saran' => 'penting'],
            ['nama_item' => 'Makanan Kaleng',  'satuan' => 'kaleng',        'jumlah' => 3, 'zona_saran' => 'penting'],
            ['nama_item' => 'Korek api',       'satuan' => 'buah',          'jumlah' => 1, 'zona_saran' => 'penting'],
            ['nama_item' => 'Baju ganti',      'satuan' => 'set',           'jumlah' => 2, 'zona_saran' => 'cukup_penting'],
            ['nama_item' => 'Selimut darurat', 'satuan' => 'buah',          'jumlah' => 1, 'zona_saran' => 'cukup_penting'],
            ['nama_item' => 'Tali',            'satuan' => 'meter',         'jumlah' => 5, 'zona_saran' => 'cukup_penting'],
        ],
        'anak' => [
            ['nama_item' => 'Susu/Formula',    'satuan' => 'kotak', 'jumlah' => 3, 'zona_saran' => 'sangat_penting'],
            ['nama_item' => 'Obat Anak',       'satuan' => 'set',   'jumlah' => 1, 'zona_saran' => 'sangat_penting'],
            ['nama_item' => 'Popok',           'satuan' => 'buah',  'jumlah' => 5, 'zona_saran' => 'penting'],
            ['nama_item' => 'Mainan kecil',    'satuan' => 'buah',  'jumlah' => 1, 'zona_saran' => 'cukup_penting'],
        ],
        'remaja' => [],
        'dewasa' => [
            ['nama_item' => 'Dokumen Penting', 'satuan' => 'set',  'jumlah' => 1, 'zona_saran' => 'sangat_penting'],
            ['nama_item' => 'Uang Tunai',      'satuan' => 'set',  'jumlah' => 1, 'zona_saran' => 'sangat_penting'],
            ['nama_item' => 'Obat Pribadi',    'satuan' => 'set',  'jumlah' => 1, 'zona_saran' => 'sangat_penting'],
            ['nama_item' => 'Power Bank',      'satuan' => 'buah', 'jumlah' => 1, 'zona_saran' => 'penting'],
            ['nama_item' => 'Radio Portabel',  'satuan' => 'buah', 'jumlah' => 1, 'zona_saran' => 'penting'],
        ],
        'lansia' => [
            ['nama_item' => 'Obat Rutin',         'satuan' => 'set',  'jumlah' => 1, 'zona_saran' => 'sangat_penting'],
            ['nama_item' => 'Alat bantu',          'satuan' => 'buah', 'jumlah' => 1, 'zona_saran' => 'sangat_penting'],
            ['nama_item' => 'Kacamata cadangan',   'satuan' => 'buah', 'jumlah' => 1, 'zona_saran' => 'penting'],
        ],
    ];

    /** Halaman utama Sebelum (Tas Siaga) */
    public function index(Request $request)
    {
        $sessionId = $request->session()->getId();

        $semuaTas = TasSiaga::where('session_id', $sessionId)
            ->withCount('items')
            ->latest()
            ->get();

        $activeTasId = $request->session()->get('active_tas_id');
        $activeTas   = $semuaTas->firstWhere('id', $activeTasId);

        // Kalau belum ada tas aktif, pakai tas pertama
        if (!$activeTas && $semuaTas->isNotEmpty()) {
            $activeTas = $semuaTas->first();
            $request->session()->put('active_tas_id', $activeTas->id);
        }

        $items = $activeTas
            ? $activeTas->items()->get()->groupBy('zona')
            : collect();

        $rekomendasi = $activeTas
            ? array_merge($this->rekomendasi['semua'], $this->rekomendasi[$activeTas->kategori] ?? [])
            : $this->rekomendasi['semua'];

        return view('sebelum.index', compact('semuaTas', 'activeTas', 'items', 'rekomendasi'));
    }

    /** Buat tas baru */
    public function store(Request $request)
    {
        $data = $request->validate([
            'nama_tas' => 'required|string|max:100',
            'kategori' => 'required|in:anak,remaja,dewasa,lansia',
            'liter'    => 'required|numeric|min:1|max:200',
        ]);

        $tas = TasSiaga::create([
            'session_id' => $request->session()->getId(),
            'nama_tas'   => $data['nama_tas'],
            'kategori'   => $data['kategori'],
            'liter'      => $data['liter'],
        ]);

        $request->session()->put('active_tas_id', $tas->id);

        return response()->json(['success' => true, 'tas' => $tas]);
    }

    /** Ganti tas aktif */
    public function setActive(Request $request, TasSiaga $tas)
    {
        // Pastikan tas milik session ini
        abort_if($tas->session_id !== $request->session()->getId(), 403);

        $request->session()->put('active_tas_id', $tas->id);

        return response()->json(['success' => true, 'tas' => $tas]);
    }

    /** Hapus tas */
    public function destroy(Request $request, TasSiaga $tas)
    {
        abort_if($tas->session_id !== $request->session()->getId(), 403);

        $tas->delete(); // items ikut terhapus karena cascadeOnDelete

        // Reset active jika yang dihapus adalah aktif
        if ($request->session()->get('active_tas_id') === $tas->id) {
            $remaining = TasSiaga::where('session_id', $request->session()->getId())->first();
            $request->session()->put('active_tas_id', $remaining?->id);
        }

        return response()->json(['success' => true]);
    }

    /** Ambil rekomendasi item berdasarkan kategori (AJAX) */
    public function rekomendasi(string $kategori)
    {
        $items = array_merge(
            $this->rekomendasi['semua'],
            $this->rekomendasi[$kategori] ?? []
        );

        return response()->json($items);
    }
}
