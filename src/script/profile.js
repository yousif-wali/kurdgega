const showSelected = ()=>{
    let selected = document.getElementsByTagName("aside")[0].getAttribute("data-selected");
    let elements = document.querySelector("[data-type='selection']").children;
    for(i = 0; i < elements.length; i++){
        elements[i].style.display = "none";
        if(elements[i].getAttribute("data-select") == selected){
            elements[i].style.display = "block";
        }
    }
   
}
const select = (e, name)=>{
    let checked = document.querySelector('[data-element="aside"] .btn-primary');
    if(checked){
        checked.classList.add('btn-secondary');
        checked.classList.remove('btn-primary');
    }
    e.classList.add("btn-primary");
    e.classList.remove("btn-secondary");
    e.parentNode.parentNode.setAttribute("data-selected", name);
    fetch("include/validator.php?profileSelected="+name);
    showSelected();
}
const selected = ()=>{
    cookies = document.cookie.split(";");
    i = 0;
    for(j = 0; j < cookies.length; j++){
        if(cookies[j].match("profileSelected")){
            i = cookies[j].match("profileSelected").index
        }else{
            continue;
        }

    }
    let chosen = cookies[i]
    let value = chosen.split("=")[1];
    let element = document.querySelector(`[data-type-for="${value}"]`);
    select(element, value);
}
selected();