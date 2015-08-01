<link rel="stylesheet" href="//netdna.bootstrapcdn.com/bootstrap/3.3.2/css/bootstrap.min.css">
<link rel="stylesheet" href="//netdna.bootstrapcdn.com/font-awesome/3.2.1/css/font-awesome.min.css">

<?php
/** ensure this file is being included by a parent file */
defined( '_VALID_' ) or die( 'Direct Access to this location is not allowed.' );
$admin_meeting=mysqli_real_escape_string($connect,$_SESSION['admin_meeting']);
if($admin_meeting!='meeting'){
exit();
}
?>
<script type="text/javascript" src="jquery/jquery-1.5.1.js"></script>
<script type="text/javascript">
$(function(){
	$("select#department").change(function(){
		var datalist2 = $.ajax({	// รับค่าจาก ajax เก็บไว้ที่ตัวแปร datalist2
			  url: "admin/section/default/return_ajax_person.php", // ไฟล์สำหรับการกำหนดเงื่อนไข
			  data:"department="+$(this).val(), // ส่งตัวแปร GET ชื่อ department ให้มีค่าเท่ากับ ค่าของ department
			  async: false
		}).responseText;
		$("select#person_id").html(datalist2); // นำค่า datalist2 มาแสดงใน listbox ที่ 2
		// ชื่อตัวแปร และ element ต่างๆ สามารถเปลี่ยนไปตามการกำหนด
	});
});

</script>
<?php

//ส่วนหัว
echo "<br />";
if(!(($index==1) or ($index==2) or ($index==5))){
echo "<table width='50%' border='0' align='center' >";
echo "<tr align='center'><td><font color='#006666' size='3'><strong>เจ้าหน้าที่</strong></font></td></tr>";
echo "</table>";
}

//ตรวจสอบ POST
if(isset($_POST['index'])){
$postindex=mysqli_real_escape_string($connect,$_POST['index']);
}else {$postindex="";}

if(isset($_GET['index'])){
$getindex=mysqli_real_escape_string($connect,$_GET['index']);
}else {$getindex="";}

//หาหน่วยงาน
$login_user_id=mysqli_real_escape_string($connect,$_SESSION['login_user_id']);
$system_user_department=mysqli_real_escape_string($connect,$_SESSION['system_user_department']);

$sql_depart = "select department_name from  system_department where department=? order by department";
    $dbquery_namedepart = $connect->prepare($sql_depart);
    $dbquery_namedepart->bind_param("i", $system_user_department);
    $dbquery_namedepart->execute();
    $result_namedepart=$dbquery_namedepart->get_result();
    while($result_departname = $result_namedepart->fetch_array())
   {
        $department_name = $result_departname['department_name'];
    }

//ส่วนฟอร์มรับข้อมูล
if($postindex==1){
echo "<form id='frm1' name='frm1'>";
echo "<Center>";
echo "<Font color='#006666' Size=3><B>เพิ่มเจ้าหน้าที่</Font>";
echo "</Cener>";
echo "<Br><Br>";
echo "<Table width='50%' Border='0' Bgcolor='#Fcf9d8' class='table table-hover table-bordered table-striped table-condensed'>";
echo "<Tr><Td align='right'>สำนัก&nbsp;&nbsp;&nbsp;&nbsp;</Td>";
echo "<td><div align='left'> $department_name";
echo "</div></td></tr>";
echo "<Tr><Td align='right'>บุคลากร&nbsp;&nbsp;&nbsp;&nbsp;</Td>";
echo "<td><div align='left'><Select name='person_id'  size='1'>";
echo  "<option  value = ''>เลือกบุคลากร</option>" ;
    $sql = "select  * from person_main where department = ? and status=0 order by name";
    $dbquery_person = $connect->prepare($sql);
    $dbquery_person->bind_param("i", $system_user_department);
    $dbquery_person->execute();
    $result_person=$dbquery_person->get_result();
    while($result_personname = $result_person->fetch_array())
   {
     $personname = $result_personname['prename'].$result_personname['name']." ".$result_personname['surname'];
     $personid = $result_personname['person_id'];

    $sql = "select  * from meeting_permission where person_id=?";
    $dbquery_permiss = $connect->prepare($sql);
    $dbquery_permiss->bind_param("i", $personid);
    $dbquery_permiss->execute();
    $result_permiss=$dbquery_permiss->get_result();
     while($result_permissuser = $result_permiss->fetch_array())
    {
         $permissid = $result_permissuser["person_id"];
     }

        if($permissid!=$personid){
        echo "<option  value ='$personid'> $personname</option>" ;
        }
    }

echo "</select>";
echo "</div></td></tr>";
echo   "<tr><td align='right'>อนุญาตให้เป็นเจ้าหน้าที่&nbsp;&nbsp;</td>";
echo   "<td align='left'>&nbsp;&nbsp;ใช่&nbsp;&nbsp;<input  type=radio name='meeting_permission1' value='1'>&nbsp;&nbsp;ไม่ใช่&nbsp;&nbsp;<input  type=radio name='meeting_permission1' value='0'  checked></td></tr>";

echo "<input type='hidden' name='index' value='4'>";
echo "<tr><td align='center' colspan='2'><INPUT TYPE='button' name='smb' value='ตกลง' onclick='goto_url(1)' class=entrybutton>
	&nbsp;&nbsp;&nbsp;</td>";
//echo "<td align='left'><INPUT TYPE='button' name='back' value='ย้อนกลับ' onclick='goto_url(0)' class=entrybutton'></td></tr>";
echo "</Table>";
echo "</form>";
}

