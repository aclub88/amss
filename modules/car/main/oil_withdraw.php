<?php
/** ensure this file is being included by a parent file */
defined( '_VALID_' ) or die( 'Direct Access to this location is not allowed.' );
require_once "modules/car/time_inc.php";
?>
<script type="text/javascript" src="./css/js/calendarDateInput.js"></script>
<script language='javascript'>
//<!–
function printContentDiv(content){
var printReady = document.getElementById(content);
//var txt= 'nn';
var txt= '';
if (document.getElementsByTagName != null){
var txtheadTags = document.getElementsByTagName('head');
if (txtheadTags.length > 0){
var str=txtheadTags[0].innerHTML;
txt += str; // str.replace(/funChkLoad();/ig, ” “);
}
}
//txt += 'nn';
if (printReady != null){
txt += printReady.innerHTML;
}
//txt +='nn';
var printWin = window.open();
printWin.document.open();
printWin.document.write(txt);
printWin.document.close();
printWin.print();
}
// –>
</script>
<div id="lblPrint">
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
$dbquery_name = mysqli_query($connect,$sql_name);
while($result_name = mysqli_fetch_array($dbquery_name)){;
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
    ?><div class="panel-heading"><h3 class="panel-title">ใบเบิกน้ำมันเชื้อเพลิงและน้ำมันหล่อลื่น</h3></div><?
}
//ส่วนฟอร์มรับข้อมูล
if($index==1){
echo "<form id='frm1' name='frm1'>";
echo "<Center>";
echo "<Font color='#006666' Size=3><B>ใบเบิกน้ำมันเชื้อเพลิงและน้ำมันหล่อลื่น</Font>";
echo "</Cener>";
echo "<Br>";
$sql = "select * from car_main where id='$_GET[id]'";
$dbquery = mysqli_query($connect,$sql);
$ref_result = mysqli_fetch_array($dbquery);
			$sql_person = "select * from person_main where  person_id='$ref_result[person_id]' ";
			$dbquery_person  = mysqli_query($connect,$sql_person);
			$result_person = mysqli_fetch_array($dbquery_person);
			$sql_car = "select * from car_car where  car_code='$ref_result[car]' ";
			$dbquery_car  = mysqli_query($connect,$sql_car);
			$result_car= mysqli_fetch_array($dbquery_car);

echo "<Table width='80%'>";
echo "<Tr align='left'><Td align='right'>เรื่อง&nbsp;&nbsp;</Td><Td>ขออนุญาตเบิกน้ำมันเชื้อเพลิงและน้ำมันหล่อลื่น</Td></Tr>";
echo "<Tr align='left'><Td align='right'>เรียน&nbsp;&nbsp;</Td><Td>ผู้อำนวยการ$_SESSION[office_name]</Td></Tr>";
echo "<Tr align='left'><Td>&nbsp;</Td><Td>ตามที่อนุญาตให้&nbsp;<b>$result_person[prename]$result_person[name]&nbsp;&nbsp;$result_person[surname]</b>&nbsp;&nbsp;ใช้รถราชการหมายเลขทะเบียน&nbsp;<b>$result_car[car_number]&nbsp;($result_car[name])</b>  </Td></Tr>";
echo "<Tr align='left'><Td>&nbsp;</Td><Td>เพื่อ&nbsp;<b>$ref_result[because]</b>&nbsp;&nbsp;ในวันที่&nbsp;<b>";
echo thai_date($ref_result['car_start']);
echo "</b></Td></Tr>";
echo "<Tr align='left'><Td>&nbsp;</Td><Td>ถึงวันที่&nbsp;<b>";
echo thai_date($ref_result['car_finish']);
echo "</b>&nbsp;&nbsp;รวม&nbsp;&nbsp; <b>$ref_result[day_total]</b>&nbsp;&nbsp;วัน&nbsp;&nbsp;  ระยะทางไปราชการครั้งนี้ ไป-กลับ (ประมาณ)..........................  กิโลเมตร นั้น</Td></Tr>";
echo "<Tr align='left'><Td>&nbsp;</Td><Td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;เสนอข้อมูลประกอบการพิจารณาอนุญาตเติม&nbsp; (&nbsp;&nbsp;)น้ำมันดีเซล&nbsp;(&nbsp;&nbsp;)น้ำมันเบนซิล ครั้งนี้ ดังนี้ </Td></Tr>";
if($ref_result['fuel']==1){
$ref_result['project']="งบเชื้อเพลิงกลาง สพท.";
$ref_result['activity']="...........................";
}
else if($ref_result['fuel']==0){
$ref_result['project']="-";
$ref_result['activity']="-";
$ref_result['money']="-";
}
echo "<Tr align='left'><Td align='right' valign='top'>1.&nbsp;</Td><Td>ใช้งบประมาณโครงการ&nbsp; <b>$ref_result[project]</b>&nbsp;&nbsp;รหัสโครงการ................................<br />กิจกรรม&nbsp; <b>$ref_result[activity]</b>&nbsp;&nbsp;จำนวนเงิน&nbsp; <b>$ref_result[money]</b>&nbsp;&nbsp;บาท</Td></Tr>";
echo "<Tr align='left'><Td align='right'>2.&nbsp;</Td><Td>มาตรฐานของรถ</Td></Tr>";
echo "<Tr align='left'><Td>&nbsp;</Td><Td>ถังน้ำมันเชื้อเพลิงบรรจุได้เต็ม จำนวน..................ลิตร ความสิ้นเปลืองจำนวน 1 ลิตร ต่อ................กิโลเมตร</Td></Tr>";
echo "<Tr align='left'><Td align='right' valign='top'>3.&nbsp;</Td><Td>จากรายงานการใช้พาหนะครั้งสุดท้ายโดย.................................................</Td></Tr>";
echo "<Tr align='left'><Td align='right'></Td><Td>เลขเข็มไมล์ที่ปรากฎครั้งสุดท้าย คือ.............................................&nbsp;น้ำมันเชื้อเพลิงคงเหลือในถัง (โดยประมาณ)..............................ลิตร<br /><br /></Td></Tr>";
echo "<Tr align='left'><Td align='right'>&nbsp;</Td><Td>(ลงชื่อ)................................เจ้าหน้าที่&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;(ลงชื่อ).............................หน.กลุ่มงาน</Td></Tr>";
echo "<Tr align='left'><Td align='right'>&nbsp;</Td><Td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;($_SESSION[login_prename]$_SESSION[login_name]&nbsp;$_SESSION[login_surname])</Td></Tr>";
echo "<Tr align='left'><Td align='right'>&nbsp;</Td><Td>(ลงชื่อ)....................................................ผอ.กลุ่มอำนวยการ&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</Td></Tr>";
echo "<Tr align='left'><Td align='right'>&nbsp;</Td><Td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;(...................................................)</Td></Tr>";
echo "</Table>";
echo "<br>";

echo "<Table width='80%'>";
echo "<tr><td width='40%'>";
echo "<Table width='100%' border='1' cellspacing='0' cellpadding='0'>";
echo "<tr><td><b><br>&nbsp;คำรับรองงบประมาณ</b><br>";
echo "&nbsp;ได้รับจัดสรร.........................บาท<br>";
echo "&nbsp;เบิกจ่ายแล้ว...........................บาท<br>";
echo "&nbsp;ขณะนี้งบประมาณคงเหลือ<br />.....................บาท<br><br>";

echo "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;ลงชื่อ.........................เจ้าหน้าที่<br>";
echo "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;(......................................)<br>";
echo "<br>";
echo "<b>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;ความเห็น</b>&nbsp;ผอ.กลุ่มบริหารงานการเงินฯ<br><br>";
echo "&nbsp;..........................................................<br>";
echo "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;ลงชื่อ............................................<br>";
echo "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;(................................................)<br>";
echo "</td></tr>";
echo "<tr><td><br>&nbsp;ได้รับน้ำมันเชื้อเพลิงแล้วตามบิลน้ำมัน<br><br>";
echo "เลขที่........................จำนวน............ลิตร<br><br>";
echo "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;ลงชื่อ......................................ผู้รับ<br>";
echo "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;(...............................................)<br>";
echo "<br>";
echo "</td></tr>";
echo "</Table>";
echo "</td>";
echo "<td valign='top'>";
echo "&nbsp;&nbsp;&nbsp;<b>เห็นควรอนุมัติ</b>........................................................<br><br><br>";
echo "&nbsp;&nbsp;&nbsp;ลงชื่อ......................................................<br /><br />";
echo "&nbsp;&nbsp;&nbsp;(................................................................)<br><br><br>";
echo "&nbsp;&nbsp;&nbsp;<b>ความเห็นผู้บังคับบัญชา</b><br><br>";
echo "&nbsp;&nbsp;&nbsp;...............................................................................<br><br>";
echo "&nbsp;&nbsp;&nbsp;(&nbsp;&nbsp;)&nbsp;อนุมัติ&nbsp;&nbsp;&nbsp;&nbsp;(&nbsp;&nbsp;)&nbsp;ไม่อนุมัติ<br><br><br>";
echo "&nbsp;&nbsp;&nbsp;ลงชื่อ......................................................<br /><br />";
echo "&nbsp;&nbsp;&nbsp;(................................................................)<br><br>";

echo "</td><tr>";
echo "</Table>";
echo "<Input Type=Hidden Name='page' Value='$_GET[page]'>";
echo "<Input Type=Hidden Name='car_index' Value='$car_index'>";
?>
</div>
<div align='center'>
<a href="javascript:printContentDiv('lblPrint');"><img src="modules/car/images/b_print.png" border='0'> พิมพ์</a>
<?php
echo "&nbsp;&nbsp;<INPUT TYPE='button' name='back' value='ย้อนกลับ' onclick='goto_url(0)'>";
echo "</div>";
echo "</form>";
}
if ($index==7){
echo "<Center>";
echo "<Font color='#006666' Size=3><B>รายละเอียด</B></Font>";
echo "</Cener>";
echo "<Br>";
echo "<Br>";
echo "<Table  align='center' width='80%' Border='0'>";
echo "<Tr ><Td colspan='2' align='right'><INPUT TYPE='button' name='smb' value='<<กลับหน้าก่อน' onclick='location.href=\"?option=car&task=main/oil_withdraw&page=$_GET[page]&car_index=$car_index\"'></Td></Tr>";
$sql = "select * from car_main where id='$_GET[id]'";
$dbquery = mysqli_query($connect,$sql);
$ref_result = mysqli_fetch_array($dbquery);
$id=$ref_result['id'];
$person_id=$ref_result['person_id'];
$rec_date=$ref_result['rec_date'];

// ชื่อและตำแหน่ง
$sql_name = "select * from person_main  left join  person_position  on  person_main.position_code=person_position.position_code  where  person_main.person_id='$person_id'";
$dbquery_name = mysqli_query($connect,$sql_name);
$result_name = mysqli_fetch_array($dbquery_name);
		$person_id = $result_name['person_id'];
		$prename=$result_name['prename'];
		$name= $result_name['name'];
		$surname = $result_name['surname'];
		$position_name = $result_name['position_name'];
		$full_name="$prename$name&nbsp;&nbsp;$surname";

echo "<Tr align='left'><Td align='right'>วันที่&nbsp;&nbsp;</Td><Td>";
echo thai_date_3($rec_date);
echo "</Td></Tr>";
echo "<Tr align='left'><Td align='right'>เรื่อง&nbsp;&nbsp;</Td><Td>ขออนุญาตใช้รถราชการ</Td></Tr>";
echo "<Tr align='left'><Td align='right'>เรียน&nbsp;&nbsp;</Td><Td>ผู้อำนวยการ$_SESSION[office_name]</Td></Tr>";
echo "<Tr align='left'><Td align='right'>ข้าพเจ้า&nbsp;&nbsp;</Td><Td>$full_name&nbsp;&nbsp;ตำแหน่ง&nbsp;&nbsp;$position_name</Td></Tr>";
echo "<Tr align='left'><Td align='right'>ขออนุญาตใช้รถราชการ&nbsp;&nbsp;</Td><Td><Select  name='car'  size='1'>";
echo  "<option  value = ''>เลือกรถ</option>" ;
$sql = "select * from  car_car where status='2' ";
$dbquery = mysqli_query($connect,$sql);
While ($result = mysqli_fetch_array($dbquery))
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
////ภาพ
$sql_pic = "select * from  car_car where car_code='$ref_result[car]' ";
$dbquery_pic = mysqli_query($connect,$sql_pic);
$result_pic = mysqli_fetch_array($dbquery_pic);
echo "<tr><td></td><td align='left'><img src='$result_pic[pic]' width='150'></td></tr>";
////
echo "<Tr align='left'><Td align='right'>สถานที่ไปราชการ&nbsp;&nbsp;</Td><Td><Input Type='Text' Name='place' Size='60' value='$ref_result[place]'></Td></Tr>";
echo "<Tr align='left'><Td align='right'>วัตถุประสงค์&nbsp;&nbsp;</Td><Td><Input Type='Text' Name='because' Size='60' value='$ref_result[because]'></Td></Tr>";
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
echo "<Td><Input Type='Text' Name='day_total' Size='5' value='$ref_result[day_total]'>&nbsp;&nbsp;วัน";
echo "<Tr align='left'><Td align='right'>มีผู้โดยสารทั้งหมด&nbsp;&nbsp;</Td><Td><Input Type='Text' Name='person_num' Size='5'  value='$ref_result[person_num]'>&nbsp;&nbsp;คน</Td></Tr>";
echo "<Tr align='left'><Td align='right'>ผู้ควบคุมรถคือ&nbsp;&nbsp;</Td><Td><Input Type='Text' Name='control_person' Size='60'  value='$ref_result[control_person]'></Td></Tr>";
$fuel_check_1="";
$fuel_check_2="";
$fuel_check_3="";
if($ref_result['fuel']==1){
$fuel_check_2="checked";
}
else if ($ref_result['fuel']==2){
$fuel_check_3="checked";
}
else {
$fuel_check_1="checked";
}
echo "<Tr align='left'><Td align='right'>เชื้อเพลิง&nbsp;&nbsp;</Td><Td><Input Type='radio' Name='fuel'  value='0' $fuel_check_1>ไม่ขอใช้จากงบเชื้อเพลิงกลาง สพท.</Td></Tr>";
echo "<Tr align='left'><Td align='right'>&nbsp;&nbsp;</Td><Td><Input Type='radio' Name='fuel'  value='1' $fuel_check_2>ขอใช้จากงบเชื้อเพลิงกลางของ สพท.</Td></Tr>";
echo "<Tr align='left'><Td align='right'>&nbsp;&nbsp;</Td><Td><Input Type='radio' Name='fuel'  value='2' $fuel_check_3>ขอใช้จากงบเชื้อเพลิงจากโครงการ&nbsp;<Input Type='Text' Name='project' Size='40' value='$ref_result[project]'>&nbsp;&nbsp;กิจกรรม&nbsp;<Input Type='Text' Name='activity' Size='40' value='$ref_result[activity]'></Td></Tr>";
echo "<Tr align='left'><Td></Td><Td>&nbsp;&nbsp;&nbsp;&nbsp;จำนวนเงิน&nbsp;<Input Type='Text' Name='money' Size='10'  value='$ref_result[money]'>&nbsp;บาท .</Td></Tr>";

if( $ref_result['self_driver']==1){
$self_driver_check="checked";
}
else{
$self_driver_check="";
}
echo "<Tr align='left'><Td align='right'>กรณีไม่มีพนักงานขับรถ&nbsp;&nbsp;</Td><Td><Input Type='checkbox' Name='self_driver'  value='1' $self_driver_check>ขออนุญาตเป็นผู้ขับรถคันดังกล่าว  ซึ่งได้รับใบอนุญาตในการขับขี่รถจากทางราชการประเภทนี้</Td></Tr>";
if( $ref_result['private_car']==1){
$private_car_check="checked";
}
else{
$private_car_check="";
}
echo "<Tr align='left'><Td align='right'>กรณีรถราชการไม่ว่าง&nbsp;&nbsp;</Td><Td><Input Type='checkbox' Name='private_car'  value='1' $private_car_check>ขออนุญาตใช้ส่วนส่วนตัวของ&nbsp<Input Type='Text' Name='car_owner' Size='40'  value='$ref_result[car_owner]'></Td></Tr>";
echo "<Tr align='left'><Td align='right'>&nbsp;&nbsp;</Td><Td>หมายเลขทะเบียน&nbsp<Input Type='Text' Name='private_car_number' Size='40'  value='$ref_result[private_car_number]'></Td></Tr>";
echo "<Tr align='left'><Td align='right'>&nbsp;&nbsp;</Td><Td>ผู้ขับขี่&nbsp<Input Type='Text' Name='private_driver' Size='40'  value='$ref_result[private_driver]'></Td></Tr>";
///////
echo "<tr><td colspan='2'>";
echo "<fieldset>";
echo "<legend>&nbsp;<B>ส่วนเจ้าหน้าที่</B>: &nbsp;</legend>";
echo "<table>";
echo "<Tr align='left'><Td align='right'>เห็นควรให้&nbsp;&nbsp;</Td>";
echo "<td><div align='left'><Select  name='driver'  size='1'>";
echo  "<option  value = ''>เลือก</option>" ;
$sql_driver= "select  car_driver.person_id, person_main.prename, person_main.name, person_main.surname from car_driver left join person_main  on car_driver.person_id=person_main.person_id ";
$dbquery_driver = mysqli_query($connect,$sql_driver);
While ($result_driver = mysqli_fetch_array($dbquery_driver))
   {
		$person_id = $result_driver['person_id'];
		$prename = $result_driver['prename'];
		$name = $result_driver['name'];
		$surname = $result_driver['surname'];
		if($person_id==$ref_result['driver']){
		echo  "<option value = $person_id selected>$prename$name $surname</option>" ;
		}
		else{
		echo  "<option value = $person_id>$prename$name $surname</option>" ;
		}
	}
echo "</select>";
echo "&nbsp;เป็นพนักงานขับรถในราชการนี้</div></td></tr>";
echo "<Tr align='left'><Td align='right'>&nbsp;&nbsp;</Td><Td><Input Type='Text' Name='officer_comment' Size='80' value='$ref_result[officer_comment]'></Td></Tr>";
$officer_sign=$ref_result['officer_sign'];
echo "<Tr align='left'><Td align='right'>ลงชื่อ&nbsp;&nbsp;</Td><Td>$full_name_ar[$officer_sign]</Td></Tr>";
echo "<Tr align='left'><Td align='right'>วดป&nbsp;&nbsp;</Td><Td>";
echo  thai_date_4($ref_result['officer_date']);
echo "</Td></Tr>";
echo "</table></fieldset>";
echo "</tr>";
///////
///////
echo "<tr><td colspan='2'>";
echo "<fieldset>";
echo "<legend>&nbsp;<B>ส่วนความเห็นชอบ</B>: &nbsp;</legend>";
echo "<table>";
echo "<Tr align='left'><Td align='right'>ความเห็น&nbsp;&nbsp;</Td><Td><Input Type='Text' Name='group_comment' Size='80' value='$ref_result[group_comment]'></Td></Tr>";
$group_sign=$ref_result['group_sign'];
echo "<Tr align='left'><Td align='right'>ลงชื่อ&nbsp;&nbsp;</Td><Td>";
if(isset($full_name_ar[$group_sign])){
echo $full_name_ar[$group_sign];
}
echo "</Td></Tr>";
echo "<Tr align='left'><Td align='right'>วดป&nbsp;&nbsp;</Td><Td>";
echo  thai_date_4($ref_result['group_date']);
echo "</Td></Tr>";
echo "</table></fieldset>";
echo "</tr>";
///////
///////
echo "<tr><td colspan='2'>";
echo "<fieldset>";
echo "<legend>&nbsp;<B>ส่วนการอนุมัติ</B>: &nbsp;</legend>";
echo "<table>";
echo "<Tr align='left'><Td align='right'>คำสั่ง(ถ้ามี)&nbsp;&nbsp;</Td><Td><Input Type='Text' Name='grant_comment' Size='80' value='$ref_result[grant_comment]'></Td></Tr>";
		$commander_grant_check1=""; $commander_grant_check2="";
		if($ref_result['commander_grant']==1){
		$commander_grant_check1="checked";
		}
		else if($ref_result['commander_grant']==2){
		$commander_grant_check2="checked";
		}
echo "<Tr align='left'><Td align='right'>อนุมัติ/ไม่อนุมัติ&nbsp;&nbsp;</Td><Td><Input Type='radio' Name='commander_grant' value='1' $commander_grant_check1>อนุมัติ&nbsp;&nbsp;<Input Type='radio' Name='commander_grant' value='2' $commander_grant_check2>ไม่อนุมัติ&nbsp;&nbsp;</Td></Tr>";
$commander_sign=$ref_result['commander_sign'];
echo "<Tr align='left'><Td align='right'>ลงชื่อ&nbsp;&nbsp;</Td><Td>$full_name_ar[$commander_sign]</Td></Tr>";
echo "<Tr align='left'><Td align='right'>วดป&nbsp;&nbsp;</Td><Td>";
echo  thai_date_4($ref_result['commander_date']);
echo "</Td></Tr>";
echo "</table></fieldset>";
echo "</tr>";

///////
echo "</table>";
}
//ส่วนแสดงผล
if(!(($index==1) or ($index==2) or ($index==5) or ($index==7))){
//ส่วนของการแยกหน้า
if($car_index>=1){
$sql="select id from car_main where car='$car_index' ";
}
else{
$sql="select id from car_main";
}
$dbquery = mysqli_query($connect,$sql);
$num_rows = mysqli_num_rows($dbquery);

$pagelen=20;  // 1_กำหนดแถวต่อหน้า
$url_link="option=car&task=main/oil_withdraw&car_index=$car_index";  // 2_กำหนดลิงค์ฺ
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
$sql="select car_main.id, car_main.person_id, car_main.car_start, car_main.car_finish, car_main.rec_date, car_main.officer_sign, car_main.group_sign, car_main.commander_sign, car_main.commander_grant, car_car.name  from car_main left join car_car on  car_main.car=car_car.car_code  where car_main.car='$car_index' order by car_start, car_car.car_code limit $start,$pagelen";
}
else{
$sql="select car_main.id, car_main.person_id, car_main.car_start, car_main.car_finish, car_main.rec_date, car_main.officer_sign, car_main.group_sign, car_main.commander_sign, car_main.commander_grant, car_car.name  from car_main left join car_car on  car_main.car=car_car.car_code order by car_start, car_car.car_code limit $start,$pagelen";
}
$dbquery = mysqli_query($connect,$sql);
    ?>
      <div class="panel-body">
        <form id='frm1' name='frm1' class="form-horizontal">
        <div class="row">
            <div class="col-md-10 text-left">
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
              <th>วันเริ่มใช้รถ</th>
              <th>วันสิ้นสุดการใช้</th>
              <th>รถ</th>
              <th>ผู้ขอใช้</th>
              <th>วดป ขออนุญาต</th>
              <th>อนุมัติ/คำสั่ง</th>
              <th>รายละเอียด</th>
              <th>เขียนใบเบิก</th>
            </tr>
          </thead>
          <tbody>
        <?
