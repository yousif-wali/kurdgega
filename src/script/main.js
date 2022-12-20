// Time Converter
const timeConverter = ()=>{
    let sectionTime = document.querySelectorAll("[data-change-time='simplify']");
    sectionTime.forEach((element)=>{

        let lastTime = new Date(element.innerHTML);
        let currentTime = new Date();
        let diff = currentTime.getTime() - lastTime.getTime();
        let result = diff / 1000;
        let type = "seconds";
        if(result > 60){ 
            type = "minutes";
        }if(result > 3600){
            type = "hours";
        }if(result > 3600 * 24){
            type = "days";
        }
        switch(type){
            case "minutes":
                result /= 60;
                break;
                case "hours":
                    result /= 3600;
                    break;
                    case "days":
                        result /= 3600 * 24;
                        break;
                        
                    }
                    if(parseInt(result) == 1){
        type = type.slice(0, -1)
    }
    element.innerHTML = parseInt(result) + " " + type + " ago";
    element.setAttribute("data-change-time", "simplified");
})
}
timeConverter();

setTimeout(()=>{
    timeConverter();
}, 90);