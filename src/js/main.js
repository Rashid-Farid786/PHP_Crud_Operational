    function message(message,status){
        let tag=document.createElement("h3");
        let text=document.createTextNode(message);
        tag.classList.add(status);
        tag.appendChild(text);
        document.write(tag.outerHTML);
        setTimeout(function(){
            tag.remove();
        },1000);
    }