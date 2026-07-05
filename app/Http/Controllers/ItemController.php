<?php

namespace App\Http\Controllers;

use App\Models\Item;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class ItemController extends Controller
{
    // Menampilkan daftar barang
    public function index(Request $request)
{
    $items = Item::all();

    $currency = $request->get('currency', 'IDR');

    $rate = 1;

    if ($currency != 'IDR') {

        $response = Http::get(
            'https://api.frankfurter.dev/v1/latest',
            [
                'base' => 'IDR',
                'symbols' => $currency
            ]
        );

        if ($response->successful()) {
            $rate = $response->json()['rates'][$currency];
        }
    }

    return view('admin.barang.barang', compact(
        'items',
        'currency',
        'rate'
    ));
}

    // Menyimpan barang baru
    public function store(Request $request)
    {
        // 1. Validasi input
        $request->validate([
            'nama_barang' => 'required|string|max:255',
            'kategori'    => 'required|in:Elektronik,Fashion,Meubel,ATK,Aksesoris,Makeup',
            'harga'       => 'required|numeric|min:0',
            'stok'        => 'required|integer|min:0',
        ]);

        // 2. Logika kode otomatis (BRG001, BRG002, dst)
        // Diurutkan berdasarkan 'id' secara menurun untuk memastikan mengambil data terakhir yang di-insert
        $lastItem = Item::orderBy('id', 'desc')->first();

        // Ambil 3 karakter pertama (BRG) lalu sisanya diubah ke integer, tambah 1
        $nextId = $lastItem ? (int) substr($lastItem->kode_barang, 3) + 1 : 1;
        $kodeOtomatis = 'BRG' . str_pad($nextId, 3, '0', STR_PAD_LEFT);

        // 3. Simpan ke Database
        Item::create([
            'kode_barang' => $kodeOtomatis,
            'nama_barang' => $request->nama_barang,
            'kategori'    => $request->kategori,
            'harga'       => $request->harga,
            'stok'        => $request->stok,
        ]);

        // 4. Redirect agar data langsung muncul di daftar
        return redirect()->route('barang.index')->with('success', 'Barang berhasil ditambahkan!');
    }

    public function edit($id)
{
    $item = Item::findOrFail($id);

    return view('admin.barang.edit', compact('item'));
}

    public function update(Request $request, $id)
{
    $request->validate([
        'nama_barang' => 'required|string|max:255',
        'kategori'    => 'required|in:Elektronik,Fashion,Meubel,ATK,Aksesoris,Makeup',
        'harga'       => 'required|numeric|min:0',
        'stok'        => 'required|integer|min:0',
    ]);

    $item = Item::findOrFail($id);

    $item->update([
        'nama_barang' => $request->nama_barang,
        'kategori'    => $request->kategori,
        'harga'       => $request->harga,
        'stok'        => $request->stok,
    ]);

    return redirect()->route('barang.index')
        ->with('success', 'Barang berhasil diperbarui!');
}

    // Menghapus barang
    public function destroy($id)
    {
        $item = Item::findOrFail($id);
        $item->delete();

        return redirect()->route('barang.index')->with('success', 'Barang berhasil dihapus!');
    }
}
