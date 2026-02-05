<x-app-layout>
    <div class="max-w-4xl mx-auto py-10 px-6">

        <!-- Title -->
        <h1 class="text-2xl font-bold mb-6 text-gray-800">
            Stock Transaction Detail
        </h1>

        <!-- Card -->
        <div class="bg-white shadow rounded-xl p-6 space-y-4">

            <div class="flex justify-between border-b pb-3">
                <span class="font-semibold text-gray-600">Item Code:</span>
                <span class="text-gray-800">{{ $transaction->item_code }}</span>
            </div>

            <div class="flex justify-between border-b pb-3">
                <span class="font-semibold text-gray-600">Quantity:</span>
                <span class="text-gray-800">{{ $transaction->quantity }}</span>
            </div>

            <div class="flex justify-between border-b pb-3">
                <span class="font-semibold text-gray-600">Status:</span>

                @if($transaction->status == 'pending')
                    <span class="px-3 py-1 rounded-full bg-yellow-100 text-yellow-700 text-sm">
                        Pending
                    </span>
                @elseif($transaction->status == 'approved')
                    <span class="px-3 py-1 rounded-full bg-green-100 text-green-700 text-sm">
                        Approved
                    </span>
                @else
                    <span class="px-3 py-1 rounded-full bg-red-100 text-red-700 text-sm">
                        Rejected
                    </span>
                @endif
            </div>

            <div class="flex justify-between">
                <span class="font-semibold text-gray-600">Requested At:</span>
                <span class="text-gray-800">{{ $transaction->created_at }}</span>
            </div>

        </div>

        <!-- Action Buttons -->
        @if($transaction->status == 'pending')
            <div class="flex gap-4 mt-6">

                <!-- Approve -->
                <form method="POST"
                      action="{{ route('admin.stock-transactions.confirm', $transaction->id) }}">
                    @csrf
                    <button
                        type="submit"
                        class="px-5 py-2 rounded-lg bg-green-600 text-white hover:bg-green-700 transition"
                    >
                        Approve
                    </button>
                </form>

                <!-- Reject -->
                <form method="POST"
                      action="{{ route('admin.stock-transactions.reject', $transaction->id) }}">
                    @csrf
                    <button
                        type="submit"
                        class="px-5 py-2 rounded-lg bg-red-600 text-white hover:bg-red-700 transition"
                    >
                        Reject
                    </button>
                </form>

            </div>
        @else
            <p class="mt-6 text-gray-600 italic">
                Transaction already processed.
            </p>
        @endif

        <!-- Back -->
        <div class="mt-8">
            <a href="{{ route