//ส่วนยืนยันการลบข้อมูล
if($getindex==2) {
echo "<form id='frmdel' name='frmdel' action='?option=meeting&task=main/permission' method='post'>";
echo "<table width='500' border='0' align='center'>";
echo "<tr><td align='center'><font color='#990000' size='4'>โปรดยืนยันความต้องการลบข้อมูลอีกครั้ง</font><br></td></tr>";
echo "<tr><td align=center>";
echo "<input type='hidden' name='index' value='3'>";
echo "<input type='hidden' name='userid' value='$_GET[id]'>";
echo "<INPUT TYPE='submit' name='smb' value='ยืนยัน'>";
echo "&nbsp;&nbsp;<INPUT TYPE='button' name='back' value='ยกเลิก' onclick='location.href=\"?option=meeting&task=main/permission\"'";
echo "</td></tr></table></form>";
}

//ส่วนลบข้อมูล
if($postindex==3){
if(isset($_POST['userid'])){
$postuserid=mysqli_real_escape_string($connect,$_POST['userid']);
}else {$postuserid="";}
$sql = "delete from meeting_permission where id=?";
    $dbquery_permiss = $connect->prepare($sql);
    $dbquery_permiss->bind_param("i", $postuserid);
    $dbquery_permiss->execute();
    $result_permiss=$dbquery_permiss->get_result();
    echo "<script>document.location.href='?option=meeting&task=main/permission'; </script>\n";
}

//ส่วนบันทึกข้อมูล
if($postindex==4){
$personid=mysqli_real_escape_string($connect,$_POST['person_id']);
$meeting_permission1=mysqli_real_escape_string($connect,$_POST['meeting_permission1']);

$rec_date = date("Y-m-d");
$sql = "insert into meeting_permission (person_id, p1, officer,rec_date) values (?,?,?,?)";
    $dbquery_addmeeting = $connect->prepare($sql);
    $dbquery_addmeeting->bind_param("iiss", $personid,$meeting_permission1,$login_user_id,$rec_date);
    $dbquery_addmeeting->execute();
    $result_addmeeting=$dbquery_addmeeting->get_result();
    echo "<script>document.location.href='?option=meeting&task=main/permission'; </script>\n";
}

//ส่วนฟอร์มแก้ไขข้อมูล
if ($getindex==5){
if(isset($_GET['id'])){
$getuserid=mysqli_real_escape_string($connect,$_GET['id']);
}else {$getuserid="";}

echo "<form id='frm1' name='frm1'>";
echo "<Center>";
echo "<Font color='#006666' Size=3><B>แก้ไข เจ้าหน้าที่</B></Font>";
echo "</Cener>";
echo "<Br><Br>";
echo "<Table width='50%' Border= '0' Bgcolor='#Fcf9d8' class='table table-hover table-bordered table-striped table-condensed'>";
echo "<Tr><Td align='right'>สำนัก&nbsp;&nbsp;&nbsp;&nbsp;</Td>";
echo "<td><div align='left'> $department_name";
echo "</div></td></tr>";
    $sql_meetingper = "select * from meeting_permission where id=? ";
    $dbquery_meetingper = $connect->prepare($sql_meetingper);
    $dbquery_meetingper->bind_param("i", $getuserid);
    $dbquery_meetingper->execute();
    $result_meetingper=$dbquery_meetingper->get_result();
   while($result_meetingpermission = $result_meetingper->fetch_array())
    {
      $ref_result = $result_meetingpermission['p1'];
      $ref_personid = $result_meetingpermission['person_id'];
    }
    $sql_person = "select  * from person_main where person_id=? and status=0 order by name";
    $dbquery_person = $connect->prepare($sql_person);
    $dbquery_person->bind_param("i",$ref_personid);
    $dbquery_person->execute();
    $result_showperson=$dbquery_person->get_result();
     while($result_person = $result_showperson->fetch_array())
    {
        $personname = $result_person['prename'].$result_person['name']." ".$result_person['surname'];
		$personuser_id = $result_person['person_id'];
   }
echo "<Tr><Td align='right'>บุคลากร&nbsp;&nbsp;&nbsp;&nbsp;</Td>";
echo "<td><div align='left'>$personname";
echo "</div></td></tr>";

			if($ref_result==1){
			$p1_check1="checked";
			$p1_check2="";
			}
			else{
			$p1_check1="";
			$p1_check2="checked";
			}
echo   "<tr><td align='right'>อนุญาตให้เป็นเจ้าหน้าที่ได้&nbsp;&nbsp;</td>";
echo   "<td align='left'>&nbsp;&nbsp;ใช่&nbsp;&nbsp;<input  type=radio name='meeting_permission1' value='1' $p1_check1>&nbsp;&nbsp;ไม่ใช่&nbsp;&nbsp;<input  type=radio name='meeting_permission1' value='0' $p1_check2></td></tr>";

echo "<Input Type=Hidden Name='index' Value='6'>";
echo "<Input Type=Hidden Name='person_id' Value='$personuser_id'>";
echo "<tr><td>&nbsp;</td><td>&nbsp;</td></tr>";
echo "<tr><td align='center' colspan='2'><INPUT TYPE='button' name='smb' value='ตกลง' onclick='goto_url_update(1)' class=entrybutton>&nbsp;&nbsp;&nbsp;&nbsp;</td>";
//echo "<td align='left'><INPUT TYPE='button' name='back' value='ย้อนกลับ' onclick='goto_url_update(0)' class=entrybutton'></td></tr>";
echo "</Table>";
echo "<Br>";
echo "<Input Type=Hidden Name='idpermis' Value='$getuserid'>";
echo "</form>";
}

