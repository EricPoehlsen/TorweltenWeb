//Retrieve and display traits based on search parameter 
//charid is character id
function getTraits(charid) {
    var charid = charid;
    xhr = new XMLHttpRequest();

    //handle answer from server
    xhr.onreadystatechange=function() {
        if (xhr.readyState==4 && xhr.status==200) {
            const result = JSON.parse(xhr.responseText);
            traitlist = document.getElementById("traitlist");
                        
            //clear the trait list
            traitlist.innerHTML = ""

            // rebuild it
            Object.keys(result).forEach(function(key) {
                //create container for each trait
                container = document.createElement("div");
                container.className = "container"

                // title line
                titleline = document.createElement("div");
                titleline.className = "line"

                // button to add trait
                button = document.createElement("button");
                button.className = "addtrait";
                button.setAttribute("id", key);
                if (result[key]["hastrait"] > 0) {
                    button.innerHTML = "✓"; 
                    button.disabled = true;
                } else {
                    button.innerHTML = "+"; 
                    button.setAttribute("onClick", "addTrait("+key+", "+charid+")");
                }
                titleline.appendChild(button);

                // Title Text
                traitname = document.createElement("div");
                traitname.setAttribute("onClick", "toggleView("+key+")");
                traitname.innerHTML = result[key]["title"];
                traitname.className = "traittitle";
                titleline.appendChild(traitname);

                // Cost
                traitcost = document.createElement("div")
                if (result[key]["maxrank"] > 1) {
                    traitcost.innerHTML = "(" + result[key]["xpcost"] + " pro Rang)";
                } else {
                    traitcost.innerHTML = "(" + result[key]["xpcost"] + ")";
                }
                titleline.appendChild(traitcost);
                container.appendChild(titleline);

                //create container for description
                traitdesc = document.createElement("div");
                traitdesc.style.display = "none";
                traitdesc.setAttribute("id", key + "desc");
                traitdesc.innerHTML = result[key]["desc"];
                container.appendChild(traitdesc);
                                
                
                //add skill to list
                traitlist.appendChild(container);
            });
        }
    }

    input = document.getElementById("search").value;
    xhr.open("POST", "gettraits.php");
    xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
    xhr.send("charid="+charid+"&input="+input);
}

// toggles the description field editable
function toggleEdit(id) {
    text = document.getElementById(id+"desc");
    if (text.hasAttribute("contenteditable")) {
        text.removeAttribute("contenteditable");
    } else {
        text.setAttribute("contenteditable", "true");
    }
}

function toggleView(id) {
    text = document.getElementById(id+"desc");
    if (text.style.display == "block") {
        text.style.display = "none";
    } else {
        text.style.display = "block";
    }
}


// add a character skill
function addTrait(traitid, charid) {
    xhr = new XMLHttpRequest();
    xhr.open("POST", "addchartrait.php");
    xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
    xhr.send("traitid="+traitid+"&charid="+charid); 

    //handle answer from server
    xhr.onreadystatechange=function() {
        if (xhr.readyState==4 && xhr.status==200) {
            console.log(xhr.responseText);
            button = document.getElementById(traitid);
            if (xhr.responseText > 0) {
                button.innerHTML = " ";
            } else {
                button.innerHTML = "+";
            } 
        }
    }
}
