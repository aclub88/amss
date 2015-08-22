<?php
/** ensure this file is being included by a parent file */
defined( '_VALID_' ) or die( 'Direct Access to this location is not allowed.' );
//sd page
if($result_permission['p1']!=1){exit();}
?>
<BR>
<div class="container">
  <div class="panel panel-default">
<?
if(!(($index==1) or ($index==2) or ($index==5))){
      ?><div class="panel-heading"><h3 class="panel-title">ประเภทยานพาหนะ</h3></div><?
}
//ส่วนเพิ่มข้อมูล
if($index==1){
    $header="บันทึกประเภทยานพาหนะ";
    $code="";
    $name="";

    if(!empty($_GET['id'])) $id=$_GET['id'];
    else $id=0;
    if(!empty($_GET['page'])) $page=$_GET['page'];
    else $page=1;
    if(!empty($_GET['ed'])) $ed=$_GET['ed'];
    else $ed=0;

    if($ed==1){
        $header="แก้ไขประเภทยานพาหนะ";
        $sql = "select * from  car_type where id='$_GET[id]'";
        $dbquery = mysqli_query($connect,$sql);
        $result = mysqli_fetch_array($dbquery);
        $code = $result['code'];
        $name = $result['name'];
    }
?>
<div class="panel-heading"><h3 class="panel-title"><?=$header;?></h3></div>
<div class="panel-body">
    <form id='frm1' name='frm1' class="form-horizontal">

<Input Type=hidden Name="id" Value="<?=$id?>">
<Input Type=hidden Name="page" Value="<?=$page?>">
        <div class="form-group">
          <label class="col-sm-3 control-label text-right" >รหัส</label>
          <div class="col-sm-2 input-group"><Input Type='Text' Name='code' class="form-control" value="<?=$code?>"></div>
        </div><hr>
        <div class="form-group">
          <label class="col-sm-3 control-label text-right" >ชื่อประเภท</label>
          <div class="col-sm-3   input-group"><Input Type='Text' Name='name' class="form-control" value="<?=$name?>">
          </div>
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
$sql = "delete from car_type where id=$_GET[id]";
$dbquery = mysqli_query($connect,$sql);
}
//ส่วนเพิ่มข้อมูล
if($index==4){
$sql = "select * from car_type where  code='$_POST[code]' ";
$dbquery = mysqli_query($connect,$sql);
if(mysqli_num_rows($dbquery)>=1){
echo "<br /><div align='center'>มีรหัสซ้ำกับรายการที่มีอยู่แล้ว ตรวจสอบอีกครั้ง</div>";
exit();
}
$sql = "insert into car_type (code,name) values ('$_POST[code]','$_POST[name]')";
$dbquery = mysqli_query($connect,$sql);
}
//ส่วนปรับปรุงข้อมูล
if ($index==6){
$sql = "select * from car_type where  code='$_POST[code]' and id!='$_POST[id]' ";
$dbquery = mysqli_query($connect,$sql);
if(mysqli_num_rows($dbquery)>=1){
echo "<br /><div align='center'>มีรหัสซ้ำกับรายการที่มีอยู่แล้ว ตรวจสอบอีกครั้ง</div>";
exit();
}
$sql = "update car_type set code='$_POST[code]', name='$_POST[name]' where id='$_POST[id]'";
$dbquery = mysqli_query($connect,$sql);
}
//ส่วนการแสดงผล
if(!(($index==1) or ($index==2) or ($index==5))){
//ส่วนของการแยกหน้า
$pagelen=20;  // 1_กำหนดแถวต่อหน้า
$url_link="option=car&task=main/car_type";  // 2_กำหนดลิงค์ฺ
$sql = "select * from  car_type "; // 3_กำหนด sql

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

$sql = "select * from car_type  order by code  limit $start,$pagelen";
$dbquery = mysqli_query($connect,$sql);
?>
  <div class="panel-body">
        <div class="row">
            <div class="col-md-3 text-left">
                <a href="?option=car&task=main/car_type&index=1" class="btn btn-primary"><span class="glyphicon glyphicon-plus"></span>&nbsp;เพิ่มข้อมูล</a>
            </div>
        </div>
    </div>
    <table class="table table-hover table-striped table-condensed table-responsive">
    <thead>
        <tr>
          <th>ที่</th>
          <th>รหัส</th>
          <th>ชื่อ</th>
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
		$code= $result['code'];
		$name = $result['name'];
?>
              <Tr>
                  <Td><?=$N?></Td>
                  <Td><?=$code?></Td>
                  <Td><?=$name?></Td>
                  <Td><a href=?option=car&task=main/car_type&index=3&id=<?=$id?>&page=<?=$page?> data-toggle='confirmation' class='btn btn-danger' data-title="คุณต้องการลบข้อมูลนี้ใช่หรือไม่" data-btn-ok-label="ใช่" data-btn-ok-icon="glyphicon glyphicon-share-alt" data-btn-ok-class="btn-success" data-btn-cancel-label="ไม่ใช่!" data-btn-cancel-icon="glyphicon glyphicon-ban-circle" data-btn-cancel-class="btn-danger"><span class='glyphicon glyphicon-trash'></span></a></Td>
    <Td><a href=?option=car&task=main/car_type&page=<?=$page?>&index=1&id=<?=$id?>&ed=1 class='btn btn-warning'><span class='glyphicon glyphicon-pencil' ></span></a></Td>
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
    if(val=='0'){
        callfrm("?option=car&task=main/car_type");   // page ย้อนกลับ
    }else if(val=='1'){
        if(frm1.code.value == ""){
            alert("กรุณากรอกรหัส");
        }else if(frm1.name.value==""){
            alert("กรุณากรอกชื่อประเภท");
        }else{
            if(ed==1){
                callfrm("?option=car&task=main/car_type&index=6");   //page ประมวลผล edit
            }else{
                callfrm("?option=car&task=main/car_type&index=4");   //page ประมวลผล
            }
        }
    }
}
</script>
