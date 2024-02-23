<?php

if(!$this->con->error){
$this->data="
<table class='crudtable table table-sm table-borderless table-responsive-md crudtable'>
<thead class='thead-dark w-100'>
<tr>
<th class='text-center'><input type='checkbox' id='check' onclick='checkbox()'/></th>";
foreach($this->fields as $key=>$value){
    $this->data.="
    <th scope='col' class='text-center'>".$value['Field']."</th>";
}
if($this->edit_btn !=true){
$this->data.="
<th class='text-center'>Update</th>";
}
if($this->delete_btn !=true){
$this->data.="
<th class='text-center'>Delete</th>";
}
if(count($this->btns)>0){
    $this->data.="
    <th class='text-center'>Custom Buttons</th>";
}
$this->data.="
</tr>
</thead>";
}
$sql1="SELECT * FROM {$this->table} LIMIT {$this->offset},{$this->limit}";
$result1=$this->customquery($sql1);
//    echo "<pre>";
//    print_r($result1);die();
if(count($result1) != 0){
$this->getid=reset($result1[0])??"";
foreach($result1 as $value){
if(is_array($value) OR (is_object($value))){
    if($this->delete_list_btn !=true){
    $this->data.="
    <tr>
    <td class='text-center'>
    <input type='checkbox' value='{$this->getid}' name='checkbox'/>
    </td>";
}
    // $id=$this->getid+1;
foreach($value as $key=>$value1){
if($key == 'id'){
    $this->getid=$value['id'];
}
//     echo "<pre>";
//    echo $value1 ;die();
if($key == 0 && $value1 !=null){
    $this->data .="
    <td class='text-center'>".str_replace("'",'',$value1)."</td>";
}
elseif((is_string($value1))){
    if(strlen($value1)>100){
        $this->data .="
        <td class='text-center'>".str_replace("'",'',substr($value1,0,10))."</td>";
    }
    // else{
    //     $this->data .="
    //     <td class='text-center'>".str_replace("'",'',$value1)."</td>";
    // }
}
$str=$value1??"";
$this->data .="
<td class='text-center'>".str_replace("'",'',$str)."</td>";
}
if($this->edit_btn !=true){
$this->data.="
<td class='text-center'>
<button id='".$this->getid."' onclick='updateOpen(this)'>
&#8634;
</button>
</td>";
}
if($this->delete_btn !=true){
    $this->data.="
<td class='text-center'>
<button id='".$this->getid."' onclick='deletedata(this)'>
X
</button>
</td>";
}
if(count($this->btns)>0){
    $this->data.="<td class='w-auto p-2'>";
    foreach($this->btns as $ke=>$value){
        $add_class='';
        $add_attr='';
        if($value['class'] !==''){
            $add_class=$value['class'];
        }
        if(count($value['attr'])>0){
            foreach($value['attr'] as $key1=>$value1){
            $add_attr.="{$key1}='{$value1}' ";
            }
        }
        $this->data.="<a href='{$value['link']}' class='inline d-inline m-2 {$add_class}' $add_attr >{$value['name']}</a>";
    }
    $this->data.="</td>";
}
$this->data.="
</tr>";
$this->getid++;
}
}

$this->data.="</table>";
$previus=0;
$nest=0;
$pages=0;
// if(!isset($_GET['page'])){
// $pages=$_GET['page']?$_GET['page']:0;
// }
if($this->pagination){
$sql="SELECT * FROM {$this->table}";
$e=$this->con->query($sql);
if($e->num_rows()>0){
if(isset($_GET['page'])){
 $this->offset=($pages-1)*$this->limit;
    $this->total_pages=ceil($e->num_rows()/$this->limit);
    // echo "Page set ".$e->num_rows;
    $previus=$pages-1;
    $nest=$pages+1;
}else{
 $this->offset=(0-1)*$this->limit;
    $this->total_pages=ceil($e->num_rows()/$this->limit);
    // echo "Page Not Set ".$e->num_rows;        
}
}
        

$this->data.="
<table class='table w-10 text-center'>
<nav class='page navigation example'>
<ul class='pagination list-group'>
<tr>";
if($pages>1){
    $this->data.="<td  class='page-item'>
    <li' class='page-item'>
    <a href='{$_SERVER['PHP_SELF']}?page={$previus}' class='page-link'>Previus</a>
    </td>"; 
}
for($i=1;$i<=$this->total_pages;$i++){
if($this->total_pages >=8){

}else{

}
$active="";
if(isset($_GET['page'])){
if($_GET['page']== $i){
$active="active";
}else{
$active="";
}
}
$this->data.="
<td>
<li style='list-style:none;' class='page-item'>
<a href='{$_SERVER['PHP_SELF']}?page={$i}' class='page-link {$active}'>{$i}</a>
</li>
</td>";
}
if($pages < $this->total_pages){
$this->data.="<td>
<li style='list-style:none;' class='page-item'>
<a href='{$_SERVER['PHP_SELF']}?page= class='page-link'>Next</a>
</li>
</td>
</ul>
</nav>";
}
$this->data.="</tr></table>";
}   
}
echo $this->data;

?>