<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Stock Transaction Requests
        </h2>
    </x-slot>

    <div class="py-10 max-w-7xl mx-auto sm:px-6 lg:px-8">

        @if(session('success'))
            <div class="bg-green-100 text-green-700 p-3 rounded mb-4">
                {{ session('success') }}
            </div>
        @endif

        <div class="bg-white shadow rounded-lg overflow-hidden">
            <table class="w-full text-sm text-left">
                <thead class="bg-gray-100 text-gray-600 uppercase text-xs">
                    <tr>
                        <th class="p-3">Item</th>
                        <th class="p-3">Qty</th>
                        <th class="p-3">User</th>
                        <th class="p-3">Status</th>
                        <th class="p-3">Action</th>
                    </tr>
                </thead>

                <tbody>
                    @foreach($transactions as $trx)
                        <tr class="border-b">
                            <td class="p-3">{{ $trx->item_name }}</td>
                            <td class="p-3">{{ $trx->quantity }}</td>
                            <td class="p-3">{{ $trx->user_name }}</td>

                            <td class="p-3">
                                @if($trx->status === 'pending')
                                    <span class="text-red-600 font-semibold">Pending</span>
                                @else
                                    <span class="text-green-600 font-semibold">Confirmed</span>
                                @endif
                            </td>

                            <td class="p-3">
                                <a href="{{ route('admin.stock.show', $trx->id) }}"
                                   class="text-blue-600 hover:underline">
                                    Detail
                                </a>
                            </td>
                        </tr>
                    @endforeach

                    @if($transactions->count() == 0)
                        <tr>
                            <td colspan="5" class="p-4 text-center text-gray-500">
                                Tidak ada request stock
                            </td>
                        </tr>
                    @endif
                </tbody>

            </table>
        </div>
    </div>
</x-app-layout>