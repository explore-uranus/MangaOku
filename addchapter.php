<html>
<head>
    <title>main</title>
</head>

<body>
<?php 
    if(isset($_POST["submit"])){
        $connection = oci_connect("hr","MangaOku12","localhost/MangaOku");
        $tmpnames = $_FILES['pages']['tmp_name'];
        $names = $_FILES['pages']['name'];
        for($i = 0; $i < count($tmpnames);$i++)
        {
            $image = file_get_contents($tmpnames[$i]);

            $manga_id = intval($_POST['manga_id']);
            $chapter = intval($_POST['chapter']);
            $tome = intval($_POST['tome']);            
            $blob = oci_new_descriptor($connection, OCI_D_LOB);
            $page = intval(substr($names[$i],0,2));

            $sql = "INSERT INTO mangaoku_chapter (manga_id,chapter,tome,img,page_num) 
                    VALUES(:manga_id,:chapter,:tome,empty_blob(),:page_num) 
                    RETURNING img
                    INTO :img";
            $result = oci_parse($connection, $sql);
           

            oci_bind_by_name($result, ":manga_id",$manga_id);
            oci_bind_by_name($result, ":tome", $tome);
            oci_bind_by_name($result, ":chapter", $chapter);
            oci_bind_by_name($result, ":img", $blob, -1, OCI_B_BLOB);
            oci_bind_by_name($result, ":page_num", $page);

            
            oci_execute($result, OCI_DEFAULT) or die ("Unable to execute query");

            if(!$blob->save($image)) {
                oci_rollback($connection);
            }
            else {
                oci_commit($connection);
            }

            oci_free_statement($result);
            $blob->free();
        }
    }else{
?>
    <form  method="POST" enctype="multipart/form-data">
    Manga
    <input type="text" name="manga_id" >
    Chapter
    <input type="text" name="chapter">
    Tome
    <input type="text" name="tome">
    Chose files
    <input type="file" multiple="multiple" name="pages[]"size="1000">
    <input type="submit" name="submit" value="submit">
    </form>
    <?php
    }
    ?>
</body>
</html>

