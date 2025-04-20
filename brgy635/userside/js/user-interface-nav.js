const icon = document.querySelector(".icon");
const icon2 = document.querySelector(".icon2");
const sidenav2 = document.querySelector(".sidenav2");
const holder = document.querySelector(".holder");


sidenav2.style.display = "none"; 

icon2.addEventListener('click', function(){
    sidenav2.style.display = "none"; 
});

icon.addEventListener('click', function(){
    sidenav2.style.display = "flex";
});
