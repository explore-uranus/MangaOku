<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->

    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">

  <link rel="stylesheet" type="text/css" href="css/category.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/ekko-lightbox/5.3.0/ekko-lightbox.css" integrity="sha256-HAaDW5o2+LelybUhfuk0Zh2Vdk8Y2W2UeKmbaXhalfA=" crossorigin="anonymous" />

  <style type="text/css" media="screen">
    


body {
  
  background: #cc6699;
  font-family: 'Roboto', sans-serif;
 }
 .form-control, .form-control:focus, .input-group-addon {
  border-radius: 5px;
  border-color: #e1e1e1;
 }
    .form-control, .btn {        
        border-radius: 3px;
    }
    input[type=text] {
  border: 2px solid black;
  border-radius: 4px;
  padding: 12px 20px;
}
input[type=checkbox]
{
  /* Double-sized Checkboxes */
  -ms-transform: scale(2); /* IE */
  -moz-transform: scale(2); /* FF */
  -webkit-transform: scale(2); /* Safari and Chrome */
  -o-transform: scale(2); /* Opera */
  transform: scale(2);
  padding: 10px;
}
.checkboxtext
{
  /* Checkbox text */
  font-size: 110%;
  display: inline;
}
.bg-light{
  background-color: #e6cad8;
}
.figure-caption{
  font-size: 100%;
  color: #eeeeee;
  text-transform: uppercase;
  font-weight: 600;
  text-align: center;
  background-color: #868e96;
  padding-top: 3px;
  padding-bottom: 3px;
}
.img-thumbnail{
  margin-top: 10px;
  padding: .5rem;
  border: 2px solid #868e96;
  border-radius: 0;
  background-color: #dddddd;
  height: 290px;
}
img.mfp-img {
    width: 85vw;
}
  </style>
