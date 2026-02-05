<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Detail Stock Request
        </h2>
    </x-slot>

    <div class="py-10 max-w-4xl mx-auto sm:px-6 lg:px-8">

        <div class="bg-white shadow rounded-lg p-6">

            <h3 class="text-lg font-bold mb-4">
                Request Barang
            </h3>

            <div class="space-y-2 text-gray-700">
                <p><b>Item:</b> {{ $transaction->item_name }}</p>
                <p><b>Quantity:</b> {{ $transaction->quantity }}</p>
                <p><b>User:</b> {{ $transaction->user_name }}</p>
                <p><b>Status:</b>
                    @if($transaction->status === 'pending')
                        <span class="text-red-600 font-semibold">Pending</span>
                    @else
                        <span class="text-green-600 font-semibold">Confirmed</span>
                    @endif
                </p>
            </div>

            {{-- Confirm Button --}}
            @if($transaction->status === 'pending')
                <form action="{{ route('admin.stock.confirm', $transaction->id) }}"
                      method="POST"
                      class="mt-6">
                    @csrf

                    <button type="submit"
                        class="px-5 py-2 bg-green-600 text-white rounded hover:bg-green-700">
                        ✅ Confirm Barang Datang
                    </button>
                </form>
            @else
                <p class="mt-6 text-green-700 font-semibold">
                    Barang sudah dikonfirmasi datang.
                </p>
            @endif

            <a href="{{ route('admin.stock.index') }}"
               class="block mt-6 text-blue-600 hover:underline">
                ← Back to Transactions
            </a>

        </div>

    </div>
</x-app-layout>