"use strict";

$(document).ready(function () {
    // Initialize flash deal progress bar if function exists
    if (typeof updateFlashDealProgressBar === 'function') {
        updateFlashDealProgressBar();
        setInterval(updateFlashDealProgressBar, 10000);
    }
});
