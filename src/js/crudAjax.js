class crud{

constructor(){

}

confirm(text){
    if(confirm(text)){
        return true;
    }else{
        return false;
    }
}

update(data){
    $.post({
        url:'update.php',
        data:data,
        success:function(data){

        }
    });

}




delete(data){
    $.post({
        url:'delete.php',
        data:data,
        success:function(data){
            
        }
    });
}
}


function checkbox(){
    let check=document.querySelectorAll("input[type=checkbox]");
    if(check.checked){
            check.checked=false;
        }else{
            check.checked=true;
        }
    check.forEach(function(value,key){
        if(key==0){

        }
        if(value.checked){
            value.checked=false;
        }else{
            value.checked=true;
        }
    });
}


function deleteAll(){
    // let check=document.querySelectorAll("input[type=checkbox]");
    // check.forEach(function(value,key){
    //     if(value.checked){
    //         value.checked=false;
    //     }else{
    //         value.checked=true;
    //     }
    // });
}

function deletedata(id){
    // alert(`delete ${id.id}`);
    $.post({
        url:'src/delete.php',
        // data:{data:id},
        success:function(re){
            console.log(re);
        }
    });
}


function updateOpen(id){
    let html=`<div class='container'>
    <div class='row'>
    <div class='col-12'>
    
    </div>
    </div>
    </div>`;
}

function updatedata(id){
    // alert(`Update ${id.id}`);
    $.post({
        url:'src/update.php',
        // data:{data:id},
        success:function(re){
            console.log(re);
        }
    });
}
