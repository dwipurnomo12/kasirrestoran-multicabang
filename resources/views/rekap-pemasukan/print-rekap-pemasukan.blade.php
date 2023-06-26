<!DOCTYPE html>
<html>
<head>
    <title>Rekap Pemasukan</title>
    <style>
        .container {
            margin: 0 auto;
            width: 100%;
            max-width: 800px;
        }
        .header {
            text-align: center;
            margin-bottom: 25px;
        }
        .header h1, .header p {
            margin: 0;
        }
        table {
            margin-bottom: 50px;
            border-collapse: collapse;
            width: 100%;
        }
        table th, table td {
            border: 1px solid #000;
            padding: 10px;
            text-align: center;
        }
        table th {
            background-color: #ccc;
        }
        tfoot {
            margin-top: auto;
        }
        tfoot td {
            text-align: left;
        }
        .detail{
            text-align: left;
            padding: 10px;
        }
   
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1><u>Rekap Pemasukan Restoran</u></h1>
            <div class="detail">
                <strong>Keterangan </strong> <br>
                @if ($data['selectedOption'])
                    Cabang  : {{ \App\Models\Cabang::find($data['selectedOption'])->cabang }} <br>
                @else
                    Cabang  : {{ auth()->user()->cabang->cabang }} <br>
                @endif

                @if ($data['tanggalMulai'] && $data['tanggalSelesai'])
                    Periode : {{ \Carbon\Carbon::parse($data['tanggalMulai'])->format('d-m-Y') }} - {{ \Carbon\Carbon::parse($data['tanggalSelesai'])->format('d-m-Y') }} <br>
                @else
                    Periode : Semua Periode <br>
                @endif

                Tanggal Cetak : {{ now()->format('d-m-Y') }} <br>
            </div>
      
        </div>

        <table>
            <thead>
                <tr>
                    <th>No</th>
                    <th>Kode</th>
                    <th>Tgl. Transaksi</th>
                    <th>Total</th>
                </tr>
            </thead>
            <tbody>
                @foreach($data['pembelians'] as $item)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $item->kode_pembelian }}</td>
                        <td>{{ $item->tgl_transaksi }}</td>
                        <td>Rp. {{ $item->total_harga }}</td>
                    </tr>
                @endforeach
            </tbody>
            <tfoot>
                <tr>
					<td colspan="3"><strong>Dicetak Oleh : {{ auth()->user()->role->role }}, Cabang {{ auth()->user()->cabang->cabang}}</strong></td>
                    <td><b>Total  : Rp. {{ number_format($data['totalPemasukan'], 2, ',', '.') }}</b></td>
				</tr>
            </tfoot>
        </table>
    </div>
</body>
</html>
