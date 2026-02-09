<x-app-layout>
    <div class="max-w-4xl mx-auto py-10">

        {{-- TITLE --}}
        <h1 class="text-2xl font-bold mb-6">
            Stock Transaction Detail
        </h1>

        {{-- CARD DETAIL --}}
        <div class="bg-white shadow rounded-lg p-6 space-y-4">

            <div>
                <p class="text-gray-600 text-sm">Item Code</p>
                <p class="font-semibold text-lg">
                    {{ $transaction->item_code }}
                </p>
            </div>

            <div>
                <p class="text-gray-600 text-sm">Quantity</p>
                <p class="font-semibold text-lg">
                    {{ $transaction->quantity }}
                </p>
            </div>

            <div>
                <p class="text-gray-600 text-sm">Status</p>

                @if($transaction->status === 'pending')
                    <span class="px-3 py-1 rounded bg-yellow-200 text-yellow-800 text-sm font-semibold">
                        Pending
                    </span>
                @elseif($transaction->status === 'approved')
                    <span class="px-3 py-1 rounded bg-green-200 text-green-800 text-sm font-semibold">
                        Approved
                    </span>
                @else
                    <span class="px-3 py-1 rounded bg-gray-200 text-gray-700 text-sm font-semibold">
                        {{ ucfirst($transaction->status) }}
                    </span>
                @endif
            </div>

            <div>
                <p class="text-gray-600 text-sm">Created At</p>
                <p class="font-semibold">
                    {{ $transaction->created_at->format('d M Y - H:i') }}
                </p>
            </div>

        </div>

        {{-- ACTION BUTTON --}}
        <div class="mt-6 flex gap-3">

            {{-- BACK BUTTON --}}
            <a href="{{ route('admin.stock.index') }}"
               class="px-4 py-2 rounded bg-gray-500 text-white hover:bg-gray-600">
                Back
            </a>

            {{-- CONFIRM BUTTON --}}
            @if($transaction->status === 'pending')
                <form action="{{ route('admin.stock.confirm', $transaction->id) }}" method="POST">
                    @csrf

                    <button type="submit"
                            class="px-4 py-2 rounded bg-blue-600 text-white hover:bg-blue-700">
                        Confirm Barang Datang
                    </button>
                </form>
            @endif

        </div>

    </div>
</x-app-layout>