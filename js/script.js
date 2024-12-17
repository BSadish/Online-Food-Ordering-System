let scrollcontainer=document.querySelector(".slider-container")

let backBtn=document.getElementById("backBtn")
let nextBtn=document.getElementById("nextBtn")
scrollcontainer.addEventListener("wheel",(evt)=>{
    evt.preventDefault();
    scrollcontainer.scrollLeft += evt.deltaY;
    scrollcontainer.style.scrollBehavior="auto";
});

nextBtn.addEventListener("click",()=>{
    scrollcontainer.scrollBy({
        left: 900,
        behavior: 'smooth' // Smooth scroll to the right
    });
})
backBtn.addEventListener("click",()=>{
    scrollcontainer.style.scrollBehavior="smooth";
    scrollcontainer.scrollLeft-=900;
})