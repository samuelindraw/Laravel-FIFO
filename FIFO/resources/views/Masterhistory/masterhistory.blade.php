<!DOCTYPE html>
<html>
<head>
	<title>Master History Report</title>
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
		<h5>Master History Report</h4>
	</center>
 
	<table class='table table-bordered'>
		<thead>
			<tr>
                <th class="d-none d-sm-table-cell">BUKTI</th>
                <th class="d-none d-sm-table-cell">TGL TRN</th>
                <th class="d-none d-sm-table-cell">JAM</th>
                <th class="d-none d-sm-table-cell">KODE LOKASI</th>
                <th class="d-none d-sm-table-cell">NAMA LOKASI</th>
                <th class="d-none d-sm-table-cell">KODE BARANG</th>
                <th class="d-none d-sm-table-cell">NAMA BARANG</th>
                <th class="d-none d-sm-table-cell">TGL MASUK</th>
                <th class="d-none d-sm-table-cell">QTY</th>
                <th class="d-none d-sm-table-cell">PROGRAM</th>
                <th class="d-none d-sm-table-cell">USERID</th>
			</tr>
		</thead>
		<tbody>
            @foreach ($masterhistory as $his )                                       
            <tr>
                <td>{{ $his->bukti }}</td>
                <td>{{ \Carbon\Carbon::parse($his->tgl_trans)->format('d/m/Y')}}</td>
                <td>{{ \Carbon\Carbon::parse($his->jam)->format('H:i')}}</td>
                <td>{{ $his->MasterLokasi->kodeLokasi }}</td>
                <td>{{ optional($his->MasterLokasi)->namaLokasi }}</td>
                <td>{{ $his->MasterBarang->kodeBarang }}</td>
                <td>{{ optional($his->MasterBarang)->namaBarang }}</td>
                <td>{{ \Carbon\Carbon::parse($his->tgl_masuk)->format('d/m/Y')}}</td>
                <td>{{ $his->qty }}</td>
                <td>{{ $his->program }}</td>
                <td>{{ $his->userid }}</td>
            </tr>
            @endforeach
		</tbody>
	</table>
 
</body>
</html>