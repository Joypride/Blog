<?php

namespace Controllers;

use Models\PostModel;

class PostController extends Controller {
    
    public function default() {
        return $this->blogAction();
    }

    public function blogAction() {

        $m = new PostModel();
        $data = [
            'posts' => $m->read()
        ];
        return $this->render('blog.html.twig', $data);
    }

    public function singleAction() {
        $m = new PostModel();
        $id = (int)$_GET['id'];
        return $this->render('single_post.html.twig', [
            'single' => $m->find($id),
        ]);
    }

    public function addAction()
    {
        $m = new PostModel();
        return $this->render('add_post.html.twig');
    }

    public function editAction()
    {
        $m = new PostModel();
        return $this->render('edit_post.html.twig');
    }
}