<?php 
session_start();
$connect = mysqli_connect('localhost','root','','food_deliverydb');
function authentication(){
    if(!isset($_SESSION['user']))
    {
       return "<script>
                    alert('You need to login first.')
                    window.location.assign('signin.php')
               </script>
              "; 
    }
}