<x-app-layout>
<div class="max-w-5xl mx-auto py-10">

    {{-- HEADER --}}
    <div class="bg-white rounded-2xl shadow-sm border p-6 mb-8">
        <h1 class="text-2xl font-bold text-gray-800">
            Edit Permintaan Barang
        </h1>
        <p class="text-sm text-gray-500 mt-1">
            Perbarui data permintaan barang dengan benar
        </p>
    </div>

    {{-- FORM --}}
    <form method="POST"
          action="{{ route('permintaan.update', $item->id) }}"
          class="bg-white rounded-2xl shadow-sm border p-8 space-y-8">

        @csrf
        @method('PUT')

        {{-- GRID --}}
        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">

            {{-- Nama Barang --}}
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-2">
                    Nama Barang
                </label>
                <input type="text"
                       name="nama_barang"
                       value="{{ old('nama_barang', $item->nama_barang) }}"
                       class="w-full rounded-xl border-gray-300 focus:border-gray-800 focus:ring-2 focus:ring-gray-800/20 transition">
                @error('nama_barang')
                    <p class="text-sm text-red-500 mt-1">{{ $message }}</p>
                @enderror
            </div>

            {{-- Merk --}}
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-2">
                    Merk / Type
                </label>
                <input type="text"
                       name="merk_type"
                       value="{{ old('merk_type', $item->merk_type) }}"
                       class="w-full rounded-xl border-gray-300 focus:border-gray-800 focus:ring-2 focus:ring-gray-800/20 transition">
                @error('merk_type')
                    <p class="text-sm text-red-500 mt-1">{{ $message }}</p>
                @enderror
            </div>

            {{-- Jumlah --}}
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-2">
                    Jumlah
                </label>
                <input type="number"
                       id="jumlah"
                       name="jumlah"
                       value="{{ old('jumlah', $item->jumlah) }}"
                       class="w-full rounded-xl border-gray-300 focus:border-gray-800 focus:ring-2 focus:ring-gray-800/20 transition">
                @error('jumlah')
                    <p class="text-sm text-red-500 mt-1">{{ $message }}</p>
                @enderror
            </div>

            {{-- Harga --}}
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-2">
                    Harga Satuan
                </label>
                <input type="number"
                       id="harga"
                       name="harga_satuan"
                       value="{{ old('harga_satuan', $item->harga_satuan) }}"
                       class="w-full rounded-xl border-gray-300 focus:border-gray-800 focus:ring-2 focus:ring-gray-800/20 transition">
                @error('harga_satuan')
                    <p class="text-sm text-red-500 mt-1">{{ $message }}</p>
                @enderror
            </div>

            {{-- Supplier --}}
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-2">
                    Supplier
                </label>
                <input type="text"
                       name="supplier"
                       value="{{ old('supplier', $item->supplier) }}"
                       class="w-full rounded-xl border-gray-300 focus:border-gray-800 focus:ring-2 focus:ring-gray-800/20 transition">
                @error('supplier')
                    <p class="text-sm text-red-500 mt-1">{{ $message }}</p>
                @enderror
            </div>

            {{-- Arrival --}}
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-2">
                    Arrival Date
                </label>
                <input type="date"
                       name="arrival_date"
                       value="{{ old('arrival_date', $item->arrival_date) }}"
                       class="w-full rounded-xl border-gray-300 focus:border-gray-800 focus:ring-2 focus:ring-gray-800/20 transition">
                @error('arrival_date')
                    <p class="text-sm text-red-500 mt-1">{{ $message }}</p>
                @enderror
            </div>

        </div>

        {{-- TOTAL PREVIEW --}}
        <div class="bg-gray-50 rounded-xl p-6 border flex justify-between items-center">
            <span class="text-gray-600 font-medium">
                Estimasi Total
            </span>
            <span id="totalPreview"
                  class="text-xl font-bold text-gray-800">
                Rp {{ number_format($item->jumlah * $item->harga_satuan) }}
            </span>
        </div>

        {{-- ACTION --}}
        <div class="flex justify-end gap-4 pt-6 border-t">

            <a href="{{ route('permintaan.manage') }}"
               class="px-5 py-2 rounded-xl border text-gray-600 hover:bg-gray-100 transition">
                Batal
            </a>

            <button type="submit"
                    class="px-6 py-2 rounded-xl bg-gray-900 text-white hover:bg-gray-800 transition shadow-sm">
                Update Data
            </button>

        </div>

    </form>

</div>

{{-- SCRIPT LIVE TOTAL --}}
<script>
const jumlah = document.getElementById('jumlah');
const harga  = document.getElementById('harga');
const totalPreview = document.getElementById('totalPreview');

function updateTotal() {
    const j = parseFloat(jumlah.value) || 0;
    const h = parseFloat(harga.value) || 0;
    const total = j * h;

    totalPreview.innerText =
        'Rp ' + total.toLocaleString('id-ID');
}

jumlah.addEventListener('input', updateTotal);
harga.addEventListener('input', updateTotal);
</script>

</x-app-layout>