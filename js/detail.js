// JavaScript Document
		function put_comment() {
			subject_id = 'see_comments';
			name = document.getElementById('name').value;
			email = document.getElementById('email').value;
			comment = document.getElementById('comment').value;
			news_id = document.getElementById('news_id').value;
			
			http.open("GET", "ajax/comment_ajax.php?name=" + escape(name) + "&email=" + escape(email) + "&news_id=" + escape(news_id) + "&comment=" + escape(comment), true);
			http.onreadystatechange = handleHttpResponse;
			http.send(null);
			
			document.getElementById('comment').value = "";
		}
		
		function countchars(box,container){
			boxcont=document.getElementById(box).value;
			if (boxcont.length>500){
				document.getElementById(box).value = boxcont.substr(0,500);
				document.getElementById(container).innerHTML="500";
			}else{
				document.getElementById(container).innerHTML=boxcont.length;
			}
			
		}
		
		function clear_textbox(box){
			if (document.getElementById(box).value == "Your comment here ..."){
				document.getElementById(box).value = "";
			}
		}
		
		function rating(h_id){
			document.getElementById('rate_div').style.visibility = "visible";
			document.getElementById('linkid').value = h_id;
			document.getElementById('rate').options.selectedIndex=0;
			document.getElementById('rate_text').innerHTML = "Rate the article below?";
		}
		
		function submit_rate (){
			rateIndex = document.rate_form.rate.selectedIndex;
			if (rateIndex > 0){
				rate = document.rate_form.rate[rateIndex].value;
				linkid = document.getElementById('linkid').value;
				
				http.open("GET", "ajax/rate_article.php?linkid=" + escape(linkid) + "&rate=" + escape(rate), true);
				http.onreadystatechange = handleHttpResponse;
				http.send(null);
				
				document.getElementById('rate_text').innerHTML = '<span style="color:#FF0000;">Thanks for rating this article </span>';
			}
		}
