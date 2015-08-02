<link rel="stylesheet" href="//netdna.bootstrapcdn.com/bootstrap/3.3.2/css/bootstrap.min.css">
<link rel="stylesheet" href="//netdna.bootstrapcdn.com/font-awesome/3.2.1/css/font-awesome.min.css">
<link href="modules/meeting/css/datepicker.css" rel="stylesheet" media="screen">

<?php
/** ensure this file is being included by a parent file */
defined( '_VALID_' ) or die( 'Direct Access to this location is not allowed.' );
$login_group=mysqli_real_escape_string($connect,$_SESSION['login_group']);
if(!($login_group<=4)){
exit();
}

require_once "modules/meeting/time_inc.php";
?>
<script type="text/javascript" src="./css/js/calendarDateInput.js"></script>
<?php

$user=mysqli_real_escape_string($connect,$_SESSION['login_user_id']);
$system_user_department=mysqli_real_escape_string($connect,$_SESSION['system_user_department']);
$system_user_department_name=mysqli_real_escape_string($connect,$_SESSION['system_user_department_name']);

//ส่วนหัว
echo "<br />";

if(isset($_GET['index'])){
$getindex=mysqli_real_escape_string($connect,$_GET['index']);
}else {$getindex="";}

if(isset($_POST['index'])){
$postindex=mysqli_real_escape_string($connect,$_POST['index']);
}else {$postindex="";}

if(!($getindex==1)){

echo "<table width='100%' border='0' align='center' >";
echo "<tr align='center'><td><font color='#006666'><h2><strong>ค้นหาห้องประชุมว่าง</strong></h2></font></td></tr>";
echo "</table>";
}

//แสดงผลวันที่
$today = date("d/m/Y");
if(isset($_POST['search_date_start'])){
$search_date_starto=mysqli_real_escape_string($connect,$_POST['search_date_start']);
    $search_date_start=explode("/", $search_date_starto);
    $search_date_start=$search_date_start[2]."-".$search_date_start[1]."-".$search_date_start[0];  //ปี เดือน วัน
}else {$search_date_start="";
      $search_date_starto=$today;
      }
if(isset($_POST['search_date_end'])){
$search_date_endo=mysqli_real_escape_string($connect,$_POST['search_date_end']);
    $search_date_end=explode("/", $search_date_endo);
    $search_date_end=$search_date_end[2]."-".$search_date_end[1]."-".$search_date_end[0];  //ปี เดือน วัน
}else {$search_date_end="";
      $search_date_endo=$today;
      }


//ส่วนแสดงผล
if(!($getindex==1)){



echo "<form id='frm1' name='frm1'>";

echo "<table width=95% border=0 align=center class='table table-hover table-bordered table-striped table-condensed'>";
echo "<Tr><Td align='center'><table ><tr><td>เลือกวันที่ที่ต้องการค้นหา &nbsp;&nbsp;</td><td>";
echo "<input class='form-control' type='text' name='search_date_start' data-provide='datepicker' data-date-language='th' value='$search_date_starto'  Size='10'>";
echo "</td><td>&nbsp;&nbsp;&nbsp; ถึงวันที่ &nbsp;&nbsp;&nbsp;</td><td>";
echo "<input class='form-control' type='text' name='search_date_end'  data-provide='datepicker' data-date-language='th' value='$search_date_endo' Size='10'>";
echo "</td>";
echo "<Input Type=Hidden Name='index' Value='1'>";
echo "<td> &nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;<INPUT TYPE='button' class='btn btn-primary' name='smb' value='ค้นหา' onclick='goto_url(1)' class=entrybutton></td>";
echo "</tr></table></Td></tr>";


echo "</Table></form>";
}


