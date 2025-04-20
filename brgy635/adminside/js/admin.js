// xmark icon
const icon2 = document.querySelector(".icon2");
const sidebar = document.querySelector(".sidebar");
// burger icon
const iconbar = document.querySelector(".iconbar");

// sidebar.style.backgroundColor = "red";
// icon2.style.color = "red";


// iconbar.style.color = "red";

iconbar.addEventListener('click', function(){
    sidebar.style.display = "none";
    if(sidebar.style.display === "none"){
        sidebar.style.display = "block";
    }
});

icon2.addEventListener('click', function(){
    if(sidebar.style.display === "block"){
        sidebar.style.display = "none";
    }
});

