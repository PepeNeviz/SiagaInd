<?php

namespace App\Http\Controllers;

use App\Models\TasSiaga;
use App\Models\TasItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TasSiagaController extends Controller
{
    private array $rekomendasi = [
        'semua' => [
            ['id'=>1,  'nama_item'=>'Air Minum',       'satuan'=>'botol (600ml)', 'jumlah'=>3, 'zona_saran'=>'sangat_penting'],
            ['id'=>2,  'nama_item'=>'P3K',             'satuan'=>'set',           'jumlah'=>1, 'zona_saran'=>'sangat_penting'],
            ['id'=>3,  'nama_item'=>'Senter',          'satuan'=>'buah',          'jumlah'=>1, 'zona_saran'=>'sangat_penting'],
            ['id'=>4,  'nama_item'=>'Peluit darurat',  'satuan'=>'buah',          'jumlah'=>1, 'zona_saran'=>'sangat_penting'],
            ['id'=>5,  'nama_item'=>'Masker',          'satuan'=>'buah',          'jumlah'=>5, 'zona_saran'=>'penting'],
            ['id'=>6,  'nama_item'=>'Makanan Kaleng',  'satuan'=>'kaleng',        'jumlah'=>3, 'zona_saran'=>'penting'],
            ['id'=>7,  'nama_item'=>'Korek api',       'satuan'=>'buah',          'jumlah'=>1, 'zona_saran'=>'penting'],
            ['id'=>8,  'nama_item'=>'Baju ganti',      'satuan'=>'set',           'jumlah'=>2, 'zona_saran'=>'cukup_penting'],
            ['id'=>9,  'nama_item'=>'Selimut darurat', 'satuan'=>'buah',          'jumlah'=>1, 'zona_saran'=>'cukup_penting'],
            ['id'=>10, 'nama_item'=>'Tali',            'satuan'=>'meter',         'jumlah'=>5, 'zona_saran'=>'cukup_penting'],
        ],
        'anak' => [
            ['id'=>11, 'nama_item'=>'Susu/Formula',  'satuan'=>'kotak', 'jumlah'=>3, 'zona_saran'=>'sangat_penting'],
            ['id'=>12, 'nama_item'=>'Obat Anak',     'satuan'=>'set',   'jumlah'=>1, 'zona_saran'=>'sangat_penting'],
            ['id'=>13, 'nama_item'=>'Popok',         'satuan'=>'buah',  'jumlah'=>5, 'zona_saran'=>'penting'],
            ['id'=>14, 'nama_item'=>'Mainan kecil',  'satuan'=>'buah',  'jumlah'=>1, 'zona_saran'=>'cukup_penting'],
        ],
        'remaja' => [],
        'dewasa' => [
            ['id'=>15, 'nama_item'=>'Dokumen Penting', 'satuan'=>'set',  'jumlah'=>1, 'zona_saran'=>'sangat_penting'],
            ['id'=>16, 'nama_item'=>'Uang Tunai',      'satuan'=>'set',  'jumlah'=>1, 'zona_saran'=>'sangat_penting'],
            ['id'=>17, 'nama_item'=>'Obat Pribadi',    'satuan'=>'set',  'jumlah'=>1, 'zona_saran'=>'sangat_penting'],
            ['id'=>18, 'nama_item'=>'Power Bank',      'satuan'=>'buah', 'jumlah'=>1, 'zona_saran'=>'penting'],
            ['id'=>19, 'nama_item'=>'Radio Portabel',  'satuan'=>'buah', 'jumlah'=>1, 'zona_saran'=>'penting'],
        ],
        'lansia' => [
            ['id'=>20, 'nama_item'=>'Obat Rutin',        'satuan'=>'set',  'jumlah'=>1, 'zona_saran'=>'sangat_penting'],
            ['id'=>21, 'nama_item'=>'Alat bantu',        'satuan'=>'buah', 'jumlah'=>1, 'zona_saran'=>'sangat_penting'],
            ['id'=>22, 'nama_item'=>'Kacamata cadangan', 'satuan'=>'buah', 'jumlah'=>1, 'zona_saran'=>'penting'],
        ],
    ];

    public function index(Request $request)
    {
        $sessionId = $request->session()->getId();

        $semuaTas = TasSiaga::where('session_id', $sessionId)
            ->withCount('items')
            ->latest()
            ->get();

        $activeTasId = $request->session()->get('active_tas_id');
        $activeTas   = $semuaTas->firstWhere('id', $activeTasId);

        if (!$activeTas && $semuaTas->isNotEmpty()) {
            $activeTas = $semuaTas->first();
            $request->session()->put('active_tas_id', $activeTas->id);
        }

        $rekomendasi = $activeTas
            ? array_merge($this->rekomendasi['semua'], $this->rekomendasi[$activeTas->kategori] ?? [])
            : $this->rekomendasi['semua'];

        return view('sebelum.index', compact('semuaTas', 'activeTas', 'rekomendasi'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'nama_tas' => 'required|string|max:100',
            'kategori' => 'required|in:anak,remaja,dewasa,lansia',
            'liter'    => 'required|numeric|min:1|max:500',
            'dim_p'    => 'nullable|numeric|min:1|max:200',
            'dim_l'    => 'nullable|numeric|min:1|max:200',
            'dim_t'    => 'nullable|numeric|min:1|max:200',
        ]);

        $tas = TasSiaga::create([
            'session_id' => $request->session()->getId(),
            ...$data,
        ]);

        $request->session()->put('active_tas_id', $tas->id);

        return response()->json(['success' => true, 'tas' => $tas]);
    }

    public function update(Request $request, TasSiaga $tas)
    {
        abort_if($tas->session_id !== $request->session()->getId(), 403);

        $data = $request->validate([
            'nama_tas' => 'sometimes|string|max:100',
            'kategori' => 'sometimes|in:anak,remaja,dewasa,lansia',
            'liter'    => 'sometimes|numeric|min:1|max:500',
            'dim_p'    => 'sometimes|nullable|numeric|min:1|max:200',
            'dim_l'    => 'sometimes|nullable|numeric|min:1|max:200',
            'dim_t'    => 'sometimes|nullable|numeric|min:1|max:200',
        ]);

        $tas->update($data);

        return response()->json(['success' => true, 'tas' => $tas->fresh()]);
    }

    public function setActive(Request $request, TasSiaga $tas)
    {
        abort_if($tas->session_id !== $request->session()->getId(), 403);
        $request->session()->put('active_tas_id', $tas->id);
        return response()->json(['success' => true, 'tas' => $tas]);
    }

    public function destroy(Request $request, TasSiaga $tas)
    {
        abort_if($tas->session_id !== $request->session()->getId(), 403);
        $tas->delete();

        if ($request->session()->get('active_tas_id') === $tas->id) {
            $remaining = TasSiaga::where('session_id', $request->session()->getId())->first();
            $request->session()->put('active_tas_id', $remaining?->id);
        }

        return response()->json(['success' => true]);
    }

    public function getItems(Request $request, TasSiaga $tas)
    {
        abort_if($tas->session_id !== $request->session()->getId(), 403);
        return response()->json($tas->items()->get());
    }

    public function rekomendasi(string $kategori)
    {
        $items = array_merge(
            $this->rekomendasi['semua'],
            $this->rekomendasi[$kategori] ?? []
        );
        return response()->json($items);
    }

    // ─── FITUR BARU: PWA HYBRID OFFLINE-TO-ONLINE SYNC ────────────────

    /**
     * Mengambil semua data tas beserta itemnya untuk di-load ke Alpine.js
     */
    public function getData(Request $request)
    {
        $sessionId = $request->session()->getId();
        
        $semuaTas = TasSiaga::with('items')
            ->where('session_id', $sessionId)
            ->latest()
            ->get();

        return response()->json(['semuaTas' => $semuaTas]);
    }

    /**
     * Menyinkronkan data snapshot lokal dari LocalStorage browser ke dalam database MySQL
     */
    public function syncData(Request $request)
    {
        $semuaTasData = $request->input('semuaTas', []);
        $sessionId = $request->session()->getId();

        DB::transaction(function () use ($semuaTasData, $sessionId) {
            // 1. Ekstrak semua ID tas asli dari payload data frontend (baikan data lokal ber-ID string/milidetik disaring)
            $incomingIds = collect($semuaTasData)->pluck('id')->filter(function($id) {
                return is_numeric($id) && $id < 2000000000; // Pisahkan ID database dengan timestamp Date.now() lokal
            })->toArray();

            // 2. Bersihkan tas di database yang sudah dihapus oleh user saat offline
            TasSiaga::where('session_id', $sessionId)
                ->whereNotIn('id', $incomingIds)
                ->delete();

            foreach ($semuaTasData as $tasData) {
                // Periksa apakah ID buatan lokal atau warisan dari database
                $isLocalId = (!isset($tasData['id']) || $tasData['id'] >= 2000000000);

                // 3. Simpan atau perbarui entitas Tas Siaga
                $tas = TasSiaga::updateOrCreate(
                    [
                        'id' => $isLocalId ? null : $tasData['id'], 
                        'session_id' => $sessionId
                    ],
                    [
                        'nama_tas' => $tasData['nama_tas'],
                        'kategori' => $tasData['kategori'],
                        'liter'    => $tasData['liter'],
                        'dim_p'    => $tasData['dim_p'] ?? null,
                        'dim_l'    => $tasData['dim_l'] ?? null,
                        'dim_t'    => $tasData['dim_t'] ?? null,
                    ]
                );

                // 4. Reset item di dalam tas ini lalu tulis ulang isi snapshot terbarunya
                $tas->items()->delete();
                if (!empty($tasData['items'])) {
                    foreach ($tasData['items'] as $item) {
                        $tas->items()->create([
                            'nama_item' => $item['nama_item'],
                            'zona'      => $item['zona'],
                            'jumlah'    => $item['jumlah'] ?? 1,
                            'satuan'    => $item['satuan'] ?? 'pcs',
                        ]);
                    }
                }
            }
        });

        return response()->json(['success' => true, 'message' => 'Sinkronisasi berhasil!']);
    }
}