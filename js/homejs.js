// JavaScript Document
		function showhidecomment (newsid){
			
			subject_id = "commentpack_" + newsid;
			inner_comment = "comment_div_" + newsid;
			inner_comment_display = document.getElementById(inner_comment).style.display;
			
			if (inner_comment_display == 'none' || inner_comment_display == 'block'){
				document.getElementById(inner_comment).style.display = "inline";
				document.getElementById(inner_comment).innerHTML = '<img src="assets/Processing.gif" />';
				
				http.open("GET", "ajax/comment_index.php?news_id=" + escape(newsid), true);
				http.onreadystatechange = handleHttpResponse;
				http.send(null);
			}else{
				document.getElementById(inner_comment).style.display = "none";
			}
		}
		
		function show_name_email(name_email){
			document.getElementById(name_email).style.display = "inline";
		}
		
		
		function clear_textbox(box){
			if (document.getElementById(box).value == "Your comment here ..."){
				document.getElementById(box).value = "";
			}
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
		
		function put_comment(newsid) {
			subject_id = 'commentpack_' + newsid;
			name_box = 'name_' + newsid;
			email_box = 'email_' + newsid;
			comment_box = 'comment_' + newsid;
			
			name_value = document.getElementById(name_box).value;
			email_value = document.getElementById(email_box).value;
			comment_value = document.getElementById(comment_box).value;
			
			inner_comment = "comment_div_" + newsid;
			document.getElementById(inner_comment).innerHTML = '<img src="assets/Processing.gif" />';
			
			http.open("GET", "ajax/comment_index.php?name=" + escape(name_value) + "&email=" + escape(email_value) + "&news_id=" + escape(newsid) + "&comment=" + escape(comment_value), true);
			http.onreadystatechange = handleHttpResponse;
			http.send(null);
		}
		
		