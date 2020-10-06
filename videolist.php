<?PHP
//$uid=$_GET['uid'];
require_once 'comm/video.dao.php';
	//得到video的总数，随机生成1到总数的数组
	$videocount=findVideoCount();
	$vcount=$videocount['num'];
	$number=range(1,$vcount);
	shuffle($number);
	$n=9;
    // $n=6;
	//得到所有video的信息并且打乱顺序作为随机
	$videolist=array();
	for($i=1;$i<=$n;$i++){
		if($i==1){
			$videoid=11;
		}else if($i==2){
			$videoid=18;
		}
		else{
			$videoid=$number[$i];
		}
		if($rs=findVideoByVideoid($videoid)){
			$likecount=findVideoLikeCount($videoid);
			$replycount=findVideoReplyCount($videoid);
			$islike=false;
			$isfocus=false;
			if(isset($_GET['uid'])){
				$uid=$_GET['uid'];
				$islike=false;
				if(findVideoLikeByUid($videoid,$uid)){
					$islike=true;
				}
				$isfocus=false;
				if(findVideoFocus($uid,$rs['uid'])){
					$isfocus=true;
				}
			}
			$videolistarr=array(array('videoid'=>$videoid,'url'=>$rs['url'],'posterurl'=>$rs['posterurl'],'videodesc'=>$rs['videodesc'],'uid'=>$rs['uid'],'uname'=>$rs['uname'],'headimage'=>$rs['headimage'],'productid'=>$rs['productid'],'publishtime'=>$rs['publishtime'],'islike'=>$islike,'isfocus'=>$isfocus,'likecount'=>$likecount,'replycount'=>$replycount));
			$videolist=array_merge_recursive($videolist,$videolistarr);
		}else{
			$i=$i-1;
		}
	}
	echo json_encode($videolist,JSON_UNESCAPED_UNICODE);	
?>