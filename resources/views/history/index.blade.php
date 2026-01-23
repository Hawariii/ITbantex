<x-app-layout>
<div class="max-w-7xl mx-auto py-8 space-y-6">

    <!-- Header -->
    <div class="bg-white shadow rounded-2xl p-6">
        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
            <div>
                <h1 class="text-2xl font-semibold text-gray-800">
                    History Export
                </h1>
                <p class="text-gray-500 text-sm">
                    Monitoring permintaan barang berdasarkan Document No
                </p>
            </div>
        </div>
    </div>

    <!-- Summary -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
        <div class="bg-white shadow rounded-2xl px-5">
            <p class="text-xs text-gray-500">Total Export</p>
            <p class="text-2xl font-semibold text-gray-800">
                {{ $exports->count() }}
            </p>
        </div>

        <div class="bg-white shadow rounded-2xl px-5">
            <p class="text-xs text-gray-500">Total Item</p>
            <p class="text-2xl font-semibold text-gray-800">
                {{ $exports->sum('item_count') }}
            </p>
        </div>

        <div class="bg-white shadow rounded-2xl px-5">
            <p class="text-xs text-gray-500">Grand Total (All)</p>
            <p class="text-2xl font-semibold text-gray-800">
                {{ number_format($exports->sum('grand_total')) }}
            </p>
        </div>
    </div>

    <!-- Export Groups (per Doc No) -->
    <div class="space-y-4">
        @forelse($exports as $exp)
            <div class="bg-white shadow rounded-2xl p-6 hover:shadow-md transition">
                <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">

                    <!-- Left -->
                    <div class="space-y-1">
                        <p class="text-xs text-gray-500">Document No</p>
                        <h2 class="text-xl font-semibold text-gray-900">
                            {{ $exp->doc_no }}
                        </h2>

                        <div class="flex flex-wrap gap-3 text-sm text-gray-600 pt-1">
                            <span class="px-3 py-1 rounded-full bg-gray-100">
                                Lokasi: <span class="font-medium text-gray-800">{{ $exp->lokasi }}</span>
                            </span>

                            <span class="px-3 py-1 rounded-full bg-gray-100">
                                Item: <span class="font-medium text-gray-800">{{ $exp->item_count }}</span>
                            </span>

                            <span class="px-3 py-1 rounded-full bg-gray-100">
                                Total: <span class="font-medium text-gray-800">{{ number_format($exp->grand_total) }}</span>
                            </span>
                        </div>

                        <p class="text-xs text-gray-500 pt-2">
                            Exported: <span class="text-gray-700">{{ optional($exp->exported_at)->format('d/m/Y H:i') }}</span>
                        </p>
                    </div>

                    <!-- Right -->
                    <div class="flex gap-2 justify-end">
                        <a href="{{ route('history.show', $exp->id) }}"
                           class="px-4 py-2 border rounded-md text-gray-700 hover:bg-gray-100 transition">
                            Detail
                        </a>
                        <form method="POST" action="{{ route('history.destroy', $exp->id) }}"
                          onsubmit="return confirm('Yakin mau hapus history Doc No {{ $exp->doc_no }}?')">
                           @csrf
                            @method('DELETE')
                            <button type="submit"
                                class="px-4 py-2 rounded-lg bg-red-600 text-white text-sm hover:bg-red-700 transition">
                                Delete
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        @empty
            <div class="bg-white shadow rounded-2xl p-10 text-center text-gray-500">
                Belum ada history export.
            </div>
        @endforelse
    </div>

</div>
</x-app-layout>
