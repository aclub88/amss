<link rel="stylesheet" href="//netdna.bootstrapcdn.com/bootstrap/3.3.2/css/bootstrap.min.css">
<link rel="stylesheet" href="//netdna.bootstrapcdn.com/font-awesome/3.2.1/css/font-awesome.min.css">

<?php
/** ensure this file is being included by a parent file */
defined( '_VALID_' ) or die( 'Direct Access to this location is not allowed.' );
$admin_meeting=mysqli_real_escape_string($connect,$_SESSION['admin_meeting']);
if($admin_meeting!="meeting"){
exit();
}

//หาหน่วยงาน
$login_user_id=mysqli_real_escape_string($connect,$_SESSION['login_user_id']);
$system_user_department=mysqli_real_escape_string($connect,$_SESSION['system_user_department']);
$system_user_department_name=mysqli_real_escape_string($connect,$_SESSION['system_user_department_name']);

//ส่วนหัว
echo "<br />";
if(!(($index==1) or ($index==2) or ($index==5))){
echo "<table width='50%' border='0' align='center' >";
echo "<tr align='center'><td><font color='#006666' size='3'><strong>กำหนดห้องประชุม";
echo "<BR>ของ ".$system_user_department_name." </strong></font></td></tr>";
echo "</table>";
echo "<br>";
}

//ส่วนฟอร์มรับข้อมูล
if(isset($_GET['index'])){
$getindex=mysqli_real_escape_string($connect,$_GET['index']);
}else {$getindex="";}

if($getindex==1){

$sql= "select max(room_code) as room_codemax from meeting_room order by id";
    $dbquery = $connect->prepare($sql);
    //$dbquery->bind_param("i", $system_user_department);
    $dbquery->execute();
    $result_max=$dbquery->get_result();
    while ($result = mysqli_fetch_array($result_max))
    //while($result_departname = $result->fetch_array())
   {
        $room_codemax = $result['room_codemax']+1; }

echo "<form id='frm1' name='frm1'>";
echo "<Center>";
echo "<Font color='#006666' Size=3><B>เพิ่มห้องประชุม</Font>";
echo "</Cener>";
echo "<Br><Br>";
echo "<Table width='50%' Border='0' Bgcolor='#Fcf9d8' class='table table-hover table-bordered table-striped table-condensed'>";
echo "<Tr><Td width='30%' align='right'>ชื่อห้องประชุม&nbsp;&nbsp;</Td>";
echo "<td><div align='left'><Input id='room_name' Type='Text' Name='room_name' Size='30'>*";
echo "</div></td></tr>";
echo "<Tr><Td align='right'>ที่นั่งทั้งหมด&nbsp;&nbsp;</Td>";
echo "<td><div align='left'><Input id='person_max' Type='Text' Name='person_max' Size='8' onkeypress=check_number();>";
echo "&nbsp; คน*</td></TR>";
echo "<Tr><Td align='right'>รายละเอียดอื่นๆ&nbsp;&nbsp;</Td>";
echo "<td><div align='left'><Input id='room_detail' Type='Text' Name='room_detail' Size='50'>";
echo "</div></td></tr>";
echo "<Input id='room_code' Type='Hidden' Name='room_code' value='$room_codemax'>";
/* เฟส2 ค่อยทำ
echo "<Tr><Td align='right'>ผู้ควบคุมห้อง&nbsp;&nbsp;</Td>";
echo "<td><div align='left'><Input id='room_controller' Type='Text' Name='room_controller' Size='30'>";
echo "</div></td></tr>";
echo "<Tr><Td align='right'>รูปภาพ&nbsp;&nbsp;</Td>";
echo "<td><div align='left'>INPUT_IMAGES";
echo "</div></td></tr>";
*/
echo   "<tr><td align='right'>อนุญาตเปิดให้ใช้งาน&nbsp;&nbsp;</td>";
echo   "<td align='left'>&nbsp;&nbsp;ใช่&nbsp;&nbsp;<input  type=radio name='active' value='1' checked>&nbsp;&nbsp;ไม่ใช่&nbsp;&nbsp;<input  type=radio name='active' value='0' ></td></tr>";

echo "<tr><td align='center' colspan='2'><INPUT TYPE='button' name='smb' value='ตกลง' onclick='goto_url(1)' class=entrybutton>
	&nbsp;&nbsp;&nbsp;";
echo "&nbsp;&nbsp;&nbsp;&nbsp;<INPUT TYPE='button' name='back' value='ย้อนกลับ' onclick='goto_url(0)' class=entrybutton'></td></tr>";
echo "</Table>";
echo "</form>";
}

