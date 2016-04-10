<?php 
$month= date ("m"); 
$year=date("Y"); 
$day=date("d"); 
// t digunakan untuk menghitung jumlah seluruh hari pada bulan ini 
//ini digunakan untuk menampilkan semua tanggal pada bulan ini 
$endDate=date("t",mktime(0,0,0,$month,$day,$year)); 
//membuat tabel kalender  
echo '<font face="arial" size="2">'; 
echo '<table align="center" border="0" cellpadding=5 cellspacing=5 style=""><tr><td align=center>'; 
//menampilkan hari ini  
echo "Hari ini tanggal : ".date("d F Y ",mktime(0,0,0,$month,$day,$year)); 
echo '</td></tr></table>'; 	
//membuat tebel baris nama-nama hari 
echo '<table align="center" border="0" width=100% cellpadding=1 cellspacing=1 style="border:1px solid #000;"> 
  <tr bgcolor="#000"> 
  <td align=center width=14% height=30px><font color=red>Minggu</font></td> 
  <td align=center width=14%>Senin</td> 
  <td align=center width=14%>Selasa</td> 
  <td align=center width=14%>Rabu</td> 
  <td align=center width=14%>Kamis</td> 
  <td align=center width=14%>Jumat</td> 
  <td align=center width=14%>Sabtu</td> 
  </tr>'; 
//cek tanggal 1 hari sekarang 
$s=date ("w", mktime (0,0,0,$month,1,$year)); 
for ($ds=1;$ds<=$s;$ds++) { 
echo "<td style='font-family:arial;color:#B3D9FF; background:#fff' align=center valign=middle height=30px> 
</td>";} 
for ($d=1;$d<=$endDate;$d++) { 
//jika variabel w= 0 disini 0 adalah hari minggu akan membuat baris baru dengan </tr> 
if (date("w",mktime (0,0,0,$month,$d,$year)) == 0) { echo "<tr>"; } 
$fontColor="#000000"; 
//menentukan warna pada tanggal hari biasa 
if (date("D",mktime (0,0,0,$month,$d,$year)) == "Sun") { $fontColor="red"; } 
echo "<td style='font-family:arial;color:#333333; background:#fff' align=center valign=middle height=30px> <span style=\"color:$fontColor\">$d</span></td>";  
//jika variabel w= 6 disini 6 adalah hari sabtu maka akan pindah baris dengan menutup baris </tr> 
if (date("w",mktime (0,0,0,$month,$d,$year)) == 6) { echo "</tr>"; }} 
echo '</table>';  
?>