$N=(($page-1)*$pagelen)+1; //*เกี่ยวข้องกับการแยกหน้า
$M=1;

While ($result = mysqli_fetch_array($dbquery)){
		$id = $result['id'];
		$person_id = $result['person_id'];
		$car_start = $result['car_start'];
		$car_finish = $result['car_finish'];
		$rec_date = $result['rec_date'];
		$officer_sign = $result['officer_sign'];
		$group_sign = $result['group_sign'];
		$grant = $result['commander_grant'];
		$commander_sign = $result['commander_sign'];
			?>
<Tr>
    <Td><?=$N?></Td>
    <Td><?echo thai_date_3($car_start);?></Td>
    <Td><?echo thai_date_3($car_finish);?></Td>
    <Td><?=$result['name']?></Td>
    <Td><?echo $full_name_ar[$person_id];?></Td>
    <Td><?echo thai_date_3($rec_date);?></Td>
    <Td>
<?
if($grant==1){echo "<img src=images/yes.png border='0'>";}
else if($grant==2){echo "<img src=images/no.png border='0'>";}
else{echo "รออนุมัติ";}
?>
    </Td>
<Td><a href=?option=car&task=main/oil_withdraw&index=7&id=<?=$id?>&page=<?=$page?>&car_index=<?=$car_index?> class='btn btn-primary'><span class='glyphicon glyphicon-file' ></span></a></Td>
<?
if($commander_sign!=""){
echo "<Td><a href=?option=car&task=main/oil_withdraw&index=1&id=$id&page=$page&car_index=$car_index><img src=images/edit.png border='0' alt='เขียนใบเบิก'></a></Td>";
}else{
echo "<td></td>";
}
?>
        </Tr>
<?
$M++;
$N++;  //*เกี่ยวข้องกับการแยกหน้า
}
?>
          </tbody>
          </Table>
