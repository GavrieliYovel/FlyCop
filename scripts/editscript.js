window.onload = () => {
    resetFormBtn();
}


let outputs = document.getElementsByTagName('output');
let ranges = document.querySelectorAll('input[type=range]');

function func(i, val) {
    outputs[i].value = val;
};



function resetFormBtn() {

    document.getElementById("resetBtn").onclick = () => {
        for (let i = 0; i < outputs.length; i++) {
            outputs[i].value = ranges[i].min;
            ranges[i].value = ranges[i].min;
        }
    }
    return;
};


$(document).ready(function () {
    $("#standStill").click(function () {
        $("#maxDistance").attr("disabled", "disabled");
    });

    $("#patrol").click(function () {
        $("#maxDistance").removeAttr("disabled");
    });
});



function showMissionSC(missionSC) {

    let scDiv = document.getElementById("missSC");
    let idx = 1;
    for (const sc of missionSC.shortcuts) {
        let btn = document.createElement('button');
        btn.className = "btn btn-secondary";
        btn.id = "btn" + idx;
        btn.innerHTML = sc["missionName"];
        let mission = document.querySelectorAll('input[type=radio]')
        btn.onclick = () => {

            if (mission[0].value == sc["type"]) {
                mission[0].checked = 'cheked';
                ranges[2].disabled = false;

            }
            else {
                mission[1].checked = 'cheked';
                ranges[2].disabled = true;
            }
            ranges[0].value = outputs[0].value = sc["duration"];
            ranges[1].value = outputs[1].value = sc["maxAltitude"];
            ranges[2].value = outputs[2].value = sc["maxDistance"];

        }
        scDiv.appendChild(btn);
        idx++;
    }


}


fetch("json/missonshortcuts.json")
    .then(response => response.json())
    .then(data => showMissionSC(data));



