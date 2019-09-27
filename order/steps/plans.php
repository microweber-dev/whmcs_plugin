<?php if (isset($_GET['style'])) {
    include(dirname(__DIR__) . '/templates/' . htmlspecialchars($_GET['style']) . '/plans/index.php');
} else {
    include(dirname(__DIR__) . '/templates/default/plans/index.php');
}
