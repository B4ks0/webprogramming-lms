<h1 class="h3 mb-4 text-gray-800">Data Kelas</h1>

<a class="btn btn-primary mb-3" href="layout.php?page=tambah_mk">Tambah</a>
<table class="table table-striped table-hover">
    <tr>
        <th>No</th>
        <th>Nama Mata Kuliah</th>
        <th>Keterangan</th>
        <th>Aksi</th>
    </tr>
    <?php

    $no = 1;
    $query = mysqli_query($koneksi, "select * from matakuliah");
    while ($row = mysqli_fetch_array($query)) {
    ?>
        <tr>
            <td><?php echo $no++; ?></td>
            <td><?php echo $row['nama_mk']; ?></td>
            <td><?php echo $row['ket']; ?></td>
            <td>
                <a class="btn btn-success btn-sm px-2" href="ubah_mk.php?id=<?php echo $row['id']; ?>">Edit</a>
                <a class="btn btn-danger btn-sm" href="hapus.php?id=<?php echo $row['id']; ?>">Hapus</a>
            </td>
        </tr>
    <?php
    }
    ?>
</table>