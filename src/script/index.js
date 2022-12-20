const deletePost = (id)=>{
    Swal.fire({
        title: 'Are you sure?',
        text: "You won't be able to revert this!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes, delete it!'
      }).then((result) => {
        if (result.isConfirmed) {
          let request = new XMLHttpRequest();
          request.open("GET", "./include/validator.php?productDeleteId=" + id);
          request.send();
          Swal.fire(
            'Deleted!',
            'Your file has been deleted.',
            'success'
          )
          window.location.reload();
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
    result = parseInt(result);
          temp += `
          <section class="d-flex justify-content-between border-bottom m-3 pe-2">
          
          <section>
            <section class="border p-1">
              ${data.username}
            </section>
            <section style="text-indent:1em;">
              ${data.comment}
            </section>
          </section>
  
  
          <section>${result} ${type} ago</section>
          </section>
          `;
        }else{
          temp = `
          <section>No Comments Yet...</section>
          `;
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