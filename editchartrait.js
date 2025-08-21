
//upate the value of the rank field
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