<?php
/** ensure this file is being included by a parent file */
defined( '_VALID_' ) or die( 'Direct Access to this location is not allowed.' );
require_once "modules/car/time_inc.php";
?>
<script type="text/javascript" src="css/js/calendarDateInput.js"></script>
<?php
$user=$_SESSION['login_user_id'];
//กรณีเลือกแสดงเฉพาะคัน
if(isset($_REQUEST['car_index'])){
$car_index=$_REQUEST['car_index'];
}
else{
$car_index="";
}
if(!isset($_POST['self_driver'])){
$_POST['self_driver']="";
}
if(!isset($_POST['private_car'])){
$_POST['private_car']="";
}
?><BR>
<div class="container">
  <div class="panel panel-default">
<?
$sql_name = "select person_id,prename,name,surname from person_main ";
$dbquery_name = mysqli_query($connect,$sql_name);
while($result_name = mysqli_fetch_array($dbquery_name)){;
		$person_id = $result_name['person_id'];
		$prename=$result_name['prename'];
		$name= $result_name['name'];
		$surname = $result_name['surname'];
$full_name_ar[$person_id]="$prename$name&nbsp;&nbsp;$surname";
}
//ส่วนหัว
if(!(($index==1)  or ($index==2) or ($index==5) or ($index==7))){
?><div class="panel-heading"><h3 class="panel-title">ทะเบียนการขออนุญาตใช้รถราชการ</h3></div><?
}
//ส่วนฟอร์มรับข้อมูล
if($index==1){
?>
<div class="panel-heading"><h3 class="panel-title">บันทึกขออนุญาตใช้รถราชการ</h3></div>
<div class="panel-body">
    <form id='frm1' name='frm1' class="form-horizontal">
    <?
    $sql = "select pic from  car_car where status='2' ";
    $dbquery = mysqli_query($connect,$sql);
    $pic_num=0;
    While ($result = mysqli_fetch_array($dbquery)){
        $pic = $result['pic'];
        if($pic!=""){
        echo "<img src='$pic' width='150'>";
        echo "&nbsp;&nbsp;&nbsp; ";
        $pic_num++;
        }
        if($pic_num==7){
        echo "<br>";
        $pic_num=0;
        }
    }
    ?>
      <div class="form-group">
          <label class="col-sm-3 control-label text-right">เรื่อง</label>
          <div class="col-sm-4 input-group">
            <label class="col-md control-label">ขออนุญาตใช้รถราชการ</label>
          </div>
        </div>
        <hr>
      <div class="form-group">
          <label class="col-sm-3 control-label text-right">เรียน</label>
          <div class="col-sm-4 input-group">
            <label class="col-md control-label">ผู้อำนวยการ<?=$_SESSION['office_name']?></label>
          </div>
        </div>
        <hr>
      <div class="form-group">
          <label class="col-sm-3 control-label text-right">ข้าพเจ้า</label>
          <div class="col-sm-4 input-group">
            <label class="col-md control-label"><?echo $_SESSION['login_prename'].$_SESSION['login_name']."&nbsp;&nbsp;".$_SESSION['login_surname']."&nbsp;&nbsp;ตำแหน่ง ".$_SESSION['login_userposition'];?></label>
          </div>
        </div>
        <hr>
      <div class="form-group">
          <label class="col-sm-3 control-label text-right">ขออนุญาตใช้รถราชการ</label>
          <div class="col-sm-3 input-group">
                <Select  name='car'  size='1' class="form-control">
                    <option  value = ''>เลือกรถ</option>
            <?$sql = "select car_code,car_number,name from  car_car where status<='2' ";
              $dbquery = mysqli_query($connect,$sql);
                While ($result = mysqli_fetch_array($dbquery)){
                    $car_code = $result['car_code'];
                    $car_number= $result['car_number'];
                    $name = $result['name'];
                    echo  "<option value = $car_code>$car_number $name</option>";
               }?>
                </select>
          </div>
        </div>
        <hr>
      <div class="form-group">
          <label class="col-sm-3 control-label text-right">สถานที่ไปราชการ</label>
          <div class="col-sm-5 input-group"><Input Type='Text' Name='place' class="form-control">
          </div>
        </div>
        <hr>
      <div class="form-group">
          <label class="col-sm-3 control-label text-right">เพื่อวัตถุประสงค์</label>
          <div class="col-sm-8 input-group"><Input Type='Text' Name='because' class="form-control">
          </div>
        </div>
        <hr>
      <div class="form-group">
          <label class="col-sm-3 control-label text-right">ตั้งแต่วันที่</label>
          <div class="col-sm-2 input-group">
    <link rel="stylesheet" href="./jquery/themes/ui-lightness/jquery.ui.all.css">
	<script src="./jquery/jquery-1.5.1.js"></script>
	<script src="./jquery/ui/jquery.ui.core.js"></script>
	<script src="./jquery/ui/jquery.ui.widget.js"></script>
	<script src="./jquery/ui/jquery.ui.datepicker.js"></script>
	<script>
	$(function() {
		$( "#datepicker" ).datepicker({
			showButtonPanel: true,
			dateFormat: 'yy-mm-dd',
			changeMonth: true,
			changeYear: true,
			monthNamesShort: ['ม.ค.', 'ก.พ.', 'มี.ค.', 'เม.ย.', 'พ.ค.', 'มิ.ย.', 'ก.ค.', 'ส.ค.', 'ก.ย.', 'ต.ค.', 'พ.ย.', 'ธ.ค.'],
			dayNamesMin: ['อา','จ','อ','พ','พฤ','ศ','ส']
		});
	});
	$(function() {
		$( "#datepicker2" ).datepicker({
			showButtonPanel: true,
			dateFormat: 'yy-mm-dd',
			changeMonth: true,
			changeYear: true,
			monthNamesShort: ['ม.ค.', 'ก.พ.', 'มี.ค.', 'เม.ย.', 'พ.ค.', 'มิ.ย.', 'ก.ค.', 'ส.ค.', 'ก.ย.', 'ต.ค.', 'พ.ย.', 'ธ.ค.'],
			dayNamesMin: ['อา','จ','อ','พ','พฤ','ศ','ส']
		});
	});
	</script><input type="text" id="datepicker" name=car_start class="form-control">

          </div>
        </div>
        <hr>
      <div class="form-group">
          <label class="col-sm-3 control-label text-right">เวลา</label>
          <div class="col-sm-2 input-group"><Input Type='Text' Name='time_start' class="form-control"><span class="input-group-addon">&nbspน.</span>
          </div>
        </div>
        <hr>
      <div class="form-group">
          <label class="col-sm-3 control-label text-right">ถึงวันที่</label>
          <div class="col-sm-2 input-group"><input type="text" id="datepicker2" name=car_finish class="form-control">
          </div>
        </div>
        <hr>
      <div class="form-group">
          <label class="col-sm-3 control-label text-right">เวลา</label>
          <div class="col-sm-2 input-group"><Input Type='Text' Name='time_finish' class="form-control"><span class="input-group-addon">&nbspน.</span>
          </div>
        </div>
        <hr>
      <div class="form-group">
          <label class="col-sm-3 control-label text-right">รวม</label>
          <div class="col-sm-2 input-group"><Input Type='Text' Name='day_total' class="form-control"><span class="input-group-addon">&nbspวัน</span>
          </div>
        </div>
        <hr>
      <div class="form-group">
          <label class="col-sm-3 control-label text-right">มีผู้โดยสารทั้งหมด</label>
          <div class="col-sm-2 input-group"><Input Type='Text' Name='person_num' class="form-control"><span class="input-group-addon">&nbsp;&nbsp;คน</span>
          </div>
        </div>
        <hr>
      <div class="form-group">
          <label class="col-sm-3 control-label text-right">ผู้ควบคุมรถคือ</label>
          <div class="col-sm-4 input-group"><Input Type='Text' Name='control_person' class="form-control">
          </div>
        </div>
        <hr>
        <div class="form-group">
          <label class="col-sm-3 control-label text-right">เชื้อเพลิง</label>
            <div class="col-sm-4">
            <div class="input-group">
            <span class="input-group-addon">
                <input type="radio" aria-label="..." name='fuel' value='0' checked></input>
            </span>
            <input type="text" class="form-control" value="ไม่ขอใช้งบประมาณ" readonly>
            </div><!-- /input-group -->
            </div>
        </div>
        <div class="form-group">
          <label class="col-sm-3 control-label text-right"></label>
            <div class="col-sm-4">
            <div class="input-group">
            <span class="input-group-addon">
                <input type="radio" aria-label="..." name='fuel' value='1'>
            </span>
            <input type="text" class="form-control" value="ขอใช้จากงบเชื้อเพลิงกลางของ สพท." readonly>
            </div><!-- /input-group -->
            </div>
        </div>
        <div class="form-group">
          <label class="col-sm-3 control-label text-right"></label>
            <div class="col-sm-4">
            <div class="input-group">
            <span class="input-group-addon">
                <input type="radio" aria-label="..." name='fuel' value='2'>
            </span>
            <input type="text" class="form-control" value="ขอใช้จากงบเชื้อเพลิงจาก" readonly>
            </div><!-- /input-group -->
            </div>
        </div>
      <div class="form-group">
          <label class="col-sm-3 control-label text-right"></label>
          <div class="col-sm-6 input-group">&nbsp;&nbsp;&nbsp;&nbsp;<span class="input-group-addon">โครงการ</span><Input Type='Text' Name='project' class="form-control"></div>
        </div>
      <div class="form-group">
          <label class="col-sm-3 control-label text-right"></label>
          <div class="col-sm-6 input-group">&nbsp;&nbsp;&nbsp;&nbsp;<span class="input-group-addon">กิจกรรม</span><Input Type='Text' Name='activity' class="form-control">
          </div>
        </div>
        <hr>
      <div class="form-group">
          <label class="col-sm-3 control-label text-right">จำนวนเงิน</label>
          <div class="col-sm-4 input-group"><Input Type='Text' Name='money' class="form-control" ><span class="input-group-addon">&nbsp;บาท</span>
          </div>
        </div>
        <hr>
      <div class="form-group">
          <label class="col-sm-3 control-label text-right">กรณีไม่มีพนักงานขับรถ</label>
          <div class="col-sm-8 input-group"><span class="input-group-addon"><Input Type='checkbox' Name='self_driver'  value='1'></span><input type="text" class="form-control" value="ขออนุญาตเป็นผู้ขับรถคันดังกล่าว  ซึ่งได้รับใบอนุญาตในการขับขี่รถจากทางราชการประเภทนี้" readonly>
          </div>
        </div>
        <hr>
      <div class="form-group">
          <label class="col-sm-3 control-label text-right">กรณีรถราชการไม่ว่าง</label>
          <div class="col-sm-8 input-group"><span class="input-group-addon"><Input Type='checkbox' Name='private_car'  value='1'></span><input type="text" class="form-control" value="ขออนุญาตใช้ส่วนส่วนตัว" readonly><Input Type='hidden' Name='car_owner'>
          </div>
        </div>
      <div class="form-group">
          <label class="col-sm-3 control-label text-right"></label>
          <div class="col-sm-4 input-group">&nbsp;&nbsp;&nbsp;<span class="input-group-addon">หมายเลขทะเบียน</span><Input Type='Text' Name='private_car_number' class="form-control">
          </div>
        </div>
      <div class="form-group">
          <label class="col-sm-3 control-label text-right"></label>
          <div class="col-sm-4 input-group">&nbsp;&nbsp;&nbsp;<span class="input-group-addon">ผู้ขับขี่</span><Input Type='Text' Name='private_driver' class="form-control">
          </div>
        </div>
        <hr>
        <div class="form-group">
          <label class="col-sm-3 control-label text-right"></label>
          <div class="col-sm-4">
            <INPUT TYPE='hidden' name='car_index' value=<?=$car_index?>>
            <label >
                <button type="button" name="smb" class="btn btn-primary" onclick='goto_url(1)'>
                    <span class="glyphicon glyphicon-ok" aria-hidden="true"></span>ตกลง
                </button>&nbsp;
                <button type="button" name="back" class="btn btn-default" onclick='goto_url(0)'>
                    <span class="glyphicon glyphicon-remove" aria-hidden="true"></span>ย้อนกลับ
                </button>
            </label>
          </div>
        </div>
    </form>
</div>
<?
}
//ส่วนลบข้อมูล
if($index==3){
$sql = "delete from car_main where id='$_GET[id]'";
$dbquery = mysqli_query($connect,$sql);
}
//ส่วนบันทึกข้อมูล
if($index==4){
$rec_date = date("Y-m-d");
	if($_POST['fuel']==0){
	$_POST['money']=0;
	}
	if($_POST['fuel']!=2){
	$_POST['project']="";
	$_POST['activity']="";
	}
$sql = "insert into car_main ( person_id, rec_date, car, place, because, car_start, time_start, car_finish, time_finish, day_total, person_num, control_person, fuel, project, activity, money, self_driver, private_car, car_owner, private_car_number, private_driver) values ('$user', '$rec_date',  '$_POST[car]', '$_POST[place]', '$_POST[because]', '$_POST[car_start]', '$_POST[time_start]','$_POST[car_finish]','$_POST[time_finish]','$_POST[day_total]', '$_POST[person_num]','$_POST[control_person]', '$_POST[fuel]', '$_POST[project]',  '$_POST[activity]',   '$_POST[money]', '$_POST[self_driver]','$_POST[private_car]','$_POST[car_owner]','$_POST[private_car_number]','$_POST[private_driver]')";
$dbquery = mysqli_query($connect,$sql);
}
//ส่วนฟอร์มแก้ไขข้อมูล
if ($index==5){
echo "<form  id='frm1' name='frm1'>";
echo "<Center>";
echo "<Font color='#006666' Size=3><B>แก้ไขรายการ</B></Font>";
echo "</Cener>";
echo "<Br><Br>";
echo "<Table  class='table table-hover table-bordered table-striped table-condensed'>";
$sql = "select * from car_main where id='$_GET[id]'";
$dbquery = mysqli_query($connect,$sql);
$ref_result = mysqli_fetch_array($dbquery);
$id=$ref_result['id'];

echo "<Tr align='left'><Td align='right' width=40%>เรื่อง&nbsp;&nbsp;</Td><Td>ขออนุญาตใช้รถราชการ</Td></Tr>";
echo "<Tr align='left'><Td align='right'>เรียน&nbsp;&nbsp;</Td><Td>ผู้อำนวยการ$_SESSION[office_name]</Td></Tr>";
echo "<Tr align='left'><Td align='right'>ข้าพเจ้า&nbsp;&nbsp;</Td><Td>$_SESSION[login_prename]$_SESSION[login_name]&nbsp;&nbsp;$_SESSION[login_surname]&nbsp;&nbsp;ตำแหน่ง$_SESSION[login_userposition]</Td></Tr>";
echo "<Tr align='left'><Td align='right'>ขออนุญาตใช้รถราชการ&nbsp;&nbsp;</Td><Td><Select  name='car'  size='1'>";
echo  "<option  value = ''>เลือกรถ</option>" ;
$sql = "select * from  car_car where status<='2' ";
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
		$car_start=$ref_result['car_start'];
		?>
		<link rel="stylesheet" href="./jquery/themes/ui-lightness/jquery.ui.all.css">
	<script src="./jquery/jquery-1.5.1.js"></script>
	<script src="./jquery/ui/jquery.ui.core.js"></script>
	<script src="./jquery/ui/jquery.ui.widget.js"></script>
	<script src="./jquery/ui/jquery.ui.datepicker.js"></script>
	<script>
	$(function() {
		$( "#datepicker" ).datepicker({
			showButtonPanel: true,
			dateFormat: 'yy-mm-dd',
			changeMonth: true,
			changeYear: true,
			monthNamesShort: ['ม.ค.', 'ก.พ.', 'มี.ค.', 'เม.ย.', 'พ.ค.', 'มิ.ย.', 'ก.ค.', 'ส.ค.', 'ก.ย.', 'ต.ค.', 'พ.ย.', 'ธ.ค.'],
			dayNamesMin: ['อา','จ','อ','พ','พฤ','ศ','ส']
		});
	});
	$(function() {
		$( "#datepicker2" ).datepicker({
			showButtonPanel: true,
			dateFormat: 'yy-mm-dd',
			changeMonth: true,
			changeYear: true,
			monthNamesShort: ['ม.ค.', 'ก.พ.', 'มี.ค.', 'เม.ย.', 'พ.ค.', 'มิ.ย.', 'ก.ค.', 'ส.ค.', 'ก.ย.', 'ต.ค.', 'พ.ย.', 'ธ.ค.'],
			dayNamesMin: ['อา','จ','อ','พ','พฤ','ศ','ส']
		});
	});
	</script>

<input type="text" id="datepicker" name=car_start value="<?=$car_start;?>"  readonly Size=10>
		<?php
echo "</Td></Tr>";
$time_start=number_format($ref_result['time_start'],2);
echo "<Tr align='left'><Td align='right'>&nbsp;&nbsp;เวลา</Td><Td><Input Type='Text' Name='time_start' Size='5' value='$time_start'>&nbspน.</Td></Tr>";
echo "<Tr align='left'><Td align='right'>ถึงวันที่&nbsp;&nbsp;</Td>";
echo "<Td align='left'>";
		$car_finish=$ref_result['car_finish'];
		?>
<input type="text" id="datepicker2" name=car_finish value="<?=$car_finish;?>"  readonly Size=10>
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
if( $ref_result['fuel']==1){
$fuel_check_2="checked";
}
else if ( $ref_result['fuel']==2){
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
	if($_POST['fuel']==0){
	$_POST['money']=0;
	}
	if($_POST['fuel']!=2){
	$_POST['project']="";
	$_POST['activity']="";
	}
		$sql = "update car_main set car='$_POST[car]',
		place='$_POST[place]',
		because='$_POST[because]',
		car_start='$_POST[car_start]',
		time_start='$_POST[time_start]',
		car_finish='$_POST[car_finish]',
		time_finish='$_POST[time_finish]',
		day_total='$_POST[day_total]',
		person_num='$_POST[person_num]',
		control_person='$_POST[control_person]',
		fuel='$_POST[fuel]',
		project='$_POST[project]',
		activity='$_POST[activity]',
		money='$_POST[money]',
		self_driver='$_POST[self_driver]',
		private_car='$_POST[private_car]',
		car_owner='$_POST[car_owner]',
		private_car_number='$_POST[private_car_number]',
		private_driver='$_POST[private_driver]'
		where id='$_POST[id]'";
		$dbquery = mysqli_query($connect,$sql);
}
if ($index==7){
?>
<div class="panel-heading"><h3 class="panel-title">รายละเอียดการขออนุญาตใช้รถราชการ</h3></div>
<div class="panel-body">
    <form id='frm1' name='frm1' class="form-horizontal">
    <?
    $sql = "select pic from  car_car where status='2' ";
    $dbquery = mysqli_query($connect,$sql);
    $pic_num=0;
    While ($result = mysqli_fetch_array($dbquery)){
        $pic = $result['pic'];
        if($pic!=""){
        echo "<img src='$pic' width='150'>";
        echo "&nbsp;&nbsp;&nbsp; ";
        $pic_num++;
        }
        if($pic_num==7){
        echo "<br>";
        $pic_num=0;
        }
    }
    $sql = "select * from car_main where id='$_GET[id]'";
    $dbquery = mysqli_query($connect,$sql);
    $ref_result = mysqli_fetch_array($dbquery);
        $id=$ref_result['id'];
        $person_id=$ref_result['person_id'];
        $rec_date=$ref_result['rec_date'];
        $car_code=$ref_result['car'];
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
    ?>
      <div class="form-group">
          <label class="col-sm-3 control-label text-right">วันที่</label>
          <div class="col-sm-4 input-group">
            <label class="col-md control-label"><? echo thai_date_3($rec_date);?></label>
          </div>
        </div><hr>
        <div class="form-group">
          <label class="col-sm-3 control-label text-right">เรื่อง</label>
          <div class="col-sm-4 input-group">
            <label class="col-md control-label">ขออนุญาตใช้รถราชการ</label>
          </div>
        </div><hr>
      <div class="form-group">
          <label class="col-sm-3 control-label text-right">เรียน</label>
          <div class="col-sm-4 input-group">
            <label class="col-md control-label">ผู้อำนวยการ<?=$_SESSION['office_name']?></label>
          </div>
        </div><hr>
      <div class="form-group">
          <label class="col-sm-3 control-label text-right">ข้าพเจ้า</label>
          <div class="col-sm-4 input-group">
            <label class="col-md control-label"><?echo $full_name."&nbsp;&nbsp;ตำแหน่ง&nbsp;&nbsp;".$position_name;?></label>
          </div>
        </div><hr>
      <div class="form-group">
          <label class="col-sm-3 control-label text-right">ขออนุญาตใช้รถราชการ</label>
          <div class="col-sm-3 input-group">
<?
    $sql = "select * from  car_car where car_code='$car_code' ";
    $dbquery = mysqli_query($connect,$sql);
    $result = mysqli_fetch_array($dbquery);
        $car_number= $result['car_number'];
        $name = $result['name'];
              ?>
              <label class="col-md control-label"><? echo $car_number."  ".$name;?></label>
          </div>
        </div>
      <div class="form-group">
          <label class="col-sm-3 control-label text-right"></label>
          <div class="col-sm-5 input-group"><img src="<?=$result['pic']?>" width='150'></div>
        </div><hr>
      <div class="form-group">
          <label class="col-sm-3 control-label text-right">สถานที่ไปราชการ</label>
          <div class="col-sm-5 input-group"><Input Type='Text' Name='place' class="form-control">
          </div>
        </div><hr>
      <div class="form-group">
          <label class="col-sm-3 control-label text-right">เพื่อวัตถุประสงค์</label>
          <div class="col-sm-8 input-group"><Input Type='Text' Name='because' class="form-control">
          </div>
        </div><hr>
      <div class="form-group">
          <label class="col-sm-3 control-label text-right">ตั้งแต่วันที่</label>
          <div class="col-sm-2 input-group">
    <link rel="stylesheet" href="./jquery/themes/ui-lightness/jquery.ui.all.css">
	<script src="./jquery/jquery-1.5.1.js"></script>
	<script src="./jquery/ui/jquery.ui.core.js"></script>
	<script src="./jquery/ui/jquery.ui.widget.js"></script>
	<script src="./jquery/ui/jquery.ui.datepicker.js"></script>
	<script>
	$(function() {
		$( "#datepicker" ).datepicker({
			showButtonPanel: true,
			dateFormat: 'yy-mm-dd',
			changeMonth: true,
			changeYear: true,
			monthNamesShort: ['ม.ค.', 'ก.พ.', 'มี.ค.', 'เม.ย.', 'พ.ค.', 'มิ.ย.', 'ก.ค.', 'ส.ค.', 'ก.ย.', 'ต.ค.', 'พ.ย.', 'ธ.ค.'],
			dayNamesMin: ['อา','จ','อ','พ','พฤ','ศ','ส']
		});
	});
	$(function() {
		$( "#datepicker2" ).datepicker({
			showButtonPanel: true,
			dateFormat: 'yy-mm-dd',
			changeMonth: true,
			changeYear: true,
			monthNamesShort: ['ม.ค.', 'ก.พ.', 'มี.ค.', 'เม.ย.', 'พ.ค.', 'มิ.ย.', 'ก.ค.', 'ส.ค.', 'ก.ย.', 'ต.ค.', 'พ.ย.', 'ธ.ค.'],
			dayNamesMin: ['อา','จ','อ','พ','พฤ','ศ','ส']
		});
	});
	</script><input type="text" id="datepicker" name=car_start class="form-control">

          </div>
        </div><hr>
      <div class="form-group">
          <label class="col-sm-3 control-label text-right">เวลา</label>
          <div class="col-sm-2 input-group"><Input Type='Text' Name='time_start' class="form-control"><span class="input-group-addon">&nbspน.</span>
          </div>
        </div><hr>
      <div class="form-group">
          <label class="col-sm-3 control-label text-right">ถึงวันที่</label>
          <div class="col-sm-2 input-group"><input type="text" id="datepicker2" name=car_finish class="form-control">
          </div>
        </div><hr>
      <div class="form-group">
          <label class="col-sm-3 control-label text-right">เวลา</label>
          <div class="col-sm-2 input-group"><Input Type='Text' Name='time_finish' class="form-control"><span class="input-group-addon">&nbspน.</span>
          </div>
        </div><hr>
      <div class="form-group">
          <label class="col-sm-3 control-label text-right">รวม</label>
          <div class="col-sm-2 input-group"><Input Type='Text' Name='day_total' class="form-control"><span class="input-group-addon">&nbspวัน</span>
          </div>
        </div><hr>
      <div class="form-group">
          <label class="col-sm-3 control-label text-right">มีผู้โดยสารทั้งหมด</label>
          <div class="col-sm-2 input-group"><Input Type='Text' Name='person_num' class="form-control"><span class="input-group-addon">&nbsp;&nbsp;คน</span>
          </div>
        </div><hr>
      <div class="form-group">
          <label class="col-sm-3 control-label text-right">ผู้ควบคุมรถคือ</label>
          <div class="col-sm-4 input-group"><Input Type='Text' Name='control_person' class="form-control">
          </div>
        </div><hr>
      <div class="form-group">
          <label class="col-sm-3 control-label text-right">เชื้อเพลิง</label>
            <div class="col-sm-4">
            <div class="input-group">
            <span class="input-group-addon">
                <input type="radio" aria-label="..." name='fuel' value='0' checked></input>
            </span>
            <input type="text" class="form-control" value="ไม่ขอใช้งบประมาณ" readonly>
            </div><!-- /input-group -->
            </div>
        </div>
      <div class="form-group">
          <label class="col-sm-3 control-label text-right"></label>
            <div class="col-sm-4">
            <div class="input-group">
            <span class="input-group-addon">
                <input type="radio" aria-label="..." name='fuel' value='1'>
            </span>
            <input type="text" class="form-control" value="ขอใช้จากงบเชื้อเพลิงกลางของ สพท." readonly>
            </div><!-- /input-group -->
            </div>
        </div>
      <div class="form-group">
          <label class="col-sm-3 control-label text-right"></label>
            <div class="col-sm-4">
            <div class="input-group">
            <span class="input-group-addon">
                <input type="radio" aria-label="..." name='fuel' value='2'>
            </span>
            <input type="text" class="form-control" value="ขอใช้จากงบเชื้อเพลิงจาก" readonly>
            </div><!-- /input-group -->
            </div>
        </div>
      <div class="form-group">
          <label class="col-sm-3 control-label text-right"></label>
          <div class="col-sm-6 input-group">&nbsp;&nbsp;&nbsp;&nbsp;<span class="input-group-addon">โครงการ</span><Input Type='Text' Name='project' class="form-control"></div>
        </div>
      <div class="form-group">
          <label class="col-sm-3 control-label text-right"></label>
          <div class="col-sm-6 input-group">&nbsp;&nbsp;&nbsp;&nbsp;<span class="input-group-addon">กิจกรรม</span><Input Type='Text' Name='activity' class="form-control">
          </div>
        </div><hr>
      <div class="form-group">
          <label class="col-sm-3 control-label text-right">จำนวนเงิน</label>
          <div class="col-sm-4 input-group"><Input Type='Text' Name='money' class="form-control" ><span class="input-group-addon">&nbsp;บาท</span>
          </div>
        </div><hr>
      <div class="form-group">
          <label class="col-sm-3 control-label text-right">กรณีไม่มีพนักงานขับรถ</label>
          <div class="col-sm-8 input-group"><span class="input-group-addon"><Input Type='checkbox' Name='self_driver'  value='1'></span><input type="text" class="form-control" value="ขออนุญาตเป็นผู้ขับรถคันดังกล่าว  ซึ่งได้รับใบอนุญาตในการขับขี่รถจากทางราชการประเภทนี้" readonly>
          </div>
        </div><hr>
      <div class="form-group">
          <label class="col-sm-3 control-label text-right">กรณีรถราชการไม่ว่าง</label>
          <div class="col-sm-8 input-group"><span class="input-group-addon"><Input Type='checkbox' Name='private_car'  value='1'></span><input type="text" class="form-control" value="ขออนุญาตใช้ส่วนส่วนตัว" readonly><Input Type='hidden' Name='car_owner'>
          </div>
        </div>
      <div class="form-group">
          <label class="col-sm-3 control-label text-right"></label>
          <div class="col-sm-4 input-group">&nbsp;&nbsp;&nbsp;<span class="input-group-addon">หมายเลขทะเบียน</span><Input Type='Text' Name='private_car_number' class="form-control">
          </div>
        </div>
      <div class="form-group">
          <label class="col-sm-3 control-label text-right"></label>
          <div class="col-sm-4 input-group">&nbsp;&nbsp;&nbsp;<span class="input-group-addon">ผู้ขับขี่</span><Input Type='Text' Name='private_driver' class="form-control">
          </div>
        </div><hr>
        <div class="form-group">
          <label class="col-sm-3 control-label text-right"></label>
          <div class="col-sm-4">
            <INPUT TYPE='hidden' name='car_index' value=<?=$car_index?>>
            <label >
                <button type="button" name="smb" class="btn btn-primary" onclick='goto_url(1)'>
                    <span class="glyphicon glyphicon-ok" aria-hidden="true"></span>ตกลง
                </button>&nbsp;
                <button type="button" name="back" class="btn btn-default" onclick='goto_url(0)'>
                    <span class="glyphicon glyphicon-remove" aria-hidden="true"></span>ย้อนกลับ
                </button>
            </label>
          </div>
        </div> <!-- OK CANCEL -->
    </form>
</div>
<?
    if(!is_numeric($_GET['id']))exit(); // check sql injection

echo "<Table  class='table table-hover table-bordered table-striped table-condensed'>";
echo "<Tr ><Td colspan='2' align='right'><INPUT TYPE='button' name='smb' value='<<กลับหน้าก่อน' onclick='location.href=\"?option=car&task=main/car_request&page=$_GET[page]&car_index=$car_index\"'></Td></Tr>";

echo "<Tr align='left'><Td align='right'>สถานที่ไปราชการ&nbsp;&nbsp;</Td><Td>$ref_result[place]</Td></Tr>";
echo "<Tr align='left'><Td align='right'>วัตถุประสงค์&nbsp;&nbsp;</Td><Td>$ref_result[because]</Td></Tr>";
echo "<Tr align='left'><Td align='right'>ตั้งแต่วันที่&nbsp;&nbsp;</Td>";
echo "<Td align='left'>$ref_result[car_start]</Td></Tr>";
$time_start=number_format($ref_result['time_start'],2);
echo "<Tr align='left'><Td align='right'>&nbsp;&nbsp;เวลา</Td><Td>$time_start&nbspน.</Td></Tr>";
echo "<Tr align='left'><Td align='right'>ถึงวันที่&nbsp;&nbsp;</Td>";
echo "<Td align='left'>$ref_result[car_finish]</Td></Tr>";
$time_finish=number_format($ref_result['time_finish'],2);
echo "<Tr align='left'><Td align='right'>&nbsp;&nbsp;เวลา</Td><Td>$time_finish&nbspน.</Td></Tr>";
echo "<Tr align='left'><Td align='right'>รวม&nbsp;&nbsp;</Td>";
echo "<Td>$ref_result[day_total]&nbsp;&nbsp;วัน";
echo "<Tr align='left'><Td align='right'>มีผู้โดยสารทั้งหมด&nbsp;&nbsp;</Td><Td>$ref_result[person_num]&nbsp;&nbsp;คน</Td></Tr>";
echo "<Tr align='left'><Td align='right'>ผู้ควบคุมรถคือ&nbsp;&nbsp;</Td><Td>$ref_result[control_person]</Td></Tr>";
$fuel_check_1=" disabled";
$fuel_check_2=" disabled";
$fuel_check_3=" disabled";
if($ref_result['fuel']==1){
$fuel_check_2="checked disabled";
}
else if ( $ref_result['fuel']==2){
$fuel_check_3="checked disabled";
}
else {
$fuel_check_1="checked disabled";
}
echo "<Tr align='left'><Td align='right'>เชื้อเพลิง&nbsp;&nbsp;</Td><Td><Input Type='radio' Name='fuel'  value='0' $fuel_check_1>ไม่ขอใช้จากงบเชื้อเพลิงกลาง สพท.</Td></Tr>";
echo "<Tr align='left'><Td align='right'>&nbsp;&nbsp;</Td><Td><Input Type='radio' Name='fuel'  value='1' $fuel_check_2>ขอใช้จากงบเชื้อเพลิงกลางของ สพท.</Td></Tr>";
echo "<Tr align='left'><Td align='right'>&nbsp;&nbsp;</Td><Td><Input Type='radio' Name='fuel'  value='2' $fuel_check_3>ขอใช้จากงบเชื้อเพลิงจากโครงการ&nbsp;<Input Type='Text' Name='project' Size='40' value='$ref_result[project]' disabled>&nbsp;&nbsp;กิจกรรม&nbsp;<Input Type='Text' Name='activity' Size='40' value='$ref_result[activity]' disabled></Td></Tr>";
echo "<Tr align='left'><Td></Td><Td>&nbsp;&nbsp;&nbsp;&nbsp;จำนวนเงิน&nbsp;<Input Type='Text' Name='money' Size='10'  value='$ref_result[money]' disabled>&nbsp;บาท .</Td></Tr>";

if( $ref_result['self_driver']==1){
$self_driver_check="checked disabled";
}
else{
$self_driver_check=" disabled";
}
echo "<Tr align='left'><Td align='right'>กรณีไม่มีพนักงานขับรถ&nbsp;&nbsp;</Td><Td><Input Type='checkbox' Name='self_driver'  value='1' $self_driver_check>ขออนุญาตเป็นผู้ขับรถคันดังกล่าว  ซึ่งได้รับใบอนุญาตในการขับขี่รถจากทางราชการประเภทนี้</Td></Tr>";
if( $ref_result['private_car']==1){
$private_car_check="checked disabled";
}
else{
$private_car_check=" disabled";
}
echo "<Tr align='left'><Td align='right'>กรณีรถราชการไม่ว่าง&nbsp;&nbsp;</Td><Td><Input Type='checkbox' Name='private_car'  value='1' $private_car_check>ขออนุญาตใช้ส่วนส่วนตัวของ&nbsp<Input Type='Text' Name='car_owner' Size='40'  value='$ref_result[car_owner]' disabled></Td></Tr>";
echo "<Tr align='left'><Td align='right'>&nbsp;&nbsp;</Td><Td>หมายเลขทะเบียน&nbsp<Input Type='Text' Name='private_car_number' Size='40'  value='$ref_result[private_car_number]' disabled></Td></Tr>";
echo "<Tr align='left'><Td align='right'>&nbsp;&nbsp;</Td><Td>ผู้ขับขี่&nbsp<Input Type='Text' Name='private_driver' Size='40'  value='$ref_result[private_driver]' disabled></Td></Tr>";
///////
echo "<tr><td colspan='2'>";
echo "<fieldset>";
echo "<legend>&nbsp;<B>ส่วนเจ้าหน้าที่</B>: &nbsp;</legend>";
echo "<table  class='table table-hover table-bordered table-striped table-condensed'>";
echo "<Tr align='left'><Td align='right'>เห็นควรให้&nbsp;&nbsp;</Td>";
echo "<td><div align='left'><Select  name='driver'  size='1' disabled>";
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
echo "<Tr align='left'><Td align='right'>&nbsp;&nbsp;</Td><Td><Input Type='Text' Name='officer_comment' Size='80' value='$ref_result[officer_comment]' disabled></Td></Tr>";
$officer_sign=$ref_result['officer_sign'];
echo "<Tr align='left'><Td align='right'>ลงชื่อ&nbsp;&nbsp;</Td><Td>";
if(isset($full_name_ar[$officer_sign])){
echo $full_name_ar[$officer_sign];
}
echo "</Td></Tr>";
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
echo "<table  class='table table-hover table-bordered table-striped table-condensed'>";
echo "<Tr align='left'><Td align='right'>ความเห็น&nbsp;&nbsp;</Td><Td><Input Type='Text' Name='group_comment' Size='80' value='$ref_result[group_comment]' disabled></Td></Tr>";
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
echo "<table  class='table table-hover table-bordered table-striped table-condensed'>";
echo "<Tr align='left'><Td align='right'>คำสั่ง(ถ้ามี)&nbsp;&nbsp;</Td><Td><Input Type='Text' Name='grant_comment' Size='80' value='$ref_result[grant_comment]' disabled></Td></Tr>";
		$commander_grant_check1=""; $commander_grant_check2="";
		if($ref_result['commander_grant']==1){
		$commander_grant_check1="checked";
		}
		else if($ref_result['commander_grant']==2){
		$commander_grant_check2="checked";
		}
echo "<Tr align='left'><Td align='right'>อนุมัติ/ไม่อนุมัติ&nbsp;&nbsp;</Td><Td><Input Type='radio' Name='commander_grant' value='1' $commander_grant_check1 disabled>อนุมัติ&nbsp;&nbsp;<Input Type='radio' Name='commander_grant' value='2' $commander_grant_check2 disabled>ไม่อนุมัติ&nbsp;&nbsp;</Td></Tr>";
$commander_sign=$ref_result['commander_sign'];
echo "<Tr align='left'><Td align='right'>ลงชื่อ&nbsp;&nbsp;</Td><Td>";
if(isset($full_name_ar[$commander_sign])){
echo $full_name_ar[$commander_sign];
}
echo "</Td></Tr>";
echo "<Tr align='left'><Td align='right'>วดป&nbsp;&nbsp;</Td><Td>";
echo  thai_date_4($ref_result['commander_date']);
echo "</Td></Tr>";
echo "</table></fieldset>";
echo "</tr>";

///////
echo "</table>";
}
//ส่วนแสดงผล
if(!(($index==1) or ($index==5) or ($index==7))){
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
$url_link="option=car&task=main/car_request&car_index=$car_index";  // 2_กำหนดลิงค์ฺ
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
$sql="select car_main.id, car_main.person_id, car_main.car_start, car_main.car_finish, car_main.rec_date, car_main.officer_sign, car_main.group_sign, car_main.commander_sign, car_main.commander_grant, car_car.name from car_main left join car_car on  car_main.car=car_car.car_code  where car_main.car='$car_index' order by car_start, car_car.car_code limit $start,$pagelen";
}
else{
$sql="select car_main.id, car_main.person_id, car_main.car_start, car_main.car_finish, car_main.rec_date, car_main.officer_sign, car_main.group_sign, car_main.commander_sign, car_main.commander_grant, car_car.name from car_main left join car_car on  car_main.car=car_car.car_code order by car_start, car_car.car_code limit $start,$pagelen";
}
$dbquery = mysqli_query($connect,$sql);
?>
      <div class="panel-body">
        <form id='frm1' name='frm1' class="form-horizontal">
        <div class="row">
            <div class="col-md-10 text-left">
                <a href="?option=car&task=main/car_request&index=1&car_index=<?=$car_index?>" class="btn btn-primary"><span class="glyphicon glyphicon-plus"></span>&nbsp;ขออนุญาตใช้รถราชการ</a>
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
              <th>ลบ</th>
              <th>แก้ไข</th>
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
			if(($M%2) == 0)$color="#FFFFB";
			else  	$color="#FFFFFF";
    ?>
<Tr>
    <Td ><?=$N?></Td>
    <Td ><?echo thai_date_3($car_start);?></Td>
    <Td ><?echo thai_date_3($car_finish);?></Td>
    <Td><?echo $result['name'];?></Td>
    <Td><?echo $full_name_ar[$person_id];?></Td>
    <Td ><?echo thai_date_3($rec_date);?></Td>
    <Td >
    <? if($grant==1){?><span class='glyphicon glyphicon-ok'></span>
    <? }else if($grant==2){?><span class='glyphicon glyphicon-remove'></span>
    <? }else{?>รออนุมัติ<?}?>
    </Td>
    <Td>
        <a href=?option=car&task=main/car_request&index=7&id=<?=$id?>&page=<?=$page?>&car_index=<?=$car_index?> class='btn btn-primary'><span class='glyphicon glyphicon-file' ></span></a>
    </Td>
    <? if(($officer_sign=="") and ($group_sign=="") and ($commander_sign=="") and ($person_id==$user)){?>
    <Td>
        <a href=?option=car&task=main/car_request&index=3&id=<?=$id?>&page=<?=$page?>&car_index=<?=$car_index?> data-toggle='confirmation' class='btn btn-danger' data-title="คุณต้องการลบข้อมูลนี้ใช่หรือไม่" data-btn-ok-label="ใช่" data-btn-ok-icon="glyphicon glyphicon-share-alt" data-btn-ok-class="btn-success" data-btn-cancel-label="ไม่ใช่!" data-btn-cancel-icon="glyphicon glyphicon-ban-circle" data-btn-cancel-class="btn-danger">
        <span class='glyphicon glyphicon-trash'></span>
        </a>
    </Td>
    <Td>
        <a href=?option=car&task=main/car_request&index=5&id=<?=$id?>&page=<?=$page?>&car_index=<?=$car_index?> class='btn btn-warning'><span class='glyphicon glyphicon-pencil' ></span></a>
    </Td>
<?}
else{
    ?>
<td></td>
    <td></td>
<?}?>
</Tr>
<?
$M++;
$N++;  //*เกี่ยวข้องกับการแยกหน้า
}
     ?>
          </tbody>
          </table>
