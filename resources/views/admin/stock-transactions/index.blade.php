<x-app-layout>
    <div class="p-6">

        <h1 class="text-2xl font-bold mb-6">
            Stock Transactions (Admin)
        </h1>

        @if(session('success'))
            <div class="p-3 bg-green-100 text-green-700 rounded mb-4">
                {{ session('success') }}
            </div>
        @endif

        @if(session('error'))
            <div class="p-3 bg-red-100 text-red-700 rounded mb-4">
                {{ session('error') }}
            </div>
        @endif

        <table class="w-full border">

            <thead class="bg-gray-100">
                <tr>
                    <th class="p-2 border">Doc No</th>
                    <th class="p-2 border">Item</th>
                    <th class="p-2 border">Qty</th>
                    <th class="p-2 border">Status</th>
                    <th class="p-2 border">Action</th>
                </tr>
            </thead>

            <tbody>
                @foreach($transactions as $trx)

                    <tr>
                        <td class="p-2 border">{{ $trx->doc_no }}</td>
                        <td class="p-2 border">{{ $trx->item_name }}</td>
                        <td class="p-2 border">{{ $trx->qty }}</td>

                        <td class="p-2 border">
                            @if($trx->status === 'pending')
                                <span class="text-yellow-600 font-bold">
                                    Pending
                                </span>
                            @else
                                <span class="text-green-600 font-bold">
                                    Confirmed
                                </span>
                            @endif
                        </td>

                        <td class="p-2 border">
                            @if($trx->status === 'pending')
                                <form method="POST"
                                      action="{{ route('admin.stock.confirm', $trx->id) }}">
                                    @csrf
                                    <button class="px-4 py-2 bg-blue-600 text-white rounded">
                                        Confirm
                                    </button>
                                </form>
                            @else
                                ✅ Done
                            @endif
                        </td>
                    </tr>

                @endforeach
            </tbody>

        </table>

    </div>
</x-app-layout>