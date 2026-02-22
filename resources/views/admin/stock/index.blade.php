<x-app-layout>

<div class="max-w-7xl mx-auto py-10 px-6 space-y-8">

    <!-- PAGE HEADER -->
    <div class="bg-white border border-gray-200 shadow-sm rounded-xl p-6">
        <h1 class="text-2xl font-bold text-gray-800">
            Pending Stock Transactions
        </h1>
        <p class="text-sm text-gray-500 mt-1">
            Daftar transaksi stok yang menunggu konfirmasi
        </p>
    </div>


    <!-- ALERT -->
    @if(session('success'))
        <div class="p-4 rounded-xl bg-green-50 text-green-700 border border-green-200">
            {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div class="p-4 rounded-xl bg-red-50 text-red-700 border border-red-200">
            {{ session('error') }}
        </div>
    @endif


    <!-- TABLE CONTAINER -->
    <div class="bg-white border border-gray-200 shadow-sm rounded-xl overflow-hidden">

        <div class="overflow-x-auto">
            <table class="min-w-full text-sm text-gray-700">

                <thead class="bg-gray-50 text-gray-500 uppercase text-xs tracking-wider">
                    <tr>
                        <th class="px-6 py-4 text-left">Item</th>
                        <th class="px-6 py-4 text-left">Qty</th>
                        <th class="px-6 py-4 text-left">Type</th>
                        <th class="px-6 py-4 text-left">Status</th>
                        <th class="px-6 py-4 text-right">Action</th>
                    </tr>
                </thead>

                <tbody class="divide-y divide-gray-100">

                    @forelse($transactions as $trx)
                        <tr class="hover:bg-gray-50 transition">

                            <td class="px-6 py-4 font-medium text-gray-800">
                                {{ $trx->item->nama_barang ?? '-' }}
                            </td>

                            <td class="px-6 py-4">
                                {{ $trx->quantity }}
                            </td>

                            <td class="px-6 py-4 uppercase text-xs tracking-wide text-gray-500">
                                {{ $trx->type }}
                            </td>

                            <td class="px-6 py-4">
                                <span class="px-3 py-1 rounded-full bg-yellow-100 text-yellow-700 text-xs font-medium">
                                    {{ ucfirst($trx->status) }}
                                </span>
                            </td>

                            <td class="px-6 py-4 text-right">
                                <div class="flex justify-end gap-2">

                                    <!-- View -->
                                    <a href="{{ route('admin.stock.show', $trx->id) }}"
                                       class="px-3 py-1.5 border border-gray-300 rounded-lg text-sm hover:bg-gray-100 transition">
                                        View
                                    </a>

                                    <!-- Confirm -->
                                    <form method="POST"
                                          action="{{ route('admin.stock.confirm', $trx->id) }}">
                                        @csrf
                                        <button type="submit"
                                            class="px-3 py-1.5 bg-green-600 text-white rounded-lg text-sm hover:bg-green-700 transition">
                                            Confirm
                                        </button>
                                    </form>

                                </div>
                            </td>

                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-6 py-10 text-center text-gray-500">
                                No pending stock transactions found.
                            </td>
                        </tr>
                    @endforelse

                </tbody>

            </table>
        </div>

    </div>

</div>

</x-app-layout>