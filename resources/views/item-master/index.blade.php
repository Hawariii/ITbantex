<x-app-layout>
<div class="max-w-7xl mx-auto py-8 space-y-6">

    <div class="flex justify-between items-center">
        <h1 class="text-2xl font-bold">Item Master</h1>

        <form action="{{ route('item-master.sync') }}" method="POST">
            @csrf
            <button class="px-4 py-2 bg-blue-600 text-white rounded">
                Sync dari Excel
            </button>
        </form>
    </div>

    @if(session('success'))
        <div class="p-3 bg-green-100 text-green-800 rounded">
            {{ session('success') }}
        </div>
    @endif

    <div class="overflow-x-auto bg-white shadow rounded">
        <table class="min-w-full text-sm">
            <thead class="bg-gray-100">
                <tr>
                    <th class="p-2">Asset</th>
                    <th class="p-2">Nama</th>
                    <th class="p-2">Type</th>
                    <th class="p-2">Merk</th>
                    <th class="p-2">Stock</th>
                    <th class="p-2">Min</th>
                    <th class="p-2">Max</th>
                </tr>
            </thead>
            <tbody>
                @foreach($items as $item)
                <tr class="border-t">
                    <td class="p-2">{{ $item->asset_no }}</td>
                    <td class="p-2">{{ $item->nama_barang }}</td>
                    <td class="p-2">{{ $item->type }}</td>
                    <td class="p-2">{{ $item->merk }}</td>
                    <td class="p-2 font-bold">{{ $item->stock }}</td>
                    <td class="p-2">{{ $item->stock_min }}</td>
                    <td class="p-2">{{ $item->stock_max }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
</x-app-layout>