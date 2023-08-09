<?php 

$handle = fopen("text3.txt", "r");

$Li=false;
$prevLine = "///";
$pattB = "/(\*)(.+)(\*)/U";
$pattItal = "/(\_)(.+)(\_)/U";
$pattStrike = "/(\~)(.+)(\~)/U";
$pattMono = "/(\"`)(.+)(\"`)/U";
$replacementB = "<b>$2</b>";
$replacementItal = "<em>$2</em>";
$replacementStrike = "<strike>$2</strike>";
$replacementMono = "<tt>$2</tt>";

while(!feof($handle)){

    $line = fgets($handle);


    #заголовок
    if ($prevLine === "\r\n" ) {
        $line = "<h4>" . $line . "</h4>";
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
    elseif ($line !== "\r\n") #если строка не пустая
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
    $prevLine = $line;

    
}
fclose($handle);