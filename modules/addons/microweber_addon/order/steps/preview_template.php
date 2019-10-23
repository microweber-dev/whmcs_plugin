<?php if (isset($_GET['style'])) {
    include(dirname(__DIR__) . '/templates/' . htmlspecialchars($_GET['style']) . '/preview_template/index.php');
} else {
    include(dirname(__DIR__) . '/templates/default/preview_template/index.php');
}
