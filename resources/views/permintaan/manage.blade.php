<x-app-layout>
<div class="max-w-7xl mx-auto py-8 space-y-6">

    <!-- Header -->
    <div class="bg-white shadow rounded-lg p-6">
        <h1 class="text-2xl font-semibold text-gray-800">
            Manage Permintaan Barang
        </h1>
        <p class="text-gray-500 text-sm">
            Kelola, hapus, dan cetak permintaan barang
        </p>
    </div>

    <!-- FORM PRINT -->
    <form id="exportForm" method="POST" action="{{ route('permintaan.exportExcel') }}">
    @csrf

        <div class="bg-white shadow rounded-lg p-6">
            <div class="flex justify-between items-center mb-4">
                <h2 class="text-lg font-semibold text-gray-800">
                    Permintaan Barang
                </h2>

                <button type="button"
                onclick="openExportModal()"
                class="px-4 py-2 border rounded-md text-gray-700 hover:bg-gray-100 transition">
                Export to Excel
                </button>

            </div>

            <div class="overflow-x-auto">
                <table class="min-w-full border border-gray-200 text-sm">
                    <thead class="bg-gray-100 text-gray-700">
                        <tr>
                            <th class="border px-3 py-2 text-center">
                                <input type="checkbox" id="checkAll">
                            </th>
                            <th class="border px-3 py-2">Nama</th>
                            <th class="border px-3 py-2">Merk</th>
                            <th class="border px-3 py-2">Jumlah</th>
                            <th class="border px-3 py-2">Harga</th>
                            <th class="border px-3 py-2">Total</th>
                            <th class="border px-3 py-2">Supplier</th>
                            <th class="border px-3 py-2">Arrival</th>
                            <th class="border px-3 py-2">Aksi</th>
                        </tr>
                    </thead>

                    <tbody>
                    @forelse ($data as $row)
                        <tr class="hover:bg-gray-50">
                            <td class="border px-3 py-2 text-center">
                                <input type="checkbox" name="ids[]" value="{{ $row->id }}">
                            </td>

                            <td class="border px-3 py-2">{{ $row->nama_barang }}</td>
                            <td class="border px-3 py-2">{{ $row->merk_type }}</td>
                            <td class="border px-3 py-2 text-center">{{ $row->jumlah }}</td>
                            <td class="border px-3 py-2">{{ number_format($row->harga_satuan) }}</td>
                            <td class="border px-3 py-2 font-semibold">{{ number_format($row->total) }}</td>
                            <td class="border px-3 py-2">{{ $row->supplier }}</td>
                            <td class="border px-3 py-2">{{ $row->arrival_date }}</td>

                            <td class="border px-3 py-2">
                                <div class="flex gap-2">
                                    <a href="{{ route('permintaan.edit', $row->id) }}"
                                       class="px-2 py-1 bg-gray-800 text-white rounded-md hover:bg-gray-700">
                                        Edit
                                    </a>

                                    <button type="button"
                                            onclick="deleteItem({{ $row->id }})"
                                            class="px-2 py-1 bg-red-600 text-white rounded-md hover:bg-red-700">
                                        Delete
                                    </button>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="9" class="text-center py-4 text-gray-500">
                                Belum ada permintaan
                            </td>
                        </tr>
                    @endforelse
                    </tbody>
                </table>
            </div>
            <!-- EXPORT MODAL -->
<div id="exportModal"
     class="fixed inset-0 bg-black/40 hidden items-center justify-center z-50">

    <div class="bg-white w-full max-w-sm rounded-lg shadow-lg p-6">
        <h3 class="text-lg font-semibold text-gray-800 mb-2">
            Export Excel
        </h3>
        <p class="text-sm text-gray-500 mb-4">
            Masukkan Document Number
        </p>

        <div class="space-y-4">
            <input type="text"
                   name="doc_no"
                   form="exportForm"
                   required
                   placeholder="Contoh: NO/Bulan/Tahun = 130126"
                   class="w-full border rounded-md px-3 py-2 text-sm focus:ring focus:ring-gray-200">

            <div class="flex justify-end gap-2">
                <button type="button"
                        onclick="closeExportModal()"
                        class="px-4 py-2 text-sm rounded-md border">
                    Batal
                </button>

                <button type="submit"
                        form="exportForm"
                        class="px-4 py-2 text-sm bg-gray-800 text-white rounded-md hover:bg-gray-700">
                    Export
                </button>
            </div>
        </div>
    </div>
</div>
        </div>
    </form>

    <!-- FORM DELETE (DI LUAR FORM PRINT) -->
    @foreach ($data as $row)
        <form id="delete-{{ $row->id }}"
              action="{{ route('permintaan.destroy', $row->id) }}"
              method="POST" class="hidden">
            @csrf
            @method('DELETE')
        </form>
    @endforeach

</div>

<script>
function deleteItem(id) {
    if (confirm('Hapus item ini?')) {
        document.getElementById('delete-' + id).submit();
    }
}

document.getElementById('checkAll')?.addEventListener('change', function () {
    document.querySelectorAll('input[name="ids[]"]').forEach(cb => {
        cb.checked = this.checked;
    });
});

   function openExportModal() {
    const checked = document.querySelectorAll('input[name="ids[]"]:checked');
    if (checked.length === 0) {
        alert('Pilih minimal 1 data untuk di-export');
        return;
    }

    document.getElementById('exportModal').classList.remove('hidden');
    document.getElementById('exportModal').classList.add('flex');
}

function closeExportModal() {
    document.getElementById('exportModal').classList.add('hidden');
    document.getElementById('exportModal').classList.remove('flex');
}
</script>
</x-app-layout>
