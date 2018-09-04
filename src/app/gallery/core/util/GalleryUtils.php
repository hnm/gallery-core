<?php
namespace gallery\core\util;

use n2n\io\managed\File;

class GalleryUtils {
	
	const IPTC_KEY_GALLERY = 'gallery';
	const IPTC_KEY_PHOTOGRAPHER = 'photographer';
	const IPTC_KEY_TITLE = 'title';
	const IPTC_KEY_DESCRIPTION = 'description';
	const IPTC_KEY_KEY_WORDS = 'keywords';
	const IPTC_KEY_KEY_PLACE = 'place';
	
	private static $win1252ToUtf8 = array(
			128 => "\xe2\x82\xac",
			130 => "\xe2\x80\x9a",
			131 => "\xc6\x92",
			132 => "\xe2\x80\x9e",
			133 => "\xe2\x80\xa6",
			134 => "\xe2\x80\xa0",
			135 => "\xe2\x80\xa1",
			136 => "\xcb\x86",
			137 => "\xe2\x80\xb0",
			138 => "\xc5\xa0",
			139 => "\xe2\x80\xb9",
			140 => "\xc5\x92",
			142 => "\xc5\xbd",
			145 => "\xe2\x80\x98",
			146 => "\xe2\x80\x99",
			147 => "\xe2\x80\x9c",
			148 => "\xe2\x80\x9d",
			149 => "\xe2\x80\xa2",
			150 => "\xe2\x80\x93",
			151 => "\xe2\x80\x94",
			152 => "\xcb\x9c",
			153 => "\xe2\x84\xa2",
			154 => "\xc5\xa1",
			155 => "\xe2\x80\xba",
			156 => "\xc5\x93",
			158 => "\xc5\xbe",
			159 => "\xc5\xb8"
	);
	
	
	public static function exifReadData($fileName, $sections = null, $arrays = false, $thumbnail = false) {
		$str = @exif_read_data($fileName);
		if ($str === false && $err = error_get_last()) {
			throw new ExifReadDataException($err['message']);
		}
		return $str;
	}
	
	public static function getIPTC(File $file){
		if (!$file->isValid()) return array();

		$size = getimagesize((string) $file->getFileSource()->getFsPath(), $info);
		if(!isset($info['APP13'])) return array();
		
		$iptc = iptcparse($info['APP13']);
	
		// get values
		$values = array(self::IPTC_KEY_GALLERY => "2#005",
				self::IPTC_KEY_PHOTOGRAPHER => "2#080",
				self::IPTC_KEY_TITLE => "2#105",
				self::IPTC_KEY_DESCRIPTION => "2#120");
		$metadata = array();
		foreach ($values as $key => $value){
			$metadata[$key] =  self::toUTF8(self::readIPTC($iptc, $value));
		}
		$metadata[self::IPTC_KEY_KEY_WORDS] = self::toUTF8(self::readIPTC($iptc, "2#025", "; "));
		
		// get place
		$place = array();
		if (isset($iptc["2#090"])){
			$place[] = implode(", ", $iptc["2#090"]);
		}
		if (isset($iptc["2#101"])){
			$place[] = implode(", ", $iptc["2#101"]);
		}
		$metadata[self::IPTC_KEY_KEY_PLACE] = implode(", ", $place);
	
		// clear all empty values
		array_filter($metadata);
		return $metadata;
	}
	/**
	 * reads the iptc information of a certain value
	 *
	 * @param array $iptc array with iptc values
	 * @param string $value array key of value
	 * @param string $glue
	 * @return string
	 */
	protected static function readIPTC($iptc, $value, $glue=", ") {
		if (isset($iptc[$value])){
			return implode($glue, $iptc[$value]);
		} else {
			return null;
		}
	}
	
