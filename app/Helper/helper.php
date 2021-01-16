<?php

use Carbon\Carbon;


function be64($id) {
    return base64_encode($id);
}

function bd64($id) {
    return base64_decode($id);
}

?>