//ส่วนยืนยันการลบข้อมูล
if($getindex==2) {
if(isset($_GET['id'])){
$getid=mysqli_real_escape_string($connect,$_GET['id']);
}else {$getid=""; exit;}

echo "<table width='500' border='0' align='center'>";
echo "<tr><td align='center'><font color='#990000' size='4'>โปรดยืนยันความต้องการลบข้อมูลอีกครั้ง</font><br></td></tr>";
echo "<tr><td align=center>";
echo "<form id='frm1' name='frm1' action='?option=meeting&task=main/set_room&index=3' method='post'> ";
echo "<Input id='iddel' Type='Hidden' Name='iddel' value='$getid'>";
echo "<INPUT TYPE='submit' name='smb' value='ยืนยัน'>
		&nbsp;&nbsp;<INPUT TYPE='button' name='back' value='ยกเลิก' onclick='location.href=\"?option=meeting&task=main/set_room\"'";
echo "</form>";
echo "</td></tr></table>";
}

//ส่วนลบข้อมูล
if($getindex==3){
if(isset($_POST['iddel'])){
$postiddel=mysqli_real_escape_string($connect,$_POST['iddel']);
}else {$postiddel=""; exit;}

$sql = "update meeting_room  set active='99' where id=?";
    $dbquery = $connect->prepare($sql);
    $dbquery->bind_param("i", $postiddel);
    $dbquery->execute();
    $result=$dbquery->get_result();
echo "<script>document.location.href='?option=meeting&task=main/set_room'; </script>\n";
}

//ส่วนบันทึกข้อมูล
if($getindex==4){
if(isset($_POST['room_code'])){
$room_code=mysqli_real_escape_string($connect,$_POST['room_code']);
}else {$room_code=""; exit;}
if(isset($_POST['room_name'])){
$room_name=mysqli_real_escape_string($connect,$_POST['room_name']);
}else {$room_name=""; exit;}
if(isset($_POST['person_max'])){
$person_max=mysqli_real_escape_string($connect,$_POST['person_max']);
}else {$person_max=""; exit;}
if(isset($_POST['room_detail'])){
$room_detail=mysqli_real_escape_string($connect,$_POST['room_detail']);
}else {$room_detail=""; exit;}
if(isset($_POST['active'])){
$active=mysqli_real_escape_string($connect,$_POST['active']);
}else {$active=""; exit;}

//$rec_date = date("Y-m-d");
$sql= "select max(room_code) as room_codemax from meeting_room order by id";
    $dbquery = $connect->prepare($sql);
    //$dbquery->bind_param("i", $postiddel);
    $dbquery->execute();
    $result_max=$dbquery->get_result();
While ($result = mysqli_fetch_array($result_max))
    {
$room_codemax = $result['room_codemax']; }
$sql = "insert into meeting_room ( id, room_code, room_name, department ,person_max,room_detail,active) values (?,?,?,?,?,?,?)";
    $dbquery = $connect->prepare($sql);
    $dbquery->bind_param("sssiisi",$room_code,$room_code,$room_name,$system_user_department,$person_max,$room_detail,$active);
    $dbquery->execute();
    $result=$dbquery->get_result();
echo "<script>document.location.href='?option=meeting&task=main/set_room'; </script>\n";
}

