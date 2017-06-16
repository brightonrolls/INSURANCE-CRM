<?php
	  function premium_0dap($idv,$cc,$y,$d,$n) {
		  
		  if ($y<5) {
			  $normal=($cc<=1500)?3.191:3.343;
		  }else{
			  $normal=($cc<=1500)?3.351:3.510;
			  }
		  $en=($cc<=1500)?['.40','.50','.65','.85','1.05','1.25','1.45']:['.45','.55','.70','.90','1.10','1.30','1.50'];
		  $tp_act=($cc<=1500)?2237:6164;
		  $normal_premium=round(($idv*$normal)/100);
		  $discount=floor($normal_premium*$d/100);
		  $normal_premium=$normal_premium-$discount;
		  $ncb=floor($normal_premium*$n/100);
		  $normal_premium=$normal_premium-$ncb;
		  $en_premium=round(($idv*$en[$y-1])/100);
		  $tp_premium=50+100+200+$tp_act;
		  $total_premium=$normal_premium+$en_premium+$tp_premium;
		  $st=round(($total_premium*15)/100,0);
		  $net_premium=$total_premium+$st;
		  return $net_premium;
	  }
	  
	  function premium_normal($idv,$cc,$y,$d,$n) {
		  
		  if ($y<5) {
			  $normal=($cc<=1500)?3.191:3.343;
		  }else{
			  $normal=($cc<=1500)?3.351:3.510;
			  }
		  $tp_act=($cc<=1500)?2237:6164;
		  $normal_premium=round(($idv*$normal)/100);
		  $discount=floor(($normal_premium*$d)/100);
		  $normal_premium=$normal_premium-$discount;
		  $ncb=floor(($normal_premium*$n)/100);
		  $normal_premium=$normal_premium-$ncb;
		  $tp_premium=50+100+200+$tp_act;
		  $total_premium=$normal_premium+$tp_premium;
		  $st=round(($total_premium*15)/100);
		  $net_premium=$total_premium+$st;
		  return $net_premium;
	  }


?>