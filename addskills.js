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

                //lower button
                button_lower = document.createElement("button");
                // button_lower.className = "skill";
                button_lower.innerHTML = "◀"; 
                button_lower.setAttribute("onClick", "changeSkill("+key+", "+charid+", \"dec\")");
                skillline.appendChild(button_lower);
                //input field
                skill_input = document.createElement("input");
                skill_input.setAttribute("id", key);
                skill_input.className = "skill";
                skill_input.value = result[key]["lvl"];
                skillline.appendChild(skill_input);

                //raise button
                button_raise = document.createElement("button");
                // button_raise.className = "skill";
                button_raise.innerHTML = "▶"; 
                button_raise.setAttribute("onClick", "changeSkill("+key+", "+charid+", \"inc\")");
                skillline.appendChild(button_raise);

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
function changeSkill(skillid, charid, action) {

    xhr = new XMLHttpRequest();
    xhr.open("POST", "modcharskill.php");
    xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
    xhr.send("skillid="+skillid+"&charid="+charid+"&action="+action); 

    //handle answer from server
    xhr.onreadystatechange=function() {
        if (xhr.readyState==4 && xhr.status==200) {
            input = document.getElementById(skillid);
            input.value = xhr.responseText
        }
    }
    

}
