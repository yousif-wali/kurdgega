//  Showing the user profile
const  fromPage = (element)=>{
        let user =  element.innerHTML;
        user = user.replace(/\s/g, "");
        window.location = "./User/"+user;
}
//          Retrieve Messages
const getMessages = ()=>{
    fetch("./include/validator.php?retrieveMessages=true").then(res=>res.json()).then(res=>{
        let chats = document.getElementById("chats");
        let tempPost = "";
        res.map((data)=>{
            let lastTime = new Date(data.time);
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
        result = parseInt(result);
            if(data.chatFrom == userLoggedin && data.chatTo == messageTo){
                tempPost += `
                <section class="tos">
                <section >
                    <section class="border rounded position-relative" data-type="message">
                    ${data.message}
                    </section>
                    <section class="row">
                        <span dir="rtl" class="toTime col-8">
                        پێش ${result} ${type}
                        </span>
                        <span class="to col-4" onclick="window.location = './Profile'">
                            ${userLoggedin}
                        </span>
                    </section>
                </section>
                </section>
                `;
            }
            if(data.chatFrom == messageTo){
                tempPost += `
                <section class="froms">
                <section >
                <section class="border rounded position-relative" data-type="message">
                    ${data.message}
                </section>
                <section class="row">
                    <span class="from col-4" onclick="fromPage(this)">
                        ${messageTo}
                    </span>
                    <span dir="rtl" class="fromTime col-8">
                        پێش ${result} ${type}
                    </span>
                </section>
            </section>
            </section>
                `;
            }
        })
        
        chats.innerHTML = tempPost;
        window.scrollTo(0,document.body.scrollHeight);
    });
}
//          Get Chat History
const chatHistory = ()=>{
    fetch("./include/validator.php?chatHistory=true").then(res=>res.json()).then(res=>{
        let chats = document.getElementById("chatHistory");
        let tempPost = "";
        res.map((data)=>{
            let lastTime = new Date(data.time);
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
            }
            if(result > 3600 * 24 * 30){
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
        result = parseInt(result);
            tempPost += `
            <section class="row align-items-center border-bottom chatProfile" data-type="${data.username}" onclick="changeChatProfile(this)">
            <img class="col-2 rounded-circle" src="./src/images/users/${data.username}/profile/profile.png"/>
            <span class="col-4">${data.chatFrom}</span>  
            <span dir='rtl' class="col-5 text-end" style="font-size:0.8rem;">پێش ${result} ${type}</span>       
            </section>
            `;
        })
        chats.innerHTML = tempPost;
    });
}
getMessages();
chatHistory();
//          SENDING MESSAGES
const sendMessage = async()=>{
    let message = document.querySelector('[data-role="sending"]').value;
    const sendingMessage = new Promise((send, reject)=>{
        async function transportData(){
           await fetch("./include/validator.php?sendingMessage="+message).then(res=>res.json()).then(res=>{
                if(res.status ==  "sent"){
                    send();
                }else{
                    reject();
                }
            });
        }
        transportData();
    });
    sendingMessage.then((data)=>{
        //  function to show messages
        getMessages();
        setTimeout(function(){
            message = "";
            document.querySelector('input').value = "";
        }, 200)
        window.scrollTo(0,document.body.scrollHeight);
    }).catch((data)=>{console.log(data)})
}
//          Changin Chat on click
const changeChatProfile = (elem)=>{
        let user = elem.getAttribute("data-type");
        messageTo = user;
        let changeProfile = new XMLHttpRequest();
        changeProfile.open("GET", "./include/validator.php?changeProfile="+messageTo);
        changeProfile.send();
        getMessages();
        chatHistory();
    if(window.innerWidth < 600){
      document.querySelector('[data-role="layout"] aside').style.zIndex = 4;
      document.querySelector('[data-role="layout"] main').style.zIndex = 5;
    }
}
//      WARNING: FOR MOBILES ONLY
const changeBackground = ()=>{
    document.querySelector('[data-role="layout"] aside').style.zIndex = 5;
      document.querySelector('[data-role="layout"] main').style.zIndex = 4;
}
//      Scroll Messages to bottom
document.getElementById("chats").scrollTop = document.getElementById("chats").clientHeight;

//  Changing Text directions
setTimeout(()=>{
    let RTLmessages = document.querySelectorAll("[data-type='message']");
    RTLmessages.forEach((elem)=>{
      if(elem.innerHTML.replaceAll(" ", "").replace("\n", "").charCodeAt(0) > 127){
          elem.setAttribute("dir", "rtl")
      }
    })
},100)