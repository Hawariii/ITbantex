<x-app-layout>
    <div class="max-w-4xl mx-auto py-10 px-6">

        <!-- Title -->
        <h1 class="text-2xl font-bold mb-6">
            Stock Transaction Detail
        </h1>

        <!-- Transaction Card -->
        <div class="bg-white shadow rounded-lg p-6">

            <p class="mb-3">
                <strong>Item:</strong>
                {{ $transaction->item->nama_barang ?? '-' }}
            </p>

            <p class="mb-3">
                <strong>Quantity:</strong>
                {{ $transaction->quantity }}
            </p>

            <p class="mb-3">
                <strong>Type:</strong>
                <span class="uppercase">{{ $transaction->type }}</span>
            </p>

            <p class="mb-3">
                <strong>Status:</strong>
                <span class="px-2 py-1 rounded bg-yellow-100 text-yellow-700 text-sm">
                    {{ $transaction->status }}
                </span>
            </p>

            <p class="mb-3">
                <strong>Created At:</strong>
                {{ $transaction->created_at->format('d M Y H:i') }}
            </p>

            <!-- Action Buttons -->
            <div class="mt-6 flex gap-3">

                <!-- Back -->
                <a href="{{ route('admin.stock.index') }}"
                   class="px-4 py-2 bg-gray-500 text-white rounded">
                    Back
                </a>

                <!-- Confirm -->
                @if($transaction->status === 'pending')
                    <form method="POST"
                          action="{{ route('admin.stock.confirm', $transaction->id) }}">
                        @csrf
                        <button type="submit"
                            class="px-4 py-2 bg-green-600 text-white rounded">
                            Confirm Transaction
                        </button>
                    </form>
                @endif

            </div>

        </div>

    </div>
</x-app-layout>