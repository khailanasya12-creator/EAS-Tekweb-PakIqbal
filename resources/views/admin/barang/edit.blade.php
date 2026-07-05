<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Barang</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        body{
            background:#f4f6f9;
        }
        .card{
            max-width:700px;
            margin:60px auto;
            border:none;
            border-radius:12px;
            box-shadow:0 2px 10px rgba(0,0,0,.1);
        }
    </style>
</head>
<body>

<div class="card p-4">
    <h3 class="mb-4 fw-bold text-center">Edit Barang</h3>

    <form action="{{ route('barang.update', $item->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label class="form-label">Nama Barang</label>
            <input
                type="text"
                name="nama_barang"
                class="form-control"
                value="{{ $item->nama_barang }}"
                required>
        </div>

        <div class="mb-3">
            <label class="form-label">Kategori</label>

            <select name="kategori" class="form-select" required>
                <option value="Elektronik" {{ $item->kategori=='Elektronik'?'selected':'' }}>Elektronik</option>
                <option value="Fashion" {{ $item->kategori=='Fashion'?'selected':'' }}>Fashion</option>
                <option value="Meubel" {{ $item->kategori=='Meubel'?'selected':'' }}>Meubel</option>
                <option value="ATK" {{ $item->kategori=='ATK'?'selected':'' }}>ATK</option>
                <option value="Aksesoris" {{ $item->kategori=='Aksesoris'?'selected':'' }}>Aksesoris</option>
                <option value="Makeup" {{ $item->kategori=='Makeup'?'selected':'' }}>Makeup</option>
            </select>
        </div>

            <div class="mb-3">
            <label>Harga</label>
            <input type="number"
           name="harga"
           class="form-control"
           value="{{ $item->harga }}"
           required>
        </div>

        <div class="mb-4">
            <label class="form-label">Stok</label>
            <input
                type="number"
                name="stok"
                class="form-control"
                value="{{ $item->stok }}"
                required>
        </div>

        <div class="d-flex justify-content-end gap-2">
            <a href="{{ route('barang.index') }}" class="btn btn-secondary">
                Batal
            </a>

            <button type="submit" class="btn btn-primary">
                Simpan Perubahan
            </button>
        </div>

    </form>

</div>

</body>
</html>