function loadTeams() {
    var xhr = new XMLHttpRequest();
    xhr.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            var teams = JSON.parse(this.responseText);
            var html = "";
            for (var i = 0; i < teams.length; i++) {
                html += "<div class='team-card'><div class='team-name'>" + teams[i].name +
                        "</div><div class='team-players'>" + teams[i].players +
                        "</div><button onclick='deleteTeam(" + teams[i].id + ")'>Delete</button></div>";
            }
            document.getElementById("team-list").innerHTML = html;
        }
    };
    xhr.open("GET", "../src/getTeams.php", true);
    xhr.send();
}

function deleteTeam(teamID) {
    var xhr = new XMLHttpRequest();
    xhr.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            alert(this.responseText);
            loadTeams(); // Reload the team list
        }
    };
    xhr.open("POST", "../src/deleteTeam.php", true);
    xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xhr.send("teamID=" + teamID);
}

window.onload = loadTeams;
