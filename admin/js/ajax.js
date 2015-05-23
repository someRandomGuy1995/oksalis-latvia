
function block()
{
    if (($('#adminPanelButtonBrowse').val() == "") || ($('#cipocka').val() == "") || ($('#title1').val() == "") || ($('#type').val() == "")) {
        alert('Fill all fields!');
        return false;
    }
}

function block2()
{
    if (($('#title1').val() == "") || ($('#type').val() == ""))
    {
        alert('Fill all fields!');
        return false;
    }
}

function block3()
{
    if (($('#title1').val() == "") || ($('#type').val() == "") || ($('#price').val() == ""))
    {
        alert('Fill all fields!');
        return false;
    }
}

function image()
{
    var fileInput = document.getElementById('adminPanelButtonBrowse');
    var file = fileInput.files[0];

    var reader = new FileReader();
    reader.onload = function(event)
    {
        var src = event.target.result;
        $('#picture').css('background-image','url(' + src + ')');
        $('#picture2').css('background-image','url(' + src + ')');

    };
    reader.readAsDataURL(file);
}

function image2()
{
    var fileInput = document.getElementById('cipocka');
    var file = fileInput.files[0];

    var reader = new FileReader();
    reader.onload = function(event)
    {
        var src = event.target.result;
        $('#picture').css('background-image','url(' + src + ')');
        $('#picture2').css('background-image','url(' + src + ')');

    };
    reader.readAsDataURL(file);
}


$(document).ready(function()
{
    //$('#maindiv').animate({'opacity': '1'},1000,function()
    //{
        $('#opacity').animate({'opacity': '1'}, 700);
   // });

});

$(document).ready(function()
{
    $('table').hide().fadeIn(300);
});

$(document).ready(function()
{
    $('#form').animate({'opacity':'1'},300);
    $('#testing').animate({'opacity':'1'},300);
    $('#testing2').animate({'opacity':'1'},300);
    $('#delete').animate({'opacity':'1'},300);
    $('#message').animate({'opacity':'1'},300);
    $('#divform').animate({'opacity':'1'},300);
});

$(document).ready(function() {
        var angle = 0;
        setInterval (function() {

        angle += 0.1;

        $('#dii').css({transform:'rotate('+angle+'deg)'});


    },50)

});