<?
echo  "<table  class='table table-hover table-bordered table-striped table-condensed'>";

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
			if(($M%2) == 0)
			$color="#FFFFB";
			else  	$color="#FFFFFF";
echo "<Tr bgcolor='$color'><Td valign='top' align='center'>$N</Td><Td valign='top' align='left'>";
echo thai_date_3($car_start);
echo "</Td><Td align='left'>";
echo thai_date_3($car_finish);
echo "</Td>";
echo "<Td valign='top' align='left' >$result[name]</Td>";
echo "<Td valign='top' align='left' >";
echo $full_name_ar[$person_id];
echo "</Td>";
echo "<Td valign='top' align='left' >";
echo thai_date_3($rec_date);
echo "</Td>";

echo "<Td valign='top' align='center'>";
if($grant==1){
echo "<img src=images/yes.png border='0'>";
}
else if($grant==2){
echo "<img src=images/no.png border='0'>";
}
else{
echo "รออนุมัติ";
}
echo "</Td>";
echo "<Td valign='top' align='center'><a href=?option=car&task=main/car_request&index=7&id=$id&page=$page&car_index=$car_index><img src=images/browse.png border='0' alt='รายละเอียด'></Td>";
if(($officer_sign=="") and ($group_sign=="") and ($commander_sign=="") and ($person_id==$user)){
echo "<Td valign='top' align='center'><a href=?option=car&task=main/car_request&index=2&id=$id&page=$page&car_index=$car_index><img src=images/drop.png border='0' alt='ลบ'></Td><Td valign='top'  align='center'><a href=?option=car&task=main/car_request&index=5&id=$id&page=$page&car_index=$car_index><img src=images/edit.png border='0' alt='แก้ไข'></a></Td>";
}
else{
echo "<td></td><td></td>";
}
echo "</Tr>";
$M++;
$N++;  //*เกี่ยวข้องกับการแยกหน้า
}
echo "</Table>";
}
?>
<script>
function goto_url(val){
	if(val==0){
		callfrm("?option=car&task=main/car_request");   // page ย้อนกลับ
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
			callfrm("?option=car&task=main/car_request&index=4");   //page ประมวลผล
		}
	}
}
function goto_url_update(val){
	if(val==0){
		callfrm("?option=car&task=main/car_request");   // page ย้อนกลับ
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
			callfrm("?option=car&task=main/car_request&index=6");   //page ประมวลผล
		}
	}
}
function goto_url2(val){
callfrm("?option=car&task=main/car_request");
}
</script>
</div>
    </div>