//ส่วนฟอร์มแก้ไขข้อมูล
if ($getindex==5){
if(isset($_GET['id'])){
$getid=mysqli_real_escape_string($connect,$_GET['id']);
}else {$getid=""; exit;}

echo "<form id='frm1' name='frm1'>";
echo "<Center>";
echo "<Font color='#006666' Size=3><B>แก้ไข การกำหนดห้องประชุม</B></Font>";
echo "</Cener>";
echo "<Br><Br>";
echo "<Table width='50%' Border= '0' Bgcolor='#Fcf9d8' class='table table-hover table-bordered table-striped table-condensed' >";
$sql = "select * from meeting_room where id=?";
    $dbquery = $connect->prepare($sql);
    $dbquery->bind_param("i", $getid);
    $dbquery->execute();
    $result_meeting=$dbquery->get_result();
    $ref_result = mysqli_fetch_array($result_meeting);
			if($ref_result['active']==1){
			$active_check1="checked";
			$active_check2="";
			}
			else{
			$active_check1="";
			$active_check2="checked";
			}

echo "<Tr><Td width='30%' align='right'>ชื่อห้องประชุม&nbsp;&nbsp;</Td>";
echo "<td><div align='left'><Input id='room_name' Type='Text' Name='room_name' Size='30' value='$ref_result[room_name]'>*";
echo "</div></td></tr>";
echo "<Tr><Td align='right'>ที่นั่งทั้งหมด&nbsp;&nbsp;</Td>";
echo "<td><div align='left'><Input id='person_max' Type='Text' Name='person_max' Size='8' value='$ref_result[person_max]' onkeypress=check_number();>";
echo "&nbsp; คน*</td></tr>";
echo "<Tr><Td align='right'>รายละเอียดอื่นๆ&nbsp;&nbsp;</Td>";
echo "<td><div align='left'><Input id='room_detail' Type='Text' Name='room_detail' Size='50' value='$ref_result[room_detail]'>";
echo "</div></td></tr>";
echo   "<tr><td align='right'>อนุญาตให้ใช้งาน&nbsp;&nbsp;</td>";
echo   "<td align='left'>&nbsp;&nbsp;ใช่&nbsp;&nbsp;<input  type=radio name='active' value='1' $active_check1>&nbsp;&nbsp;ไม่ใช่&nbsp;&nbsp;<input  type=radio name='active' value='0' $active_check2></td></tr>";

/* เฟส2 ค่อยทำ
echo "<Tr><Td align='right'>ผู้ควบคุมห้อง&nbsp;&nbsp;</Td>";
echo "<td><div align='left'><Input id='room_controller' Type='Text' Name='room_controller' Size='30'>";
echo "</div></td></tr>";
echo "<Tr><Td align='right'>รูปภาพ&nbsp;&nbsp;</Td>";
echo "<td><div align='left'>INPUT_IMAGES";
echo "</div></td></tr>";
*/
echo "<tr><td align='center' colspan='2'><INPUT TYPE='button' name='smb' value='ตกลง' onclick='goto_url_update(1)' class=entrybutton>&nbsp;&nbsp;";
echo "&nbsp;&nbsp;&nbsp;&nbsp;<INPUT TYPE='button' name='back' value='ย้อนกลับ' onclick='goto_url_update(0)' class=entrybutton'></td></tr>";
echo "</Table>";
echo "<Br>";
echo "<Input Type=Hidden id='id' Name='id' Value='$getid'>";
echo "</form>";
}

//ส่วนปรับปรุงข้อมูล
if ($getindex==6){

if(isset($_POST['id'])){
$postid=mysqli_real_escape_string($connect,$_POST['id']);
}else {$postid=""; exit;}

if(isset($_POST['room_name'])){
$room_name=mysqli_real_escape_string($connect,$_POST['room_name']);
}else {$room_name=""; exit;}
if(isset($_POST['person_max'])){
$person_max=mysqli_real_escape_string($connect,$_POST['person_max']);
}else {$person_max=""; exit;}
if(isset($_POST['room_detail'])){
$room_detail=mysqli_real_escape_string($connect,$_POST['room_detail']);
}else {$room_detail=""; exit;}
if(isset($_POST['active'])){
$active=mysqli_real_escape_string($connect,$_POST['active']);
}else {$active=""; exit;}

$sql = "update meeting_room  set  room_name=?, person_max=?, room_detail=?, active=? where id=?";
    $dbquery = $connect->prepare($sql);
    $dbquery->bind_param("sisii", $room_name,$person_max,$room_detail,$active,$postid);
    $dbquery->execute();
    $result=$dbquery->get_result();
}

