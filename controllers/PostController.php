<?php

namespace Controllers;

use Models\PostModel;
use Models\CommentModel;
use Models\CategoryModel;
use Utils\Tools;

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
        $c = new CommentModel();
        $id = (int)$_GET['id'];
        $content = false;

        if (Tools::getValue('content')) {
            if(!empty(Tools::getValue('content')) && (Tools::getSession('id')))
            {
            $comment = [
                'content' => Tools::getValue('content'), 
                'post' => $_POST['id'],
                'user' => Tools::getSession('id')
            ];
            $c->create($comment);
            } else if (!empty(Tools::getValue('content')) && !empty(Tools::getValue('name')) && !empty(Tools::getValue('surname')))
            {
            $name = Tools::getValue('name');
            $surname = Tools::getValue('surname');
            $comment = [
                'content' => Tools::getValue('content'), 
                'post' => $_POST['id'],
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

    public function addAction()
    {
        $category = new CategoryModel();
        return $this->render('add_post.html.twig', [
            'category' => $category->category(),
        ]);
    }

    public function insertAction() {

        if (!empty($_FILES)) {

            $dossier = 'public/img/';
            $fichier = basename($_FILES['image']['name']);
            $taille_maxi = 50000000;
            $taille = filesize($_FILES['image']['tmp_name']);
            $extensions = array('.png', '.gif', '.jpg', '.jpeg');
            $extension = strrchr($_FILES['image']['name'], '.');

            if(!in_array($extension, $extensions)) { //Si l'extension n'est pas dans le tableau
                $erreur = 'Seuls les fichiers de type png, gif, jpg ou jpeg sont acceptés';
            }
            if($taille>$taille_maxi) {
                $erreur = 'Le fichier est trop volumineux';
            }
            if(!isset($erreur)) { //S'il n'y a pas d'erreur, on upload
                //Formatage du nom du fichier
                $fichier = strtr($fichier,
                    'ÀÁÂÃÄÅÇÈÉÊËÌÍÎÏÒÓÔÕÖÙÚÛÜÝàáâãäåçèéêëìíîïðòóôõöùúûüýÿ',
                    'AAAAAACEEEEIIIIOOOOOUUUUYaaaaaaceeeeiiiioooooouuuuyy');
                $fichier = preg_replace('/([^.a-z0-9]+)/i', '-', $fichier);
                move_uploaded_file($_FILES['image']['tmp_name'], $dossier . $fichier);
                $path = './public/img/' . $fichier;
            }
            else {
                echo $erreur;
            }

            if(!empty(Tools::getValue('title')) && !empty(Tools::getValue('category')) && !empty(Tools::getValue('headline')) && !empty(Tools::getValue('content'))) {
                $m = new PostModel();
                $post = [
                    'title' => Tools::getValue('title'), 
                    'category' => Tools::getValue('category'),
                    'headline' => Tools::getValue('headline'),
                    'content' => Tools::getValue('content'),
                    'user' => $_POST['id'],
                    'image' => $path,
                ];
                $m->create($post);
                header('Location: ?controller=user&action=adminPost');
            } else {
                header('Location: ?controller=post&action=add');
            }
        }
    }

    public function editAction()
    {
        $post = new PostModel();
        $tag = new CategoryModel();
        $id = (int)$_GET['id'];
        return $this->render('edit_post.html.twig', ['post' => $post->find($id), 'category' => $tag->category()]);
    }

    public function updateAction()
    {
        if (!empty($_FILES)) {

            $dossier = 'public/img/';
            $fichier = basename($_FILES['image']['name']);
            $taille_maxi = 50000000;
            $taille = filesize($_FILES['image']['tmp_name']);
            $extensions = array('.png', '.gif', '.jpg', '.jpeg');
            $extension = strrchr($_FILES['image']['name'], '.');
    
                if(!in_array($extension, $extensions)) { //Si l'extension n'est pas dans le tableau
                    $erreur = 'Seuls les fichiers de type png, gif, jpg ou jpeg sont acceptés';
                }
                if($taille>$taille_maxi) {
                    $erreur = 'Le fichier est trop volumineux';
                }
                if(!isset($erreur)) { //S'il n'y a pas d'erreur, on upload
                    //Formatage du nom du fichier
                    $fichier = strtr($fichier,
                        'ÀÁÂÃÄÅÇÈÉÊËÌÍÎÏÒÓÔÕÖÙÚÛÜÝàáâãäåçèéêëìíîïðòóôõöùúûüýÿ',
                        'AAAAAACEEEEIIIIOOOOOUUUUYaaaaaaceeeeiiiioooooouuuuyy');
                    $fichier = preg_replace('/([^.a-z0-9]+)/i', '-', $fichier);
                    move_uploaded_file($_FILES['image']['tmp_name'], $dossier . $fichier);
                    $path = './public/img/' . $fichier;
                }
                else {
                    echo $erreur;
                }
                
                if (!empty(Tools::getValue('title')) && !empty(Tools::getValue('category')) && !empty(Tools::getValue('headline')) && !empty(Tools::getValue('content')))
                {            
                    $model = new PostModel();
                    $tags = new CategoryModel();
                        $post = [
                            'title' => Tools::getValue('title'), 
                            'category' => Tools::getValue('category'),
                            'headline' => Tools::getValue('headline'),
                            'content' => Tools::getValue('content'),
                            'id' => $_POST['id'],
                            'image' => $path
                        ];
                        $model->edit($post);
    
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
    }

    public function deleteAction()
    {
        $model = new PostModel();
        $id = (int)$_GET['id'];
        $model->delete($id);
        header('Location: ?controller=user&action=adminPost');
    }

    public function validatePostAction() {
        $post = new PostModel();
        $id = (int)$_GET['id'];
        $post->validatePost($id);
        header('Location: ?controller=user&action=superAdmin');
    }

    public function deletePostAdminAction()
    {
        $post = new PostModel();
        $id = (int)$_GET['id'];
        $post->delete($id);
        header('Location: ?controller=user&action=superAdmin');
    }
}
