<?php 

namespace Controllers;

use Models\CategoryModel;
use Utils\Tools;

class CategoryController extends Controller {

    public function default() {
        return $this->render('super_admin.html.twig');
    }

    public function addAction() {
        if(Tools::getValue('category')) {
            $tag = new CategoryModel();
            $name = Tools::getValue('category');
            
            $tag->create($name);

            header('Location: /user/adminPost');
        }
    }

    public function deleteAction()
    {
        $tag = new CategoryModel();
        $id = (int)Tools::getValue('id');
        $tag->delete($id);
        header('Location: /user/adminPost');
    }
}
