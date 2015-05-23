$(document).ready(function() {
    var angle = 0;
    setInterval (function() {
        angle += 0.1;
        $('#dii').css({transform:'rotate('+angle+'deg)'});
    },15)
});


function image() {
    var fileInput = document.getElementById('file');
    var file = fileInput.files[0];

    var reader = new FileReader();
    reader.onload = function(event) {
        var src = event.target.result;
        $('.coursePhoto').css('background-image','url(' + src + ')');
    };
    reader.readAsDataURL(file);
}


$(document).ready(function() {
    $('input[type=radio][name=radio1]').change(function(){
        if($('input[name=radio1]:checked').val() == "cenaMin") {
            var myArray = $(".viewport");
            myArray.sort(function (a, b) {
                // convert to integers from strings
                a = parseFloat($(a).attr("data-price"));
                b = parseFloat($(b).attr("data-price"));

                // compare
                if(a > b) {
                    return 1;
                } else if(a < b) {
                    return -1;
                } else {
                    return 0;
                }
            });
            $("#sjuda").append(myArray);
        }

        else  if($('input[name=radio1]:checked').val() == "cenaMax") {
            var myArray = $(".viewport");
            myArray.sort(function (a, b) {
                // convert to integers from strings
                a = parseFloat($(a).attr("data-price"));
                b = parseFloat($(b).attr("data-price"));

                // compare
                if(a < b) {
                    return 1;
                } else if(a > b) {
                    return -1;
                } else {
                    return 0;
                }
            });
            $("#sjuda").append(myArray);
        }

        else  if($('input[name=radio1]:checked').val() == "nosA") {
            var myArray = $(".viewport");
            myArray.sort(function (a, b) {
                var res1 = $(a).attr("data-name").charAt(0);
                a = res1.charCodeAt(0);

                var res2 = $(b).attr("data-name").charAt(0);
                b = res2.charCodeAt(0);

                // compare
                if(a > b) {
                    return 1;
                } else if(a < b) {
                    return -1;
                } else {
                    return 0;
                }
            });
            $("#sjuda").append(myArray);
        }

        else  if($('input[name=radio1]:checked').val() == "nosZ") {
            var myArray = $(".viewport");
            myArray.sort(function (a, b) {
                var res1 = $(a).attr("data-name").charAt(0);
                a = res1.charCodeAt(0);

                var res2 = $(b).attr("data-name").charAt(0);
                b = res2.charCodeAt(0);

                // compare
                if(a < b) {
                    return 1;
                } else if(a > b) {
                    return -1;
                } else {
                    return 0;
                }
            });
            $("#sjuda").append(myArray);
        }
    });

});


$(document).ready(function() {
    var width = 1050;
    var speed = 1500;
    var pause = 6000;
    var slide = 1;

    setInterval(function() {
        $('.slides').animate({'margin-left': '-='+width}, speed, function(){
            slide++;
            if(slide == 5)
            {
                $('.slides').css('margin-left','0');
                slide = 1;
            }
        })
    },pause)
});


// Cool hover zoom effect

$(document).ready(function() {
    $('.viewport').mouseenter(function(e) {
        $(this).children('a').children('img').animate({ height: '140', left: '0', top: '0', width: '235'}, 100);
        $(this).children('a').children('span').fadeIn(200);
    }).mouseleave(function(e) {
        $(this).children('a').children('img').animate({ height: '130', left: '0', top: '0', width: '225'}, 100);
        $(this).children('a').children('span').fadeOut(200);
    });
});


// zooming

$(document).ready(function() {
    $("#zoom_01").mouseenter(function(){
        $("#zoom_01").elevateZoom();
    });
});


// courses form data validation

$(document).ready(function(){
    $("#courseForm" ).on('change',function() {
        var count = 0;
        var values = {};

        $.each($('#courseForm').serializeArray(), function (i, field) {
            values[field.name] = field.value;
            if (field.value != '') {
                count++;
            }
            if (count > 4) {
                console.log('5 input fields are not empty!!');
                $('#submitCoursesForm').prop("disabled", false).removeAttr("disabled");
            }
        });
        console.log(count);
    })
});

$(document).ready(function(){
    $('#showForm').on('click', function(){
        $(".courseApply").slideDown(500);
        $('#showForm').css({'display': 'none'});
    })
});

$(document).ready(function(){
    $('#close').on('click', function(){
        $('.alert-success').slideUp(500);
        $('.alert-warning').slideUp(500);
    })
});