<?php
error_reporting(E_ALL);
ini_set('display_errors', '1');
//将出错信息输出到一个文本文件
ini_set('error_log', dirname(__FILE__) . '/error_log.txt');  
    if(!is_array($_GET)&&count($_GET)<=0){
       exit();
    }
    include('../lib.php');
    $type=$_GET['type'];
    @$q=urlencode($_GET['q']);
    $ptk= isset($_GET['ptk']) ? $_GET['ptk'] : '';
    $order=isset($_GET['order'])?$_GET['order']:'relevance';
    $sortid=$_GET['sortid'];
    switch($type){
    	case 'video':
            	   $videodata=get_search_video($q,APIKEY,$ptk,'video',$order,GJ_CODE);
            	   	if($videodata['pageInfo']['totalResults']<=1){
    		    echo'<div class="alert alert-danger h4 p-3 m-2" role="alert">Không tìm thấy kết quả cho <strong>'.urldecode($q).'</strong> hay bất kì video có liên quan nào</div>';
    		    exit;
    		}
            	   echo '<ul  class="list-unstyled  video-list-thumbs row pt-1">';
            	   foreach($videodata["items"] as $v) {
                echo '<li class="col-xs-6 col-sm-6 col-md-4 col-lg-4" ><a href="./watch.php?v='.$v["id"]["videoId"].'" target="_black" class="hhh" title="'.$v["snippet"]["title"].'" >
            			<img src="./thumbnail.php?type=mqdefault&vid='.$v["id"]["videoId"].'" class="img-responsive" />
            			<p class="fa play kkk" ></p>
            			<span class="text-dark text-overflow font2 my-2">'.$v["snippet"]["title"].'</span></a>
            		
            		<div class="pull-left pull-left1 icontext"><i class="fa fa-user icoys"></i><span class="pl-1"><a href="./channel.php?channelid='.$v["snippet"]["channelId"].'" class="icoys" title="'.$v["snippet"]["channelTitle"].'" >'.$v["snippet"]["channelTitle"].'</a>
            		</span></div>
            		
            		<div class="pull-right pull-right1 icontext">
            		    <i class="fa fa-clock-o pl-1 icoys "></i><span class="pl-1 icoys">'.format_date($v["snippet"]["publishedAt"]).'</span></div>
            </li>';
            }
                echo '</ul> ';
                echo '<div class="col-md-12">';
            if (array_key_exists("nextPageToken",$videodata) && array_key_exists("prevPageToken",$videodata) ) {
               
                echo'<a class="btn btn-outline-primary  w-25 pull-left" href="./search.php?q='.$_GET["q"].'&order='.$_GET["order"].'&type='.$_GET['type'].'&pageToken='.$videodata["prevPageToken"].'" data-toggle="">Trước</a>
                      <a class="btn btn-outline-primary  w-25 pull-right" href="./search.php?q='.$_GET["q"].'&order='.$_GET["order"].'&type='.$_GET['type'].'&pageToken='.$videodata["nextPageToken"].'" data-toggle="">Tiếp</a>
                    ';
            } elseif (array_key_exists("nextPageToken",$videodata) && !array_key_exists("prevPageToken",$videodata)) {
                echo '<a class="btn btn-outline-primary btn-block" href="./search.php?q='.$_GET["q"].'&order='.$_GET["order"].'&type='.$_GET['type'].'&pageToken='.$videodata["nextPageToken"].'" data-toggle="">Xem thêm...</a>
                    ';
            } elseif (!array_key_exists("nextPageToken",$videodata) && !array_key_exists("prevPageToken",$videodata)) {} else {
                echo '<a class="btn btn-outline-primary btn-block" href="./search.php?q='.$_GET["q"].'&order='.$_GET["order"].'&type='.$_GET['type'].'&pageToken='.$videodata["prevPageToken"].'" data-toggle="">Trước</a>' ;
            }
            echo'</div>';
    		break;
        case 'recommend':
    $random=random_recommend();
    foreach($random as $v) {
    echo '<span class="txt2 ricon h5">'.$v['t'].'</span>';
     echo'<ul class="list-unstyled video-list-thumbs row pt-1">';
        foreach ($v['dat'] as $value) {
          
    echo '<li class="col-xs-6 col-sm-6 col-md-4 col-lg-4" ><a href="./watch.php?v='. $value['id'].'" class="hhh" >
    			<img src="./thumbnail.php?type=mqdefault&vid='.$value['id'].'" class=" img-responsive" /><p class="fa play kkk" ></p>
    			<span class="text-dark text-overflow font2 my-2" title="'.$value['title'].'">'.$value['title'].'</span></a>';
    		
        }
    echo '</ul>';
    		} 
      break;
    	case 'channel':
                  $videodata=get_search_video($q,APIKEY,$ptk,'channel',$order,GJ_CODE);
                  echo'<div class="row">';
            	   foreach($videodata['items'] as $v) {
            	    echo '<div class="col-md-6 col-sm-12 col-lg-6 col-xs-6 p-3 offset"><div class="media">
      <img class="col-4 d-flex align-self-center mr-3  mtpd" src="./thumbnail.php?type=photo&vid='.$v['snippet']['channelId'].'">
      <div class="media-body col-8 chaneelit">
        <a href="./channel.php?channelid='.$v['snippet']['channelId'].'" class="mtpda"><h5 class="mt-0">'.$v['snippet']['channelTitle'].'</h5></a>
        <p class="mb-0">'.$v['snippet']['description'].'</p>
      </div>
    </div></div>';
    }
    	            echo'</div>';
    	            echo '<div class="col-md-12 pt-3">';
            if (array_key_exists("nextPageToken",$videodata) && array_key_exists("prevPageToken",$videodata) ) {
               
                echo'<a class="btn btn-outline-primary  w-25 pull-left" href="./search.php?q='.$_GET["q"].'&order='.$_GET["order"].'&type='.$_GET['type'].'&pageToken='.$videodata["prevPageToken"].'" data-toggle="">Trước</a>
                      <a class="btn btn-outline-primary  w-25 pull-right" href="./search.php?q='.$_GET["q"].'&order='.$_GET["order"].'&type='.$_GET['type'].'&pageToken='.$videodata["nextPageToken"].'" data-toggle="">Sau</a>
                    ';
            } elseif (array_key_exists("nextPageToken",$videodata) && !array_key_exists("prevPageToken",$videodata)) {
                echo '<a class="btn btn-outline-primary btn-block" href="./search.php?q='.$_GET["q"].'&order='.$_GET["order"].'&type='.$_GET['type'].'&pageToken='.$videodata["nextPageToken"].'" data-toggle="">Xem thêm...</a>
                    ';
            } elseif (!array_key_exists("nextPageToken",$videodata) && !array_key_exists("prevPageToken",$videodata)) {} else {
                echo '<a class="btn btn-outline-primary btn-block" href="./search.php?q='.$_GET["q"].'&order='.$_GET["order"].'&type='.$_GET['type'].'&pageToken='.$videodata["prevPageToken"].'" data-toggle="">Trước</a>' ;
            }
            echo'</div>';
    		break;
    	case 'channels':
    		$video=get_channel_video($_GET['channelid'],$ptk,APIKEY,GJ_CODE);
    		if($video['pageInfo']['totalResults']<=1){
    		    echo'<p>Không có nội dung! Người dùng kênh này không tải lên bất kỳ nội dung hoặc nội dung kênh có bản quyền, tạm thời không thể xem!</p>';
    		    exit;
    		}
    		foreach($video['items'] as $v) {
        echo ' <div class="media height1 py-3 pt-3">
    		<div class="media-left" style="width:30%;min-width:30%;">
    		<a href="./watch.php?v='. $v['id']['videoId'].'" target="_blank" class="d-block" style="position:relative">
    		<img src="./thumbnail.php?type=mqdefault&vid='. $v['id']['videoId'].'" width="100%">
    		<p class="small smallp"><i class="fa fa-clock-o pr-1 text-white"></i>'.format_date($v['snippet']['publishedAt']).'</p>
    		</a>
    		</div>
    		<div class="media-body pl-2"  style="width:70%;max-width:70%;">
    			<h5 class="media-heading listfont">
    				<a href="./watch.php?v='. $v['id']['videoId'].'" target="_blank" class="font30" title="'.$v["snippet"]["title"].'">'.$v["snippet"]["title"].'</a>
    			</h5>
    			<p class="listfont1">'.$v['snippet']['description'].'</p>
    			
    		</div>
    	</div>';
     }
     
    
    if (array_key_exists("nextPageToken",$video) && array_key_exists("prevPageToken",$video) ) {
       
        echo'<a class="btn btn-outline-primary m-1 w-25 pull-left" href="./channel.php?channelid='.$_GET['channelid'].'&pageToken='.$video['prevPageToken'].'" data-toggle="">Trước</a>
              <a class="btn btn-outline-primary m-1 w-25 pull-right" href="./channel.php?channelid='.$_GET['channelid'].'&pageToken='.$video['nextPageToken'].'" data-toggle="">Tiếp</a>
            ';
    } elseif (array_key_exists("nextPageToken",$video) && !array_key_exists("prevPageToken",$video)) {
        echo '<a class="btn btn-outline-primary m-1 btn-block" href="./channel.php?channelid='.$_GET['channelid'].'&pageToken='.$video['nextPageToken'].'" data-toggle="">Xem thêm...</a>
            ';
    } elseif (!array_key_exists("nextPageToken",$video) && !array_key_exists("prevPageToken",$video)) {} else {
        echo '<a class="btn btn-outline-primary m-1 btn-block" href="./channel.php?channelid='.$_GET['channelid'].'&pageToken='.$video['prevPageToken'].'" data-toggle="">Trước</a>' ;
    }
    echo'</div>';
    break;
    	case 'related':
    	 $related=get_related_video($_GET['v'],APIKEY);
    	 
     foreach($related["items"] as $v) {
       echo'<div class="media height1">
    		<div class="media-left" style="width:40%">
    		<a href="./watch.php?v='.$v["id"]["videoId"].'" >
    		<img src="./thumbnail.php?type=mqdefault&vid='.$v["id"]["videoId"].'" width="100%">
    		</a>
    		</div>
    		<div class="media-body pl-2">
    			<h5 class="media-heading height2">
    				<a href="./watch.php?v='.$v["id"]["videoId"].'" class="text-dark">'.$v["snippet"]["title"].'</a>
    			</h5>
    			<p class="small mb-0 pt-2">'
    			.format_date($v["snippet"]["publishedAt"]).
    			'</p>
    		</div>
    	</div>';  
     }	
    		break;
    case 'menu':
        $vica=videoCategories(APIKEY,GJ_CODE);
        
        echo '<ul class="list-group text-dark">
        <li class="list-group-item font-weight-bold"><i class="fa fa-home fa-fw pr-4"></i><a href="./" class="text-dark">Trang chủ</a></li>
        <li class="list-group-item"><i class="fa fa-fire fa-fw pr-4"></i><a href="./content.php?cont=trending" class="text-dark">Trending</a></li>
        <li class="list-group-item"><i class="fa fa-history fa-fw pr-4"></i><a href="./content.php?cont=history" class="text-dark">History</a></li>
        <li class="list-group-item"><i class="fa fa-gavel fa-fw pr-4"></i><a href="./content.php?cont=DMCA"class="text-dark">DMCA</a></li>
        <li class="list-group-item"><i class="fa fa-cloud-download fa-fw pr-4"></i><a href="./content.php?cont=video" class="text-dark">Download Video</a></li>
        <li class="list-group-item"><i class="fa fa-file-code-o fa-fw pr-4 pr-4"></i><a href="./content.php?cont=api" class="text-dark">API</a></li>
        </ul>
        <ul class="list-group pt-3">
        <li class="list-group-item font-weight-bold"></i>Chủ Đề Nổi Bật</li>
        ';
        foreach($vica['items'] as $v){
        echo '<li class="list-group-item"><a href="./content.php?cont=category&sortid='.$v['id'].'" class="text-dark">'.$v['snippet']['title'].'</a></li>';    
        }
        echo '</ul>';
        break;
    
    case 'trending':
    $home_data=get_trending(APIKEY,'18','',GJ_CODE);
    echo'<ul class="list-unstyled video-list-thumbs row pt-1">';
    foreach($home_data["items"] as $v) {
    echo '<li class="col-xs-6 col-sm-6 col-md-4 col-lg-4" ><a href="./watch.php?v='. $v["id"].'" class="hhh" >
    			<img src="./thumbnail.php?type=mqdefault&vid='.$v["id"].'" class=" img-responsive" /><p class="fa play kkk" ></p>
    			<span class="text-dark text-overflow font2 my-2" title="'.$v["snippet"]["title"].'">'.$v["snippet"]["title"].'</span></a>
    			<div class="pull-left pull-left1 icontext"><i class="fa fa-user icoys"></i><span class="pl-1"><a href="./channel.php?channelid='.$v["snippet"]["channelId"].'"  class=" icoys" title="'.$v["snippet"]["channelTitle"].'">'.$v["snippet"]["channelTitle"].'</a></span></div>
    		
    		<div class="pull-right pull-right1 icontext icoys">
    		    <i class="fa fa-clock-o pl-1"></i><span class="pl-1">'.format_date($v["snippet"]["publishedAt"]).'</span></div>
    		<span class="duration">'.covtime($v["contentDetails"]["duration"]).'</span></li>';
    		}  
    echo '</ul>';
      break;
    
    
      
    case 'DMCA':
        echo '<div class="font-weight-bold h6 pb-1">DMC</div>';
        echo '<h6><b>DMCA：</b><h6>';
        echo '<p class="h6" style="line-height: 1.7">This site video content from the Internet.<br>
If inadvertently violate your copyright.<br>
Send copyright complaints to '.EMAIL.'! We will response within 48 hours!<br></p>';
echo '<h6 class="pt-3"><b>Note：</b><h6>';
        echo '<p class="h6" style="line-height: 1.7">Vui lòng đọc các điều khoản và điều kiện sau, nếu bạn không đồng ý với bất kỳ điều khoản nào của thỏa thuận này, bạn có thể chọn không sử dụng trang web này. Một khi bạn duyệt trang web, cho dù bạn có ý định trình duyệt hoặc duyệt web không chủ ý, bạn có nghĩa là bạn hoàn toàn chấp nhận các điều khoản của thỏa thuận này.<br>
        1. Theo quan điểm của các trang web với các phương pháp thu hồi phi thủ công, nội dung bản quyền của trang web của bên thứ ba nội dung mà bạn yêu cầu, bạn có thể có được thông tin và tiếp cận với các dịch vụ từ các trang web của trang đầu tiên, nhưng trang web này không chịu trách nhiệm về tính hợp pháp nội dung và không thừa nhận Bất kỳ trách nhiệm pháp lý. <br>
        2. Tất cả các nội dung của trang này từ các trang web của bên thứ ba, trang web này sẽ được lọc kỹ thuật nhất lọc nội dung bất hợp pháp, nếu bạn vô tình duyệt các nội dung của các ngay lập tức đóng cửa. <br>
        3. Sử dụng trang web này, bạn cần phải hứa không sử dụng các nội dung của trang web này dưới mọi hình thức, trực tiếp hoặc gián tiếp tham gia vào các hành vi vi phạm luật pháp Trung Quốc và đạo đức xã hội, quyền xóa các nội dung của trang web này vi phạm các cam kết ở trên. <br>
        4. Bất kỳ cá nhân hay tổ chức nào có thể không sử dụng này tạo ra nội dung trang web, tải lên, sao chép, phân phối, phổ biến hoặc in lại như sau: đối với các nguyên tắc cơ bản trong Hiến pháp; gây nguy hiểm cho an ninh quốc gia, tiết lộ bí mật nhà nước, lật đổ quyền lực nhà nước, phá hoại đoàn kết dân tộc ; hại danh dự quốc gia và lợi ích; xúi giục hận thù dân tộc, phân biệt đối xử dân tộc, phá hoại đoàn kết dân tộc; vi phạm các chính sách tôn giáo nhà nước hoặc tuyên truyền sùng bái và mê tín phong kiến; lan truyền tin đồn, làm nhiễu loạn trật tự xã hội hoặc làm suy yếu sự ổn định xã hội; truyền bá khiêu dâm, khiêu dâm, cờ bạc , Bạo lực, giết người, khủng bố hoặc gây tội ác, lăng mạ hoặc vu khống người khác, xâm phạm đến quyền, lợi ích hợp pháp của người khác, và các thông tin khác bị pháp luật và hành chính cấm.<br></p>';
        echo '<h6 class="pt-3"><b>Từ chối：</b><h6>';
         echo '<p class="h6" style="line-height: 1.7">1. Trang web này không thể nằm trong chỉ mục nội dung trang web của bên thứ ba được đảm bảo. <br>
         2. Bất kỳ cá nhân hoặc tổ chức nào trong nội dung được xuất bản trên trang web của bên thứ ba chỉ cho biết vị trí và quan điểm riêng của họ, trang này chỉ như một công cụ tìm kiếm, không đại diện cho vị trí hoặc quan điểm. Tất cả các tranh chấp do nội dung của các trang web bên thứ ba gây ra đều phải chịu tất cả các khoản nợ pháp lý và liên đới và một số khoản nợ. Trang này không chịu bất kỳ trách nhiệm pháp lý và liên đới và một số.<br>
         
         </p>';
       break;
     case 'api':
         echo '<div class="font-weight-bold h6 pb-1">API</div>';
         echo '<p>URL :</p>
         <div class="alert table-inverse" role="alert">'.dirname('http://'.$_SERVER['SERVER_NAME'].$_SERVER["REQUEST_URI"]).'/api.php</div><p>Phương thức : GET</p><table class="table table-bordered table-active"><thead><tr><th>Thông số</th><th>Mô tả</th></tr> </thead><tbody><tr><td>type</td><td>Yêu cầu trả về(info: thông tin video, downlink: liên kết tải xuống)</td></tr><tr><td>v</td><td>YoutubeID Video</td></tr></tbody></table>'
               ;
         echo '<h5>Nhận thông tin video: (nội dung video, giới thiệu video, kênh tải lên và các thông tin khác) </h5>';
         echo '<p>Ví dụ：'.dirname('http://'.$_SERVER['SERVER_NAME'].$_SERVER["REQUEST_URI"]).'/api.php?type=info&v=LsDwn06bwjM</p>
               <p>Định dạng： JSON</p>';
         
         echo '<h5>Liên kết tải xuống:</h5>';
         echo '<p>Ví dụ：'.dirname('http://'.$_SERVER['SERVER_NAME'].$_SERVER["REQUEST_URI"]).'/api.php?type=downlink&v=LsDwn06bwjM</p>
               <p>Định dạng： JSON</p>';
         break;
    case 'videos':
        echo '<div class="font-weight-bold h6 pb-1">Tải về Video</div>';
        echo '<form  onsubmit="return false" id="ipt">
  <div class="form-group text-center" >
  <input name="type" value="videodownload" style="display: none;">
      <input type="text" name="link"  placeholder="Vui lòng nhập liên kết video từ Youtube" id="soinpt"  autocomplete="off" /><button type="submit" id="subu" style="width: 24%;vertical-align:middle;border: none;height: 50px;background-color: #e62117;color: #fff;font-size: 18px;display: inline-block;" ><i class="fa fa-download fa-lg pr-1"></i>Tìm kiếm</button>
  </div>
    </form>';
    if(isset($_GET['type']) && isset($_GET['v'])){
        echo '<div id="videoslist" class="text-center">';
       $viddata=get_video_info($_GET['v'],APIKEY);
        echo '<h5>'.$viddata['items']['0']['snippet']['title'].'</h5>';
        echo '<div class="p-3"><img src="./thumbnail.php?type=0&vid='.$_GET['v'].'" class="rounded img-fluid"></div>';
        echo video_down($_GET['v'],$viddata['items']['0']['snippet']['title']);  
        echo '</div>';
    }else{
        echo '<div id="videoslist" class="text-center"><p>Mẹo: Nếu bạn không thể tải xuống, hãy nhấp chuột phải vào Save As!<p></div>'; 
    }
    echo '<script>
     $("#subu").click(function() {$("#videoslist").load(\'./ajax/ajax.php\',$("#ipt").serialize());});
 </script>
';
       break;
       
       
    case 'trendinglist':
    $home=get_trending(APIKEY,'48',$ptk,GJ_CODE);
        echo '<div class="font-weight-bold h6 pb-1">Phổ Biến Hàng Ngày</div> ';
    echo'<ul class="list-unstyled video-list-thumbs row pt-1">';
    foreach($home["items"] as $v) {
    echo '<li class="col-xs-6 col-sm-6 col-md-4 col-lg-4" ><a href="./watch.php?v='. $v["id"].'" class="hhh" >
    			<img src="./thumbnail.php?type=mqdefault&vid='.$v["id"].'" class=" img-responsive" /><p class="fa play kkk" ></p>
    			<span class="text-dark text-overflow font2 my-2">'.$v["snippet"]["title"].'</span></a>
    			<div class="pull-left pull-left1 icontext"><i class="fa fa-user icoys"></i><span class="pl-1"><a href="./channel.php?channelid='.$v["snippet"]["channelId"].'"  class="icoys">'.$v["snippet"]["channelTitle"].'</a></span></div>
    		
    		<div class="pull-right pull-right1 icoys icontext">
    		    <i class="fa fa-clock-o"></i><span class="pl-1">'.format_date($v["snippet"]["publishedAt"]).'</span>
    		</div>
    		<span class="duration">'.covtime($v["contentDetails"]["duration"]).'</span>
    		</li>';
    		}  
    echo '</ul>';
    if (array_key_exists("nextPageToken",$home) && array_key_exists("prevPageToken",$home) ) {
       
        echo'<a class="btn btn-outline-primary m-1 w-25 pull-left" href="./content.php?cont=trending&pageToken='.$home['prevPageToken'].'" data-toggle="">Trước</a>
              <a class="btn btn-outline-primary m-1 w-25 pull-right" href="./content.php?cont=trending&pageToken='.$home['nextPageToken'].'" data-toggle="">Tiếp</a>
            ';
    } elseif (array_key_exists("nextPageToken",$home) && !array_key_exists("prevPageToken",$home)) {
        echo '<a class="btn btn-outline-primary m-1 btn-block" href="./content.php?cont=trending&pageToken='.$home['nextPageToken'].'" data-toggle="">Xem thêm...</a>
            ';
    } elseif (!array_key_exists("nextPageToken",$home) && !array_key_exists("prevPageToken",$home)) {} else {
        echo '<a class="btn btn-outline-primary m-1 btn-block" href="./content.php?cont=trending&pageToken='.$home['prevPageToken'].'" data-toggle="">Quay lại</a>' ;
    }
    break;
    
    
    
    case 'history':
    $hisdata=Hislist($_COOKIE['history'],APIKEY);
    echo '<div class="font-weight-bold h6 pb-1">Lịch Sử</div> ';
       if($hisdata['pageInfo']['totalResults'] ==0){echo '<div class="alert alert-warning" role="alert"><h4 class="alert-heading">Lịch Sử</h4>
  <p>Xin lỗi Bạn chưa xem bất kỳ video nào!</p>
  <p class="mb-0">Trang web này sử dụng cookie để tạm thời lưu trữ lịch sử của bạn trong trình duyệt của bạn, trang web này sẽ không lưu lịch sử xem của bạn, chỉ ghi lại lịch sử duyệt web cuối cùng của bạn, nếu bạn đã xóa cookie của trình duyệt, sẽ Không thể phục hồi!</p>
</div>';exit();}           
                foreach($hisdata["items"] as $v) {
                $description = strlen($v['snippet']['description']) > 250 ? substr($v['snippet']['description'],0,250)."...." : $v['snippet']['description'];
                echo '<div class="media height1 py-3 pt-3 ">
    		<div class="media-left" style="width:30%;min-width:30%;">
    		<a href="./watch.php?v='.$v['id'].'" target="_blank" class="d-block" style="position:relative">
    		<img src="./thumbnail.php?type=mqdefault&vid='.$v["id"].'" width="100%">
    		<p class="small smallp"><i class="fa fa-clock-o pr-1 text-white"></i>'.covtime($v['contentDetails']['duration']).'</p>
    		</a>
    		</div>
    		<div class="media-body pl-2"  style="width:70%;max-width:70%;">
    			<h5 class="media-heading listfont">
    				<a href="./watch.php?v='.$v['id'].'" target="_blank" class="font30">'.$v["snippet"]["title"].'</a>
    			</h5>
    			<p class="listfont1">'.$description.'</p>
    			
    		</div> 
    		</div>';    
                    
                } 
     break;
     
     
    case 'videodownload': 
        if(stripos($_GET['link'],'youtu.be') !== false || stripos($_GET['link'],'youtube.com') !== false || stripos($_GET['link'],'watch?v=') !== false  ){}else{echo '<h6>Yêu cầu lỗi</h6>';break;exit();}
        preg_match("/^(?:http(?:s)?:\/\/)?(?:www\.)?(?:m\.)?(?:youtu\.be\/|youtube\.com\/(?:(?:watch)?\?(?:.*&)?v(?:i)?=|(?:embed|v|vi|user)\/))([^\?&\"'>]+)/", $_GET['link'], $mats);
        $viddata=get_video_info($mats[1],APIKEY);
        echo '<h5>'.$viddata['items']['0']['snippet']['title'].'</h5>';
        echo '<div class="text-center p-3"><img src="./thumbnail.php?type=0&vid='.$mats[1].'" class="rounded img-fluid"></div>';
        echo video_down($mats[1],$viddata['items']['0']['snippet']['title']);
     break;
     
    case 'category':   
    $category=Categories($sortid,APIKEY,$ptk,$order,GJ_CODE);
    if($category['pageInfo']['totalResults']=='0'){
        echo '<div class="alert alert-danger m-2" role="alert">
                <strong>Xin lỗi！</strong> Do các hạn chế về bản quyền, nội dung này tạm thời không khả dụng!
              </div>';
              exit();
    }
    echo'<ul class="list-unstyled video-list-thumbs row pt-1">';
    foreach($category['items'] as $v) {
    echo '<li class="col-xs-6 col-sm-6 col-md-4 col-lg-4" ><a href="./watch.php?v='. $v['id']['videoId'].'" class="hhh" >
    			<img src="./thumbnail.php?type=mqdefault&vid='.$v['id']['videoId'].'" class=" img-responsive" /><p class="fa play kkk" ></p>
    			<span class="text-dark text-overflow font2 my-2">'.$v['snippet']['title'].'</span></a>
    			<div class="pull-left pull-left1 icontext"><i class="fa fa-user"></i><span class="pl-1 icoys"><a href="./channel.php?channelid='.$v['snippet']['channelId'].'" class="icoys">'.$v['snippet']['channelTitle'].'</a></span></div>
    		
    		<div class="pull-right pull-right1 icontext icoys">
    		<i class="fa fa-clock-o pl-1"></i><span class="pl-1">'.format_date($v["snippet"]["publishedAt"]).'</span>
            </div>
    		';
    		}  
    echo '</ul>';
    if (array_key_exists("nextPageToken",$category) && array_key_exists("prevPageToken",$category) ) {
       
        echo'<a class="btn btn-outline-primary m-1 w-25 pull-left" href="./content.php?cont=category&sortid='.$sortid.'&order='.$_GET["order"].'&pageToken='.$category['prevPageToken'].'" data-toggle="">Trước</a>
              <a class="btn btn-outline-primary m-1 w-25 pull-right" href="./content.php?cont=category&sortid='.$sortid.'&order='.$_GET["order"].'&pageToken='.$category['nextPageToken'].'" data-toggle="">Tiếp</a>
            ';
    } elseif (array_key_exists("nextPageToken",$category) && !array_key_exists("prevPageToken",$category)) {
        echo '<a class="btn btn-outline-primary m-1 btn-block" href="./content.php?cont=category&sortid='.$sortid.'&order='.$_GET["order"].'&pageToken='.$category['nextPageToken'].'" data-toggle="">Xem thêm...</a>
            ';
    } elseif (!array_key_exists("nextPageToken",$category) && !array_key_exists("prevPageToken",$category)) {} else {
        echo '<a class="btn btn-outline-primary m-1 btn-block" href="./content.php?cont=category&sortid='.$sortid.'&order='.$_GET["order"].'&pageToken='.$category['prevPageToken'].'" data-toggle="">Quay lại</a>' ;
    }
    
    break;    
    }
    
?>