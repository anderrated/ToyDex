const addItem = document.getElementById('add-item');

addItem.addEventListener('click', add);

// function add() {
//     const addPopup =  document.createElement('div');
//     addPopup.className = 'add-popup';
//     addPopup.id = 'add_Toy_Popup';
//     addPopup.innerHTML = `

//     <div class = "form_section" id = >
//         <form action = "addItem.php" class="" method= >
//             <h2>Add a New Toy</h2>

//             <label for="Toy_Name">Toy Name</label>
//             <input type = "text" name ="Toy_Name" required>

//             <label for="Description">Description</label>
//             <input type = "text" name ="Description" required>

//             <label for="Price">Price</label>
//             <input type = "text" name ="Price" required>

//             <label for="Manufacturer">Manufacturer</label>
//             <input type = "text" name ="Manufacturer" required>

//             <label for="Category">Category</label>
//             <input type = "text" name ="Category" required>

//             <button type="submit" class="">Add Toy</button>
//             <button type="button" class="" onclick="closeAddPopup()">Cancel</button>
//         </form>
//     </div>
//     `
// }



function closeAddPopup(){
    document.getElementById("add_section").style.display = "none";

}

function openAddPopup(){
    document.getElementById("add_Popup_Form").style.display = "block";
}