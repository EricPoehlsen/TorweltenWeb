//Retrieve and display skills based on search parameter 
//charid is character id
function getSkills(charid) {
    var charid = charid;
    xhr = new XMLHttpRequest();


    //handle answer from server
    xhr.onreadystatechange=function() {
        if (xhr.readyState==4 && xhr.status==200) {
            console.log(xhr.responseText);
            const result = JSON.parse(xhr.responseText);
            skilllist = document.getElementById("skilllist");
                        
            //clear the skill list
            skilllist.innerHTML = ""

            Object.keys(result).forEach(function(key) {
                //create container for each line
                skillline = document.createElement("div");
                skillline.className = "skillline";

                //create container for button
                button = document.createElement("button");
                button.className = "skill";
                button.setAttribute("id", key);
                if (result[key]["lvl"] > 0) {
                    button.innerHTML = result[key]["lvl"]; 
                } else {
                    button.innerHTML = "+"; 
                    button.setAttribute("onClick", "changeSkill(event, "+key+", "+charid+")");
                }
                skillline.appendChild(button);

                //create container for name
                skillname = document.createElement("div");
                skillname.className = "skill"
                skillname.innerHTML = result[key]["skill"];
                skillline.appendChild(skillname);
                
                //add skill to list
                skilllist.appendChild(skillline);
            });
        }
    }

    input = document.getElementById("search").value;
    xhr.open("POST", "getskills.php");
    xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
    xhr.send("charid="+charid+"&input="+input);
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