//ส่วนฟอร์มรับข้อมูล
if($postindex==1){
//แสดงห้องประชุมในสำนัก
echo "<table width='100%' border='0' align='center' >";
echo "<tr><td align='left'><H3><strong>ห้องประชุมในสำนัก</strong></H3></td></tr><tr><td>";
    $sql_roomdepart="select * from meeting_room where department=? and active=1 order by room_code";
    $dbquery_roomdepart = $connect->prepare($sql_roomdepart);
    $dbquery_roomdepart->bind_param("i", $system_user_department);
    $dbquery_roomdepart->execute();
    $result_meetroomdepart=$dbquery_roomdepart->get_result();
 While ($result_roomdepart = mysqli_fetch_array($result_meetroomdepart))
{
    $room_code=$result_roomdepart["room_code"];
    $room_name=$result_roomdepart["room_name"];

    //แสดงห้องประชุมที่มีการใช้งาน
    echo "<table class='table table-hover table-bordered table-striped table-condensed'>";
    echo "<tr><td align='left' colspan='5'><h4><strong>ห้องประชุม $room_name</strong></h4></td></tr>";
    echo "<tr><td><table class='table table-hover table-bordered table-striped table-condensed'>";

    //แสดงรายการที่มีการจอง
    $sql_roombook="select * from meeting_main where room=?  and (book_date_start between ? and ?) and (book_date_end between ? and ?) and (approve=1 or approve=0) order by room,book_date_start,start_time,rec_date";
    $dbquery_roombook = $connect->prepare($sql_roombook);
    $dbquery_roombook->bind_param("issss", $room_code,$search_date_start,$search_date_end,$search_date_start,$search_date_end);
    $dbquery_roombook->execute();
    $result_qroombook=$dbquery_roombook->get_result();
    $numroombook = mysqli_num_rows($result_qroombook);
     if($numroombook>0){
     While ($result_roombook = mysqli_fetch_array($result_qroombook))
     {
        if($result_roombook["id"]!=""){

		$start_time=$result_roombook['start_time'];
		$start_time=number_format($start_time,2);
		$finish_time=$result_roombook['finish_time'];
		$finish_time=number_format($finish_time,2);
		$book_date_start = $result_roombook['book_date_start'];
		$book_date_end = $result_roombook['book_date_end'];
		$rec_date = $result_roombook['rec_date'];
        $coordinator = $result_roombook['coordinator'];
		$chairman = $result_roombook['chairman'];
		$person_num = $result_roombook['person_num'];
		$book_person = $result_roombook['book_person'];
		$user_book = $result_roombook['user_book'];
		$other = $result_roombook['other'];
		$rec_date = $result_roombook['rec_date'];
        $approve = $result_roombook['approve'];
        $officer = $result_roombook['officer'];
        $officer_date = $result_roombook['officer_date'];
        $reason = $result_roombook['reason'];
        $objective = $result_roombook['objective'];

    //หาชื่อผู้จอง
    $sql_person="select * from person_main where  status='0' and person_id=? ";

    $dbquery_person = $connect->prepare($sql_person);
    $dbquery_person->bind_param("i", $user_book);
    $dbquery_person->execute();
    $result_qperson=$dbquery_person->get_result();
 While ($result_person = mysqli_fetch_array($result_qperson))
{
     $name=$result_person['name'];
     $surname=$result_person['surname'];
     $department=$result_person['department'];
}
    //แสดงชื่อหน่วยงาน
    $sql_depart="select * from system_department where department=? ";
    $dbquery_depart = $connect->prepare($sql_depart);
    $dbquery_depart->bind_param("i", $department);
    $dbquery_depart->execute();
    $result_qdepart=$dbquery_depart->get_result();
 While ($result_depart = mysqli_fetch_array($result_qdepart))
{
     $department_name=$result_depart['department_name'];
 }

     if($approve==1){
         $showstatus="อนุมัติแล้ว";
     }else if($approve==2){
        $showstatus="<font color='red'>ไม่อนุมัติ</font>";
     }else{
        $showstatus="<font color='blue'>รอการอนุมัติ</font>";
     }

    echo "<tr><td>วันที่ ".thai_date_3($book_date_start)." ถึง ".thai_date_3($book_date_end)."</td>";
    echo "<td>เวลา : $start_time น. - $finish_time น.</td>";
    echo "<td>ผู้จอง : $name $surname($department_name)</td>";
    echo "<td>สถานะ : $showstatus</td>";
    echo "<td>รายละเอียด : เด๋วเอาปุ่มใส่</td>";
    echo "</tr>";
    echo "<tr><td align='left' colspan='5'>เรื่อง : ($chairman)$objective</td></tr>";
    echo "<tr><td align='left' colspan='5' height='1px'></td></tr>";
     }//แสดงรายการที่มีการจอง
    }
     }else{ //ตรวจสอบมีการจองห้องหรือไม่
            echo " - ว่าง - ";
        }

    echo "</table></td></tr></table>";


 }//ห้องประชุมของสำนัก

echo "<br><br><br>";
//แสดงห้องประชุมต่างสำนัก
echo "<table width='100%' border='0' align='center' >";
echo "<tr><td align='left'><H3><strong>ห้องประชุมต่างสำนัก</strong></H3></td></tr><tr><td>";
    $sql_roomdepart="select * from meeting_room where department!=? and active=1 order by room_code";
    $dbquery_roomdepart = $connect->prepare($sql_roomdepart);
    $dbquery_roomdepart->bind_param("i", $system_user_department);
    $dbquery_roomdepart->execute();
    $result_meetroomdepart=$dbquery_roomdepart->get_result();
 While ($result_roomdepart = mysqli_fetch_array($result_meetroomdepart))
{
    $room_code=$result_roomdepart["room_code"];
    $room_name=$result_roomdepart["room_name"];

    //แสดงห้องประชุมที่มีการใช้งาน
    echo "<table class='table table-hover table-bordered table-striped table-condensed'>";
    echo "<tr><td align='left' colspan='5'><h4><strong>ห้องประชุม $room_name</strong></h4></td></tr>";
    echo "<tr><td><table class='table table-hover table-bordered table-striped table-condensed'>";

    //แสดงรายการที่มีการจอง
    $sql_roombook="select * from meeting_main where room=?  and (book_date_start between ? and ?) and (book_date_end between ? and ?) and (approve=1 or approve=0) order by room,book_date_start,start_time,rec_date";
    $dbquery_roombook = $connect->prepare($sql_roombook);
    $dbquery_roombook->bind_param("issss", $room_code,$search_date_start,$search_date_end,$search_date_start,$search_date_end);
    $dbquery_roombook->execute();
    $result_qroombook=$dbquery_roombook->get_result();
    $numroombook = mysqli_num_rows($result_qroombook);
     if($numroombook>0){
     While ($result_roombook = mysqli_fetch_array($result_qroombook))
     {
        if($result_roombook["id"]!=""){

		$start_time=$result_roombook['start_time'];
		$start_time=number_format($start_time,2);
		$finish_time=$result_roombook['finish_time'];
		$finish_time=number_format($finish_time,2);
		$book_date_start = $result_roombook['book_date_start'];
		$book_date_end = $result_roombook['book_date_end'];
		$rec_date = $result_roombook['rec_date'];
        $coordinator = $result_roombook['coordinator'];
		$chairman = $result_roombook['chairman'];
		$person_num = $result_roombook['person_num'];
		$book_person = $result_roombook['book_person'];
		$user_book = $result_roombook['user_book'];
		$other = $result_roombook['other'];
		$rec_date = $result_roombook['rec_date'];
        $approve = $result_roombook['approve'];
        $officer = $result_roombook['officer'];
        $officer_date = $result_roombook['officer_date'];
        $reason = $result_roombook['reason'];
        $objective = $result_roombook['objective'];

    //หาชื่อผู้จอง
    $sql_person="select * from person_main where  status='0' and person_id=? ";

    $dbquery_person = $connect->prepare($sql_person);
    $dbquery_person->bind_param("i", $user_book);
    $dbquery_person->execute();
    $result_qperson=$dbquery_person->get_result();
 While ($result_person = mysqli_fetch_array($result_qperson))
{
     $name=$result_person['name'];
     $surname=$result_person['surname'];
     $department=$result_person['department'];
}
    //แสดงชื่อหน่วยงาน
    $sql_depart="select * from system_department where department=? ";
    $dbquery_depart = $connect->prepare($sql_depart);
    $dbquery_depart->bind_param("i", $department);
    $dbquery_depart->execute();
    $result_qdepart=$dbquery_depart->get_result();
 While ($result_depart = mysqli_fetch_array($result_qdepart))
{
     $department_name=$result_depart['department_name'];
 }

     if($approve==1){
         $showstatus="อนุมัติแล้ว";
     }else if($approve==2){
        $showstatus="<font color='red'>ไม่อนุมัติ</font>";
     }else{
        $showstatus="<font color='blue'>รอการอนุมัติ</font>";
     }

    echo "<tr><td>วันที่ ".thai_date_3($book_date_start)." ถึง ".thai_date_3($book_date_end)."</td>";
    echo "<td>เวลา : $start_time น. - $finish_time น.</td>";
    echo "<td>ผู้จอง : $name $surname($department_name)</td>";
    echo "<td>สถานะ : $showstatus</td>";
    echo "<td>รายละเอียด : เด๋วเอาปุ่มใส่</td>";
    echo "</tr>";
    echo "<tr><td align='left' colspan='5'>เรื่อง : ($chairman)$objective</td></tr>";
    echo "<tr><td align='left' colspan='5' height='1px'></td></tr>";
     }//แสดงรายการที่มีการจอง
    }
     }else{ //ตรวจสอบมีการจองห้องหรือไม่
            echo " - ว่าง - ";
        }

    echo "</table></td></tr></table>";


 }//ห้องประชุมของสำนัก

}



