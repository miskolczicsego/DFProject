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
        html += '<h4><label for="feed-hour-' + (i+1) + '">' + labelTexts[i] + '</label></h4>';
        html += '<input id="feed-hour-' + (i+1) + '"class="form-control" name="feeder[feed-hour-' + (i+1)+ ']"/>';
        html += "<br />"
    }
    if (selectedValue > 0) {
        html += '<h4><label for="scheduled-feed-quantity">Mennyiség (g)</label></h4>';
        html += '<input id="fscheduled-feed-quantity" class="form-control" name="feeder[scheduled-feed-quantity]"/>';
    }
    $('#feed-hours').html(html);
})
});