<! --
/**
* Online Registration Form for SLiMS
*
* Copyright (C) 2010 Purwoko [tamanjiwa@gmail.com]
* Modified by Mirza Rachmad P. [mirzarachmad@gmail.com]
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
-->

<script language="javascript" src="../jquery-2.1.1.min.js"></script>

<script type="text/css">
/* simple css-based tooltip */
.tooltip {
    background-color:#000;
    border:1px solid #fff;
    padding:10px 15px;
    width:200px;
    display:none;
    color:#fff;
    text-align:left;
    font-size:12px;
 
    /* outline radius for mozilla/firefox only */
    -moz-box-shadow:0 0 10px #000;
    -webkit-box-shadow:0 0 10px #000;
}

</script>
	
<?php
// include ("jadwal_reg.php");

//Tanggal buka pendaftaran
$buka_reg = "15 September 2014";
//tanggal tutup pendaftaran
$tutup_reg = "20 September 2014";

$page_title=$sysconf['library_name']." | Pendaftaran Anggota Baru";
?>

<form id="daftar" name="daftar" method="post" action="index.php?p=proses_daftar" enctype="multipart/form-data">
  <table class="border margined"  width="600" border="0">
	<tr>
		<td colspan="4"><?php echo '<font color="#CC0000"><center>'.$sysconf['library_name'].'</font><b> | Pendaftaran Anggota Baru</b>
		<br /><br />Pengumuman: Registrasi dibuka mulai <b>'.$buka_reg.'</b> dan ditutup <font color="#CC0000"><b>'.$tutup_reg.'</b></font></center>'; ?></td>
	</tr>
	<tr><td><br /></td></tr>
    <tr>
		<td class="tblHead" width="112"></td>
		<td class="tblContent" width="290" colspan="3"><input name="id" type="hidden" id="id" size="4" /></td>
    </tr>
    <tr>
		<td width="30%"><?php echo __('Member ID'); ?></td>
		<td><input name="member_id" type="text" id="member_id" size="18" maxlength="18" title="Masukkan Nomor Induk (untuk siswa, misal 1202/2231.099), NIP (untuk PNS, tanpa spasi misal 197002031995021013), atau untuk Non-PNS ditentukan perpustakaan"/> 
		</td>
    </tr>
    <tr>
		<td><?php echo __('Member Name');?></td>
		<td><input name="member_name" type="text" id="member_name" size="40" title="Nama Anda sesuai kartu identitas"/></td>
    </tr>
	<tr>
		<td>Angkatan</td>
		<td>
		<?php
			// Year generated drop down list 
			// [http://forums.phpfreaks.com/topic/282055-year-generated-drop-down-list/]
			$current_year = date("Y");
			$range = range($current_year, ($current_year - 4));
			echo '<select id="lstbln" class="inputstyle" name="member_notes" title="Tahun berapa Anda bergabung dengan sekolah ini?">';
			//Now we use a foreach loop and build the option tags
			foreach($range as $r)
			{
			echo '<option value="'.$r.'">'.$r.'</option>';
			}
			 
			//Echo the closing select tag
			echo '</select>';
		?>
		</td>
    </tr>
	<tr>
		<td><?php echo __('Institution');?></td>
		<td><input name="inst_name" type="text" id="textfield3" size="40" title="Isi dengan nama institusi tempat Anda belajar/bekerja" value="SMK Negeri 8 Malang"/></td>
    </tr>
	<tr>
		<td><?php echo __('Birth Date');?> </td>
		<td style="width:90px"><select id="birth_d" style="width:90px" class="inputstyle" name="birth_d" title="Tanggal lahir">
					<option selected="selected" value="01">1</option>
					<option value="02">2</option>
					<option value="03">3</option>
					<option value="04">4</option>
					<option value="05">5</option>
					<option value="06">6</option>
					<option value="07">7</option>
					<option value="08">8</option>
					<option value="09">9</option>
					<option value="10">10</option>
					<option value="11">11</option>
					<option value="12">12</option>
					<option value="13">13</option>
					<option value="14">14</option>
					<option value="15">15</option>
					<option value="16">16</option>
					<option value="17">17</option>
					<option value="18">18</option>
					<option value="19">19</option>
					<option value="20">20</option>
					<option value="21">21</option>
					<option value="22">22</option>
					<option value="23">23</option>
					<option value="24">24</option>
					<option value="25">25</option>
					<option value="26">26</option>
					<option value="27">27</option>
					<option value="28">28</option>
					<option value="29">29</option>
					<option value="30">30</option>
					<option value="31">31</option>
					</select>
					
					<select id="birth_m" style="width:128px" class="inputstyle" name="birth_m" title="Bulan lahir">
					<option selected="selected" value="01">Januari</option>
					<option value="02">Februari</option>
					<option value="03">Maret</option>
					<option value="04">April</option>
					<option value="05">Mei</option>
					<option value="06">Juni</option>
					<option value="07">Juli</option>
					<option value="08">Agustus</option>
					<option value="09">September</option>
					<option value="10">Oktober</option>
					<option value="11">November</option>
					<option value="12">Desember</option>
					</select>
				</td>
				<td><input style="width:80px" name="birth_y" type="text" id="birth_y" size="4" maxlength="4" title="Tahun lahir Anda dengan format YYYY (misal 1998)"/>
			</td>
    </tr>
	<tr>
		<td><?php echo __('Member Type');?></td>
		<td><select id="lstbln" class="inputstyle" name="member_type" title="Jenis keanggotaan Anda di perpustakaan">
			<option selected="selected" value="1">Siswa</option>
			<option value="2">Guru/Karyawan</option>
			</select></td>
    </tr>
	<tr>
		<td><?php echo __('Gender');?></td>
		<td><select id="lstbln" class="inputstyle" name="gender" title="Jenis kelamin Anda">
			<option selected="selected" value="0"><?php echo __('Male');?></option>
			<option value="1"><?php echo __('Female');?></option>
			</select></td>
    </tr>
	<tr>
		<td><?php echo __('Address');?></td>
		<td><textarea name="member_address" type="textarea" id="textfield3" cols="35" rows="6" title="Masukkan Alamat Anda secara lengkap"></textarea></td>
    </tr>
	<tr>
		<td><?php echo __('Postal Code');?></td>
		<td><input name="postal_code" type="text" id="textfield3" size="5" maxlength="5" title="Kode Pos tempat tinggal Anda"/></td>
    </tr>
	<tr>
		<td><?php echo __('Phone Number');?></td>
		<td><input name="member_phone" type="text" id="textfield3" size="40" title="Masukkan nomor telepon/ponsel Anda yang bisa dihubungi"/></td>
    </tr>

	<tr>
		<td><?php echo __('Member Email');?></td>
		<td><input name="member_email" type="text" id="textfield3" size="40" title="Masukkan alamat surat elektronik (e-mail) yang Anda miliki"/></td>
    </tr>
	<tr>
		<td><?php echo __('Photo');?></td>
		<td><input id="member_image" name="member_image"  type="file" title="Unggah foto Anda ukuran 3 x 4 dengan format PNG atau JPG, ukuran berkas maksimum 500 kB"/>
		   <script language="javascript">
		   // http://stackoverflow.com/questions/651700/how-to-have-jquery-restrict-file-types-on-upload
			$('#member_image').bind('change', function() {
			var ext = $('#member_image').val().split('.').pop().toLowerCase();
			if($.inArray(ext, ['png','jpg','jpeg']) == -1) {
				alert('Error! Berkas harus berupa gambar dengan format JPG atau PNG.');
			}
		   // http://belajarngoding.com/jquery-file-checker/#.U-1ZGvl_smQ
			var ukuranFile = this.files[0].size;
				if (ukuranFile > 500000) {
					alert('Error! Ukuran berkas lebih dari 500 kB.\nUkuran berkas maksimal 500 kB, jika tidak berkas tidak akan diunggah.');
					exit();
					}
			});
			</script>
		 </td>
		 <td><img src="images/no-photo.jpg" id="gambar_nodin" width="120" alt="Preview Gambar" />
		
		 <script>
		 //script source:http://yogacp.web.id/demo/preview_image/
			function bacaGambar(input) {
				if (input.files && input.files[0]) {
					var reader = new FileReader();

					reader.onload = function (e) {
						$('#gambar_nodin').attr('src', e.target.result);
					}

					reader.readAsDataURL(input.files[0]);
				}
			}

			$("#member_image").change(function(){
				bacaGambar(this);
			});
		</script>
		 </td>
	</tr>
	<tr>
		<td><?php echo __('Password');?> </td>
		<td><input name="mpasswd" type="password" id="textfield3" size="40" title="Masukkan kata sandi yang akan digunakan untuk mengakses akun Anda di situs ini"/></td>
    </tr>
	<tr>
		<td>Ulangi Kata Sandi</td>
		<td><input name="password" type="password" id="textfield3" size="40" title="Ulangi kata sandi yang telah dimasukkan sebelumnya"/></td>
    </tr>
	<tr>
		<td></td>
		<td colspan="3">Dengan ini saya menyatakan data yang saya masukkan di atas benar adanya.</td>
	</tr>
	<tr>
		<td></td>
		<td>
			<table>
			<tr>
			<td><input type="submit" name="btnsubmit" id="button" value="     Kirim     " title="Kirim data yang telah Anda masukkan pada formulir di atas" class="memberButton" onclick="konfirmasi()"/></td>
			<td><input type="reset" name="btnreset" id="button" value="     Reset     " title="Kosongkan isi formulir di atas" class="loginButton" /></td>
			</tr>
			</table>
		<td>&nbsp;</td>
    </tr>
    </tr>
  </table>
  
</form>

<script type="text/javascript">
// select all desired input fields and attach tooltips to them
      $("#daftar :input").tooltip({
      // place tooltip on the right edge
      position: "right",
      // a little tweaking of the position
      offset: [2, 10],
      // use the built-in fadeIn/fadeOut effect
      effect: "fade",
      // custom opacity setting
      opacity: 0.7
      });
	  
function konfirmasi() {
	  var nama_anggota = document.getElementById("member_name").value;
	  alert('Terima kasih, '+ nama_anggota +'. Dengan mengklik "Kirim" Anda menyatakan semua data serta berkas yang diunggah sesuai dengan persyaratan, jika tidak data Anda tidak akan diproses.\n\nKeanggotaan Anda sekarang berstatus TIDAK AKTIF. \n\nUntuk mengaktifkannya, konfirmasikan keanggotaan Anda ke Kepala atau Staf perpustakaan. \nTunjukkan Nama dan Nomor ID Anggota yang telah Anda gunakan untuk mendaftarkan diri.');
}
</script>
