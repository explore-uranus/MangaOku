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

  <link rel="stylesheet" type="text/css" href="css/styles.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/ekko-lightbox/5.3.0/ekko-lightbox.css" integrity="sha256-HAaDW5o2+LelybUhfuk0Zh2Vdk8Y2W2UeKmbaXhalfA=" crossorigin="anonymous" />


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
              <a href="#">About us</a>
            </li>
            <li >
              <a href="categories.php">Categories</a>
            </li>
            <?php
          if(!isset($_POST['signup'])){ ?>
            <li >
              <a href="registration.php">Sign up</a>
            </li>
          </ul>



        <form class="navbar-form navbar-right" action="main_page.php">
          <div class="form-group">
            <input type="text" placeholder="Email" class="form-control">
          </div>
          <div class="form-group">
            <input type="password" placeholder="Password" class="form-control">
          </div>
           <button type="submit" class="btn btn-success">Sign in</button>
        </form>
          <?php }
          else{
            ?>
            <li >
              <a href="myprofile.php">My profile</a>
            </li>
          </ul>
            <?php
          }?>
        </div>
      </div>
    </div>
   

<section class=" container-fluid jumbotron text-center">
    
      <h1>Manga Oku</h1>
      <p class="lead text-muted">Kel balalar Kazakh manga Okulyk.</p>
      
 
  </section>



  <div class="col-md-12 colTop align-self-center mb-4">
    <h2 class="page__title my-auto">
              Обновления популярной манги
          </h2>
    <p class="text-white">Update of popular manga</p>
  </div>
 
  <section class="bg-light">
   <div class="container mb-4 ">
     <div class="row">
     <form method="get" action = "displayManga.php">

       <?php
        session_start();

        $check = array();
        $connection = oci_connect("hr","MangaOku12","localhost/MangaOku");
        $chaptersql = "SELECT * FROM MANGAOKU_CHAPTER WHERE PAGE_NUM = 1 ORDER BY CHAPTER DESC";
        $chapterresult = oci_parse($connection, $chaptersql);
        oci_execute($chapterresult);

        while (OCIFetchInto($chapterresult,$ch,OCI_ASSOC)) {
          $mangasql =  "SELECT * FROM MANGAOKU_MANGA WHERE MANGA_ID =".$ch['MANGA_ID']; 
          $mangaresult = oci_parse($connection, $mangasql);
          oci_execute($mangaresult);
          ocifetchinto($mangaresult,$mg,OCI_ASSOC);  
          $name =  $mg['TITLE']." ".$ch['CHAPTER']." Chapter";
          array_push($check,$name);
          $img= ($ch['IMG']->load());

          if($fp = fopen ("temp/".$name.".png", "w")){
            fwrite ($fp, $img);
            echo '<div class="col-md-3">
                    <a   title="">
                      <img class="img-fluid img-thumbnail" src="temp/'.$name.'.png" alt="'.$name.'">
                    </a>
                    <figcaption class="py-2 figure-caption bg-secondary text-center">
                      <input class="btn btn-success btn-block" type="submit" value = "'.$mg['TITLE']." ".$ch['CHAPTER'].' Chapter" name = "'.join("/",explode(" ",$mg['TITLE']))."/".$ch['CHAPTER'].'/Chapter">
                    </figcaption>
                  </div>';
          }else{
            echo ("failed to open the file");
          }
        }
            $_SESSION['check'] = $check;
            
        ?>
        </form>
     </div>
   </div> 
  </section>


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