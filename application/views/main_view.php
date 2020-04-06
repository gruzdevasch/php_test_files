<h2 class="title">Текстовый редактор</h2>
<div class="directories">
    <form class="form" method="POST" action="/">
        <label for="data">Содержимое:
            <textarea class='main_input' name="data" placeholder="Содержимое" id='data'><?php if (!empty($data['text'])) echo $data['text'] ?></textarea>
        </label>
        <input type="submit" value="Сохранить" />
    </form>
    <br />
    <form action="" method="post" enctype="multipart/form-data">
        <input type="file" name="images[]" multiple>
        <input type="submit" value="Загрузить изображение">
    </form>
</div>
<br/>
<h2>Изображения</h2> <a href="/clearImages/">Удалить все</a>
<div class="images">
<?php if (!empty($data['images'])) {
    foreach ($data['images'] as $image) {
        echo "<img src=" . $image . " alt=''/>";
    }
}
?>
</div>
<?php if (!empty($data['text'])):?>
<h2>Текст</h2>
<div class="text">
<p><?php echo $data['text'] ?></p>
</div>
<?php endif;?>