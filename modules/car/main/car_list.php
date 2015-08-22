<?php
/** ensure this file is being included by a parent file */
defined( '_VALID_' ) or die( 'Direct Access to this location is not allowed.' );
//sd page
if($result_permission['p1']!=1){exit();}?>
<BR>
<div class="container">
  <div class="panel panel-default">
<?
//ฟังชั่นupload
function file_upload() {
		$uploaddir = 'modules/car/upload_files/';      //ที่เก็บไไฟล์
		$uploadfile = $uploaddir.basename($_FILES['userfile']['name']);
		$basename = basename($_FILES['userfile']['name']);

		$pic_code=$_POST['car_code'];
		//ลบไฟล์เดิม
		$exists_file=$uploaddir.$pic_code.substr($basename,-4);
		if(file_exists($exists_file)){
		unlink($exists_file);
		}

		if (move_uploaded_file($_FILES['userfile']['tmp_name'],  $uploadfile))
			{
				$before_name  = $uploaddir.$basename;
				$changed_name = $uploaddir.$pic_code.substr($basename,-4) ;
				rename("$before_name" , "$changed_name");

		//ลดขนาดภาพ
				if(substr($basename,-3)=="jpg"){
				$ori_file=$changed_name;
				$ori_size=getimagesize($ori_file);
				$ori_w=$ori_size[0];
				$ori_h=$ori_size[1];
					if($ori_w>500){
					$new_w=500;
					$new_h=round(($new_w/$ori_w)*$ori_h);
					$ori_img=imagecreatefromjpeg($ori_file);
					$new_img=imagecreatetruecolor($new_w, $new_h);
					imagecopyresized($new_img, $ori_img,0,0, 0,0, $new_w, $new_h, $ori_w, $ori_h);
					$new_file=$ori_file;
					imagejpeg($new_img, $new_file);
					imagedestroy($ori_img);
					imagedestroy($new_img);
					}
				}

			return  $changed_name;
			}
}
if(!(($index==1) or ($index==2) or ($index==5))){
    ?><div class="panel-heading"><h3 class="panel-title">ยานพาหนะ</h3></div><?
}
//ส่วนเพิ่มข้อมูล
if($index==1){
    $header="เพิ่มยานพาหนะ";
    $car_type = "";
    $car_code = "";
    $car_number = "";
    $car_name = "";
    $status = "";

    if(!empty($_GET['id'])) $id=$_GET['id'];
    else $id=0;
    if(!empty($_GET['page'])) $page=$_GET['page'];
    else $page=1;
    if(!empty($_GET['ed'])) $ed=$_GET['ed'];
    else $ed=0;

    if($ed==1){
        $header="แก้ไขยานพาหนะ";

        $sql = "select * from  car_car where id='$_GET[id]'";
        $dbquery = mysqli_query($connect,$sql);
        $result = mysqli_fetch_array($dbquery);
        $car_type = $result['car_type'];
        $car_code = $result['car_code'];
        $car_number = $result['car_number'];
        $car_name = $result['name'];
        $status = $result['status'];
    }
?>
<div class="panel-heading"><h3 class="panel-title"><?=$header;?></h3></div>
<div class="panel-body">
    <form Enctype = multipart/form-data id='frm1' name='frm1' class="form-horizontal">
        <Input Type=hidden Name="id" Value="<?=$id?>"></Input>
        <Input Type=hidden Name="page" Value="<?=$page?>"></Input>
        <div class="form-group">
          <label class="col-sm-3 control-label text-right" >ประเภท</label>
          <div class="col-sm-2 input-group">
              <Select  name='car_type' id='car_type' class="form-control">
                  <option  value = ''>เลือก</option>
                  <?
                $sql = "select * from  car_type  order by code";
                $dbquery = mysqli_query($connect,$sql);
                While ($result = mysqli_fetch_array($dbquery))
                {
                    $name=$result['name'];
                    $selected="";
                    if($result['code']==$car_type) $selected="selected";
                    echo  "<option value = $result[code] $selected>$result[code] $name</option>" ;
                }
        ?></select></div>
        </div><hr>
        <div class="form-group">
          <label class="col-sm-3 control-label text-right" >รหัสยานพาหนะ</label>
          <div class="col-sm-2 input-group"><Input Type='Text' Name='car_code' id='car_code' class="form-control"  maxlength='3' onkeydown='integerOnly()' value="<?=$car_code?>"></div>
        </div><hr>
        <div class="form-group">
          <label class="col-sm-3 control-label text-right" >เลขทะเบียน</label>
          <div class="col-sm-2 input-group"><Input Type='Text' Name='car_number' id='car_number' class="form-control" value="<?=$car_number?>"></div>
        </div><hr>
        <div class="form-group">
          <label class="col-sm-3 control-label text-right" >ชื่อยานพาหนะ</label>
          <div class="col-sm-2 input-group"><Input Type='Text' Name='car_name' id='car_name' class="form-control" value="<?=$car_name?>"></div>
        </div><hr>
        <div class="form-group">
          <label class="col-sm-3 control-label text-right" >สถานะ</label>
          <div class="col-sm-2 input-group">
              <Select  name='status'  id='status' class="form-control">
                <option value = ''>เลือก</option>
                <option value = '1' <? if($status==1) echo "selected";?> >1.พาหนะปัจจุบันใช้งานเฉพาะ</option>
                <option value = '2' <? if($status==2) echo "selected";?> >2.พาหนะปัจจุบันอนุญาตให้จองใช้งาน </option>
                <option value = '3' <? if($status==3) echo "selected";?> >3.พาหนะที่เคยใช้งาน </option>
              </select>
        </div><hr>
        <div class="form-group">
          <label class="col-sm-3 control-label text-right" >ไฟล์รูปภาพ</label>
          <div class="col-sm-2 input-group"><input name = 'userfile' type = 'file' class="form-control"></div>
        </div><hr>
        <div class="form-group">
          <label class="col-sm-3 control-label text-right"></label>
          <div class="col-sm-4">
            <label >
                <button type="button" name="smb" class="btn btn-primary" onclick='goto_url_ed(<?=$ed?>,1)'>
                    <span class="glyphicon glyphicon-ok" aria-hidden="true"></span>ตกลง
                </button>&nbsp;
                <button type="button" name="back" class="btn btn-default" onclick='goto_url_ed(<?=$ed?>,0)'>
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
$sql = "delete from car_car where id=$_GET[id]";
$dbquery = mysqli_query($connect,$sql);
}
//ส่วนเพิ่มข้อมูล
if($index==4){
$basename = basename($_FILES['userfile']['name']);
$changed_name="";
if ($basename!="")
{
$changed_name = file_upload();
}

$sql = "select  * from  car_car where  car_code='$_POST[car_code]'  ";
$dbquery = mysqli_query($connect,$sql);
$num_rows=mysqli_num_rows($dbquery);
		if($num_rows>=1){
					?>
					<script>
					alert("รหัสยานพาหนะมีอยู่แล้ว  ยกเลิกการบันทึกข้อมูล");
					</script>
					<?php
		}
		else {
		$sql = "insert into car_car (car_code, car_type, car_number, name,  pic, status) values ('$_POST[car_code]', '$_POST[car_type]','$_POST[car_number]','$_POST[car_name]', '$changed_name' , '$_POST[status]' )";
		$dbquery = mysqli_query($connect,$sql);
		}
}
//ส่วนปรับปรุงข้อมูล
if ($index==6){
$sql = "select * from car_car where  car_code='$_POST[car_code]' and  id!='$_POST[id]' ";
$dbquery = mysqli_query($connect,$sql);
if(mysqli_num_rows($dbquery)>=1){
echo "<br /><div align='center'>มีรหัสซ้ำกับรายการที่มีอยู่แล้ว ตรวจสอบอีกครั้ง</div>";
exit();
}
$basename = basename($_FILES['userfile']['name']);
if ($basename!=""){
$changed_name = file_upload();
$sql = "update car_car set  car_code='$_POST[car_code]',
car_type='$_POST[car_type]',
car_number='$_POST[car_number]',
name='$_POST[car_name]',
status='$_POST[status]',
pic='$changed_name'
where id='$_POST[id]'";
}
else{
$sql = "update car_car set  car_code='$_POST[car_code]',
car_type='$_POST[car_type]',
car_number='$_POST[car_number]',
name='$_POST[car_name]',
status='$_POST[status]'
where id='$_POST[id]'";
}
$dbquery = mysqli_query($connect,$sql);
}
//ส่วนแสดง
if(!(($index==1) or ($index==2) or ($index==5))){
	//ส่วนของการแยกหน้า
$pagelen=20;  // 1_กำหนดแถวต่อหน้า
$url_link="option=car&task=main/car_list";  // 2_กำหนดลิงค์ฺ
$sql = "select * from car_car "; // 3_กำหนด sql

$dbquery = mysqli_query($connect,$sql);
$num_rows = mysqli_num_rows($dbquery );
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

$sql = "select car_car.id, car_car.car_code, car_car.name as car_name, car_car.car_number, car_type.name, car_car.status, car_car.pic from  car_car left join car_type on car_car.car_type=car_type.code  order by  car_car.car_type, car_car.car_code limit $start,$pagelen";
$dbquery = mysqli_query($connect,$sql);
?>
  <div class="panel-body">
        <div class="row">
            <div class="col-md-3 text-left">
                <a href="?option=car&task=main/car_list&index=1" class="btn btn-primary"><span class="glyphicon glyphicon-plus"></span>&nbsp;เพิ่มข้อมูล</a>
            </div>
        </div>
    </div>
      <table class="table table-hover table-striped table-condensed table-responsive">
    <thead>
        <tr>
          <th>ที่</th>
          <th>รหัส</th>
          <th>ประเภทยานพาหนะ</th>
          <th>ชื่อยานพาหนะ</th>
          <th>เลขทะเบียน</th>
          <th>สถานะภาพ</th>
          <th>รูป</th>
          <th>ลบ</th>
          <th>แก้ไข</th>
        </tr>
          </thead>
          <tbody><?
$N=(($page-1)*$pagelen)+1;  //*เกี่ยวข้องกับการแยกหน้า
$M=1;
While ($result = mysqli_fetch_array($dbquery))
	{
		$id = $result['id'];
		$car_code= $result['car_code'];
		$car_type= $result['name'];
		$car_name = $result['car_name'];
		$car_number = $result['car_number'];
		$status = $result['status'];
				if($status==1){
				$status="<font color='#FF9933'>พาหนะปัจจุบันใช้งานเฉพาะ</font>";
				}
				else if ($status==2){
				$status="พาหนะปัจจุบันอนุญาตให้จองใช้งาน";
				}
				else if ($status==3){
				$status="<font color='#FF0000'>พาหนะที่เคยใช้งาน</font>";
				}
    ?>
    <Tr>
        <Td><?=$N?></Td>
        <Td><?=$car_code?></Td>
        <Td><?=$car_type?></Td>
        <Td><?=$car_name?></Td>
        <Td><?=$car_number?></Td>
        <Td><?=$status?></Td>
        <?
if($result['pic']!=""){?>
    <Td><a href='modules/car/main/pic_show.php?&id=<?=$id?>' target='_blank' class='btn btn-primary'><span class='glyphicon glyphicon-picture' ></span></a></Td>
<?}else echo "<Td>&nbsp;</Td>";?>
    <Td><a href=?option=car&task=main/car_list&index=3&id=<?=$id?>&page=<?=$page?> data-toggle='confirmation' class='btn btn-danger' data-title="คุณต้องการลบข้อมูลนี้ใช่หรือไม่" data-btn-ok-label="ใช่" data-btn-ok-icon="glyphicon glyphicon-share-alt" data-btn-ok-class="btn-success" data-btn-cancel-label="ไม่ใช่!" data-btn-cancel-icon="glyphicon glyphicon-ban-circle" data-btn-cancel-class="btn-danger"><span class='glyphicon glyphicon-trash'></span></a></Td>
    <Td><a href=?option=car&task=main/car_list&page=<?=$page?>&index=1&id=<?=$id?>&ed=1 class='btn btn-warning'><span class='glyphicon glyphicon-pencil' ></span></a></Td>
	</Tr>
      <?
$M++;
$N++;  //*เกี่ยวข้องกับการแยกหน้า
	}
    ?>
          </tbody>
</Table>
<?}?>
    </div>
    </div>
<script>
function goto_url_ed(ed,val){
	if(val==0){
		callfrm("?option=car&task=main/car_list");   // page ย้อนกลับ
	}else if(val==1){
		if(frm1.car_type.value == ""){
			alert("กรุณาเลือกประเภท");
		}else if(frm1.car_code.value==""){
			alert("กรุณากรอกรหัสยานพาหนะ");
		}else if(frm1.car_number.value==""){
			alert("กรุณากรอกเลขทะเบียนยานพาหนะ");
		}else if(frm1.car_name.value==""){
			alert("กรุณากรอกชื่อยานพาหนะ");
		}else if(frm1.status.value==""){
			alert("กรุณาเลือกสถานะ");
		}else{
            if(ed==1){
                callfrm("?option=car&task=main/car_list&index=6");   //page ประมวลผล edit
            }else{
                callfrm("?option=car&task=main/car_list&index=4");   //page ประมวลผล
            }
		}
	}
}
</script>
