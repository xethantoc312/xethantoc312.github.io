<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="content-type" content="text/html; charset=utf-8" />
        <title>Kiểm tra cập nhật</title>
    </head>
    <body>
        <?php
        $version='4.0';
        $Posttime='20171225';
        $ch=curl_init();
        curl_setopt($ch,CURLOPT_URL ,'https://raw.githubusercontent.com/zxq2233/You2php.github.io/master/version.json');
        curl_setopt($ch,CURLOPT_RETURNTRANSFER ,1);
        curl_setopt($ch,CURLOPT_CONNECTTIMEOUT ,20);
        curl_setopt($ch,CURLOPT_REFERER ,'http://www.youtube.com/');
        curl_setopt($ch,CURLOPT_USERAGENT ,"Mozilla/5.0 (Windows NT 5.1) AppleWebKit/534.30 (KHTML, like Gecko) Chrome/12.0.742.91 Safari/534.30");
        $f=curl_exec($ch);
        curl_close($ch);
        $up=json_decode($f,true);
        if ( (int)$up['time'] > (int)$Posttime ) {
            
            echo 'Đã có phiên bản mới nhất, hãy nâng cấp!</br>';
           echo 'Phiên bản hiện tại: v'.$version.'</br>';
           echo 'Phiên bản mới nhất: v'.$up['version'].'</br>';
           echo 'Vui lòng tải xuống phiên bản mới nhất từ địa chỉ này:<a href="'.$up['links'].'" target="_blank">'.$up['links'].'</a></br>';
           echo 'Cập nhật nội dung:'.$up['des'];
        } else{
          echo 'Bạn đang dùng phiên bản mới nhất, không cần nâng cấp!'; 
        }
        ?>    
</body>
</html>