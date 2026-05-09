<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cetak Laporan Donasi - Lazismu Situbondo</title>
    <link rel="icon" type="image/png" href="{{ asset('images/padi-lazismu.jpg') }}">
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        @page {
            size: A4 Landscape; /* Format Landscape karena kolom tabel cukup banyak */
            margin: 1cm;
        }
        body {
            font-family: 'Times New Roman', Times, serif; /* Font standar dokumen resmi */
            color: #000;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        th, td {
            border: 1px solid #000;
            padding: 8px;
            font-size: 11pt;
        }
        th {
            background-color: #f3f4f6;
            text-align: center;
        }
    </style>
</head>
<body onload="window.print()">

    <div class="text-center mb-6">
        <h2 class="text-xl font-bold uppercase underline">Laporan Rekapitulasi Donasi</h2>
        <p class="mt-2 text-sm">
            Periode: 
            @if($startDate && $endDate)
                <strong>{{ \Carbon\Carbon::parse($startDate)->format('d/m/Y') }}</strong> s/d <strong>{{ \Carbon\Carbon::parse($endDate)->format('d/m/Y') }}</strong>
            @else
                <strong>Semua Waktu</strong>
            @endif
        </p>
    </div>

    <table>
        <thead>
            <tr>
                <th style="width: 5%">No</th>
                <th style="width: 10%">Tgl Transaksi</th>
                <th style="width: 15%">Kode Transaksi</th>
                <th style="width: 20%">Nama Donatur</th>
                <th style="width: 10%">Kategori</th>
                <th style="width: 15%">Program</th>
                <th style="width: 10%">Bank Tujuan</th>
                <th style="width: 15%">Nominal</th>
            </tr>
        </thead>
        <tbody>
            @forelse($reports as $index => $report)
            <tr>
                <td style="text-align: center;">{{ $index + 1 }}</td>
                <td style="text-align: center;">{{ $report->created_at->format('d/m/Y') }}</td>
                <td style="text-align: center;" class="font-mono">{{ $report->kode_transaksi }}</td>
                <td>{{ $report->user->nama }}</td>
                <td style="text-align: center;">{{ $report->program->kategori->nama_kategori }}</td>
                <td>{{ $report->program->nama_program }}</td>
                <td>{{ $report->rekening->nama_bank }} - {{ $report->rekening->no_rekening }}</td>
                <td style="text-align: right; font-weight: bold;">Rp {{ number_format($report->nominal, 0, ',', '.') }}</td>
            </tr>
            @empty
            <tr>
                <td colspan="8" style="text-align: center; font-style: italic; padding: 20px;">
                    Tidak ada data donasi pada periode atau filter tersebut.
                </td>
            </tr>
            @endforelse
        </tbody>
        @if($reports->count() > 0)
        <tfoot>
            <tr>
                <td colspan="7" style="text-align: right; font-weight: bold; padding-right: 15px;">TOTAL DANA TERKUMPUL</td>
                <td style="text-align: right; font-weight: bold; font-size: 12pt;">Rp {{ number_format($totalNominal, 0, ',', '.') }}</td>
            </tr>
        </tfoot>
        @endif
    </table>

    <div class="mt-12 flex justify-between" style="page-break-inside: avoid;">
        <div class="text-center w-64">
            <p>Mengetahui,</p>
            <p class="mt-1 font-bold">Manajer Lazismu Situbondo</p>
            <div style="height: 80px;"></div>
            <p class="font-bold underline">( ____________________ )</p>
        </div>
        <div class="text-center w-64">
            <p>Situbondo, {{ \Carbon\Carbon::now()->locale('id')->translatedFormat('d F Y') }}</p>
            <p class="mt-1 font-bold">Admin Lazismu</p>
            <div style="height: 80px;"></div>
            <p class="font-bold underline">( ____________________ )</p>
        </div>
    </div>

</body>
</html>