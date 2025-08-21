//update a characters attribute 
//action is inc(rease), dec(rease) or set
//id is character id
function updateAttrib(attr,action,id) {
    xhr = new XMLHttpRequest();

    //handle answer from server
    xhr.onreadystatechange=function() {
        if (xhr.readyState==4 && xhr.status==200) {
            const result = JSON.parse(xhr.responseText);
            document.getElementById(result.attr).value=result.value;
            console.log(result.attr); 
        }
    }

    xhr.open("POST", "updateattribute.php");
    xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
    xhr.send("attr="+attr+"&action="+action+"&charid="+id);

}

//set character as public of private
function setPublic(charid) {
    xhr = new XMLHttpRequest();

    //handle answer from server
    xhr.onreadystatechange=function() {
        if (xhr.readyState==4 && xhr.status==200) {
            console.log(xhr.responseText); 
        }
    }

    public = document.getElementById("public").checked;
    console.log(public);


    xhr.open("POST", "setcharpublic.php");
    xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
    xhr.send("public="+public+"&charid="+charid);
}