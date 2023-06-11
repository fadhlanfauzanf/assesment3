<?php
header('Content-Type: application/json; charset=utf8');

// Allow cross-origin requests
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE');
header('Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept');
header('Content-Type: application/json; charset=utf8');

$koneksi = mysqli_connect("localhost", "root", "", "tubes");

if ($_SERVER['REQUEST_METHOD'] === 'GET') { // Menampilkan Semua Data + Bisa lebih spesifik
    $sql = "SELECT * FROM masukkan";
    $query = mysqli_query($koneksi, $sql);
    $array_data = array();
    while ($data = mysqli_fetch_assoc($query)) {
        $array_data[] = $data;
    }
    echo json_encode($array_data, JSON_PRETTY_PRINT);
} else if ($_SERVER['REQUEST_METHOD'] === 'POST') { // [POST] Menambahkan data + Use Body, x-www-form-urlencoded in Postman
    $id_user = $_POST['id_user']; // All Required since its a new data
    $username = $_POST['username']; 
    $isi_komen = $_POST['isi_komen'];
    $sql = "INSERT INTO masukkan (id_user,username,isi_komen) VALUES('$id_user','$username','$isi_komen')";
    $cek = mysqli_query($koneksi, $sql);

    if ($cek) {
        $data = [
            'status' => "Berhasil"
        ];
        echo json_encode([$data], JSON_PRETTY_PRINT);
    } else {
        $data = [
            'status' => "Gagal"
        ];
        echo json_encode([$data], JSON_PRETTY_PRINT);
    }
} else if ($_SERVER['REQUEST_METHOD'] === 'DELETE') { // [DELETE] Id only + Use Param in Postman
    $id_user = $_GET['id_user']; 
    $sql = "DELETE FROM masukkan WHERE id_user='$id_user'";
    $cek = mysqli_query($koneksi, $sql);

    if ($cek) {
        $data = [
            'status' => "Berhasil"
        ];
        echo json_encode([$data], JSON_PRETTY_PRINT);
    } else {
        $data = [
            'status' => "Gagal"
        ];
        echo json_encode([$data], JSON_PRETTY_PRINT);
    }
} else if ($_SERVER['REQUEST_METHOD'] === 'PUT') { // [PUT] Use All + Use Params in Postman
    parse_str(file_get_contents("php://input"), $_PUT);
    $id_user = $_PUT['id_user_update']; 
    $username = $_PUT['username_update'];
    $isi_komen = $_PUT['isi_komen_update'];

    $sql = "UPDATE masukkan SET username='$username', isi_komen='$isi_komen' WHERE id_user='$id_user'";
    $cek = mysqli_query($koneksi, $sql);

    if ($cek) {
        $data = [
            'status' => "Berhasil"
        ];
        echo json_encode([$data], JSON_PRETTY_PRINT);
    } else {
        $data = [
            'status' => "Gagal"
        ];
        echo json_encode([$data], JSON_PRETTY_PRINT);
    }
}
?>