<?}?>
<script>
function goto_url(val){
	if(val==0){
		callfrm("?option=car&task=main/oil_withdraw");   // page ย้อนกลับ
	}else if(val==1){
		if(frm1.car.value == ""){
		alert("กรุณาเลือกรถยนต์");
		}else if(frm1.place.value == ""){
		alert("กรุณากรอกสถานไปราชการ");
		}else if(frm1.because.value == ""){
		alert("กรุณากรอกวัตถุประสงค์");
		}else if(frm1.control_person.value == ""){
		alert("กรุณากรอกผู้ควบคุมรถ");
		}else{
			callfrm("?option=car&task=main/oil_withdraw&index=4");   //page ประมวลผล
		}
	}
}
function goto_url_update(val){
	if(val==0){
		callfrm("?option=car&task=main/oil_withdraw");   // page ย้อนกลับ
	}else if(val==1){
		if(frm1.car.value == ""){
		alert("กรุณาเลือกรถยนต์");
		}else if(frm1.place.value == ""){
		alert("กรุณากรอกสถานไปราชการ");
		}else if(frm1.because.value == ""){
		alert("กรุณากรอกวัตถุประสงค์");
		}else if(frm1.control_person.value == ""){
		alert("กรุณากรอกผู้ควบคุมรถ");
		}else{
			callfrm("?option=car&task=main/oil_withdraw&index=6");   //page ประมวลผล
		}
	}
}
function goto_url2(val){
callfrm("?option=car&task=main/oil_withdraw");
}
</script>
