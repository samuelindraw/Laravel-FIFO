<!DOCTYPE html>
<html>
<head>
	<title>Master Stock Report</title>
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
</head>
<body>
	<style type="text/css">
		table tr td,
		table tr th{
			font-size: 9pt;
		}
	</style>
	<center>
		<h5>Master Stock Report</h4>
	</center>
 
	<table class='table table-bordered'>
		<thead>
			<tr>
                <th class="d-none d-sm-table-cell">Kode Lokasi</th>
                <th class="d-none d-sm-table-cell">Nama Lokasi</th>
                <th class="d-none d-sm-table-cell">Kode Barang</th>
                <th class="d-none d-sm-table-cell">Nama Barang</th>
                <th class="d-none d-sm-table-cell">Tgl Masuk</th>
                <th class="d-none d-sm-table-cell">qty</th>
                <th class="d-none d-sm-table-cell">um</th>
			</tr>
		</thead>
		<tbody>
            @foreach ($masterstok as $stok )                                       
            <tr>
                <td>{{ $stok->MasterLokasi->kodeLokasi }}</td>
                <td>{{ optional($stok->MasterLokasi)->namaLokasi }}</td>
                <td>{{ $stok->MasterBarang->kodeBarang }}</td>
                <td>{{ optional($stok->MasterBarang)->namaBarang }}</td>
                <td>{{ \Carbon\Carbon::parse($stok->tgl_masuk)->format('d/m/Y')}}</td>
                <td>{{ $stok->qty }}</td>
                <td>{{ $stok->MasterBarang->um }}</td>
            </tr>
            @endforeach
		</tbody>
	</table>
 
</body>
</html>