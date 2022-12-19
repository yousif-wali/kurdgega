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
            if(data.chatFrom == userLoggedin && data.chatTo == messageTo){
                tempPost += `
                <section class="tos">
                    <section class="border rounded position-relative" data-type="message">
                    ${data.message}
                    </section>
                    <section class="row">
                        <span class="toTime col-8">
                        ${data.time}
                        </span>
                        <span class="to col-4" onclick="window.location = './Profile'">
                            ${userLoggedin}
                        </span>
                    </section>
                </section>
                `;
            }
            if(data.chatFrom == messageTo){
                tempPost += `
                <section class="froms">
                <section class="border rounded position-relative" data-type="message">
                    ${data.message}
                </section>
                <section class="row">
                    <span class="from col-4" onclick="fromPage(this)">
                        ${messageTo}
                    </span>
                    <span class="fromTime col-8">
                        ${data.time}
                    </span>
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
            tempPost += `
            <section class="row align-items-center border-bottom chatProfile" data-type="${data.username}" onclick="changeChatProfile(this)">
            <img class="col-2 rounded-circle" src="./src/images/users/${data.username}/profile/profile.png"/>
            <span class="col-4">${data.chatFrom}</span>  
            <span class="col-5 text-end" style="font-size:0.8rem;">${data.time}</span>       
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
        message = "";
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
}
