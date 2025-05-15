<?php

require_once 'controller/searchController.php';

$controller = new SearchController();
echo $controller->search();
?>