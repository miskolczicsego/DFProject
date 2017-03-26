/**
 * Created by miskolczicsego on 2017.03.26..
 */


$('#feeder_numberOfFeedPerDay').change(function(){
    var selectedValue = parseInt($('#feeder_numberOfFeedPerDay option:selected').val()) + 1;
    var i;
    var labelTexts = ["Etetési óra 1", "Etetési óra 2", "Etetési óra 3", "Etetési óra 4", "Etetési óra 5"];
    var html = '';
    console.log(selectedValue);
    for (i = 0 ; i < selectedValue; ++i) {
        html += '<label for="feed-hour-' + (i+1) + '">' + labelTexts[i] + '</label>';
        html += '<input id="feed-hour-' + (i+1) + '" name="feeder[feed-hour-' + (i+1)+ ']"/>';
        html += "<br />"
    }

    $('#feed-hours').html(html);
})