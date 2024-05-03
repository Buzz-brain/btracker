let openMenu = document.getElementById("openMenu");
let menuOverlay = document.getElementsByClassName("menuOverlay")[0];
let remove = document.getElementsByClassName("remove")[0];

openMenu.addEventListener("click", function () {
  menuOverlay.style.transform = "translate(0%)";
  openMenu.src = "menuSwitch.png"
});
remove.addEventListener("click", function () {
  menuOverlay.style.transform = "translate(-100%)";
  openMenu.src = "menu.png"
});

let viewBtn = document.getElementsByClassName("viewBtn");
let viewMap = document.getElementById("viewMap");


for (i=0; i < viewBtn.length; i++) {
    let viewMap = viewBtn[i].parentElement.parentElement.nextElementSibling;
    let viewCancelBtn = viewBtn[i].firstElementChild;
    let viewCancelBtnImg = viewBtn[i].firstElementChild.firstElementChild;
    let viewIconBtn = viewBtn[i].firstElementChild.nextElementSibling;
    let viewIconBtnImg = viewBtn[i].firstElementChild.nextElementSibling.firstElementChild;

    viewCancelBtn.addEventListener("click", function() {
        viewMap.style.display = "table-row";
        viewMap.style.position = "relative";
        viewCancelBtn.style.display = "none";
        viewIconBtn.style.display = "block";
    })
    viewIconBtn.addEventListener("click", function() {
        viewMap.style.display = "none"
        viewIconBtn.style.display = "none";
        viewCancelBtn.style.display = "block";
    })
    
}