var total_points = 0;
var total_votes = 0;
var percentage = 0;
var rounded_percentage = 0;
var application_type = "super";
var approved = false;

function submit_vote(points) {
	total_points += points;
	total_votes++;
	percentage = (total_points / total_votes) * 100;
	rounded_percentage = Math.round(percentage);
	update_score();
}

function update_score() {
	document.getElementById("points").innerHTML = total_points;
	document.getElementById("total_votes").innerHTML = total_votes;
	document.getElementById("rounded_percentage").innerHTML = rounded_percentage;
	document.getElementById("percentage").innerHTML = percentage;
	application_type = document.getElementById("type").value;

	if (application_type == "super" && rounded_percentage >= 60) {
		approved = true;
	} else if (application_type == "telnet" && rounded_percentage >= 65) {
		approved = true;
	} else if (application_type == "senior" && rounded_percentage >= 70) {
		approved = true;
	} else {
		approved = false;
	}

	if (approved) {
		document.getElementById("status").style = "color: #0f0;";
		document.getElementById("status").innerHTML = "Accepted";
	} else {
		document.getElementById("status").style = "color: #f00;";
		document.getElementById("status").innerHTML = "Denied";
	}
}