</head>
<body>
  <div class = "navbar navbar-inverse navbar-fixed-top">
    <div class="container">
      <div class="navbar-header">
        <button class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
          <span class="icon-bar"></span>
          <span class="icon-bar"></span>
          <span class="icon-bar"></span>
        </button>
        <a class="navbar-brand" href="main_page.php">MangaOku</a>
      </div>
      <div class="navbar-collapse collapse navbar-right">
        <ul class="nav navbar-nav">
          <li >
            <a href="category.php">Categories</a>
          </li>
          <li >
            <a href="index.html">Sign up</a>
          </li>
        </ul>
        <form class="navbar-form navbar-right">
          <div class="form-group">
            <input type="text" placeholder="Email" class="form-control">
          </div>
          <div class="form-group">
            <input type="password" placeholder="Password" class="form-control">
          </div>
           <button type="submit" class="btn btn-success">Sign in</button>
        </form>
        </div>
      </div>
    </div>
    <div class="container">
      <h3 class="text-center p-2">Cateogory og Manga</h3>
          <h1>Filter Manga</h1>
          <hr>
          <div class="row">
            <div class = col-lg-3>              
              
           <?php
            if(isset($_GET['csearch'])){
              echo   '<form action="categories.php" method="get" accept-charset="utf-8">
                        <section class="bg-light">
                            <h2 style="color:#ff00a5">Select Manga Type</h2>
                        </section> 
                        <ul class="list-group">';
              $genres= array();
              $connection =oci_connect("hr","MangaOku12","localhost/MangaOku");
              $sql = "SELECT * FROM MANGAOKU_GENRES";
              $res= oci_parse($connection,$sql);
              oci_execute($res);
              while(ocifetchinto($res, $r,OCI_ASSOC)){
                if(empty($_GET[$r['GENRE']])){
                  echo'<li class="list-group-item">
                        <div class="form-check">
                          <label >
                            <input type="checkbox" name = '.$r['GENRE'].' style="" value="Manga">
                            <span class="checkboxtext">
                              '.$r['GENRE'].'
                            </span>
                          </label>
                        </div>
                      </li>';
                }
                else{
                  array_push($genres,$r['GENRE']);
                  echo'<li class="list-group-item">
                        <div class="form-check">
                          <label >
                            <input type="checkbox" name = '.$r['GENRE'].' style="" value="Manga"checked>
                            <span class="checkboxtext">
                              '.$r['GENRE'].'
                            </span>
                          </label>
                        </div>
                      </li>';
                }    
              }
              echo'</ul>
                  <input type="submit" class="btn btn-success btn-block" name="csearch" value ="Search">
                  </form>
                  </div>
                      <div class="container mb-4 ">
                          <section class="bg-light">
                            <div class="row">';
              $list = array();
              $msql = "SELECT * FROM MANGAOKU_GENRE ORDER BY MANGA_ID";
              $mres = oci_parse($connection,$msql);
              oci_execute($mres);
              while (ocifetchinto($mres, $m,OCI_ASSOC)){            
                if(!in_array($m['MANGA_ID'],array_keys($list))){
                  $narr = array();
                  $list[$m['MANGA_ID']] = $narr;
                }
                array_push($list[$m['MANGA_ID']],$m['GENRE']);
              }
              $select = array();
              for($i = 1; $i<count($list)+1;$i++){
                if(array_intersect($genres, $list[$i]) == $genres){
                  array_push($select, $i);
                }
              }
              foreach ($select as $s){
                $msql = "SELECT * FROM MANGAOKU_MANGA where manga_id =".$s;    
                $mres = oci_parse($connection, $msql);
                oci_execute($mres);
                while(ocifetchinto($mres,$m,OCI_ASSOC)){
                  $img= ($m['POSTER']->load());
                  $name =  $m['TITLE'];
                  if($fp = fopen ("temp/".$name.".png", "w")){
                    fwrite ($fp, $img);
                    echo'<div class="col-md-3">
                          <a  href="images.jpg" title="">
                            <img class="img-fluid img-thumbnail" src="temp/'.$name.'.png" alt="15 Глава">
                          </a>
                          <figcaption class="py-2 figure-caption bg-secondary text-center">
                            '.$name.'
                          </figcaption>
                        </div>';
                    }else{
                      echo ("failed to open the file");
                    }    
                  }
                }           
              
            echo '</div>
                </section>
              </div> 
            </div>';
            }
            else{
            ?>
              <form action="categories.php" method="get" accept-charset="utf-8">
              <section class="bg-light">
                <h2 style="color:#ff00a5">Select Manga Type</h2>
                </section>             
                <ul class="list-group">
                <?php
                $connection =oci_connect("hr","MangaOku12","localhost/MangaOku");
                $sql = "SELECT * FROM MANGAOKU_GENRES";
                $res= oci_parse($connection,$sql);
                oci_execute($res);
                while(ocifetchinto($res, $r,OCI_ASSOC)){
                  echo '<li class="list-group-item">
                          <div class="form-check">
                            <label >
                              <input type="checkbox" name = '.$r['GENRE'].' style="" value="Manga">
                                <span class="checkboxtext">
                                  '.$r['GENRE'].'
                                </span>
                            </label>
                          </div>
                        </li>';
                }              
                ?>
                </ul>
                <input type="submit" class="btn btn-success btn-block" name="csearch" value ="Search">
              </form>
          </div>

          <section class="bg-light">
            <div class="container mb-4 ">
              <div class="row">
                <?php
                  $msql = "SELECT * FROM MANGAOKU_MANGA";
                  $mres = oci_parse($connection, $msql);
                  oci_execute($mres);
                  while(ocifetchinto($mres,$m,OCI_ASSOC)){
                    $img= ($m['POSTER']->load());
                    $name =  $m['TITLE'];
                    if($fp = fopen ("temp/".$name.".png", "w")){
                      fwrite ($fp, $img);
                      echo' <div class="col-md-3">
                              <a  href="images.jpg" title="">
                                <img class="img-fluid img-thumbnail" src="temp/'.$name.'.png" alt="15 Глава">
                              </a>
                              <figcaption class="py-2 figure-caption bg-secondary text-center">
                              '.$name.'
                              </figcaption>
                            </div>';
                      }else{
                        echo ("failed to open the file");
                      }   
                    }
                   }
                ?>
              </div>
            </div> 
          </section>

        </div>
      </div>
</body>
    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
     <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script> 
    
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
   <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/ekko-lightbox/5.3.0/ekko-lightbox.js" integrity="sha256-jGAkJO3hvqIDc4nIY1sfh/FPbV+UK+1N+xJJg6zzr7A=" crossorigin="anonymous"></script>
<script type="text/javascript">
 
</script>
  
</html>