<?php
   
session_start();
if ($_GET['do']=='exit'){
    	 $_SESSION['enter']=0; 
}
if (isset($_POST['submit'])){





$link = @mysqli_connect('localhost', 'root', '', 'gyakorlás');
$query = 'SELECT nev as user, jelszo as pass, Jogosultság FROM `user` WHERE `nev` LIKE "'.$_POST['user'].'" AND `jelszo` LIKE "'.$_POST['pass'].'"';
$result = mysqli_query($link, $query);





if(mysqli_num_rows($result)==1){ 
    $vizsgalat = mysqli_fetch_array($result,MYSQLI_ASSOC);
    $row = $vizsgalat['Jogosultság'];
    if($row == 1){$_SESSION['Jog']=1; } else {$_SESSION['Jog']=0; }
	 $_SESSION['enter']=1;
	 $_SESSION['name']=$_POST['user'];
 } else {
	 $_SESSION['enter']=0;	 
 }

}
// nev LIKE "$_POST-ban lévő user"
//<a> </a> link
if (@$_SESSION['enter']==1){
	echo 'Hello '.$_SESSION['name'].'! ÜDv az oldalon!<BR>';
    echo '<a href="?do=exit">KILÉPÉS</a>';
    
    if($_SESSION['Jog'] == 1){ 
        $link = @mysqli_connect('localhost', 'root', '', 'gyakorlás');

    $query1 = "SELECT nev as user FROM user";
    $result1 = mysqli_query($link, $query1);
    
   // $row = @mysqli_fetch_array($result, MYSQLI_ASSOC);
//  echo " $row['user']"
    while( $row = (mysqli_fetch_array($result1)) ) 
    {
        
        echo " <li>".$row['user']."</li>"."<br>";
        
    }
    echo '
    <FORM NAME="form2" action="korrep.php" method="POST">
        <INPUT TYPE="text" name="user_inp">
        <INPUT TYPE="password" name="pass_inp">
        <INPUT TYPE="submit" name="submit2" value="Hozzáad">
    </FORM>
    ';
    
    echo '
	<FORM NAME="frissit" action="korrep.php" method="POST">
       Az eredeti felhasználó <INPUT TYPE="text" name="user_alap">
       Az új felhasználó <INPUT TYPE="text" name="user_fr">
		Az új jelszó <INPUT TYPE="password" name="pass_fr">
		<INPUT TYPE="submit" name="frissit" value="Modosit">
	</FORM>	
    ';	
    echo '
	<FORM NAME="torles" action="korrep.php" method="POST">
       A felhasznalo <INPUT TYPE="text" name="user_torol">
		<INPUT TYPE="submit" name="torol" value="Töröl">
	</FORM>	
	';
    if (isset($_POST['submit2'])){

        $link = @mysqli_connect('localhost', 'root', '', 'gyakorlás');
        $query2 = 'INSERT INTO user VALUES ("'.$_POST['user_inp'].'","'.$_POST['pass_inp'].'")';
        mysqli_query($link, $query2);
    }
    if (isset($_POST['frissit'])){

        $link = @mysqli_connect('localhost', 'root', '', 'gyakorlás');
        $query ='UPDATE `user` SET `nev` ="'.$_POST['user_fr'].'", `jelszo` = "'.$_POST['pass_fr'].'" WHERE `nev` LIKE "'.$_POST['user_alap'].'"';
        mysqli_query($link, $query);
    }
    if (isset($_POST['torol'])){

        
    $link = @mysqli_connect('localhost', 'root', '', 'gyakorlás');
    $query ='DELETE FROM `user` WHERE `nev` LIKE "'.$_POST['user_torol'].'"';
    mysqli_query($link, $query);
    }
  
    }
    if($_SESSION['Jog'] == 0){
        echo '
        <FORM NAME="frissit0" action="korrep.php" method="POST">
           Az új felhasználó <INPUT TYPE="text" name="user_fr0">
            Az új jelszó <INPUT TYPE="password" name="pass_fr0">
            <INPUT TYPE="submit" name="frissit0" value="Modosit">
        </FORM>	
        ';
        if (isset($_POST['frissit0'])){

            $link = @mysqli_connect('localhost', 'root', '', 'gyakorlás');
            $query ='UPDATE `user` SET `nev` ="'.$_POST['user_fr0'].'", `jelszo` = "'.$_POST['pass_fr0'].'" WHERE `nev` LIKE "'.$_SESSION['name'].'"';
            mysqli_query($link, $query);
        }
    }


} else {
	
	echo '
	<FORM NAME="form1" action="korrep.php" method="POST">
		<INPUT TYPE="text" name="user">
		<INPUT TYPE="password" name="pass">
		<INPUT TYPE="submit" name="submit" value="BELEP">
	</FORM>	
	';	
}




@mysqli_close($link);


?> 
			