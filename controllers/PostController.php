<?php

namespace Controllers;

use Models\PostModel;

class PostController extends Controller {
    
    public function default() {
        return $this->blogAction();
    }

    public function blogAction() {
        return $this->render('blog.html.twig');
    }

    public function singleAction() {
        return $this->render('single_post.html.twig');
    }
}