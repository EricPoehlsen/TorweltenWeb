//Retrieve and display skills based on search parameter 
//charid is character id
function getTraits(charid) {
    var charid = charid;
    xhr = new XMLHttpRequest();


    //handle answer from server
    xhr.onreadystatechange=function() {
        if (xhr.readyState==4 && xhr.status==200) {
            const result = JSON.parse(xhr.responseText);
            traitlist = document.getElementById("traitlist");
                        
            //clear the skill list
            traitlist.innerHTML = ""

            Object.keys(result).forEach(function(key) {
                //create container for each line
                traitline = document.createElement("div");
                traitline.className = "traitline";

                //create container for button
                button = document.createElement("button");
                button.className = "trait";
                button.setAttribute("id", key);
                if (result[key]["lvl"] > 0) {
                    button.innerHTML = result[key]["lvl"]; 
                } else {
                    button.innerHTML = "+"; 
                    button.setAttribute("onClick", "changeSkill(event, "+key+", "+charid+")");
                }
                traitline.appendChild(button);

                //create container for name
                traitname = document.createElement("div");
                traitname.className = "trait"
                traitname.setAttribute("onClick", "toggleView("+key+")");
                traitname.innerHTML = result[key]["title"];
                traitline.appendChild(traitname);

                //create container for description
                traitdesc = document.createElement("div");
                traitdesc.style.display = "none";
                traitdesc.setAttribute("id", key + "desc");
                traitdesc.setAttribute("ondblClick", "toggleEdit("+key+")");

                traitdesc.innerHTML = result[key]["desc"];
                traitline.appendChild(traitdesc);
                                
                
                //add skill to list
                traitlist.appendChild(traitline);
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
function changeSkill(event, skillid, charid) {
    // get Position of the click:
    clickpos = event.screenX;
    button = document.getElementById(skillid);
    box = button.getBoundingClientRect();
    midpoint = box.left + (box.width/2);
    
    // increase if button clicked right - decrease if clicked left
    action = ""
    if (button.innerHTML == "+") {
        action = "inc";
    } else {
        if (clickpos < midpoint) {
            action = "dec";
        } else {
            action = "inc";
        }
    }

    xhr = new XMLHttpRequest();
    xhr.open("POST", "modcharskill.php");
    xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
    xhr.send("skillid="+skillid+"&charid="+charid+"&action="+action); 

    //handle answer from server
    xhr.onreadystatechange=function() {
        if (xhr.readyState==4 && xhr.status==200) {
            button = document.getElementById(skillid);
            if (xhr.responseText > 0) {
                button.innerHTML = xhr.responseText;
            } else {
                button.innerHTML = "+";
            } 
        }
    }
    

}
