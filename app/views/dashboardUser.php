<?php
    ob_start();
?>


<?php
$content = ob_get_clean();
require __DIR__ . '/layouts/public.php';