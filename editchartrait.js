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


function changeRank(action, maxrank) {
    maxrank = maxrank || 1;
    input = document.getElementById("rank");
    rank = parseInt(input.value);    
    if (action == "up" && rank < maxrank) {
        rank += 1;
    } else if (action == "down" && rank > 0) {
        rank -= 1;
    }
    input.value = rank;
}