<head>
<?php 

        session_start();
        $check = $_SESSION['check'];
        foreach($check as $c){
            if(isset($_GET[join("/",explode(" ",$c))])){
                $manga =  $c;
            }
        }    
        echo '<title>'.$manga.'</title>';
        $chap = intval(explode(" ", $manga)[count(explode(" ",$manga))-2]);
        $connection = oci_connect("hr", "MangaOku12", "localhost/MangaOku");
        $m =join(" ",array_slice(explode(" ",$manga),0,count(explode(" ",$manga))-2 ));
        $mangasql = "SELECT * FROM MANGAOKU_MANGA WHERE TITLE = '". $m."'";
         $mangaresult = oci_parse($connection,$mangasql);
        
         oci_execute($mangaresult); 
        ocifetchinto($mangaresult, $choise,OCI_ASSOC);
        $ch = intval($choise['MANGA_ID']);
?>
</head>
<body style = "
     background-color: black;

    flex-wrap: nowrap;
    flex-direction: column;
     text-align: center;
">
<?php   
        $chaptersql = "SELECT * FROM MANGAOKU_CHAPTER WHERE MANGA_ID = ".$ch." AND CHAPTER = ".$chap." ORDER BY PAGE_NUM";
        $chapterresult = oci_parse($connection,$chaptersql);
        oci_execute($chapterresult);
        $img='';
        $count=0;
        while (OCIFetchInto($chapterresult,$arr,OCI_ASSOC)) {
            $count++;
            $img= ($arr[ 'IMG' ]->load());
            if($fp = fopen ("temp/test".$count.".png", "w")){
                fwrite ($fp, $img);

            echo'<img style="  border: 8px solid black;" src="temp/test'.$count.'.png"><br>';

            }else{
            echo ("failed to open the file");
            }
            
        } 
?>
</body>

