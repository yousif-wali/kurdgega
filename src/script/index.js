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