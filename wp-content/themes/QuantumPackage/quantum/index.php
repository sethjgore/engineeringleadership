<?php 
if(get_field("blog_style","options") == "Squared Images"){
	get_template_part("template","blog-2");
}else{
	get_template_part("template","blog");
}