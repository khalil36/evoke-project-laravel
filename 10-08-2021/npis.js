window.checkFieldName = function (val='', index=''){
    var items=[]; var existing_option ='';
    var numberOfColumns = document.getElementById("number_of_columns").value;
    for (var i = 0; i < numberOfColumns ; i++) {
        if (index != i ) {
            if (val != 'not_selected') {
                
                var objSelect = document.getElementById("field_" + i);
                existing_option = objSelect.options[objSelect.selectedIndex].text;

                if (objSelect.value == val) {

                    document.getElementById("field_" + index).value = 'not_selected';

                    alert(`"${existing_option}" is already selected`);
                    break;
                } else if (val == 'date') {
                    console.log('this is date');
                    var columValues = document.querySelectorAll('#map-table tr td:nth-child('+index+1 +')');
                    columValues.forEach(function (value, i) {
                        alert('this is the : '+value.innerHTML); // The element
                        //alert(i); // The index in the NodeList
                    });
                } 

            } 
        }  
       
    }

}


window.validateForm = function () {

    items=[];
    var numberOfColumns = document.getElementById("number_of_columns").value;
    for (var i = 0;  i < numberOfColumns ; i++) {
        var x = document.getElementById('field_'+i).value;
        items.push(x);
    }

    for (var i = 0;  i < numberOfColumns ; i++) {
        var x = document.getElementById('field_'+i).value;
        if (x == 'date') {

        }
        //items.push(x);
    }

    if (items) {
        var npi_required = document.getElementById('npi-required');

        if(items.indexOf('npi') > -1){
            npi_required.style.display = 'none';
            return true;
        } else {
            npi_required.style.display = 'block';
            return false;
        }

    }

    return false;
}




