const addItem = document.getElementById('add-item');

addItem.addEventListener('click', add);


function closeAddPopup(){
    document.getElementById("add_section").style.display = "none";

}

function openAddPopup(){
    document.getElementById("add_Popup_Form").style.display = "block";
}