	public static function toUTF8($text){
		/**
		 * Function \ForceUTF8\Encoding::toUTF8
		 *
		 * This function leaves UTF8 characters alone, while converting almost all non-UTF8 to UTF8.
		 *
		 * It assumes that the encoding of the original string is either Windows-1252 or ISO 8859-1.
		 *
		 * It may fail to convert characters to UTF-8 if they fall into one of these scenarios:
		 *
		 * 1) when any of these characters:   ÀÁÂÃÄÅÆÇÈÉÊËÌÍÎÏÐÑÒÓÔÕÖ×ØÙÚÛÜÝÞß
		 *    are followed by any of these:  ("group B")
		 *                                    ¡¢£¤¥¦§¨©ª«¬­®¯°±²³´µ¶•¸¹º»¼½¾¿
		 * For example:   %ABREPRESENT%C9%BB. «REPRESENTÉ»
		 * The "«" (%AB) character will be converted, but the "É" followed by "»" (%C9%BB)
		 * is also a valid unicode character, and will be left unchanged.
		 *
		 * 2) when any of these: àáâãäåæçèéêëìíîï  are followed by TWO chars from group B,
		 * 3) when any of these: ðñòó  are followed by THREE chars from group B.
		 *
		 * @name toUTF8
		 * @param string $text  Any string.
		 * @return string  The same string, UTF8 encoded
		 *
		 */
		if(is_array($text))
		{
			foreach($text as $k => $v)
			{
				$text[$k] = self::toUTF8($v);
			}
			return $text;
		}
	
		if(!is_string($text)) {
			return $text;
		}
		 
		$max = mb_strlen($text, '8bit');
	
		$buf = "";
		for($i = 0; $i < $max; $i++){
			$c1 = $text{$i};
			if($c1>="\xc0"){ //Should be converted to UTF8, if it's not UTF8 already
				$c2 = $i+1 >= $max? "\x00" : $text{$i+1};
				$c3 = $i+2 >= $max? "\x00" : $text{$i+2};
				$c4 = $i+3 >= $max? "\x00" : $text{$i+3};
				if($c1 >= "\xc0" & $c1 <= "\xdf"){ //looks like 2 bytes UTF8
					if($c2 >= "\x80" && $c2 <= "\xbf"){ //yeah, almost sure it's UTF8 already
						$buf .= $c1 . $c2;
						$i++;
					} else { //not valid UTF8.  Convert it.
						$cc1 = (chr(ord($c1) / 64) | "\xc0");
						$cc2 = ($c1 & "\x3f") | "\x80";
						$buf .= $cc1 . $cc2;
					}
				} elseif($c1 >= "\xe0" & $c1 <= "\xef"){ //looks like 3 bytes UTF8
					if($c2 >= "\x80" && $c2 <= "\xbf" && $c3 >= "\x80" && $c3 <= "\xbf"){ //yeah, almost sure it's UTF8 already
						$buf .= $c1 . $c2 . $c3;
						$i = $i + 2;
					} else { //not valid UTF8.  Convert it.
						$cc1 = (chr(ord($c1) / 64) | "\xc0");
						$cc2 = ($c1 & "\x3f") | "\x80";
						$buf .= $cc1 . $cc2;
					}
				} elseif($c1 >= "\xf0" & $c1 <= "\xf7"){ //looks like 4 bytes UTF8
					if($c2 >= "\x80" && $c2 <= "\xbf" && $c3 >= "\x80" && $c3 <= "\xbf" && $c4 >= "\x80" && $c4 <= "\xbf"){ //yeah, almost sure it's UTF8 already
						$buf .= $c1 . $c2 . $c3 . $c4;
						$i = $i + 3;
					} else { //not valid UTF8.  Convert it.
						$cc1 = (chr(ord($c1) / 64) | "\xc0");
						$cc2 = ($c1 & "\x3f") | "\x80";
						$buf .= $cc1 . $cc2;
					}
				} else { //doesn't look like UTF8, but should be converted
					$cc1 = (chr(ord($c1) / 64) | "\xc0");
					$cc2 = (($c1 & "\x3f") | "\x80");
					$buf .= $cc1 . $cc2;
				}
			} elseif(($c1 & "\xc0") == "\x80"){ // needs conversion
				if(isset(self::$win1252ToUtf8[ord($c1)])) { //found in Windows-1252 special cases
					$buf .= self::$win1252ToUtf8[ord($c1)];
				} else {
					$cc1 = (chr(ord($c1) / 64) | "\xc0");
					$cc2 = (($c1 & "\x3f") | "\x80");
					$buf .= $cc1 . $cc2;
				}
			} else { // it doesn't need conversion
				$buf .= $c1;
			}
		}
		return $buf;
	}
}

class ExifReadDataException extends \RuntimeException {
	
}