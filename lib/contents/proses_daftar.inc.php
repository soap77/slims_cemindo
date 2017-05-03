<?php
/*
* Online Registration Process
*
* Copyright (C) 2010 Purwoko [tamanjiwa@gmail.com]
*
* This program is free software; you can redistribute it and/or modify
* it under the terms of the GNU General Public License as published by
* the Free Software Foundation; either version 2 of the License, or
* (at your option) any later version.
*
* This program is distributed in the hope that it will be useful,
* but WITHOUT ANY WARRANTY; without even the implied warranty of
* MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
* GNU General Public License for more details.
*
* You should have received a copy of the GNU General Public License
* along with this program; if not, write to the Free Software
* Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston, MA 02110-1301 USA
*
*/

$page_title=$sysconf['library_name']." | Pendaftaran Anggota Baru";

//variabel dari form
$id=$_POST['id'];
$member_id=$_POST['member_id']; //nomor induk
$member_name=$_POST['member_name'];
$birth_date=$_POST['birth_y'].'-'.$_POST['birth_m'].'-'.$_POST['birth_d'];
// $register_date=$_POST['register_date'];
$register_date=date("Y-m-d");
$inst_name=$_POST["inst_name"];
$member_notes='Angkatan '.$_POST["member_notes"];
$member_type_id=$_POST['member_type'];
$gender=$_POST['gender'];
$member_address=$_POST['member_address'];
$postal_code=$_POST['postal_code'];
$member_phone=$_POST['member_phone'];
// $pin=$_POST['pin']; //nomor identitas
$member_email=$_POST['member_email'];
$mpasswd=md5($_POST['mpasswd']);


/*
Upload Foto Keanggotaan Perpustakaan
diterapkan dari
http://stackoverflow.com/questions/173868/how-to-extract-a-file-extension-in-php
http://media-kreatif.com/home/post/46/membuat-script-upload-file-lengkap-dengan-php-dan-mysql.prm
diaplikasikan oleh Mirza Rachmad P (mirzarachmad@gmail.com)
*/

//Buat konfigurasi upload
//Folder tujuan upload file
$eror       = false;
$folder     = './images/persons/';
//type file yang bisa diupload
$file_type  = array('jpg','jpeg','png');
//ukuran maximum file yang dapat diupload
$max_size   = 500000; // 500kb
if(isset($_POST['btnsubmit'])){
    //Mulai memorises data
    $file_name  = $_FILES['member_image']['name'];
    $file_size  = $_FILES['member_image']['size'];
		//cari extensi file dengan menggunakan fungsi explode  << menggunakan logika
		//$explode    = explode('.',$file_name);
		//$extensi    = $explode[count($explode)-1];
 
	//cari ekstensi dengan PATHINFO  << menggunakan fungsi PHP yang sudah ada
	$extensi = pathinfo($file_name, PATHINFO_EXTENSION); 
	
	
    //check apakah type file sudah sesuai
    if(!in_array($extensi,$file_type)){
        $eror   = true;
        $pesan = '- Tipe berkas yang Anda unggah tidak sesuai. Berkas harus bertipe JPG atau PNG';
    }
	//check ukuran file apakah sudah sesuai
    if($file_size > $max_size){
        $eror   = true;
        $pesan = '- Ukuran berkas melebihi batas maksimum. Maksimum ukuran berkas 500 kb';
    }
    if($eror == true){
        echo '<script> alert("'.$pesan.'. Data Anda tidak akan diproses.");</script>';
		header("location:index.php?p=daftar");
		exit();
    }
    else{ 
        //mulai memproses upload file
		//Beri nama baru pada file terupload. 
		//Apabila ada karakter khusus pada ID, tidak digunakan untuk nama file
		  $clean_id = preg_replace('/[^A-Za-z0-9\ -]/', '', $_POST['member_id']);
		  $new_imagename = 'member_'.$clean_id.'.'.$extensi;
        if(move_uploaded_file($_FILES['member_image']['tmp_name'], $folder.$new_imagename)){
            //masukkan data ke database
			$tambah1 = "INSERT INTO member(member_id,member_name,member_notes,inst_name,birth_date,register_date,member_since_date,member_type_id,gender,member_address,postal_code,is_pending,member_phone,pin,member_email,mpasswd,member_image)VALUES('$member_id','$member_name','$member_notes','$inst_name','$birth_date','$register_date','$register_date','$member_type_id','$gender','$member_address','$postal_code','1','$member_phone','$pin','$member_email','$mpasswd','$new_imagename')";
			$query1 = $dbs->query($tambah1);
			echo "window.alert('Berhasil mengunggah foto '".$new_imagename."')";
        } else{
			$tambah0 = "INSERT INTO member(member_id,member_name,member_notes,inst_name,birth_date,register_date,member_since_date,member_type_id,gender,member_address,postal_code,is_pending,member_phone,pin,member_email,mpasswd)VALUES('$member_id','$member_name','$member_notes','$inst_name','$birth_date','$register_date','$register_date','$member_type_id','$gender','$member_address','$postal_code','1','$member_phone','$pin','$member_email','$mpasswd')";
			$query0 = $dbs->query($tambah0);
        }
    //}
}

echo '</script>';

header("location:index.php");
exit();
?>
