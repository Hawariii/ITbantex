<x-app-layout>
    <div class="p-6">

        <h1 class="text-2xl font-bold mb-6">
            Admin Dashboard
        </h1>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

            <a href="{{ route('admin.stock.index') }}"
               class="p-6 bg-white rounded-xl shadow hover:bg-gray-50">
                <h2 class="font-semibold text-lg">
                    Stock Transactions
                </h2>
                <p class="text-gray-500 text-sm">
                    Confirm user stock-out requests
                </p>
            </a>

            <a href="{{ route('admin.item-master.index') }}"
               class="p-6 bg-white rounded-xl shadow hover:bg-gray-50">
                <h2 class="font-semibold text-lg">
                    Item Master
                </h2>
                <p class="text-gray-500 text-sm">
                    Manage item stock data
                </p>
            </a>

        </div>

    </div>
</x-app-layout>