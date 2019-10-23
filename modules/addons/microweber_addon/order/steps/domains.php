<?php if (isset($_GET['style'])) {
    include(dirname(__DIR__) . '/templates/' . htmlspecialchars($_GET['style']) . '/domains/index.php');
} else {
    include(dirname(__DIR__) . '/templates/default/domains/index.php');
}
