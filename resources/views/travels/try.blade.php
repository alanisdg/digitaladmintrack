

 <?php

 $imei = '08357041063131547';
 $point[1] = " echo '0108358683068711150f0102010202a058c8546f58c8546e0f70e4c1c4424d420000a3300000000000780d020014ffbf4f080700191e010000002fa8' | xxd -r -p | nc -u -w1 104.236.115.50 3002 ;";
 $point[2] = " echo '0208358683068711150f0102010202a058c8546f58c8546e0f70e4c1c4424d420000a3300000000000780d020014ffbf4f080700191e010000002fa8' | xxd -r -p | nc -u -w1 104.236.115.50 3002 ;";
 $point[3] = " echo '0308358683068711150f0102010202a058c8546f58c8546e0f70e4c1c4424d420000a3300000000000780d020014ffbf4f080700191e010000002fa8' | xxd -r -p | nc -u -w1 104.236.115.50 3002 ;";
 $point[4] = " echo '0408358683068711150f0102010202a058c8546f58c8546e0f70e4c1c4424d420000a3300000000000780d020014ffbf4f080700191e010000002fa8' | xxd -r -p | nc -u -w1 104.236.115.50 3002 ;";
 $point[5] = " echo '0508358683068711150f0102010202a058c8546f58c8546e0f70e4c1c4424d420000a3300000000000780d020014ffbf4f080700191e010000002fa8' | xxd -r -p | nc -u -w1 104.236.115.50 3002 ;";
 $point[6] = " echo '0608358683068711150f0102010202a058c8546f58c8546e0f70e4c1c4424d420000a3300000000000780d020014ffbf4f080700191e010000002fa8' | xxd -r -p | nc -u -w1 104.236.115.50 3002 ;";
 $point[7] = " echo '0708358683068711150f0102010202a058c8546f58c8546e0f70e4c1c4424d420000a3300000000000780d020014ffbf4f080700191e010000002fa8' | xxd -r -p | nc -u -w1 104.236.115.50 3002 ;";
 $point[9] = " echo '0908358683068711150f0102010202a058c8546f58c8546e0f70e4c1c4424d420000a3300000000000780d020014ffbf4f080700191e010000002fa8' | xxd -r -p | nc -u -w1 104.236.115.50 3002 ;";
 $point[11] = " echo '1108358683068711150f0102010202a058c8546f58c8546e0f70e4c1c4424d420000a3300000000000780d020014ffbf4f080700191e010000002fa8' | xxd -r -p | nc -u -w1 104.236.115.50 3002 ;";

 $point[1] = " echo '010".$imei."f0102010202a058c8546f58c8546e0f70e4c1c4424d420000a3300000000000780d020014ffbf4f080700191e010000002fa8' | xxd -r -p | nc -u -w1 104.236.115.50 3002 ;";


 $command ='';
 /*
 foreach ($point as $point) {
     $command = " echo '' "
     $command .= $point . " sleep 5 ;";
 }
 */
 if(isset($_POST['submit'])){
     for ($i=11; $i <58 ; $i++) {
         $imei = $_POST['imei'];
         $seconds = $_POST['seconds'];
         $msg=  $i.$imei."f0102010202a058c8546f58c8546e0f70e4c1c4424d420000a3300000000000780d020014ffbf4f080700191e010000002fa8";

         $sock = socket_create(AF_INET, SOCK_DGRAM, SOL_UDP);

    socket_set_option($sock, SOL_SOCKET, SO_BROADCAST, 1);
        $len = 50;

        socket_sendto($sock, $msg, $len, 0, '104.236.115.50', 3002);
        socket_close($sock);
        sleep($seconds);
     }
 }

 echo $command;
  ?>
<form class="" action="/traveltestpost" method="post">
    {!! csrf_field() !!}
    segundos
    <input type="text" name="seconds" value="1">
    imei -
    <input type="text" name="imei" value="08357041063131547">
    <input type="submit" name="submit" value="">
</form>
