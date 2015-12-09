<?php 
    $query = "SELECT * FROM chatpost LEFT JOIN chatuser ON chatuser.id = chatpost.iduser WHERE chatpost.idcategory = '".$_SESSION['idcategory']."' ORDER BY chatpost.date DESC  LIMIT 0, 4 " ;
    $resultatPost = mysqli_query($db, $query);
    $listPost = array();
   while( $post = mysqli_fetch_assoc($resultatPost))
   {
    /*require('views/testPost.phtml');*/
    $listPost[] = $post;
   }
$listPost = array_reverse($listPost);
 $i = 0;
while (isset($listPost[$i]))
{
    $post = $listPost[$i];
    require('views/testPost.phtml');
    $i++;
}

?>