function showTeams(userType) {
    var teamSelection = document.getElementById('teamSelection');
    if (userType === 'team') {
        teamSelection.style.display = 'block';
        fetchTeams();
    } else {
        teamSelection.style.display = 'none';
    }
}

function fetchTeams() {
    var xhr = new XMLHttpRequest();
    xhr.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            document.getElementById('team_id').innerHTML = this.responseText;
        }
    };
    xhr.open("GET", "../src/getTeamsForRegistration.php", true);
    xhr.send();
}
