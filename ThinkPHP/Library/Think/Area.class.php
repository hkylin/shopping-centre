<?php
namespace Think;
class Area{
	public static function city($pro){
		$city = json_encode($pro);
	
		$str="";
		if(!defined('CALENDAR_INIT')){
			define('CALENDAR_INIT',1);
			$str.='<select id="province" name="address_province">
                         <option></option>
                          </select>
                          <select id="city" name="address_city">
                               <option></option>
                           </select>
                          <select id="county" name="address_county">
                                  <option></option>
                            </select>
							<script type="text/javascript"  src="'.__ROOT__.'/Public/home/js/area.js"></script>
							<script type="text/javascript">_init_area('.$city.');</script>';
		}
		return $str;
    }
}
?>
