<!DOCTYPE html>
<html>
<head>
    <title>Print Permintaan Barang</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            table-layout: fixed;
        }

        td, th {
            border: 1px solid #000;
            padding: 4px;
            word-wrap: break-word;
        }

        .center { text-align: center; }
        .right { text-align: right; }
        .bold { font-weight: bold; }

        @media print {
            button { display: none; }
        }
    </style>
</head>
<body>

<h3 style="text-align:right;">
    Tanggal: {{ now()->format('d-m-Y') }}
</h3>

<table>
    <thead>
        <tr>
            <th>Nama Barang</th>
            <th>Merk / Type</th>
            <th>Jumlah</th>
            <th>Harga Satuan</th>
            <th>Sub Total</th>
            <th>Supplier</th>
            <th>Arrival</th>
            <th>Keterangan</th>
        </tr>
    </thead>

    <tbody>
    @foreach ($data as $row)
        <tr>
            <td>{{ $row->nama_barang }}</td>
            <td>{{ $row->merk_type }}</td>
            <td class="center">{{ $row->jumlah }}</td>
            <td class="right">{{ number_format($row->harga_satuan) }}</td>
            <td class="right">{{ number_format($row->total) }}</td>
            <td>{{ $row->supplier }}</td>
            <td class="center">{{ $row->arrival_date }}</td>
            <td></td>
        </tr>
    @endforeach
    </tbody>

    <tfoot>
        <tr>
            <td colspan="4" class="bold right">TOTAL</td>
            <td class="bold right">
                {{ number_format($data->sum('total')) }}
            </td>
            <td colspan="3"></td>
        </tr>
    </tfoot>
</table>

<script>
    window.onload = () => window.print();
</script>

</body>
</html>
