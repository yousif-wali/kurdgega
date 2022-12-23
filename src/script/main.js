// Time Converter
const timeConverter = ()=>{
    let sectionTime = document.querySelectorAll("[data-change-time='simplify']");
    sectionTime.forEach((element)=>{

        let lastTime = new Date(element.innerHTML);
        let currentTime = new Date();
        let diff = currentTime.getTime() - lastTime.getTime();
        let result = diff / 1000;
        let type = "سانیە";
        if(result > 60){ 
            type = "دەقە";
        }if(result > 3600){
            type = "سەعات";
        }if(result > 3600 * 24){
            type = "ڕۆژ";
        }if(result > 3600 * 24 * 7){
            type = "هەفتە";
        }if(result > 3600 * 24 * 30){
            type = "مانگ";
        }if(result > 3600 * 24 * 30 * 12){
            type = "ساڵ";
        }
        switch(type){
            case "دەقە":
                result /= 60;
                break;
                case "سەعات":
                    result /= 3600;
                    break;
                    case "ڕۆژ":
                        result /= 3600 * 24;
                        break;
                        case "هەفتە":
                            result /= 3600 * 24 * 7 
                            break;
                        case "مانگ":
                            result /= 3600 * 24 * 30
                            break;
                        case "ساڵ":
                            result /= 3600 * 24 * 30 * 12
                            break;     
                    }
                    if(parseInt(result) == 1){
        type = type.slice(0, -1)
    }
    element.innerHTML = "پێش " + parseInt(result) + " " + type ;
    element.setAttribute("dir", "rtl");
    element.setAttribute("data-change-time", "simplified");
})
}
timeConverter();

setTimeout(()=>{
    timeConverter();
}, 90);