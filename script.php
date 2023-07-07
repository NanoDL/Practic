<?php
session_start();

$_SESSION['date'] = date('d.m.Y');                           //переменные
$_SESSION['operator'] = 'ИП Улямаев Руслан Ильдарович';
$_SESSION['domain'] = 'https://'.$_SERVER['HTTP_HOST'];
//$consent = $domain.'/_docs/consent';

echo $_SESSION['date'];

#require 'template.php';
#require 'template.phtml';

$templateHtml = file_get_contents('template.phtml');        //помещаю html страницу в переменную $templateHtml
#echo $templateHtml;

file_put_contents('index.php', $templateHtml );             //генерация готового файла