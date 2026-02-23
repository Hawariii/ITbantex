<x-app-layout>

<div class="max-w-5xl mx-auto py-10 px-6 space-y-8">

    <!-- PAGE HEADER -->
    <div class="bg-white border border-gray-200 shadow-sm rounded-xl p-6">
        <h1 class="text-2xl font-bold text-gray-800">
            Stock Transaction Detail
        </h1>
        <p class="text-sm text-gray-500 mt-1">
            Detail lengkap transaksi stok
        </p>
    </div>


    <!-- DETAIL CARD -->
    <div class="bg-white border border-gray-200 shadow-sm rounded-xl p-8">

        <div class="grid grid-cols-1 md:grid-cols-2 gap-8 text-sm">

            <div>
                <p class="text-gray-500 text-xs uppercase tracking-wide mb-1">
                    Item
                </p>
                <p class="font-semibold text-gray-800">
                    {{ $transaction->item->nama_barang ?? '-' }}
                </p>
            </div>

            <div>
                <p class="text-gray-500 text-xs uppercase tracking-wide mb-1">
                    Quantity
                </p>
                <p class="font-semibold text-gray-800">
                    {{ $transaction->quantity }}
                </p>
            </div>

            <div>
                <p class="text-gray-500 text-xs uppercase tracking-wide mb-1">
                    Type
                </p>
                <p class="uppercase text-gray-600 font-medium text-xs tracking-wide">
                    {{ $transaction->type }}
                </p>
            </div>

            <div>
                <p class="text-gray-500 text-xs uppercase tracking-wide mb-1">
                    Status
                </p>

                <span class="px-3 py-1 rounded-full bg-yellow-100 text-yellow-700 text-xs font-medium">
                    {{ ucfirst($transaction->status) }}
                </span>
            </div>

            <div class="md:col-span-2">
                <p class="text-gray-500 text-xs uppercase tracking-wide mb-1">
                    Created At
                </p>
                <p class="text-gray-700">
                    {{ $transaction->created_at->format('d M Y H:i') }}
                </p>
            </div>

        </div>


        <!-- ACTION BUTTONS -->
        <div class="mt-10 pt-6 border-t border-gray-200 flex flex-wrap gap-3">

            <!-- Back -->
            <a href="{{ route('admin.stock.index') }}"
               class="px-4 py-2 border border-gray-300 rounded-lg text-sm hover:bg-gray-100 transition">
                Back
            </a>

            <!-- Confirm -->
            @if($transaction->status === 'pending')
                <form method="POST"
                      action="{{ route('admin.stock.confirm', $transaction->id) }}">
                    @csrf
                    <button type="submit"
                        class="px-4 py-2 bg-green-600 text-white rounded-lg text-sm hover:bg-green-700 transition">
                        Confirm Transaction
                    </button>
                </form>
            @endif

        </div>

    </div>

</div>

</x-app-layout>