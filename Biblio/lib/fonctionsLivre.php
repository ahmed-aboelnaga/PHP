<?php

    function readBook($f){
        $datas = [];
        $desc = [];
        $n = false; // it will be true when we start reading descrption of a book
        while(! feof($f)){
            $line = fgets($f);
            $line =str_replace("\n","",$line);
            $line =str_replace("\r","",$line);
            
            if ($line == ""){
                if($n){
                    $desc[] = $datas;
                    $datas = []; 
                    $n = false;}
                }
            elseif(strpos($line, ":") === false){
                if(count($desc) == 0){
                    throw new Exception("Error: $line");}
                return $desc;
            }
            else{
                $n = true;
                $line_a = explode(" : ", $line);
                for($x = 0; $x<count($line_a);$x++){
                    $line_a[$x] = trim($line_a[$x]);
                }
                $datas[$line_a[0]] = $line_a[1];

            }
        }
        if(count($desc) === 0){return False;}
        return $desc;
    }

    
    function elementBuilder($elementType, $content, $elementClass = ""){
        $data = "<$elementType ";
        if ($elementClass != ""){$data .= "class='$elementClass'";}
        $data .= ">$content</$elementType>";
        return $data;
    }

    function authorsToHTML($authors){
        $d = explode("-" ,$authors);
        for($x = 0; $x < count($d); $x++){
            $d[$x] = trim($d[$x]);
            $d[$x] = "<span>".$d[$x]."</span> ";
        }
        return implode("",$d);
    }

    function coverToHTML($fileName){
        return "<img src='$fileName' alt='image de couverture' />";
    }

    function propertyToHTML($propName, $propValue){
        if($propName == "titre"){
            return elementBuilder("h2", $propValue, $propName);
        }
        elseif($propName == "couverture"){
            return elementBuilder( "div",coverToHTML($propValue),$propName);
        }
        elseif($propName == "auteurs"){
            return elementBuilder("div", authorsToHTML($propValue), $propName);
        }
        elseif($propName == "année"){
            return elementBuilder("time",$propValue, $propName);
        }
        else{
            return elementBuilder("div",$propValue, $propName);
        }
    }

    function bookToHTML($book){
        $book = $book[0];
        $html_t = "<article class='livre'>". propertyToHTML("couverture", "couvertures/".$book["couverture"])."<div class='description'>";
        foreach($book as $x=>$val){
            if($x != "couverture"){
                $html_t .= propertyToHTML($x,$val);
            }
        }
        $html_t .= "</div></article>";
        return $html_t;
    }

    function libraryToHTML($file){
        $html_t = "";
        $books = readBook($file);
        if($books === false){
            echo "<p>No book found</p>";
            return -1;}
        foreach($books as $book){
            $html_t .= bookToHTML([$book]);
        }        
        return $html_t;
    }
?>
