<?php 

namespace Controllers;

use Models\CommentModel;

class CommentController extends Controller {

    public function default() {
        return $this->render('super_admin.html.twig');
    }

    public function addAction() {
        if(Tools::getValue('category')) {
            $tag = new CommentModel();
            $name = Tools::getValue('category');
            
            $tag->create($name);

            header('Location: ?controller=user&action=adminPost');
        }
    }

    public function deleteCommentAction() {
        $comment = new CommentModel();
        $id = (int)$_GET['id'];
        $comment->delete($id);
        header('Location: ?controller=user&action=superAdmin');
    }

    public function validateAction() {
        $comment = new CommentModel();
        $id = (int)$_GET['id'];
        $comment->validate($id);
        header('Location: ?controller=user&action=superAdmin');
    }

    public function newCommentAction() {

    }
}
