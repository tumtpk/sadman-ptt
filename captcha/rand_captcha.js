 var captcha_text = "";

var btnVerify = document.getElementById("verifyButton");

// button to refresh captcha
var btnRefresh = document.getElementById("refreshButton");

// list of chars to include in captcha
var alpha = new Array('A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J', 'K', 'L', 'M', 'N', 'O', 'P', 'Q', 'R', 'S', 'T', 'U', 'V', 'W', 'X', 'Y', 'Z',
    'a', 'b', 'c', 'd', 'e', 'f', 'g', 'h', 'i', 'j', 'k', 'l', 'm', 'n', 'o', 'p', 'q', 'r', 's', 't', 'u', 'v', 'w', 'x', 'y', 'z',
    '0', '1', '2', '3', '4', '5', '6', '7', '8', '9');

// 2d context, used to write text as image
var tCtx = document.getElementById('textCanvas').getContext('2d');

// image element to show captcha
var imageElem = document.getElementById('image');

// font for captcha text, included in html file
var font = '270 27px "Cutive Mono"';

btnRefresh.onclick = function() {
    Captcha();
};

// 'Verify' button onclick, checks if user input is correct
btnVerify.onclick = function() {
    if (ValidCaptcha()) {
        document.getElementById('checkcaptcha').innerHTML = '';
    } else {

        document.getElementById('checkcaptcha').innerHTML = '<span style="color: red;font-weight:bold;">กรุณากรอกข้อความให้ตรงกับภาพ</span>';
        return false;
    }
};
// generates captcha text and converts it to image
function Captcha() {
    for (var i = 0; i < 6; i++) {
        var a = alpha[Math.floor(Math.random() * alpha.length)];
        var b = alpha[Math.floor(Math.random() * alpha.length)];
        var c = alpha[Math.floor(Math.random() * alpha.length)];
        var d = alpha[Math.floor(Math.random() * alpha.length)];
        var e = alpha[Math.floor(Math.random() * alpha.length)];
        var f = alpha[Math.floor(Math.random() * alpha.length)];
        var g = alpha[Math.floor(Math.random() * alpha.length)];
    }
    captcha_text = a + ' ' + b + ' ' + ' ' + c + ' ' + d + ' ' + e + ' ' + f + ' ' + g;

    document.fonts.load(font)
    .then(function() {
        tCtx.font = font;
        tCtx.canvas.width = tCtx.measureText(captcha_text).width;
        tCtx.canvas.height = 40;
        tCtx.font = font;
        tCtx.fillStyle = '#444';
        tCtx.fillText(captcha_text, 0, 20);

        var c = document.getElementById("textCanvas");
        var ctx = c.getContext("2d");
            // Draw lines
            for (var i = 0; i < 7; i++) {
                ctx.beginPath();
                ctx.moveTo(c.width * Math.random(), c.height * Math.random());
                ctx.lineTo(c.width * Math.random(), c.height * Math.random());
                ctx.strokeStyle = "rgb(" +
                Math.round(256 * Math.random()) + "," +
                Math.round(256 * Math.random()) + "," +
                Math.round(256 * Math.random()) + ")";
                ctx.stroke();
            }

            imageElem.src = tCtx.canvas.toDataURL();
        });

    document.getElementById('textCaptcha').value=removeSpaces(captcha_text);
}

// checks user input
function ValidCaptcha() {
    var string1 = removeSpaces(captcha_text);
    var string2 = removeSpaces(document.getElementById('txtInput').value);
    console.log(string1 + " " + string2);
    if (string1 === string2) {
        return true;
    } else {
        return false;
    }
}

// to improve the visibility of the text in the picture, spaces are added
// between the characters. This function removes spaces to compare captcha with user input
function removeSpaces(string) {
    return string.split(' ').join('');
}