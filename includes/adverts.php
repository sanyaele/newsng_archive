<?php

function custom_adverts ($num){
	$ad[1] = '<!--Adverts-->
				<section class="widget">
					<script async src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
                    <!-- medium_rec_nt -->
                    <ins class="adsbygoogle"
                         style="display:inline-block;width:300px;height:250px"
                         data-ad-client="ca-pub-2732469417891860"
                         data-ad-slot="5546605186"></ins>
                    <script>
                    (adsbygoogle = window.adsbygoogle || []).push({});
                    </script>
				</section><!--Adverts-->';
	$ad[2] = '<!--Adverts-->
				<section class="widget">
					<a href="http://www.ayeci.org/" target="_blank"><img src="http://newsng.com/adverts/ayeci.gif" alt="Gift of Literacy Campaign" width="300" height="223" border="0" /></a>
				</section><!--Adverts-->';
	$ad[3] = '<!--Adverts-->
				<section class="widget">
					<a href="http://www.9ineteenworks.com/" target="_blank"><img src="http://newsng.com/adverts/nineteen.jpg" alt="Donate Sanitary pad for 500 girls" width="300" height="300" border="0" /></a>
				</section><!--Adverts-->';
		$ad[4] = '<a href="http://c.jumia.io/?a=4187&c=77&p=r&E=kkYNyk2M4sk%3d&ckmrdr=https%3A%2F%2Fwww.jumia.com.ng%2Finfinix-hot-s%2F&utm_source=cake&utm_medium=affiliation&utm_campaign=4187&utm_term="><img src="https://www.jumia.com/affiliate-program/banners/9/77/300x250.jpg"/></a>';
	return $ad[$num];
}

function get_adv (){
	$ad[1] = "<a href=\"http://affiliate.jumia.com/go.cgi?pid=516&amp;wmid=127&amp;cpid=1&amp;prid=10&amp;target=shoes_728x90\" rel=\"nofollow\" title=\"jumia.com.ng\"><img src=\"http://newsng.com/img.php?img=j1\" height=\"90\" width=\"728\" border=\"0\" alt=\"jumia.com.ng\" /></a>";
	$ad[2] = "<a href=\"http://affiliate.jumia.com/go.cgi?pid=516&amp;wmid=132&amp;cpid=1&amp;prid=10&amp;target=fashiondresses_728x90\" rel=\"nofollow\" title=\"jumia nigeria\"><img src=\"http://newsng.com/img.php?img=j2\" height=\"90\" width=\"728\" border=\"0\" alt=\"jumia nigeria\" /></a>";
	$ad[3] = "<a href=\"http://affiliate.jumia.com/go.cgi?pid=516&amp;wmid=136&amp;cpid=1&amp;prid=29&amp;target=beautycorner_728x90\" rel=\"nofollow\" title=\"jumia.com.ng\"><img src=\"http://newsng.com/img.php?img=j3\" height=\"90\" width=\"728\" border=\"0\" alt=\"http://www.jumia.com.ng/\" /></a>";
	$ad[4] = "<a href=\"http://affiliate.jumia.com/go.cgi?pid=516&amp;wmid=140&amp;cpid=1&amp;prid=29&amp;target=beautymakeup_728x90\" rel=\"nofollow\" title=\"jumia.com.ng\"><img src=\"http://newsng.com/img.php?img=j4\" height=\"90\" width=\"728\" border=\"0\" alt=\"jumia.com.ng\" /></a>";
	$ad[5] = "<a href=\"http://affiliate.jumia.com/go.cgi?pid=516&amp;wmid=468&amp;cpid=1&amp;prid=8&amp;target=mobiledeal_728x90\" rel=\"nofollow\" title=\"http://www.jumia.com.ng/\"><img src=\"http://newsng.com/img.php?img=j5\" height=\"90\" width=\"728\" border=\"0\" alt=\"jumia nigeria\" /></a>";
	$ad[6] = "<a href=\"http://affiliate.jumia.com/go.cgi?pid=516&amp;wmid=338&amp;cpid=1&amp;prid=8&amp;target=mobilesamsung_728x90\" rel=\"nofollow\" title=\"jumia.com.ng\"><img src=\"http://newsng.com/img.php?img=j6\" height=\"90\" width=\"728\" border=\"0\" alt=\"jumia ng\" /></a>";
	$ad[7] = "<a href=\"http://affiliate.jumia.com/go.cgi?pid=516&amp;wmid=162&amp;cpid=1&amp;prid=26&amp;target=kidsfashion_728x90\" rel=\"nofollow\" title=\"jumia nigeria\"><img src=\"http://static.jumia.com.ng/items_13/Nigeria/Kids/Fashion/728x90.gif\" height=\"90\" width=\"728\" border=\"0\" alt=\"http://www.jumia.com.ng/\" /></a>";
	
	$ad[8] = "<a href=\"http://affiliate.jumia.com/go.cgi?pid=516&amp;wmid=626&amp;cpid=1&amp;prid=25&amp;target=dayofthedeal_728x90\" rel=\"nofollow\" title=\"jumia.com.ng\"><img src=\"http://www.jumia.co/nl-templates-nigeria/affiliate/Specials/DEAL%20OF%20THE%20DAY/AFFL_U_2814_DEALI_GENE_ALL_EN_CTA_728x90_1.gif\" height=\"90\" width=\"728\" border=\"0\" alt=\"jumia nigeria\" /></a>";
	$num = rand(1,8);
	return $ad[8];
}

