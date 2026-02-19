<x-app-layout>
    <div class="max-w-6xl mx-auto py-10 px-6">

        <!-- Title -->
        <h1 class="text-2xl font-bold mb-6">
            Pending Stock Transactions
        </h1>

        <!-- Success / Error Message -->
        @if(session('success'))
            <div class="mb-4 p-3 bg-green-100 text-green-800 rounded">
                {{ session('success') }}
            </div>
        @endif

        @if(session('error'))
            <div class="mb-4 p-3 bg-red-100 text-red-800 rounded">
                {{ session('error') }}
            </div>
        @endif

        <!-- Table -->
        <div class="bg-white shadow rounded-lg overflow-hidden">
            <table class="w-full border-collapse">
                <thead class="bg-gray-100 text-left">
                    <tr>
                        <th class="p-3">Item</th>
                        <th class="p-3">Qty</th>
                        <th class="p-3">Type</th>
                        <th class="p-3">Status</th>
                        <th class="p-3">Action</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse($transactions as $trx)
                        <tr class="border-t">
                            <td class="p-3">
                                {{ $trx->item->nama_barang ?? '-' }}
                            </td>

                            <td class="p-3">
                                {{ $trx->quantity }}
                            </td>

                            <td class="p-3 uppercase">
                                {{ $trx->type }}
                            </td>

                            <td class="p-3">
                                <span class="px-2 py-1 rounded bg-yellow-100 text-yellow-700 text-sm">
                                    {{ $trx->status }}
                                </span>
                            </td>

                            <td class="p-3 flex gap-2">

                                <!-- Detail -->
                                <a href="{{ route('admin.stock.show', $trx->id) }}"
                                   class="px-3 py-1 bg-blue-600 text-white rounded text-sm">
                                    View
                                </a>

                                <!-- Confirm -->
                                <form method="POST"
                                      action="{{ route('admin.stock.confirm', $trx->id) }}">
                                    @csrf
                                    <button type="submit"
                                        class="px-3 py-1 bg-green-600 text-white rounded text-sm">
                                        Confirm
                                    </button>
                                </form>

                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="p-6 text-center text-gray-500">
                                No pending stock transactions found.
                            </td>
                        </tr>
                    @endforelse
                </tbody>

            </table>
        </div>

    </div>
</x-app-layout>