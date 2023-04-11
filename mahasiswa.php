<?php
include("koneksi.php");

$jkel = [
	'L' => 'Laki-laki',
	'P' => 'Perempuan'
];

$jurusan = [
	"Rekayasa Perangkat Lunak" => "Rekayasa Perangkat Lunak",
	"Multimedia" => "Multimedia",
	"Administrasi Tata Kelola Perkantoran" => "Administrasi Tata Kelola Perkantoran",
];

//jika tombol simpan diklik
if (isset($_POST['bsimpan'])) {
	//Pengujian Apakah data akan diedit atau disimpan baru
	if ($_GET['hal'] == "edit") {
		//Data akan di edit
		$edit = mysqli_query($koneksi, "UPDATE 	mahasiswa set
											 	nim = '$_POST[nim]',
											 	nama = '$_POST[nama]',
												jkel = '$_POST[jkel]',
												jurusan = '$_POST[jurusan]',
												notelp = '$_POST[notelp]'
											 WHERE id = '$_GET[id]'
										   ");
		if ($edit) //jika edit sukses
		{
			echo "<script>
						alert('Edit data suksess!');
						document.location='mahasiswa.php';
				     </script>";
		} else {
			echo "<script>
						alert('Edit data GAGAL!!');
						document.location='mahasiswa.php';
				     </script>";
		}
	} else {
		//Data akan disimpan Baru
		$simpan = mysqli_query($koneksi, "INSERT INTO mahasiswa (nim, nama, jkel, jurusan, notelp)
										  VALUES ('$_POST[nim]', 
										  		 '$_POST[nama]', 
										  		 '$_POST[jkel]', 
										  		 '$_POST[jurusan]',
												 '$_POST[notelp]')
										 ");
		if ($simpan) //jika simpan sukses
		{
			echo "<script>
						alert('Simpan data suksess!');
						document.location='mahasiswa.php';
				     </script>";
		} else {
			echo "<script>
						alert('Simpan data GAGAL!!');
						document.location='mahasiswa.php';
				     </script>";
		}
	}
}


//Pengujian jika tombol Edit / Hapus di klik
if (isset($_GET['hal'])) {
	//Pengujian jika edit Data
	if ($_GET['hal'] == "edit") {
		//Tampilkan Data yang akan diedit
		$tampil = mysqli_query($koneksi, "SELECT * FROM mahasiswa WHERE id = '$_GET[id]' ");
		$data = mysqli_fetch_array($tampil);
	} else if ($_GET['hal'] == "hapus") {
		//Persiapan hapus data
		$hapus = mysqli_query($koneksi, "DELETE FROM mahasiswa WHERE id = '$_GET[id]' ");
		if ($hapus) {
			echo "<script>
						alert('Hapus Data Suksess!!');
						document.location='mahasiswa.php';
				     </script>";
		}
	}
}

?>

<!DOCTYPE html>
<html>

<head>
	<title>CRUD PHP & MySQL + Bootstrap 4</title>
	<link rel="stylesheet" type="text/css" href="css/bootstrap.min.css">
</head>

<body>
<?php include "navbar.php"; ?>
	<div class="container">
		<h1 class="text-center">CRUD PHP & MySQL + Bootstrap 4</h1>
		<h2 class="text-center">BNSP SWADHARMA</h2>
		<?php if (!empty($_GET['hal'])) : ?>
			<!-- Awal Card Form -->
			<div class="card mt-3">
				<div class="card-header bg-primary text-white">
					Form Input Data Mahasiswa
				</div>
				<div class="card-body">
					<form method="post" action="">
						<div class="form-group">
							<label>Nim</label>
							<input type="text" name="nim" value="<?= @$data['nim'] ?>" class="form-control" placeholder="Input NIM disini!" required>
						</div>
						<div class="form-group">
							<label>Nama</label>
							<input type="text" name="nama" value="<?= @$data['nama'] ?>" class="form-control" placeholder="Input Nama disini!" required>
						</div>
						<div class="form-group">
							<label>Jenis Kelamin</label>
							<?php foreach ($jkel as $key => $value) : ?>
								<div class="form-check form-check-inline">
									<input class="form-check-input" type="radio" name="jkel" id="jkl<?= $key ?>" value="<?= $key ?>" <?= $key == @$data['jkel'] ? "checked" : "" ?>>
									<label class="form-check-label" for="jkl<?= $key ?>">
										<?= $value ?>
									</label>
								</div>
							<?php endforeach; ?>
						</div>
						<div class="form-group">
							<label>Jurusan</label>
							<select class="form-control" name="jurusan">
								<?php foreach ($jurusan as $key => $value) : ?>
									<option value="<?= $value ?>" <?= $value == @$data['jurusan'] ? "selected" : "" ?>><?= $value ?></option>
								<?php endforeach; ?>
							</select>
							<div class="form-group">
							<label>No Telp</label>
							<input type="text" name="notelp" value="<?= @$data['notelp'] ?>" class="form-control" placeholder="Input Nomor Telepon disini!" required>
						</div>
						</div>

						<a href="mahasiswa.php" class="btn btn-primary">Kembali</a>
						<button type="submit" class="btn btn-success" name="bsimpan">Simpan</button>
						<button type="reset" class="btn btn-danger" name="breset">Kosongkan</button>

					</form>
				</div>
			</div>
			<!-- Akhir Card Form -->
		<?php else : ?>

			<!-- Awal Card Tabel -->
			<div class="card mt-3">
				<div class="card-header bg-success text-white">
					Daftar Mahasiswa
					<div class="float-right">
						<a href="mahasiswa.php?hal=tambah" class="btn btn-primary">
							Tambah
						</a>
					</div>
				</div>
				<div class="card-body">

					<table class="table table-bordered table-striped">
						<tr>
							<th>No.</th>
							<th>NIS</th>
							<th>Nama</th>
							<th>Jenis Kelamin</th>
							<th>Jurusan</th>
							<th>No telp</th>
							<th>Aksi</th>
						</tr>
						<?php
						$no = 1;
						$tampil = mysqli_query($koneksi, "SELECT * from mahasiswa order by id asc");
						while ($data = mysqli_fetch_array($tampil)) :

						?>
							<tr>
								<td><?= $no++; ?></td>
								<td><?= $data['nim'] ?></td>
								<td><?= $data['nama'] ?></td>
								<td><?= $jkel[$data['jkel']] ?></td>
								<td><?= $data['jurusan'] ?></td>
								<td><?= $data['notelp'] ?></td>
								<td>
									<a href="mahasiswa.php?hal=edit&id=<?= $data['id'] ?>" class="btn btn-warning"> Edit </a>
									<a href="mahasiswa.php?hal=hapus&id=<?= $data['id'] ?>" onclick="return confirm('Apakah yakin ingin menghapus data ini?')" class="btn btn-danger"> Hapus </a>
								</td>
							</tr>
						<?php endwhile; //penutup perulangan while 
						?>
					</table>

				</div>
			</div>
			<!-- Akhir Card Tabel -->
		<?php endif; ?>
	</div>

	<script type="text/javascript" src="js/bootstrap.min.js"></script>
</body>

</html>