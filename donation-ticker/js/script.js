jQuery(document).ready(function($) {
    function updateDonation(raised) {
        var target = parseInt($('#dt-target').text());
        var percentage = (raised / target) * 100;
        $('#dt-raised').text(raised);
        $('.progress').css('width', percentage + '%');
    }
});