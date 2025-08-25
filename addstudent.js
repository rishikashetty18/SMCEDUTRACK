var selectedRow = null

function onFormSubmit(e) {
	event.preventDefault();
        var formData = readFormData();
        if (selectedRow == null){
            insertNewRecord(formData);
		}
        else{
            updateRecord(formData);
		}
        resetForm();    
}

//Retrieve the data
function readFormData() {
    var formData = {};
    formData["sid"] = document.getElementById("sid").value;
    formData["fname"] = document.getElementById("fname").value;
    formData["lname"] = document.getElementById("lname").value;
    formData["genderSelect"] = document.getElementById("genderSelect").value;
    formData["classSelect"] = document.getElementById("classSelect").value;
    
    return formData;
}

//Insert the data
function insertNewRecord(data) {
    var table = document.getElementById("storeList").getElementsByTagName('tbody')[0];
    var newRow = table.insertRow(table.length);
    cell1 = newRow.insertCell(0);
		cell1.innerHTML = data.sid;
    cell2 = newRow.insertCell(1);
		cell2.innerHTML = data.fname;
    cell3 = newRow.insertCell(2);
		cell3.innerHTML = data.lname;
    cell4 = newRow.insertCell(3);
		cell4.innerHTML = data.genderSelect;
    cell5 = newRow.insertCell(4);
		cell5.innerHTML = data.classSelect;
   
    cell6 = newRow.insertCell(5);
        cell6.innerHTML = `<button onClick="onEdit(this)">Edit</button> <button onClick="onDelete(this)">Delete</button>`;
}

//Edit the data
function onEdit(td) {
    selectedRow = td.parentElement.parentElement;
    document.getElementById("sid").value = selectedRow.cells[0].innerHTML;
    document.getElementById("fname").value = selectedRow.cells[1].innerHTML;
    document.getElementById("lname").value = selectedRow.cells[2].innerHTML;
    document.getElementById("genderSelect").value = selectedRow.cells[3].innerHTML;
    document.getElementById("classSelect").value = selectedRow.cells[4].innerHTML;
    
}
function updateRecord(formData) {
    selectedRow.cells[0].innerHTML = formData.sid;
    selectedRow.cells[1].innerHTML = formData.fname;
    selectedRow.cells[2].innerHTML = formData.lname;
    selectedRow.cells[3].innerHTML = formData.genderSelect;
    selectedRow.cells[4].innerHTML = formData.classSelect;
    
}

//Delete the data
function onDelete(td) {
    if (confirm('Do you want to delete this record?')) {
        row = td.parentElement.parentElement;
        document.getElementById('storeList').deleteRow(row.rowIndex);
        resetForm();
    }
}

//Reset the data
function resetForm() {
    document.getElementById("sid").value = '';
    document.getElementById("fname").value = '';
    document.getElementById("lname").value = '';
    document.getElementById("genderSelect").value = '';
    document.getElementById("classSelect").value = '';
    
    selectedRow = null;
}
