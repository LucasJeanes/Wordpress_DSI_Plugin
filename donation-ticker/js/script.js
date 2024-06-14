jQuery(document).ready(function($) {
    // Example function to update donation amount dynamically
    function updateDonation(raised) {
        var target = parseInt($('#dt-target').text());
        var percentage = (raised / target) * 100;
        $('#dt-raised').text(raised);
        $('.progress').css('width', percentage + '%');
    }

    // Example usage: Update donation amount after 3 seconds
    setTimeout(function() {
        updateDonation(500); // Update with new raised amount
    }, 3000);
});
