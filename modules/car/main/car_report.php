<?php
/** ensure this file is being included by a parent file */
defined( '_VALID_' ) or die( 'Direct Access to this location is not allowed.' );
require_once "modules/car/time_inc.php";
?>
<script type="text/javascript" src="./css/js/calendarDateInput.js"></script>
<?php
$user=$_SESSION['login_user_id'];
//กรณีเลือกแสดงเฉพาะคัน
if(isset($_REQUEST['car_index'])){
$car_index=$_REQUEST['car_index'];
}
else{
$car_index="";
}
$sql_name = "select * from person_main ";
$query_name = mysqli_query($connect,$sql_name);
while($result_name = mysqli_fetch_array($query_name)){;
		$person_id = $result_name['person_id'];
		$prename=$result_name['prename'];
		$name= $result_name['name'];
		$surname = $result_name['surname'];
$full_name_ar[$person_id]="$prename$name&nbsp;&nbsp;$surname";
}
//ส่วนหัว
?>
<BR>
<div class="container">
  <div class="panel panel-default">
<?
if(!(($index==1)  or ($index==2) or ($index==5) or ($index==7))){
    ?><div class="panel-heading"><h3 class="panel-title">รายงานการใช้ยานพาหนะ</h3></div><?
}
//ส่วนฟอร์มรับข้อมูล
if($index==1){
echo "<form id='frm1' name='frm1'>";
echo "<Center>";
echo "<Font color='#006666' Size=3><B>บันทึกรายงานการใช้ยานพาหนะ</Font>";
echo "</Cener>";
echo "<Br><Br>";
echo "<Table width='80%'>";
echo "<Tr align='left'><Td align='right'>ข้าพเจ้า&nbsp;&nbsp;</Td><Td>$_SESSION[login_prename]$_SESSION[login_name]&nbsp;&nbsp;$_SESSION[login_surname]&nbsp;&nbsp;ตำแหน่ง$_SESSION[login_userposition]</Td></Tr>";
echo "<Tr align='left'><Td align='right'>ได้ทำหน้าที่ขับรถ&nbsp;&nbsp;</Td><Td><Select  name='car'  size='1'>";
echo  "<option  value = ''>เลือกรถ</option>" ;
$sql = "select * from  car_car where status<='2' ";
$query = mysqli_query($connect,$sql);
While ($result = mysqli_fetch_array($query))
   {
		$car_code = $result['car_code'];
		$car_number= $result['car_number'];
		$name = $result['name'];
		echo  "<option value = $car_code>$car_number $name</option>";
	}
echo "</select>";
echo "</Td></Tr>";
echo "<Tr align='left'><Td align='right'>ไปราชการ(สถานที่)&nbsp;&nbsp;</Td><Td><Input Type='Text' Name='place' Size='60'></Td></Tr>";
echo "<Tr align='left'><Td align='right'>เพื่อวัตถุประสงค์&nbsp;&nbsp;</Td><Td><Input Type='Text' Name='because' Size='80'></Td></Tr>";
echo "<Tr align='left'><Td align='right'>ตั้งแต่วันที่&nbsp;&nbsp;</Td>";
echo "<Td align='left'>";
?>
<script>
								var Y_date=<?php echo date("Y")?>
								var m_date=<?php echo date("m")?>
								var d_date=<?php echo date("d")?>
								Y_date= Y_date+'/'+m_date+'/'+d_date
								DateInput('car_start', true, 'YYYY-MM-DD', Y_date)</script>
<?php

echo "</Td></Tr>";
echo "<Tr align='left'><Td align='right'>&nbsp;&nbsp;เวลา</Td><Td><Input Type='Text' Name='time_start' Size='5'>&nbspน.</Td></Tr>";
echo "<Tr align='left'><Td align='right'>ถึงวันที่&nbsp;&nbsp;</Td>";
echo "<Td align='left'>";
?>
<script>
								var Y_date=<?php echo date("Y")?>
								var m_date=<?php echo date("m")?>
								var d_date=<?php echo date("d")?>
								Y_date= Y_date+'/'+m_date+'/'+d_date
								DateInput('car_finish', true, 'YYYY-MM-DD', Y_date)</script>
<?php
echo "</Td></Tr>";
echo "<Tr align='left'><Td align='right'>&nbsp;&nbsp;เวลา</Td><Td><Input Type='Text' Name='time_finish' Size='5'>&nbspน.</Td></Tr>";
echo "<Tr align='left'><Td align='right'>รวม&nbsp;&nbsp;</Td>";
echo "<Td><Input Type='Text' Name='day_total' Size='5'>&nbsp;&nbsp;วัน";
echo "<Tr align='left'><Td align='right'>มีผู้โดยสารทั้งหมด&nbsp;&nbsp;</Td><Td><Input Type='Text' Name='person_num' Size='5'>&nbsp;&nbsp;คน</Td></Tr>";
echo "<Tr align='left'><Td align='right'>ผู้ควบคุมรถคือ&nbsp;&nbsp;</Td><Td><Input Type='Text' Name='control_person' Size='60'></Td></Tr>";
echo "<Tr align='left'><Td align='right'>&nbsp;&nbsp;เลขเข็มไมล์เมื่อเริ่มเดินทาง</Td><Td>&nbsp<Input Type='Text' Name='start_mile' Size='20'></Td></Tr>";
echo "<Tr align='left'><Td align='right'>&nbsp;&nbsp;เลขเข็มไมล์เมื่อสิ้นสุดการเดินทาง</Td><Td>&nbsp<Input Type='Text' Name='finish_mile' Size='20'></Td></Tr>";
echo "<Tr align='left'><Td align='right'>&nbsp;&nbsp;น้ำมันเชื้อเพลิงคงเหลือในถังเมื่อสิ้นสุดการเดินทาง</Td><Td>&nbsp<Input Type='Text' Name='fuel' Size='10'>&nbsp;ลิตร (ประมาณ)</Td></Tr>";
echo "<Tr align='left'><Td align='right'>&nbsp;&nbsp;สภาพการณ์</Td><Td>&nbsp<textarea rows='5' name='detail' cols='55'></textarea></Td></Tr>";
echo "</Table>";
echo "<Br>";
echo "<INPUT TYPE='button' name='smb' value='ตกลง' onclick='goto_url(1)' >
		&nbsp;&nbsp;<INPUT TYPE='button' name='back' value='ย้อนกลับ' onclick='goto_url(0)'>";
echo "</form>";
}
//ส่วนยืนยันการลบข้อมูล
if($index==2) {
echo "<table width='500' border='0' align='center'>";
echo "<tr><td align='center'><font color='#990000' size='4'>โปรดยืนยันความต้องการลบข้อมูลอีกครั้ง</font><br></td></tr>";
echo "<tr><td align=center>";
echo "<INPUT TYPE='button' name='smb' value='ยืนยัน' onclick='location.href=\"?option=car&task=main/car_report&index=3&id=$_GET[id]&page=$_REQUEST[page]&car_index=$car_index\"'>
		&nbsp;&nbsp;<INPUT TYPE='button' name='back' value='ยกเลิก' onclick='location.href=\"?option=car&task=main/car_report&page=$_REQUEST[page]&car_index=$car_index\"'";
echo "</td></tr></table>";
}
//ส่วนลบข้อมูล
if($index==3){
$sql = "delete from car_report where id='$_GET[id]'";
$query = mysqli_query($connect,$sql);
}
//ส่วนบันทึกข้อมูล
if($index==4){
$rec_date = date("Y-m-d H:i:s");
$sql = "insert into car_report ( person_id, rec_date, car, place, because, car_start, time_start, car_finish, time_finish, day_total,  person_num, control_person, start_mile, finish_mile, fuel, detail) values ('$user', '$rec_date',  '$_POST[car]', '$_POST[place]', '$_POST[because]', '$_POST[car_start]', '$_POST[time_start]','$_POST[car_finish]','$_POST[time_finish]','$_POST[day_total]', '$_POST[person_num]','$_POST[control_person]', '$_POST[start_mile]', '$_POST[finish_mile]',  '$_POST[fuel]',   '$_POST[detail]')";
$query = mysqli_query($connect,$sql);
}
//ส่วนฟอร์มแก้ไขข้อมูล
if ($index==5){
echo "<form  id='frm1' name='frm1'>";
echo "<Center>";
echo "<Font color='#006666' Size=3><B>แก้ไขรายการ</B></Font>";
echo "</Cener>";
echo "<Br><Br>";
echo "<Table width='90%' Border='0'>";
$sql = "select * from car_report where id='$_GET[id]'";
$query = mysqli_query($connect,$sql);
$ref_result = mysqli_fetch_array($query);
$id=$ref_result['id'];
echo "<Tr align='left'><Td align='right'>ข้าพเจ้า&nbsp;&nbsp;</Td><Td>$_SESSION[login_prename]$_SESSION[login_name]&nbsp;&nbsp;$_SESSION[login_surname]&nbsp;&nbsp;ตำแหน่ง$_SESSION[login_userposition]</Td></Tr>";
echo "<Tr align='left'><Td align='right'>ได้ทำหน้าที่ขับรถ&nbsp;&nbsp;</Td><Td><Select  name='car'  size='1'>";
echo  "<option  value = ''>เลือกรถ</option>" ;
$sql = "select * from  car_car where status<='2' ";
$query = mysqli_query($connect,$sql);
While ($result = mysqli_fetch_array($query))
   {
		$car_code = $result['car_code'];
		$car_number= $result['car_number'];
		$name = $result['name'];
				if($car_code==$ref_result['car']){
				echo  "<option value = $car_code selected>$car_number $name</option>";
				}
				else{
				echo  "<option value = $car_code>$car_number $name</option>";
				}
	}
echo "</select>";
echo "</Td></Tr>";
echo "<Tr align='left'><Td align='right'>ไปราชการ(สถานที่)&nbsp;&nbsp;</Td><Td><Input Type='Text' Name='place' Size='60' value='$ref_result[place]'></Td></Tr>";
echo "<Tr align='left'><Td align='right'>เพื่อวัตถุประสงค์&nbsp;&nbsp;</Td><Td><Input Type='Text' Name='because' Size='80' value='$ref_result[because]'></Td></Tr>";
echo "<Tr align='left'><Td align='right'>ตั้งแต่วันที่&nbsp;&nbsp;</Td>";
echo "<Td align='left'>";
$car_start=explode("-", $ref_result['car_start']);
?>
		<script>
										var Y_date=<?php echo $car_start[0]?>
										var m_date=<?php echo $car_start[1]?>
										var d_date=<?php echo $car_start[2]?>
										Y_date= Y_date+'/'+m_date+'/'+d_date
										DateInput('car_start', true, 'YYYY-MM-DD', Y_date)</script>
<?php
echo "</Td></Tr>";
$time_start=number_format($ref_result['time_start'],2);
echo "<Tr align='left'><Td align='right'>&nbsp;&nbsp;เวลา</Td><Td><Input Type='Text' Name='time_start' Size='5' value='$time_start'>&nbspน.</Td></Tr>";
echo "<Tr align='left'><Td align='right'>ถึงวันที่&nbsp;&nbsp;</Td>";
echo "<Td align='left'>";

$car_finish=explode("-", $ref_result['car_finish']);
?>
<script>
										var Y_date=<?php echo $car_finish[0]?>
										var m_date=<?php echo $car_finish[1]?>
										var d_date=<?php echo $car_finish[2]?>
										Y_date= Y_date+'/'+m_date+'/'+d_date
										DateInput('car_finish', true, 'YYYY-MM-DD', Y_date)</script>
<?php
echo "</Td></Tr>";
$time_finish=number_format($ref_result['time_finish'],2);
echo "<Tr align='left'><Td align='right'>&nbsp;&nbsp;เวลา</Td><Td><Input Type='Text' Name='time_finish' Size='5' value='$time_finish'>&nbspน.</Td></Tr>";
echo "<Tr align='left'><Td align='right'>รวม&nbsp;&nbsp;</Td>";
echo "<Td><Input Type='Text' Name='day_total' Size='5'  value='$ref_result[day_total]'>&nbsp;&nbsp;วัน";
echo "<Tr align='left'><Td align='right'>มีผู้โดยสารทั้งหมด&nbsp;&nbsp;</Td><Td><Input Type='Text' Name='person_num' Size='5'  value='$ref_result[person_num]'>&nbsp;&nbsp;คน</Td></Tr>";
echo "<Tr align='left'><Td align='right'>ผู้ควบคุมรถคือ&nbsp;&nbsp;</Td><Td><Input Type='Text' Name='control_person' Size='60'  value='$ref_result[control_person]'></Td></Tr>";
echo "<Tr align='left'><Td align='right'>&nbsp;&nbsp;เลขเข็มไมล์เมื่อเริ่มเดินทาง</Td><Td>&nbsp<Input Type='Text' Name='start_mile' Size='20'  value='$ref_result[start_mile]'></Td></Tr>";
echo "<Tr align='left'><Td align='right'>&nbsp;&nbsp;เลขเข็มไมล์เมื่อสิ้นสุดการเดินทาง</Td><Td>&nbsp<Input Type='Text' Name='finish_mile' Size='20'  value='$ref_result[finish_mile]'></Td></Tr>";
echo "<Tr align='left'><Td align='right'>&nbsp;&nbsp;น้ำมันเชื้อเพลิงคงเหลือในถังเมื่อสิ้นสุดการเดินทาง</Td><Td>&nbsp<Input Type='Text' Name='fuel' Size='10'  value='$ref_result[fuel]'>&nbsp;ลิตร (ประมาณ)</Td></Tr>";
echo "<Tr align='left'><Td align='right'>&nbsp;&nbsp;สภาพการณ์</Td><Td>&nbsp<textarea rows='5' name='detail' cols='55'>$ref_result[detail]</textarea></Td></Tr>";
echo "</Table>";
echo "<Input Type=Hidden Name='id' Value='$_GET[id]'>";
echo "<Input Type=Hidden Name='page' Value='$_GET[page]'>";
echo "<Input Type=Hidden Name='car_index' Value='$car_index'>";
echo "<Br>";
echo "<INPUT TYPE='button' name='smb' value='ตกลง' onclick='goto_url_update(1)' class=entrybutton>
		&nbsp;&nbsp;<INPUT TYPE='button' name='back' value='ย้อนกลับ' onclick='goto_url_update(0)' class=entrybutton'>";
echo "</form>";
}
//ส่วนปรับปรุงข้อมูล
if ($index==6){
		$sql = "update car_report set car='$_POST[car]',
		place='$_POST[place]',
		because='$_POST[because]',
		car_start='$_POST[car_start]',
		time_start='$_POST[time_start]',
		car_finish='$_POST[car_finish]',
		time_finish='$_POST[time_finish]',
		day_total='$_POST[day_total]',
		person_num='$_POST[person_num]',
		control_person='$_POST[control_person]',
		start_mile='$_POST[start_mile]',
		finish_mile='$_POST[finish_mile]',
		fuel='$_POST[fuel]',
		detail='$_POST[detail]'
		where id='$_POST[id]'";
		$query = mysqli_query($connect,$sql);
}
if ($index==7){
echo "<Center>";
echo "<Font color='#006666' Size=3><B>รายละเอียด</B></Font>";
echo "</Cener>";
echo "<Br>";
echo "<Br>";
echo "<Table  align='center' width='80%' Border='0'>";
echo "<Tr ><Td colspan='2' align='right'><INPUT TYPE='button' name='smb' value='<<กลับหน้าก่อน' onclick='location.href=\"?option=car&task=main/car_report&page=$_GET[page]&car_index=$car_index\"'></Td></Tr>";
$sql = "select * from car_report where id='$_GET[id]'";
$query = mysqli_query($connect,$sql);
$ref_result = mysqli_fetch_array($query);
$id=$ref_result['id'];
$person_id=$ref_result['person_id'];
$rec_date=$ref_result['rec_date'];

// ชื่อและตำแหน่ง
$sql_name = "select * from person_main  left join  person_position  on  person_main.position_code=person_position.position_code  where  person_main.person_id='$person_id'";
$query_name = mysqli_query($connect,$sql_name);
$result_name = mysqli_fetch_array($query_name);
		$person_id = $result_name['person_id'];
		$prename=$result_name['prename'];
		$name= $result_name['name'];
		$surname = $result_name['surname'];
		$position_name = $result_name['position_name'];
		$full_name="$prename$name&nbsp;&nbsp;$surname";

echo "<Tr align='left'><Td align='right'>วันที่รายงาน&nbsp;&nbsp;</Td><Td>";
echo thai_date_4($rec_date);
echo "</Td></Tr>";
echo "<Tr align='left'><Td align='right'>ผู้รายงาน&nbsp;&nbsp;</Td><Td>$full_name&nbsp;&nbsp;&nbsp;ตำแหน่ง&nbsp;&nbsp;$position_name</Td></Tr>";
echo "<Tr align='left'><Td align='right'>ได้ทำหน้าที่ขับรถ&nbsp;&nbsp;</Td><Td><Select  name='car'  size='1'>";
echo  "<option  value = ''>เลือกรถ</option>" ;
$sql = "select * from  car_car where status='2' ";
$query = mysqli_query($connect,$sql);
While ($result = mysqli_fetch_array($query))
   {
		$car_code = $result['car_code'];
		$car_number= $result['car_number'];
		$name = $result['name'];
				if($car_code==$ref_result['car']){
				echo  "<option value = $car_code selected>$car_number $name</option>";
				}
				else{
				echo  "<option value = $car_code>$car_number $name</option>";
				}
	}
echo "</select>";
echo "</Td></Tr>";
echo "<Tr align='left'><Td align='right'>ไปราชการ(สถานที่)&nbsp;&nbsp;</Td><Td><Input Type='Text' Name='place' Size='60' value='$ref_result[place]'></Td></Tr>";
echo "<Tr align='left'><Td align='right'>เพื่อวัตถุประสงค์&nbsp;&nbsp;</Td><Td><Input Type='Text' Name='because' Size='80' value='$ref_result[because]'></Td></Tr>";
echo "<Tr align='left'><Td align='right'>ตั้งแต่วันที่&nbsp;&nbsp;</Td>";
echo "<Td align='left'>";
$car_start=explode("-", $ref_result['car_start']);
?>
		<script>
										var Y_date=<?php echo $car_start[0]?>
										var m_date=<?php echo $car_start[1]?>
										var d_date=<?php echo $car_start[2]?>
										Y_date= Y_date+'/'+m_date+'/'+d_date
										DateInput('car_start', true, 'YYYY-MM-DD', Y_date)</script>
<?php
echo "</Td></Tr>";
$time_start=number_format($ref_result['time_start'],2);
echo "<Tr align='left'><Td align='right'>&nbsp;&nbsp;เวลา</Td><Td><Input Type='Text' Name='time_start' Size='5' value='$time_start'>&nbspน.</Td></Tr>";
echo "<Tr align='left'><Td align='right'>ถึงวันที่&nbsp;&nbsp;</Td>";
echo "<Td align='left'>";

$car_finish=explode("-", $ref_result['car_finish']);
?>
<script>
										var Y_date=<?php echo $car_finish[0]?>
										var m_date=<?php echo $car_finish[1]?>
										var d_date=<?php echo $car_finish[2]?>
										Y_date= Y_date+'/'+m_date+'/'+d_date
										DateInput('car_finish', true, 'YYYY-MM-DD', Y_date)</script>
<?php
echo "</Td></Tr>";
$time_finish=number_format($ref_result['time_finish'],2);
echo "<Tr align='left'><Td align='right'>&nbsp;&nbsp;เวลา</Td><Td><Input Type='Text' Name='time_finish' Size='5' value='$time_finish'>&nbspน.</Td></Tr>";
echo "<Tr align='left'><Td align='right'>รวม&nbsp;&nbsp;</Td>";
echo "<Td><Input Type='Text' Name='day_total' Size='5'  value='$ref_result[day_total]'>&nbsp;&nbsp;วัน";
echo "<Tr align='left'><Td align='right'>มีผู้โดยสารทั้งหมด&nbsp;&nbsp;</Td><Td><Input Type='Text' Name='person_num' Size='5'  value='$ref_result[person_num]'>&nbsp;&nbsp;คน</Td></Tr>";
echo "<Tr align='left'><Td align='right'>ผู้ควบคุมรถคือ&nbsp;&nbsp;</Td><Td><Input Type='Text' Name='control_person' Size='60'  value='$ref_result[control_person]'></Td></Tr>";
echo "<Tr align='left'><Td align='right'>&nbsp;&nbsp;เลขเข็มไมล์เมื่อเริ่มเดินทาง</Td><Td>&nbsp<Input Type='Text' Name='start_mile' Size='20'  value='$ref_result[start_mile]'></Td></Tr>";
echo "<Tr align='left'><Td align='right'>&nbsp;&nbsp;เลขเข็มไมล์เมื่อสิ้นสุดการเดินทาง</Td><Td>&nbsp<Input Type='Text' Name='finish_mile' Size='20'  value='$ref_result[finish_mile]'></Td></Tr>";
echo "<Tr align='left'><Td align='right'>&nbsp;&nbsp;น้ำมันเชื้อเพลิงคงเหลือในถังเมื่อสิ้นสุดการเดินทาง</Td><Td>&nbsp<Input Type='Text' Name='fuel' Size='10'  value='$ref_result[fuel]'>&nbsp;ลิตร (ประมาณ)</Td></Tr>";
echo "<Tr align='left'><Td align='right'>&nbsp;&nbsp;สภาพการณ์</Td><Td>&nbsp<textarea rows='5' name='detail' cols='55'>$ref_result[detail]</textarea></Td></Tr>";
///////
echo "</table>";
}
//ส่วนแสดงผล
if(!(($index==1) or ($index==2) or ($index==5) or ($index==7))){

//ส่วนของการแยกหน้า
if($car_index>=1){
$sql="select id from car_report where car='$car_index' ";
}
else{
$sql="select id from car_report";
}
$query = mysqli_query($connect,$sql);
$num_rows = mysqli_num_rows($query);

$pagelen=20;  // 1_กำหนดแถวต่อหน้า
$url_link="option=car&task=main/car_report&car_index=$car_index";  // 2_กำหนดลิงค์ฺ
$totalpages=ceil($num_rows/$pagelen);

if(!isset($_REQUEST['page'])){
$_REQUEST['page']="";
}
if($_REQUEST['page']==""){
$page=$totalpages;
		if($page<2){
		$page=1;
		}
}
else{
		if($totalpages<$_REQUEST['page']){
		$page=$totalpages;
					if($page<1){
					$page=1;
					}
		}
		else{
		$page=$_REQUEST['page'];
		}
}
$start=($page-1)*$pagelen;
if(($totalpages>1) and ($totalpages<16)){
echo "<div align=center>";
echo "หน้า	";
			for($i=1; $i<=$totalpages; $i++)	{
					if($i==$page){
					echo "[<b><font size=+1 color=#990000>$i</font></b>]";
					}
					else {
					echo "<a href=$PHP_SELF?$url_link&page=$i>[$i]</a>";
					}
			}
echo "</div>";
}
if($totalpages>15){
			if($page <=8){
			$e_page=15;
			$s_page=1;
			}
			if($page>8){
					if($totalpages-$page>=7){
					$e_page=$page+7;
					$s_page=$page-7;
					}
					else{
					$e_page=$totalpages;
					$s_page=$totalpages-15;
					}
			}
			echo "<div align=center>";
			if($page!=1){
			$f_page1=$page-1;
			echo "<<a href=$PHP_SELF?$url_link&page=1>หน้าแรก </a>";
			echo "<<<a href=$PHP_SELF?$url_link&page=$f_page1>หน้าก่อน </a>";
			}
			else {
			echo "หน้า	";
			}
			for($i=$s_page; $i<=$e_page; $i++){
					if($i==$page){
					echo "[<b><font size=+1 color=#990000>$i</font></b>]";
					}
					else {
					echo "<a href=$PHP_SELF?$url_link&page=$i>[$i]</a>";
					}
			}
			if($page<$totalpages)	{
			$f_page2=$page+1;
			echo "<a href=$PHP_SELF?$url_link&page=$f_page2> หน้าถัดไป</a>>>";
			echo "<a href=$PHP_SELF?$url_link&page=$totalpages> หน้าสุดท้าย</a>>";
			}
			echo " <select onchange=\"location.href=this.options[this.selectedIndex].value;\" size=\"1\" name=\"select\">";
			echo "<option  value=\"\">หน้า</option>";
				for($p=1;$p<=$totalpages;$p++){
				echo "<option  value=\"?$url_link&page=$p\">$p</option>";
				}
			echo "</select>";
echo "</div>";
}
//จบแยกหน้า
if($car_index>=1){
$sql="select car_report.id, car_report.person_id, car_report.rec_date, car_report.place, car_report.finish_mile, car_report.fuel, car_car.car_number from car_report left join car_car on  car_report.car=car_car.car_code  where car_report.car='$car_index' order by car_report.rec_date  limit $start,$pagelen";
}
else{
$sql="select car_report.id, car_report.person_id, car_report.rec_date, car_report.place, car_report.finish_mile, car_report.fuel, car_car.car_number from car_report left join car_car on  car_report.car=car_car.car_code order by car_report.rec_date  limit $start,$pagelen";
}
$query = mysqli_query($connect,$sql);
    ?>
      <div class="panel-body">
        <form id='frm1' name='frm1' class="form-horizontal">
        <div class="row">
            <div class="col-md-10 text-left">
                <a href="?option=car&task=main/car_report&index=1" class="btn btn-primary"><span class="glyphicon glyphicon-plus"></span>&nbsp;บันทึกรายงานการใช้ยานพาหนะ</a>
            </div>
            <div class="col-md-2 text-right">
                <Select  name='car_index' class="form-control" onchange="goto_url2(1)">
                    <option value ="" >รถทุกคัน</option>
                    <?
    $sql_car = "SELECT car_code,name,car_number  FROM car_car where status<='2' ";
    $dbquery_car = mysqli_query($connect,$sql_car);
    While ($result_car = mysqli_fetch_array($dbquery_car )){
        $selected="";
        if ($car_index==$result_car ['car_code']) $selected="selected";
            echo "<option value=$result_car[car_code]  $selected>$result_car[car_number] $result_car[name]</option>";
    }
    ?>
    </select>
            </div>
       </div>
        </form>
          </div>
      <table class="table table-hover table-striped table-condensed table-responsive">
          <thead>
            <tr>
              <th>เลขที่</th>
              <th>วันรายงาน</th>
              <th>ผู้รายงาน</th>
              <th>รถ</th>
              <th>สถานที่ไปราชการ</th>
              <th>เข็มไมล์สุดท้าย(ก.ม.)</th>
              <th>น้ำมันคงเหลือ(ลิตร)</th>
              <th>รายละเอียด</th>
              <th>ลบ</th>
              <th>แก้ไข</th>
            </tr>
          </thead>
          <tbody>
        <?

$N=(($page-1)*$pagelen)+1; //*เกี่ยวข้องกับการแยกหน้า
$M=1;

While ($result = mysqli_fetch_array($query)){
		$id = $result['id'];
		$rec_date = $result['rec_date'];
		$finish_mile= $result['finish_mile'];
		$fuel = $result['fuel'];
?>
              <Tr bgcolor='$color'>
                  <Td valign='top' align='center'><?=$N?></Td>
                  <Td valign='top' align='left'><? echo thai_date_3($rec_date);?></Td>
                  <Td>
                      <?
			$sql_person = "select * from person_main where  person_id='$result[person_id]' ";
			$query_person  = mysqli_query($connect,$sql_person);
			$result_person = mysqli_fetch_array($query_person);
			echo "$result_person[prename]$result_person[name]&nbsp;&nbsp;$result_person[surname]";
?>
</Td>
                  <Td><?=$result['car_number']?></Td>
                  <Td><?=$result['place']?></Td>
                  <Td><?=$result['finish_mile']?></Td>
                  <Td><?=$result['fuel']?></Td>
                  <Td><a href=?option=car&task=main/car_report&index=7&id=$id&page=$page&car_index=$car_index><img src=images/browse.png border='0' alt='รายละเอียด'></Td>
<?
//กำหนดเวลาให้แก้ไขได้
$now=time();
$timestamp_recdate=make_time_2($rec_date);
$timestamp_recdate2=$timestamp_recdate+3600;
//////////////////////
if( $result['person_id']==$user and $now<$timestamp_recdate2){
echo "<Td valign='top' align='center'><a href=?option=car&task=main/car_report&index=2&id=$id&page=$page&car_index=$car_index><img src=images/drop.png border='0' alt='ลบ'></Td><Td valign='top'  align='center'><a href=?option=car&task=main/car_report&index=5&id=$id&page=$page&car_index=$car_index><img src=images/edit.png border='0' alt='แก้ไข'></a></Td>";
}
else{
echo "<td></td><td></td>";
}
?></Tr>
<?
$M++;
$N++;  //*เกี่ยวข้องกับการแยกหน้า
}
?>
    </tbody>
</Table>
<?
}

