/**
 * Created by klezaic on 24.04.17..
 */
$default_uri = window.location.hostname;
$selectedDropDownOption = 0;

$(document).ready(function () {

    $div = $("<div style='border: groove; padding: 20px, width:auto'></div>");
    $uri = $('<input />'), {
        type: 'text',
        value: 'uri',
        id: 'textBoxUri'
    };
    $btn = $('<input />', {
        type: 'button',
        value: 'Submit',
        id: 'buttonUriSubmit'
    });
    $res = $("<label id='labelScore'>");
    $dropDown = '<select id="dropDownRating">';
    for (var i = 0; i <= 10; i++) {
        $dropDown += '<option value="' + i + '">' + i + '</option>';
    }
    $dropDown += '</select>';

    $div.append('URI:<br>');
    $div.append($uri);
    $div.append('<br>Rating:<br> ');
    $div.append($dropDown);
    $div.append('<br>');
    $div.append($btn);
    $div.append('<br>Current Average Score:\t');
    $div.append($res);

    if ($("#URIRatingVoteSystem").length !== 0) {
        $("#URIRatingVoteSystem").append($div);
    }
    else {
        $('body').append($div);
    }

    $uri.val($default_uri);

    updateScore();
});

$(document).delegate('input', 'focusout', function () {
    updateScore();
});

function updateScore() {

    $.getJSON('http://localhost:8000/api/getAvgRating/' + $uri.val())
        .done(function (json) {
            $res.text(json.score);
        })
        .fail(function (jqxhr, textStatus, error) {
            $res.text(0);
        });
};

$(document).delegate('#dropDownRating', 'click', function () {
    $selectedDropDownOption = ($('#dropDownRating option:selected').text());
});

$(document).delegate('#buttonUriSubmit', 'click', function () {
    $vote = new Object();
    $vote.visitor_id = "Visitor_" + (Math.floor((Math.random() * 1000) + 1)).toString();
    $vote.uri = $uri.val();
    $vote.rating = parseInt($selectedDropDownOption);

    //jQuery.support.cors = true;

    $.ajax({
        type: 'POST',
        url: 'http://localhost:8000/api/setRating',
        crossDomain: true,
        data: JSON.stringify($vote),
        dataType: 'json',
        success: function (data) {
            $res.text(data.score);
        },
        contentType: 'application/json'
    });

});