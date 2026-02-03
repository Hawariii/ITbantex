<x-app-layout>
    
 {{-- TABLE --}}
<table class="w-full border">
    <thead>
        <tr class="bg-gray-200">
            <th>Item</th>
            <th>Qty</th>
            <th>Status</th>
            <th>Client</th>
            <th>Action</th>
        </tr>
    </thead>
    <tbody>
        @foreach($transactions as $trx)
        <tr>
            <td>{{ $trx->item->name }}</td>
            <td>{{ $trx->qty }}</td>
            <td>{{ $trx->status }}</td>
            <td>{{ $trx->creator->name }}</td>
            <td>
                @if($trx->status === 'pending')
                <form method="POST" action="{{ route('stock.confirm', $trx->id) }}">
                    @csrf
                    <button class="bg-green-500 text-white px-2 py-1 rounded">
                        CONFIRM
                    </button>
                </form>
                @else
                    ✔
                @endif
            </td>
        </tr>
        @endforeach
    </tbody>
</table>
</x-app-layout>