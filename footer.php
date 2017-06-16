


<script>
  //premium calculator
	  function premium(idv,cc,y,d,n,type) {
		  
		  if (y<5) {
			  normal=(cc<=1500)?3.191:3.343;
		  }else{
			  normal=(cc<=1500)?3.351:3.510;
			  }
		  en=(cc<=1500)?['.40','.50','.65','.85','1.05','1.25','1.45']:['.45','.55','.70','.90','1.10','1.30','1.50'];
		  tp_act=(cc<=1500)?2863:7890;
		  var np=(idv*normal)/100;
		  var normal_premium=Math.ceil((idv*normal)/100);
		  var discount=Math.floor((np*d)/100);
		  normal_premium=normal_premium-discount;
		  var ncb=Math.floor((normal_premium*n)/100);
		  normal_premium=normal_premium-ncb;
		  var en_premium=Math.ceil((idv*en[y-1])/100);
		  var tp_premium=50+100+200+tp_act;
		  var total_premium=(type=='0dap')?normal_premium+en_premium+tp_premium:normal_premium+tp_premium;
		  var st=Math.ceil((total_premium*15)/100);
		  net_premium=total_premium+st;
		  return net_premium;
	  }
	  
	  

</script>
  </body>
</html>