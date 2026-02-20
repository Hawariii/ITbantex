<x-app-layout>

<div class="min-h-screen bg-gray-100 py-10">
    <div class="max-w-6xl mx-auto px-6">

        {{-- ALERT --}}
        @if(session('success'))
            <div class="mb-6 p-4 rounded-lg bg-green-100 text-green-700 border border-green-300">
                {{ session('success') }}
            </div>
        @endif

        @if(session('error'))
            <div class="mb-6 p-4 rounded-lg bg-red-100 text-red-700 border border-red-300">
                {{ session('error') }}
            </div>
        @endif


        <div class="bg-white shadow-xl rounded-2xl p-8 space-y-8">

            <!-- HEADER -->
            <div class="flex flex-col md:flex-row md:justify-between md:items-center gap-4 border-b pb-6">
                <div>
                    <h1 class="text-3xl font-bold text-gray-800">
                        Permintaan Barang
                    </h1>
                    <p class="text-sm text-gray-500">
                        Nomor dokumen dibuat otomatis oleh sistem
                    </p>
                </div>

                <div class="text-left md:text-right">
                    <p class="text-xs text-gray-400 uppercase">Doc No</p>
                    <p class="text-2xl font-bold text-sky-400 tracking-widest">
                        {{ $docNo }}
                    </p>
                </div>
            </div>


            <!-- FORM -->
            <form method="POST" action="{{ route('permintaan.store') }}" class="space-y-10">
                @csrf

                <!-- Informasi Umum -->
                <div>
                    <h2 class="text-lg font-semibold text-gray-800 mb-4">
                        Informasi Umum
                    </h2>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <input type="text"
                            name="supplier"
                            placeholder="Supplier"
                            required
                            class="w-full border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-indigo-500">

                        <input type="date"
                            name="arrival_date"
                            required
                            class="w-full border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-indigo-500">
                    </div>
                </div>


                <!-- DETAIL BARANG -->
                <div>
                    <div class="flex justify-between items-center mb-4">
                        <h2 class="text-lg font-semibold text-gray-800">
                            Detail Barang
                        </h2>

                        <button type="button"
                            onclick="addItem()"
                            class="px-4 py-2 bg-sky-400 text-white rounded-lg text-sm hover:bg-sky-600 transition">
                            + Tambah Barang
                        </button>
                    </div>

                    <div id="items" class="space-y-4">

                        <!-- ROW -->
                        <div class="item grid grid-cols-1 md:grid-cols-12 gap-3 bg-gray-50 p-4 rounded-xl border relative">

                            <!-- Nama Barang -->
                            <div class="md:col-span-3 relative">
                                <input type="text"
                                    name="nama_barang[]"
                                    placeholder="Nama Barang"
                                    autocomplete="off"
                                    onkeyup="filterItems(this)"
                                    class="w-full border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-indigo-500">

                                <div class="suggestions absolute z-50 bg-white border w-full rounded-lg shadow mt-1 hidden max-h-40 overflow-y-auto"></div>
                            </div>

                            <div class="md:col-span-3">
                                <input type="text"
                                    name="merk_type[]"
                                    placeholder="Merk / Type"
                                    class="w-full border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-indigo-500">
                            </div>

                            <div class="md:col-span-2">
                                <input type="number"
                                    name="jumlah[]"
                                    placeholder="Jumlah"
                                    class="w-full border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-indigo-500">
                            </div>

                            <div class="md:col-span-3">
                                <input type="number"
                                    name="harga_satuan[]"
                                    placeholder="Harga Satuan"
                                    class="w-full border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-indigo-500">
                            </div>

                            <div class="md:col-span-1 flex items-center justify-center">
                                <button type="button"
                                    onclick="removeItem(this)"
                                    class="text-red-500 hover:text-red-700 text-xl font-bold">
                                    ×
                                </button>
                            </div>

                        </div>

                    </div>
                </div>


                <!-- SUBMIT -->
                <div class="flex justify-end pt-6 border-t">
                    <button type="submit"
                        class="px-6 py-3 bg-gray-900 text-white rounded-xl hover:bg-black transition">
                        Simpan Permintaan
                    </button>
                </div>

            </form>

        </div>
    </div>
</div>


<!-- SCRIPT -->
<script>

const itemList = @json($items->pluck('nama_barang'));

function addItem() {
    const items = document.getElementById('items');
    const firstItem = items.children[0];
    const clone = firstItem.cloneNode(true);

    clone.querySelectorAll('input').forEach(input => input.value = '');
    clone.querySelector('.suggestions').innerHTML = '';
    clone.querySelector('.suggestions').classList.add('hidden');

    items.appendChild(clone);
}

function removeItem(button) {
    const items = document.getElementById('items');
    if (items.children.length > 1) {
        button.closest('.item').remove();
    }
}

function filterItems(input) {
    const container = input.parentElement.querySelector('.suggestions');
    const value = input.value.toLowerCase();

    container.innerHTML = '';

    if (!value) {
        container.classList.add('hidden');
        return;
    }

    const filtered = itemList.filter(item =>
        item.toLowerCase().includes(value)
    );

    if (filtered.length === 0) {
        container.classList.add('hidden');
        return;
    }

    filtered.forEach(item => {
        const div = document.createElement('div');
        div.textContent = item;
        div.className = "px-3 py-2 hover:bg-indigo-100 cursor-pointer text-sm";

        div.onclick = () => {
            input.value = item;
            container.classList.add('hidden');
        };

        container.appendChild(div);
    });

    container.classList.remove('hidden');
}

</script>

</x-app-layout>