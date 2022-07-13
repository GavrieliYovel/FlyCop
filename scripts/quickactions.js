window.onload = () => {
    if (getBtnId()) {
        clickBtn();
    }
};

function getBtnId() {
    let aKeyValue = window.location.search.substring(1).split("&");
    let btnId = aKeyValue[0].split("=")[1];
    return btnId;
};


function clickBtn() {
    let btn = getBtnId();
    document.getElementById(btn).click();
};

