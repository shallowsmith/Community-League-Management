// Loads all teams from the database and displays them on the page
function loadTeams() {
    var xhr = new XMLHttpRequest();
    xhr.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            var teams = JSON.parse(this.responseText);
            var html = "";
            for (var i = 0; i < teams.length; i++) {
                html += "<div class='team-card'>" +
                          "<div class='team-name'>" + teams[i].name + "</div>" +
                          "<div class='team-players'>Catchers: " + teams[i].catchers + "</div>" +
                          "<div class='team-players'>Pitchers: " + teams[i].pitchers + "</div>" +
                          "<div class='team-players'>Infield: " + teams[i].infield + "</div>" +
                          "<div class='team-players'>Outfield: " + teams[i].outfield + "</div>" +
                          "<div>Coach: " + (teams[i].coach || 'No coach assigned') + "</div>" +
                          "<button onclick='deleteTeam(" + teams[i].id + ")'>Delete</button>" +
                        "</div>";
            }
            document.getElementById("team-list").innerHTML = html;
        }
    };
    xhr.open("GET", "../src/getTeams.php", true);
    xhr.send();
}

// Deletes a team from the database
function deleteTeam(teamID) {
    var xhr = new XMLHttpRequest();
    xhr.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            alert(this.responseText);
            loadTeams(); 
        }
    };
    xhr.open("POST", "../src/deleteTeam.php", true);
    xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xhr.send("teamID=" + teamID);
}

window.onload = loadTeams;
