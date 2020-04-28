<html>
<head>
    <title>main</title>
</head>

<body>
<?php 

    
    $cn = oci_connect("hr","MangaOku12","localhost/MangaOku");
    $gsql = 'SELECT * FROM MANGAOKU_GENRES';
    $gres  = oci_parse($cn, $gsql);
    oci_execute($gres);
    if(isset($_POST["submit"])){
        $connection = oci_connect("hr","MangaOku12","localhost/MangaOku");

        $sql = "INSERT INTO MANGAOKU_MANGA
                (MANGA_ID, TITLE, RELEASE_DATE, RAITING, LAST_TOME, DESCRIPTION, POSTER) 
                VALUES(:manga_id, :title, TO_DATE(:release_date,'YYYY-MM-DD'), :raiting, :last_tome, :description, empty_blob()) 
                RETURNING poster
                INTO :poster";
        $result = oci_parse($connection, $sql);

        $img = file_get_contents($_FILES['page']['tmp_name']);
        $msql = "SELECT MAX(MANGA_ID)AS MAX FROM MANGAOKU_MANGA";
        $mres = oci_parce($connection,$msql);
        oci_execute($mres);
        ocifetchinto($mres,$m,OCI_ASSOC);
        $manga_id = $m['MAX'];
        $title = $_POST['title'];
        $date = $_POST['date'];
        $rait = intval($_POST['rait']);
        $tom = intval($_POST['tome']);
        $text = $_POST['desc'];

        $blob = oci_new_descriptor($connection, OCI_D_LOB);
        
        $gesql = "INSERT INTO MANGAOKU_GENRE (manga_id, genre)
                    VALUES (:manga_id, :genre)";
        $gesqlres = oci_parse($connection, $gesql);
        oci_bind_by_name($gesqlres, ":manga_id", $manga_id);

        while(ocifetchinto($gres,$g, OCI_ASSOC)){
            if(isset($_POST[$g['GENRE']])){
                oci_bind_by_name($gesqlres, ":genre",$g['GENRE']);
                oci_execute($gesqlres, OCI_DEFAULT) or die ("Unable to execute query");

            }
        }
        oci_bind_by_name($result, ":manga_id",$manga_id);
        oci_bind_by_name($result, ":title", $title);
        oci_bind_by_name($result, ":release_date",$date);
        oci_bind_by_name($result, ":raiting",$rait);
        oci_bind_by_name($result, ":last_tome",$tom);
        oci_bind_by_name($result, ":description",$text);
        oci_bind_by_name($result, ":poster", $blob, -1, OCI_B_BLOB);
        
        oci_execute($result, OCI_DEFAULT) or die ("Unable to execute query");


        
        
        
        if(!$blob->save($img)) {
            oci_rollback($connection);
        }
        else {
        oci_commit($connection);
        }

        oci_free_statement($result);
        oci_free_statement($gesqlres);
        $blob->free();
  
    }else{
?>
    <form  method="POST" enctype="multipart/form-data">
   
    Title<br>
    <input type="text" name = "title"><br>
    Release date<br>
    <input type="date" name = "date"><br>
    raiting<br>
    <input type="text" name = "rait"><br>
    Last tome<br>
    <input type="text" name = "tome"><br>
    <?php
    
    while(ocifetchinto($gres,$gr,OCI_ASSOC)){
    echo '<input type="checkbox" name ="'.$gr['GENRE'].'">'.$gr['GENRE'].'<br>';
}
    ?>
    Description<br>
    <textarea name="desc" cols="50" rows="5"></textarea><br>
    Chose Poster<br>
    <input type="file"  name="page"><br>
    <input type="submit" name="submit" value="submit">
    </form>
    <?php
    }
    ?>
</body>
</html>

