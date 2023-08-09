<?php

#файл html шаблона
$htmlFile = 'templateHtml.php';



//файл с данными
$dataFile ='data.php';

#переменна для готовой html страницы
$modifiedHtml =' ';

$replacement = "</body>";

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

#получение текста
$text = "";

$textFile = fopen("text.php", "r");

//определяет находимся ли мы в открытом списке (отсутствует </ul>)
$Li=false;
//переменная для предыдущей строки
$prevLine = "///";
//шаблон для жирного текста
$pattB = "/(\*)(.+)(\*)/U";
//шаблон для курсива 
$pattItal = "/(\_)(.+)(\_)/U";
//шаблон для зачеркнутого
$pattStrike = "/(\~)(.+)(\~)/U";
//шаблон для моноширинного
$pattMono = "/(\"`)(.+)(\"`)/U";
//шаблон для замены на жирный
$replacementB = "<b>$2</b>";
//шаблон для замены на курсивный
$replacementItal = "<em>$2</em>";
//шаблон для замены на зачеркнутый
$replacementStrike = "<strike>$2</strike>";
//шаблон для замены на моноширинный
$replacementMono = "<tt>$2</tt>";

//цикл обхода файла
while(!feof($textFile)){

    //получение строки
    $line = fgets($textFile);


    #заголовок
    if ($prevLine === "\r\n" ) {
        $line = "<h4>" . $line . "</h4>";
        //если есть <ul> то закрываем
       if($Li){
            $line = "</ul>" . $line;
            $Li=false;
        }
    }
    #Список
    elseif (substr($line, 0, 1) === "\t"  /*$prevLine !== "\r\n"*/ && $line !== "\r\n" )
    {

        $line = "<li>" . $line . "</li>";
        if (!$Li){
            $line = "<ul>" . $line;
            $Li=true;
        }
    }
    #Обычные строки
    elseif ($line !== "\r\n" ) #если строка не пустая
    {                                          #добавить переменную для измененной строки
        $line = "<p>" . $line . "</p>";

        if($Li){
            $line = "</ul>" . $line;
            $Li=false;
        }
    }
    $line = preg_replace($pattB, $replacementB ,$line);
    $line = preg_replace($pattItal, $replacementItal ,$line);
    $line = preg_replace($pattStrike, $replacementStrike ,$line);
    $line = preg_replace($pattMono, $replacementMono ,$line);
    echo $line;
    $text = "{$text}\r\n{$line}";
    $prevLine = $line;

    
}
fclose($textFile);

//получение данных из файла
$data = file_get_contents($dataFile);
//объединение данных с текстом
$text = $data . $text;


#получение шаблона html
$templateHtml = file_get_contents($htmlFile);        

$modifiedHtml = str_replace($replacement, $text . $replacement ,$templateHtml);
@mkdir($generatedPath);
file_put_contents($generatedPath . '/index.php', $modifiedHtml );  //генерация готового файла 

echo $modifiedHtml;
