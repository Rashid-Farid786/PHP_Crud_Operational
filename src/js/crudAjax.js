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
    var arr=[];
    $(":checkbox:checked").each(function(key,value){
        arr[key]=$(this).val();
    });
    // console.log(arr);
    if(arr.length != 0){
    if(confirm("Are you Reali to delete data")){
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
    }else{
        alert("You Not Selected Deleted Value");
    }
}

function load(){
    
    $.post({
        url:'src/adddata.php',
        success:function(re){
            // console.log(re);
            $('body').append(re);
            }
        

    });
}


function deletedata(id){
    $.post({
        url:'src/delete.php',
        data:{de:id.id},
        success:function(re){
            // console.log(re);
           if(re == 1){
            alert("Data Deleted");
               window.location.reload();
           }else{
            alert("Data Not Deleted");
           }
        }
    });
}


function updateOpen(id){
    $.post({
        url:'src/loadmodel.php',
        data:{up:id.id},
        success:function(data,status,xhr){
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

function toggle() {
    var password = document.getElementById("text");
    if (password.type == 'password') {
        password.type = 'text';
    } else {
        password.type = 'password';
    }
}

function add(){

}

function model(){
    document.querySelector(".modal-backdrop").remove();
    document.querySelector(".modal").remove();
}