function get_adv_txt (){
	$ad[1] = "<a href=\"http://affiliate.jumia.com/go.cgi?pid=516&amp;wmid=393&amp;cpid=1&amp;prid=8&amp;target=smartphones\" rel=\"nofollow\" title=\"jumia.com.ng\"><b>Jumia Smartphones</b></a><br />Buy latest Smartphones from top brands at Jumia.com.ng!";
	$ad[2] = "<a href=\"http://affiliate.jumia.com/go.cgi?pid=516&amp;wmid=392&amp;cpid=1&amp;prid=10&amp;target=fashionm\" rel=\"nofollow\" title=\"jumia ng\"><b>Jumia Fashion Men</b></a><br />Discover Men's Fashion from top brands at Jumia.com.ng!";
	$ad[3] = "<a href=\"http://affiliate.jumia.com/go.cgi?pid=516&amp;wmid=394&amp;cpid=1&amp;prid=10&amp;target=fashionwshoes\" rel=\"nofollow\" title=\"jumia.com.ng\"><b>Jumia Fashion Women shoes</b></a><br />Enjoy great variety on Women's Shoes selection at Jumia.com.ng!";
	$ad[4] = "<a href=\"http://affiliate.jumia.com/go.cgi?pid=516&amp;wmid=385&amp;cpid=1&amp;prid=10&amp;target=fashionw\" rel=\"nofollow\" title=\"jumia.com.ng\"><b>Jumia Fashion Women</b></a><br />Discover Women's Fashion from top brands at Jumia.com.ng!";
	$ad[5] = "<a href=\"http://affiliate.jumia.com/go.cgi?pid=516&amp;wmid=391&amp;cpid=1&amp;prid=9&amp;target=computing\" rel=\"nofollow\" title=\"jumia ng\"><b>Jumia Computing</b></a><br />Buy top brand Computers and Tablets at Jumia.com.ng!";
	$ad[6] = "<a href=\"http://affiliate.jumia.com/go.cgi?pid=516&amp;wmid=380&amp;cpid=1&amp;prid=29&amp;target=beautycorner\" rel=\"nofollow\" title=\"jumia nigeria\"><b>Jumia Beauty</b></a><br />Make-up, Cremes, Hair Care &amp; more - Visit Jumia.com.ng!";
	
	$num = rand(1,6);
	return $ad[$num];
}
?>