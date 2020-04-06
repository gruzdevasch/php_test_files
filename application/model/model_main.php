<?php

function test_input($data)
{
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}
function can_upload($file)
{
    // если имя пустое, значит файл не выбран
    if ($file['name'] == '')
        return 'Вы не выбрали файл.';

    /* если размер файла 0, значит его не пропустили настройки 
	сервера из-за того, что он слишком большой */
    if ($file['size'] == 0)
        return 'Файл слишком большой.';

    // разбиваем имя файла по точке и получаем массив
    $getMime = explode('.', $file['name']);
    // нас интересует последний элемент массива - расширение
    $mime = strtolower(end($getMime));
    // объявим массив допустимых расширений
    $types = array('jpg', 'png', 'gif', 'bmp', 'jpeg');

    // если расширение не входит в список допустимых - return
    if (!in_array($mime, $types))
        return 'Недопустимый тип файла.';

    return true;
}

function make_upload($file)
{
    // формируем уникальное имя картинки: случайное число и name
    $name = mt_rand(0, 10000) . $file['name'];
    copy($file['tmp_name'], 'upload/' . $name);
}

class Model_Main extends Model
{

    public function setText()
    {

        $response = test_input(filter_input(INPUT_POST, 'data'));;

        $fp = fopen('text.txt', 'w');
        fwrite($fp, $response);
        fclose($fp);
    }
    public function setImages()
    {
        foreach ($_FILES['images']['name'] as $key => $val) {
            $tmp_name = $_FILES["images"]["tmp_name"][$key];
            $name = basename($_FILES["images"]["name"][$key]);
            move_uploaded_file($tmp_name, "upload/$name");
        }
    }
    public function getText()
    {
        $text = null;
        if (file_exists('text.txt')) {
            $text = file_get_contents('text.txt', true);
        }
        return $text;
    }
    public function getImages()
    {
        $files = glob("upload/*.*");
        $images = array();
        foreach ($files as $image) {
            $supported_file = array(
                'gif',
                'jpg',
                'jpeg',
                'bmp',
                'png'
            );

            $ext = strtolower(pathinfo($image, PATHINFO_EXTENSION));
            if (in_array($ext, $supported_file)) {
                array_push($images, $image);
            } else {
                continue;
            }
        }
        return $images;
    }
    public function clearImages()
    {
        $files = glob('upload/*'); // get all file names
        foreach ($files as $file) { // iterate files
            if (is_file($file))
                unlink($file); // delete file
        }
    }
}
