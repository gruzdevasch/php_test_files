<?php

class Controller_Main extends Controller {

    function __construct() {
        $this->model = new Model_Main();
        $this->view = new View();
    }

    function action_index() {
        $data = Array();
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            if(isset($_FILES['images'])) {
                $this->model->setImages();
            }
            else {
                $this->model->setText();
            }
        } 
        $data['images'] = $this->model->getImages();
        $data['text'] = $this->model->getText();
        $this->view->generate('main_view.php', 'template_view.php', $data, 'Главная');
    }
    function action_clearImages() {
        $this->model->clearImages();
        header('Location: /');
    }
}
