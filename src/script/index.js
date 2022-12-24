//  Deleting Post
const deletePost = (id)=>{
    Swal.fire({
        title: 'دڵنیاییت لە کردارەکەت؟',
        text: "لە دووای رازیبوون، ناتوانیت کردارەکە پوچەڵ کەیتەوە",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        cancelButtonText: "نەخێر",
        confirmButtonText: 'بەڵێ دڵنیام',
        
      }).then((result) => {
        if (result.isConfirmed) {
          let request = new XMLHttpRequest();
          request.open("GET", "./include/validator.php?productDeleteId=" + id);
          request.send();
          Swal.fire(
            'رەشکرایەوە',
            'بەڵاوکراوەکە بە سەرکەوتووی ڕەشکرایەوە!',
            'success'
          )
          setTimeout(
            ()=>{
              window.location.reload();
            },1000
          )
        }
      })
}
// Sending a report
const sendReport = (id)=>{
  Swal.fire({
    title: ':هۆکاری شکایەتەکەتمان پێبڵێ',
    input: 'text',
    inputAttributes: {
      autocapitalize: 'off'
    },
    showCancelButton: true,
    cancelButtonText: "پاشتگەستبوونەوە",
    confirmButtonText: 'ناردن',
    showLoaderOnConfirm: true,
    allowOutsideClick: () => !Swal.isLoading()
  }).then((result) => {
    if (result.isConfirmed) {
      console.log(result);
      let sendData = new XMLHttpRequest();
      sendData.open("GET", `./include/validator.php?reportProductId=${id}&reportMessage=${result.value}`);
      sendData.send();
      Swal.fire({
        title: `زانیاریەکەت گەیشت`,
        confirmButtonText: "زۆر باشە"
      })
    }
  })
}
/*      Show Likes For Products */
const showLikes = ()=>{
    let posts = document.querySelectorAll("[data-role='posts']");
    posts.forEach((elem)=>{
        id = elem.getAttribute("data-post");
        id = id.replace("post", "")
const URL = './include/validator.php?showLikesFor='+id;
const data = {
   "showLikesFor": id
};
// Send a post request
fetch(URL, {
   method: "POST",
   body: JSON.stringify(data),
   headers: {
      "Content-type": "application/json; charset=UTF-8"
   }
}).then(res=>res.json()).then((res)=>{
    elem.children[0].innerHTML = res;
})
    })
}
showLikes();
/*      Update Likes For Products */
const likePost = (username, product, button, userloggedin)=>{
    let request = new XMLHttpRequest();
    request.open("POST", "./include/validator.php?UserLiked="+username+"&ProductLiked="+product);
    request.send();
    showLikes();
    if(userloggedin != ""){
        button.children[1].classList.toggle("text-primary");
    }

}
// Remove Sliders from Carousel
const removeSliders = ()=>{
  let indicator = document.querySelectorAll("[data-type='imagePost'] .carousel-indicators");
  for(i = 0; i < indicator.length; i++){
    if(indicator[i].children.length == 1){
      document.querySelector(`#${indicator[i].parentNode.id} [data-bs-slide='next']`).style.display = "none";
      document.querySelector(`#${indicator[i].parentNode.id} [data-bs-slide='prev']`).style.display = "none";
      document.querySelector(`#${indicator[i].parentNode.id} .carousel-indicators`).style.display = "none";
    }
  }
}
removeSliders();
//  Show commentors
const showCommentors = ()=>{
  let commentHolder = document.querySelectorAll("[data-role='commendHolder']");
  commentHolder.forEach((commentElement)=>{
    fetch("./include/validator.php?showComments="+commentElement.getAttribute("data-post")).then(res=>res.json()).then(res=>{
      let temp = "";
      res.map((data)=>{
        if(data.username != " " && data.username != "" && data.username != null && data.username != undefined){
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
    result = parseInt(result);
          temp += `
          <section class="row justify-content-between border-bottom m-3 pe-2">
          
            <section class="col-4 border p-1">
              ${data.username}
            </section>
            <section class="col-8" dir="rtl">پێش ${result} ${type} </section>
            <section class="col-12" style="text-indent:1em;" data-type="mesage">
              ${data.comment}
            </section>
          </section>
          `;
        }else{
          temp = `
          <section dir="rtl">هییچ کۆمێنتێك نیە...</section>
          `;
        }

      })
      let kurdishComments = document.querySelectorAll('[data-type="mesage"]');
      kurdishComments.forEach((kurdish)=>{
        if(kurdish.innerHTML.charCodeAt(0)){
          kurdish.setAttribute("dir", "rtl")
        }
      })
      commentElement.innerHTML = temp;
    });
  })
}
showCommentors();
// update comment numbers
const updateCommentNumbers = ()=>{
  let posts = document.querySelectorAll("[data-type='commentNumbers']");
  posts.forEach((elem)=>{
    let postid = elem.getAttribute("data-post")
    fetch("./include/validator.php?showCommentNumber="+postid).then(res=>res.json()).then(
      res=>{
        elem.innerHTML = res.total;
      }
    );
  })
}
updateCommentNumbers();
//    Comment to a post
const commentToPost = (postId, element)=>{
  let msg = element.parentNode.children[0].value
  if(msg != ""){
    fetch("./include/validator.php?sendComment="+msg+"&postId="+postId).then(res=>res.text()).then(
      res=>{
        updateCommentNumbers();
        showCommentors();
        setTimeout(()=>{
          element.parentNode.children[0].value = "";
        }, 300)
      } 
    )
  }
}