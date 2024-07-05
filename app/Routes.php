<?php

use FastRoute\RouteCollector;

return function (RouteCollector $r) {
    $r->addRoute('GET', '/', ['ArticlesWebsite\Controllers\HomeController', 'index']);
    $r->addRoute('GET', '/articles', ['ArticlesWebsite\Controllers\ListArticlesController', 'list']);
    $r->addRoute('POST', '/articles', ['ArticlesWebsite\Controllers\CreateArticleController', 'create']);
    $r->addRoute('GET', '/articles/create', ['ArticlesWebsite\Controllers\CreateArticleController', 'create']);
    $r->addRoute('GET', '/articles/{id:\d+}', ['ArticlesWebsite\Controllers\ShowArticleController', 'show']);
    $r->addRoute('GET', '/articles/{id:\d+}/edit', ['ArticlesWebsite\Controllers\EditArticleController', 'edit']);
    $r->addRoute('PUT', '/articles/{id:\d+}', ['ArticlesWebsite\Controllers\EditArticleController', 'edit']);
    $r->addRoute('DELETE', '/articles/{id:\d+}', ['ArticlesWebsite\Controllers\DeleteArticleController', 'delete']);
};
