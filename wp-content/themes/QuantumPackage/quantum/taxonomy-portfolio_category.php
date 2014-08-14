<?php
$cur_cat = get_query_var("portfolio_category");
$cur_cat = get_term_by('slug',$cur_cat,'portfolio_category');
$cur_cat = $cur_cat->term_id;
$cur_cat_template = get_field("portfolio_template","portfolio_category_{$cur_cat}");
$default_cat_template = get_field("portfolio_template","options");
if($cur_cat_template){
	get_template_part("template",$cur_cat_template);
}elseif($default_cat_template){
	get_template_part("template",$default_cat_template);
}else{
	get_template_part("template","home-grid");
}
//get_template_part("template","home-grid-3columns");