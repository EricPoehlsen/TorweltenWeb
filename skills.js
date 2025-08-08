//Retrieve and display skills based on search parameter 
//charid is character id
function getSkills(charid) {
    xhr = new XMLHttpRequest();


    //handle answer from server
    xhr.onreadystatechange=function() {
        if (xhr.readyState==4 && xhr.status==200) {
            const result = JSON.parse(xhr.responseText);
            
            //const result = JSON.parse(xhr.responseText);
            //document.getElementById(result.attr).value=result.value;
            console.log(xhr.responseText); 
        }
    }

    input = document.getElementById("search").value;
    xhr.open("POST", "getskills.php");
    xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
    xhr.send("charid="+charid+"&input="+input);

}