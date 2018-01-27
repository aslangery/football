<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<?php
include 'index.php';
    include 'data.php';
?>
<html>
    <head>
        <meta charset="UTF-8">
        <title></title>
    </head>
    <body>
        <form action="page.php" enctype="text/plain" method="get">
        <select name="team1">
        <?php
        $id1=$_GET['team1'];
        $id2=$_GET['team2'];
        foreach ($data as $key=>$team){
            $s=($key==$id1)?'selected':'';
            echo '<option value='.$key.' '.$s.'>'.$team['name'].'</option>';
        }
        ?>
        </select>
        
        <select name="team2">
        <?php
        foreach ($data as $key=>$team){
            $s=($key==$id2)?'selected':'';
            echo '<option value='.$key.' '.$s.'>'.$team['name'].'</option>';
        }
        ?>
        </select>
            <input type="submit" title="Result"/>
        </form>
        <?php
            
            $res= match($id1, $id2);
            echo $res[0].' : '.$res[1];
        ?>
        
    </body>
</html>
