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
    if(confirm("Are you Reali to delete data")){
    var arr=[];
   $(":checkbox:checked").each(function(key,value){
    arr[key]=$(this).val();
   });
//    console.log(arr);
   $.post({
    url:'src/delete.php',
    data:{de:arr},
    success:function(re){
        // console.log(re);
        
            window.location.reload();
        }
});
}
}

function load(){
    
    $.post({
        url:'src/adddata.php',
        success:function(re){
            console.log(re);
            }

    });
}


function deletedata(id){
    // if(confirm("Are you Reali to delete data")){
    $.post({
        url:'src/delete.php',
        data:{de:id.id},
        success:function(re){
            // console.log(re);
           if(re){
               window.location.reload();
           }
        }
    });
    // }
}


function updateOpen(id){
    // alert(`Update ${id.id}`);
    $.post({
        url:'src/loadmodel.php',
        data:{up:id.id},
        success:function(data,status,xhr){
            // console.log(`${data}`);
            $('body').append(data);
        },
        error:function(xhr,status,error){
            console.log(error);
        }
    });
}

// function updatedata(id){
//     alert(`Update ${id.id}`);
//     // $.post({
//     //     url:'src/update.php',
//     //     // data:{data:id},
//     //     success:function(re){
//     //         console.log(re);
//     //     }
//     // });
// }