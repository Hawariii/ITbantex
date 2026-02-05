<x-app-layout>
    <div class="max-w-6xl mx-auto py-10 px-6">

        <h1 class="text-2xl font-bold mb-6 text-gray-800">
            Stock Transactions (Admin)
        </h1>

        <div class="bg-white shadow rounded-xl overflow-hidden">

            <table class="w-full text-sm text-left">
                <thead class="bg-gray-100 text-gray-700">
                    <tr>
                        <th class="p-4">Item Code</th>
                        <th class="p-4">Quantity</th>
                        <th class="p-4">Status</th>
                        <th class="p-4">Action</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse($transactions as $trx)
                        <tr class="border-b hover:bg-gray-50">
                            <td class="p-4">{{ $trx->item_code }}</td>
                            <td class="p-4">{{ $trx->quantity }}</td>
                            <td class="p-4 capitalize">{{ $trx->status }}</td>

                            <td class="p-4">
                                <a href="{{ route('admin.stock-transactions.show', $trx->id) }}"
                                   class="text-blue-600 hover:underline">
                                    View Detail
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="p-6 text-center text-gray-500">
                                No stock transactions found.
                            </td>
                        </tr>
                    @endforelse
                </tbody>

            </table>

        </div>
    </div>
</x-app-layout>