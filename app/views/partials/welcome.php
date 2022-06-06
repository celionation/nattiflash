<?php


use core\Session;


?>

<div class="welcome mt-5 p-3 pt-4 d-flex justify-content-between border-bottom border-danger border-2 bg-black">
    <h3 class="text-white h6 mt-2">Welcome To <span class="text-danger">CNBlog</span></h3>
    <h3 class="text-white h6 mt-2">Thursday, 11 December</h3>
</div>

<?= Session::displaySessionAlerts(); ?>
