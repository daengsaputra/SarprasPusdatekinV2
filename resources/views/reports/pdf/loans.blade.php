<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <style>
        body { font-family: DejaVu Sans, sans-serif; font-size: 12px; }
        h2 { text-align: center; margin-bottom: 10px; }
        table { width: 100%; border-collapse: collapse; }
        th, td { border: 1px solid #000; padding: 6px; text-align: left; }
        th { background: #f3f4f6; }
    </style>
</head>
<body>
    <h2>{{ $title }} ({{ $period[0] }} s/d {{ $period[1] }})</h2>
    <table>
        <thead>
            <tr>
                <th>Tanggal</th>
                <th>Aset</th>
                <th>Peminjam</th>
                <th>Unit</th>
                <th>Status</th>
                <th>Jumlah</th>
                <th>Rencana Kembali</th>
                <th>Kembali</th>
            </tr>
        </thead>
        <tbody>
            @foreach($rows as $row)
                <tr>
                    <td>{{ optional($row->loan_date)->format('Y-m-d') ?? '-' }}</td>
                    <td>{{ $row->asset->name ?? '-' }}</td>
                    <td>{{ $row->borrower_name }}</td>
                    <td>{{ $row->unit ?? '-' }}</td>
                    <td>{{ $row->status }}</td>
                    <td>{{ $row->quantity }}</td>
                    <td>{{ optional($row->return_date_planned)->format('Y-m-d') ?? '-' }}</td>
                    <td>{{ optional($row->return_date_actual)->format('Y-m-d') ?? '-' }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