//ส่วนปรับปรุงข้อมูล
if ($postindex==6){

$person_id=mysqli_real_escape_string($connect,$_POST['person_id']);
$meeting_permission1=mysqli_real_escape_string($connect,$_POST['meeting_permission1']);
$idpermis=mysqli_real_escape_string($connect,$_POST['idpermis']);

$rec_date = date("Y-m-d");
$sql_update = "update meeting_permission set  person_id=?, p1=?, officer=?, rec_date=? where id=?";
                    $dbquery_update = $connect->prepare($sql_update);
                    $dbquery_update->bind_param("iissi", $person_id,$meeting_permission1,$login_user_id,$rec_date,$idpermis);
                    $dbquery_update->execute();
                    $result_update = $dbquery_update->get_result();
echo "<script>document.location.href='?option=meeting&task=main/permission'; </script>\n";
}

//ส่วนแสดงผล
if(!(($index==1) or ($index==2) or ($index==5))){

$sql_show = "select meeting_permission.id, meeting_permission.p1, person_main.name, person_main.surname from meeting_permission left join person_main on meeting_permission.person_id=person_main.person_id where person_main.department=? order by meeting_permission.id";
    $dbquery_show = $connect->prepare($sql_show);
    $dbquery_show->bind_param("i", $system_user_department);
    $dbquery_show->execute();
    $result_show = $dbquery_show->get_result();

echo "<form id='frm1' name='frm1' action='?option=meeting&task=main/permission' method='post'>";
echo  "<table width=50% border=0 align=center class='table table-hover table-bordered table-striped table-condensed'>";
echo "<Input Type=Hidden Name='index' Value='1'>";
echo "<Tr><Td colspan='5' align='left'><INPUT TYPE='submit' name='smb' value='เพิ่มเจ้าหน้าที่'></Td></Tr>";

echo "<Tr bgcolor='#FFCCCC'><Td  align='center' rowspan='2' >ที่</Td><Td  align='center' rowspan='2' >ชื่อเจ้าหน้าที่</Td><td  align='center'>สิทธื์</td><Td align='center' rowspan='2' width='50'>ลบ</Td><Td align='center' rowspan='2' width='50'>แก้ไข</Td></Tr>";
echo "<tr bgcolor='#CC9900'><Td  align='center' width='80'>เจ้าหน้าที่</Td></tr>";
$M=1;
While ($result = mysqli_fetch_array($result_show))
	{
		$id = $result['id'];
		$name = $result['name'];
		$surname = $result['surname'];
			if($result['p1']==1){
			$p1_pic="<img src=images/yes.png border='0' alt='มีสิทธิ์'>";			}
			else{
			$p1_pic="<img src=images/no.png border='0' alt='ไม่มีสิทธิ์'>";
			}
			if(($M%2) == 0)
			$color="#FFFFC";
			else  	$color="#FFFFFF";
		echo "<Tr bgcolor=$color><Td align='center' width='50'>$M</Td><Td  align='left'>$name $surname</Td><Td align='center'>$p1_pic</Td>
		<Td align='center' width='50' ><a href=?option=meeting&task=main/permission&index=2&id=$id><img src=images/drop.png border='0' alt='ลบ'></a></Td>
		<Td align='center' width='50'><a href=?option=meeting&task=main/permission&index=5&id=$id><img src=images/edit.png border='0' alt='แก้ไข'></a></Td>
	</Tr>";
$M++;
	}
echo "</Table></form>";
}

?>
<script>
function goto_url(val){
	if(val==0){
		callfrm("?option=meeting&task=main/permission");   // page ย้อนกลับ
	}else if(val==1){
		if(frm1.person_id.value == ""){
			alert("กรุณาเลือกบุคลากร");
		}else{
			callfrm("?option=meeting&task=main/permission");   //page ประมวลผล
		}
	}
}

function goto_url_update(val){
	if(val==0){
		callfrm("?option=meeting&task=main/permission");   // page ย้อนกลับ
	}else if(val==1){
		if(frm1.person_id.value == ""){
			alert("กรุณาเลือกบุคลากร");
		}else{
			callfrm("?option=meeting&task=main/permission");   //page ประมวลผล
		}
	}
}
</script>
