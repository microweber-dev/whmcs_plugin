<?php if (isset($_GET['template-preview-style']) AND $_GET['template-preview-style'] == 'v2') {
    include('template-2/index.php');
} elseif (isset($_GET['template-preview-style']) AND $_GET['template-preview-style'] == 'v3') {
    include('template-3/index.php');
} else {
    include('template-1/index.php');
} ?>