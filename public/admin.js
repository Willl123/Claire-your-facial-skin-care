const menuBtn = document.getElementById("menuBtn");

const sidebar = document.querySelector(".sidebar");

menuBtn.addEventListener("click",(e)=>{

    e.stopPropagation();

    sidebar.classList.toggle("show");

});

sidebar.addEventListener("click",(e)=>{

    e.stopPropagation();

});

document.addEventListener("click",()=>{

    sidebar.classList.remove("show");

});