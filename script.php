<?php
session_start();

#файл html шаблона
$htmlFile = 'templateHtml.php';

#файл шаблона текста
$textFile ='text.php';

#переменна для готовой html страницы
$modifiedHtml =' ';

$arrPath = [
    1 => './agreement',
    2 => './consent',
    3 => './privacy',
    4 => './offer',
    5 => './cookie',
    6 => './test'
];

#тут можно выбрать один из желаемых путей
$generatedPath = $arrPath[6]; 


#Данные вводимые пользователем
$_SESSION['date'] = date('d.m.Y');                         
$_SESSION['operator'] = 'ИП Улямаев Руслан Ильдарович';
$_SESSION['domain'] = 'https://'.$_SERVER['HTTP_HOST'];
$_SESSION['consent'] = $_SESSION['domain'] . '/consent';
$_SESSION['privacy'] = $_SESSION['domain'] . '/privacy';
$_SESSION['agreement'] = $_SESSION['domain'] . '/agreement';


#получение текста
$text = file_get_contents($textFile);

#получение шаблона html
$templateHtml = file_get_contents($htmlFile);        


#поиск позиции для вставки текста
$insert_position = strpos($templateHtml, "</body>"); 


#проверка есть ли место куда вставить текст
if ($insert_position !== false) {
    $modifiedHtml = substr_replace($templateHtml, $text, $insert_position);
    @mkdir($generatedPath);
    file_put_contents($generatedPath . '/index.php', $modifiedHtml );  //генерация готового файла 

    echo $modifiedHtml;
} else {
    echo "Место для вставки текста не найдено.";
}
