<?php

namespace Controllers;

use Models\PostModel;
use Models\CommentModel;
use Models\CategoryModel;
use Utils\Tools;

class PostController extends Controller
{

    public function default()
    {
        return $this->blogAction();
    }

    // Liste des articles
    public function blogAction()
    {

        $m = new PostModel();
        $data = [
            'posts' => $m->read()
        ];
        return $this->render('blog.html.twig', $data);
    }

    // Détail d'un article
    public function singleAction()
    {
        $m = new PostModel();
        $c = new CommentModel();
        $id = (int)Tools::getValue('id');
        $content = false;

        if (Tools::getValue('content')) {
            if (!empty(Tools::getValue('content')) && (Tools::getSession('id'))) {
                $comment = [
                    'content' => Tools::getValue('content'),
                    'post' => Tools::getValue('id'),
                    'user' => Tools::getSession('id')
                ];
                $c->create($comment);
            } else if (!empty(Tools::getValue('content')) && !empty(Tools::getValue('name')) && !empty(Tools::getValue('surname'))) {
                $name = Tools::getValue('name');
                $surname = Tools::getValue('surname');
                $comment = [
                    'content' => Tools::getValue('content'),
                    'post' => Tools::getValue('id'),
                    'user' => NULL
                ];
                $c->create($comment);
            }
            $content = 'Votre commentaire a bien été soumis et sera publié dès sa validation par un modérateur';
        }
        return $this->render('single_post.html.twig', [
            'single' => $m->find($id),
            'comments' => $c->validated($id),
            'content' => $content,
        ]);
    }

    // Ajouter un article
    public function addAction()
    {
        $category = new CategoryModel();
        return $this->render('add_post.html.twig', [
            'category' => $category->category(),
        ]);
    }

    public function insertAction()
    {
        if (!empty(Tools::getValue('title')) && !empty(Tools::getValue('category')) && !empty(Tools::getValue('headline')) && !empty(Tools::getValue('content'))) {

            $image = '';

            if (!empty($_FILES)) {

                $img = Tools::uploadFile($_FILES['image'], 'public/img/');

                if ($img['path']) {
                    $image = $img['path'];
                }
            }

            $m = new PostModel();
            $post = [
                'title' => Tools::getValue('title'),
                'category' => Tools::getValue('category'),
                'headline' => Tools::getValue('headline'),
                'content' => Tools::getValue('content'),
                'user' => Tools::getValue('id'),
                'image' => $image,
            ];
            $m->create($post);
            header('Location: /user/adminPost');
        } else {
            header('Location: /post/add');
        }
    }

    // Modifier un article
    public function editAction()
    {
        $post = new PostModel();
        $tag = new CategoryModel();
        $id = (int)Tools::getValue('id');
        return $this->render('edit_post.html.twig', ['post' => $post->find($id), 'category' => $tag->category()]);
    }

    public function updateAction()
    {
        if (!empty(Tools::getValue('title')) && !empty(Tools::getValue('category')) && !empty(Tools::getValue('headline')) && !empty(Tools::getValue('content'))) {

            $image = NULL;

            if (!empty($_FILES)) {

                $img = Tools::uploadFile($_FILES['image'], 'public/img/');

                if ($img['path']) {
                    $image = $img['path'];
                }
            }

            $model = new PostModel();
            $tags = new CategoryModel();
            $post = [
                'title' => Tools::getValue('title'),
                'category_id' => Tools::getValue('category'),
                'headline' => Tools::getValue('headline'),
                'content' => Tools::getValue('content'),
            ];
            $id = Tools::getValue('id');
            if ($image) {
                $post['image'] = $image;
            }
            $model->edit($id, $post);

            return $this->render('admin_post.html.twig', [
                'pending' => $model->pending(Tools::getSession('id')),
                'validated' => $model->validated(Tools::getSession('id')),
                'refused' => $model->refused(Tools::getSession('id')),
                'countp' => $model->countPending(Tools::getSession('id')),
                'countv' => $model->countValidated(Tools::getSession('id')),
                'countr' => $model->countRefused(Tools::getSession('id')),
                'tags' => $tags->read(),
            ]);
        }
    }

    public function deleteAction()
    {
        $model = new PostModel();
        $id = (int)Tools::getValue('id');
        $model->delete($id);
        header('Location: /user/adminPost');
    }

    public function validatePostAction()
    {
        $post = new PostModel();
        $id = (int)Tools::getValue('id');
        $post->validatePost($id);
        header('Location: /user/superAdmin');
    }

    public function deletePostAdminAction()
    {
        $post = new PostModel();
        $id = (int)Tools::getValue('id');
        $post->delete($id);
        header('Location: /user/superAdmin');
    }
}
