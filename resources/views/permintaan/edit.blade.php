<x-app-layout>
<div class="max-w-4xl mx-auto py-8">
<div class="bg-white p-6 rounded shadow">

<h2 class="text-lg font-semibold mb-4">Edit Barang</h2>

<form method="POST" action="{{ route('permintaan.update', $item->id) }}" class="space-y-3">
    @csrf
    @method('PUT')

    <input type="text" name="nama_barang" value="{{ $item->nama_barang }}">
    <input type="text" name="merk_type" value="{{ $item->merk_type }}">
    <input type="number" name="jumlah" value="{{ $item->jumlah }}">
    <input type="text" name="harga_satuan" value="{{ number_format($item->harga_satuan, 0, ',', '.') }}">
    <input type="text" name="supplier" value="{{ $item->supplier }}">
    <input type="date" name="arrival_date" value="{{ $item->arrival_date }}">
    <textarea name="keterangan">{{ $item->keterangan }}</textarea>

    <button class="px-4 py-2 bg-gray-800 text-white rounded">
        Update
    </button>
</form>

</div>
</div>
</x-app-layout>