?>
    </div>
    </div>
<script>
function goto_url(val){
	if(val==0){
		callfrm("?option=car&task=main/car_report");   // page ย้อนกลับ
	}else if(val==1){
		if(frm1.car.value == ""){
		alert("กรุณาเลือกรถยนต์");
		}else if(frm1.place.value == ""){
		alert("กรุณากรอกสถานไปราชการ");
		}else if(frm1.finish_mile.value == ""){
		alert("กรุณากรอกเลขไมล์สิ้นสุดการเดินทาง");
		}else if(frm1.fuel.value == ""){
		alert("กรุณากรอกเชื้อเพลิงคงเหลือ");
		}else{
			callfrm("?option=car&task=main/car_report&index=4");   //page ประมวลผล
		}
	}
}

function goto_url_update(val){
	if(val==0){
		callfrm("?option=car&task=main/car_report");   // page ย้อนกลับ
	}else if(val==1){
		if(frm1.car.value == ""){
		alert("กรุณาเลือกรถยนต์");
		}else if(frm1.place.value == ""){
		alert("กรุณากรอกสถานไปราชการ");
		}else if(frm1.finish_mile.value == ""){
		alert("กรุณากรอกเลขไมล์สิ้นสุดการเดินทาง");
		}else if(frm1.fuel.value == ""){
		alert("กรุณากรอกเชื้อเพลิงคงเหลือ");
		}else{
			callfrm("?option=car&task=main/car_report&index=6");   //page ประมวลผล
		}
	}
}

function goto_url2(val){
callfrm("?option=car&task=main/car_report");
}

</script>
