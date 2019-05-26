<?php


function load_photo($filePath, $errorCode){

    try{    
        //Проверка на ошибки
        if($errorCode!== UPLOAD_ERR_OK || !is_uploaded_file($filePath)){

            //Массив с названиями ошибок
            $errorMessages=[
                UPLOAD_ERR_INI_SIZE => 'Размер файла превысил значение upload_max_filesize в конфигурации PHP.',
                UPLOAD_ERR_FORM_SIZE => 'Размер загружаемого файла превысил значение MAX_FILE_SIZE в HTML-форме.',
                UPLOAD_ERR_PARTIAL => 'Загружаемый файл был получен частично.',
                UPLOAD_ERR_NO_FILE => 'Файл не был загружен.',
                UPLOAD_ERR_NO_TMP_DIR => 'Отсутствует временная папка.',
                UPLOAD_ERR_CANT_WRITE => 'Не удалось записать файл на диск.',
                UPLOAD_ERR_EXTENSION => 'РНР-расширение остановило загрузку файла.',
            ];

            //Неизвестная ошибка
            $unknownMessage='При загрузке файла произошла неизвестная ошибка.';

            //Если в массиве нет кода ошибки - ошибка неизвестна
            $outputMessage=isset($errorMessages[$errorCode])?$errorMessages[$errorCode]:$unknownMessage;

            die ($outputMessage);
        }

        //Создаем ресурс FileInfo
        $finfo = finfo_open(FILEINFO_MIME_TYPE);

        //Получим MIME-тип
        $mime=(string) finfo_file($finfo, $filePath);

        //Проверим ключевое слово image
        if (strpos($mime, 'image')===false) die('Можно загружать только изображения.');

        //Ограничение на размер файла (5Мб)
        $limitBytes=1024*1024*5;

        if(filesize($filePath)>$limitBytes) die('Размер изображения не должен превышать 5Мб.');

        //Перемещаем загружаемый файл в папку с картинками
        //Генерируем новое имя файла на основе md5
        $name=md5_file($filePath);

        //
        $image=getimagesize($filePath);

        //Генерируем расширение на основе типа изображения
        $extension = image_type_to_extension($image[2]);

        $format=str_replace('jpeg', 'jpg', $extension);

        $pic_path='pics/'.$name.$format;

        if (!move_uploaded_file($filePath, __DIR__ .'/'. $pic_path)) {
            die('При записи изображения на диск произошла ошибка.');
        }
        else return $pic_path;
    }
    catch(Exception $ex){
        echo $ex;
    };
};
?>