//ส่วนแสดงผล
if(!(($getindex==1) or ($getindex==2) or ($getindex==5))){

$sql= "select * from meeting_room where department=? and (active='1' or active ='0') order by id ";
    $dbquery = $connect->prepare($sql);
    $dbquery->bind_param("i", $system_user_department);
    $dbquery->execute();
    $result_dep=$dbquery->get_result();
echo  "<table width=50% border=0 align=center class='table table-hover table-bordered table-striped table-condensed'>";
echo "<Tr><Td colspan='6' align='left'><INPUT TYPE='button' name='smb' value='เพิ่มห้องประชุม' onclick='location.href=\"?option=meeting&task=main/set_room&index=1\"'</Td></Tr>";
echo "<Tr bgcolor='#FFCCCC'><Td  align='center'>ที่</Td><Td  align='center' >ชื่อห้องประชุม</Td><td align='center'>จำนวนคนสูงสุด</td><td align='center'>สถานะ</td><Td align='center' width='50'>แก้ไข</Td><Td align='center' width='50'>ลบห้องประชุม</Td></Tr>";
$M=1;
While ($result = mysqli_fetch_array($result_dep))
	{
		$id = $result['id'];
		$room_code = $result['room_code'];
		$room_name = $result['room_name'];
		$person_max = $result['person_max'];
		$active = $result['active'];
			if($active==1){
			$active_text="<font color='#0033FF'>เปิดใช้งาน</font>";
			}
			else{
			$active_text="<font color='#FF0033'>ปิดใช้งาน</font>";
			}

			if(($M%2) == 0)
			$color="#FFFFC";
			else $color="#FFFFFF";
		echo "<Tr bgcolor=$color><Td align='center' width='50'>$M</Td><Td  align='left'>$room_name </Td><Td align='center'>$person_max คน</Td><Td align='center'>$active_text</Td>

		<Td align='center' width='50'><a href=?option=meeting&task=main/set_room&index=5&id=$id><img src=images/edit.png border='0' alt='แก้ไข'></a></Td>";
        echo "<Td align='center' width='50'><a href=?option=meeting&task=main/set_room&index=2&id=$id><img src=images/drop.png border='0' alt='ลบ'></a></Td>
	</Tr>";
$M++;
	}
echo "</Table>";
}
?>
<script>
function goto_url(val){
	if(val==0){
		callfrm("?option=meeting&task=main/set_room");   // page ย้อนกลับ
	}else if(val==1){
		if(frm1.room_code.value == ""){
			alert("กรุณากรอกข้อมูลเพิ่มห้องประชุมผ่านระบบ");
		}else if(frm1.room_name.value == ""){
			alert("กรุณาระบุชื่อห้องประชุม");
		}else if(frm1.person_max.value == ""){
			alert("กรุณากรอกที่นั่งทั้งหมด");
		}else{
			callfrm("?option=meeting&task=main/set_room&index=4");   //page ประมวลผล
		}
	}
}


function goto_url_update(val){
	if(val==0){
		callfrm("?option=meeting&task=main/set_room");   // page ย้อนกลับ
	}else if(val==1){
        if(frm1.id.value == ""){
			alert("กรุณากรอกข้อมูลเพิ่มห้องประชุมผ่านระบบ");
		}else if(frm1.room_name.value == ""){
			alert("กรุณาระบุชื่อห้องประชุม");
		}else if(frm1.person_max.value == ""){
			alert("กรุณากรอกที่นั่งทั้งหมด");
		}else{
		callfrm("?option=meeting&task=main/set_room&index=6");    //page ประมวลผล
        }
	}
}
</script>
<SCRIPT language=JavaScript>
function check_number() {
e_k=event.keyCode
//if (((e_k < 48) || (e_k > 57)) && e_k != 46 ) {
if (e_k != 13 && (e_k < 48) || (e_k > 57)) {
event.returnValue = false;
alert("ต้องเป็นตัวเลขเท่านั้น... \nกรุณาตรวจสอบข้อมูลของท่านอีกครั้ง...");
}
}
</script>