?>
    <script src="//getbootstrap.com/2.3.2/assets/js/jquery.js"></script>
    <script src="//getbootstrap.com/2.3.2/assets/js/google-code-prettify/prettify.js"></script>

    <script src="modules/meeting/js/bootstrap-datepicker.js"></script>
       <script src="modules/meeting/js/bootstrap-datepicker.th.js"></script>

    <script id="datepicker"  type="text/javascript">
      function datepicker() {
        $('.datepicker').datepicker({
          format: 'yyyy-mm-dd',
          autoclose : true
          });
      }
    </script>

    <script type="text/javascript">
      $(function(){
        $('pre[data-source]').each(function(){
          var $this = $(this),
            $source = $($this.data('source'));

          var text = [];
          $source.each(function(){
            var $s = $(this);
            if ($s.attr('type') == 'text/javascript'){
              text.push($s.html().replace(/(\n)*/, ''));
            } else {
              text.push($s.clone().wrap('<div>').parent().html()
                .replace(/(\"(?=[[{]))/g,'\'')
                .replace(/\]\"/g,']\'').replace(/\}\"/g,'\'') // javascript not support lookbehind
                .replace(/\&quot\;/g,'"'));
            }
          });

          $this.text(text.join('\n\n').replace(/\t/g, '    '));
        });

        prettyPrint();
        demo();
      });
    </script>


<script>
function goto_url(val){
	if(val==0){
		callfrm("?option=meeting&task=main/search");   // page ย้อนกลับ
	}else if(val==1){
		if(frm1.search_date_start.value == ""){
			alert("กรุณาเลือกวันที่เริ่ม");
		}else if(frm1.search_date_end.value == ""){
			alert("กรุณาระบุวันที่สิ้นสุด");
		}else if(frm1.search_date_end.value < frm1.search_date_start.value){
			alert("วันที่สิ้นสุดมากกว่าวันที่เริ่มต้น กรุณาเลือกวันที่ใหม่");
		}else{
			callfrm("?option=meeting&task=main/search");   //page ประมวลผล
		}
	}
}

function goto_url2(val){
callfrm("?option=meeting&task=main/meeting");
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