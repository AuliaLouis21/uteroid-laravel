<?php

# YouTube PHP class
# used for embedding videos as well as video screenies on web page without single line of HTML code
#
# Dedicated to my beloved brother FILIP. Rest in peace!
#
# by Avram, www.avramovic.info

class YouTube {

function _GetVideoIdFromUrl($url) {
	$parts = explode('?v=',$url);
	if (count($parts) == 2) {
		$tmp = explode('&',$parts[1]);
		if (count($tmp)>1) {
			return $tmp[0];
		} else {
			return $parts[1];
		}
	} else {
		return $url;
	}
}

function EmbedVideo($videoid,$width = 425,$height = 350) {
	$videoid = $this->_GetVideoIdFromUrl($videoid);
	return '<object width="'.$width.'" height="'.$height.'"><param name="movie" value="http://www.youtube.com/v/'.$videoid.'"></param><param name="wmode" value="transparent"></param><embed src="http://www.youtube.com/v/'.$videoid.'" type="application/x-shockwave-flash" wmode="transparent" width="'.$width.'" height="'.$height.'"></embed></object>';
}

function GetImg($videoid,$imgid = 1) {
	$videoid = $this->_GetVideoIdFromUrl($videoid);
	return "http://img.youtube.com/vi/$videoid/$imgid.jpg";
}

function ShowImg($videoid,$imgid = 1,$alt = 'Video screenshot') {
	return "<img src='".$this->GetImg($videoid,$imgid)."' width='130' height='97' border='0' alt='".$alt."' title='".$alt."' />";
}

}

?>
