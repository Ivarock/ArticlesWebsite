<?php

use FastRoute\RouteCollector;

return function (RouteCollector $r) {
    $r->addRoute('GET', '/', ['ArticlesWebsite\Controllers\HomeController', 'index']);
    $r->addRoute('GET', '/articles', ['ArticlesWebsite\Controllers\ListArticlesController', 'list']);
    $r->addRoute('POST', '/articles', ['ArticlesWebsite\Controllers\CreateArticleController', 'create']);
    $r->addRoute('GET', '/articles/create', ['ArticlesWebsite\Controllers\CreateArticleController', 'create']);
    $r->addRoute('GET', '/articles/{id:\d+}', ['ArticlesWebsite\Controllers\ShowArticleController', 'show']);
    $r->addRoute('GET', '/articles/{id:\d+}/edit', ['ArticlesWebsite\Controllers\EditArticleController', 'edit']);
    $r->addRoute('POST', '/articles/{id:\d+}/edit', ['ArticlesWebsite\Controllers\EditArticleController', 'edit']);
    $r->addRoute('POST', '/articles/{id:\d+}/delete', ['ArticlesWebsite\Controllers\DeleteArticleController', 'delete']);
    $r->addRoute('POST', '/articles/{id:\d+}/comments', ['ArticlesWebsite\Controllers\AddCommentController', '__invoke']);
    $r->addRoute('POST', '/articles/{id:\d+}/comments/{comment_id:\d+}/delete', ['ArticlesWebsite\Controllers\DeleteCommentController', '__invoke']);
    $r->addRoute('POST', '/articles/{id:\d+}/like', ['ArticlesWebsite\Controllers\LikeArticleController', '__invoke']);
    $r->addRoute('POST', '/articles/{id:\d+}/comments/{comment_id:\d+}/like', ['ArticlesWebsite\Controllers\LikeCommentController', '__invoke']);
};
