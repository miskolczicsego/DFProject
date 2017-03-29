/**
 * Created by miskolczicsego on 2017.03.26..
 */


$(document).ready( function(){
    $('#feeder_numberOfFeedPerDay').change(function(){
    var selectedValue = parseInt($('#feeder_numberOfFeedPerDay option:selected').val());
    var i;
    var labelTexts = ["Etetési óra 1", "Etetési óra 2", "Etetési óra 3", "Etetési óra 4", "Etetési óra 5"];
    var html = '';
    console.log(selectedValue);
    for (i = 0 ; i < selectedValue; ++i) {
        html += '<label for="feed-hour-' + (i+1) + '">' + labelTexts[i] + '</label>';
        html += '<input id="feed-hour-' + (i+1) + '" name="feeder[feed-hour-' + (i+1)+ ']"/>';
        html += "<br />"
    }
    if (selectedValue > 0) {
        html += '<label for="scheduled-feed-quantity">Mennyiség</label>';
        html += '<input id="fscheduled-feed-quantity" name="feeder[scheduled-feed-quantity]"/>';
    }
    $('#feed-hours').html(html);
})
});