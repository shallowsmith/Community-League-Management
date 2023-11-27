function loadTeams() {
    var xhr = new XMLHttpRequest();
    xhr.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            var teams = JSON.parse(this.responseText);
            var html = "";
            for (var i = 0; i < teams.length; i++) {
                html += "<div class='team-card'><div class='team-name'>" + teams[i] + "</div></div>";
            }
            document.getElementById("team-list").innerHTML = html;
        }
    };
    xhr.open("GET", "getTeams.php", true);
    xhr.send();
}
window.onload = loadTeams;