<?php header('Content-Type: text/css; charset: UTF-8'); ?>

<?php if(isset($_GET["font"]) && $_GET["font"]): ?>
    body, a, h1, h2, h3, h4, h5, h6 {
    font-family: '<?php echo $_GET["font"]; ?>', Arial, sans-serif;
    }
<?php endif; ?>

<?php if(isset($_GET["italic_font"]) && $_GET["italic_font"]): ?>
blockquote {
    font-family: "<?php echo $_GET["italic_font"]; ?>" !important;
}
.capture h3 {
    font-family: '<?php echo $_GET["italic_font"]; ?>', serif !important;
}
.sg_title h2 {
    font-family: '<?php echo $_GET["italic_font"]; ?>', serif !important;
}
.dropcap {
    font-family: "<?php echo $_GET["italic_font"]; ?>" !important;
}
blockquote cite {
    font-family: "<?php echo $_GET["italic_font"]; ?>" !important;
}
<?php endif; ?>

<?php if(isset($_GET["brand_color"]) && $_GET["brand_color"]): ?>
    ::selection      { background:<?php echo $_GET["brand_color"]; ?>; color:#000;}
    ::-moz-selection  { background:<?php echo $_GET["brand_color"]; ?>; color:#000;}
    a:hover {
    color:  <?php echo $_GET["brand_color"]; ?> !important;
    }

    blockquote {
    border-color: <?php echo $_GET["brand_color"]; ?> !important;
    }

    .navbar-nav li a:hover {
    color: <?php echo $_GET["brand_color"]; ?> !important;
    }
	.button_u:hover {
	border: 2px solid <?php echo $_GET["brand_color"]; ?>;
	color: <?php echo $_GET["brand_color"]; ?>;
	}
    .social-icons a:hover {
    background: <?php echo $_GET["brand_color"]; ?> !important;
    }
	.social-icons a:hover i{
	color:#fff;
	}
    .post_thumb_hover {
    background: <?php echo $_GET["brand_color"]; ?> !important;
    }

    .widget_content .blog-recent-posts i {
    color: <?php echo $_GET["brand_color"]; ?> !important;

    }

    input:focus, textarea:focus {
    border: 2px solid <?php echo $_GET["brand_color"]; ?> !important;

    }

    .post_thumb_hover_g {
    background: <?php echo $_GET["brand_color"]; ?> !important;
    }

    .post_title_g i {
    color: <?php echo $_GET["brand_color"]; ?> !important;
    }

    .team_desc h3 {
    color: <?php echo $_GET["brand_color"]; ?> !important;
    }

    .svg_marker i {
    color: <?php echo $_GET["brand_color"]; ?> !important;
    }

    .get_in_touch li i {
    color: <?php echo $_GET["brand_color"]; ?> !important;
    }

    .page-template-template-home-fullscreen-php .header .navbar-nav > li > a:hover {
    color: <?php echo $_GET["brand_color"]; ?> !important;
    }

    .button_s {
    border: 2px solid <?php echo $_GET["brand_color"]; ?>;
    color:  <?php echo $_GET["brand_color"]; ?> !important;
    }

    .post_thumb_b_holder {
    background: <?php echo $_GET["brand_color"]; ?> !important;
    }

    .project_desc ul li i {
    color: <?php echo $_GET["brand_color"]; ?> !important;
    }

    .pr_slider_arrows i:hover {
    background: <?php echo $_GET["brand_color"]; ?> !important;
    }

    .bullets-pr-slider ul li a:hover  {
    border: 2px solid <?php echo $_GET["brand_color"]; ?> !important;
    }


    .fn a {
    color: <?php echo $_GET["brand_color"]; ?> !important;
    }

    .fn  {
    color: <?php echo $_GET["brand_color"]; ?> !important;
    }

    .a_slider_bullets ul li a:hover{
    border-color: <?php echo $_GET["brand_color"]; ?> !important;
    }

    .single_a_s a:hover {
    color: <?php echo $_GET["brand_color"]; ?> !important;
    }

    ul.accordion > li a.active {
    background-color: <?php echo $_GET["brand_color"]; ?> !important;
    border-color: <?php echo $_GET["brand_color"]; ?> !important;
    }

    ul.tab_buttons > li a.active {
    background-color: <?php echo $_GET["brand_color"]; ?> !important;
    border-color: <?php echo $_GET["brand_color"]; ?> !important;
    }

    ul.toggle> li a.active {
    background-color: <?php echo $_GET["brand_color"]; ?> !important;
    border-color: <?php echo $_GET["brand_color"]; ?> !important;
    }

    .highlight {
    background-color: <?php echo $_GET["brand_color"]; ?> !important;
    }

    .white:hover {
    border: 2px solid <?php echo $_GET["brand_color"]; ?> !important;
    color:  <?php echo $_GET["brand_color"]; ?> !important;
    }

    .dark-grey:hover {
    border: 2px solid <?php echo $_GET["brand_color"]; ?> !important;
    color:  <?php echo $_GET["brand_color"]; ?> !important;
    }

    .green {
    border: 2px solid <?php echo $_GET["brand_color"]; ?> !important;
    color: <?php echo $_GET["brand_color"]; ?> !important;
    }

    blockquote cite {
    color: <?php echo $_GET["brand_color"]; ?> !important;
    }
	
	/*WooCommerce*/
	.woocommerce-info {
   		border-top: 3px solid <?php echo $_GET["brand_color"]; ?>;
   }
   
   .woocommerce-info:before {
	   background-color: <?php echo $_GET["brand_color"]; ?>;
   }
   
   .woocommerce span.onsale, .woocommerce-page span.onsale {
	   background: <?php echo $_GET["brand_color"]; ?>;
   }
    
   .woocommerce ul.cart_list li .star-rating, .woocommerce ul.product_list_widget li .star-rating, .woocommerce-page ul.cart_list li .star-rating, .woocommerce-page ul.product_list_widget li .star-rating {
	   color: <?php echo $_GET["brand_color"]; ?>;
   } 
   
   .woocommerce .star-rating:before, .woocommerce-page .star-rating:before {
	   color: <?php echo $_GET["brand_color"]; ?>;
   }
   
   .woocommerce table.cart td.actions .button.alt, .woocommerce #content table.cart td.actions .button.alt, .woocommerce-page table.cart td.actions .button.alt, .woocommerce-page #content table.cart td.actions .button.alt {
	   background: <?php echo $_GET["brand_color"]; ?>;
	   border: 1px solid <?php echo $_GET["brand_color"]; ?>;
   }
   
   .comment-text strong {
   		color: <?php echo $_GET["brand_color"]; ?>;
   }
	
   .woocommerce .star-rating span, .woocommerce-page .star-rating span {
		color: <?php echo $_GET["brand_color"]; ?>;
   }
	
	.woocommerce-message {
		border-top: 3px solid <?php echo $_GET["brand_color"]; ?>;
	}
	
	.woocommerce-message:before {
		background-color: <?php echo $_GET["brand_color"]; ?>;
	}
   
	.woocommerce div.product span.price, .woocommerce div.product p.price, .woocommerce #content div.product span.price, .woocommerce #content div.product p.price, .woocommerce-page div.product span.price, .woocommerce-page div.product p.price, .woocommerce-page #content div.product span.price, .woocommerce-page #content div.product p.price {
		color: <?php echo $_GET["brand_color"]; ?>;
	}
	
	mark {
		background: <?php echo $_GET["brand_color"]; ?> ;
	}
	
	.woocommerce .widget_price_filter .price_slider_wrapper .ui-widget-content, .woocommerce-page .widget_price_filter .price_slider_wrapper .ui-widget-content {
		background: <?php echo $_GET["brand_color"]; ?>;
	}

	.amount {
		color: <?php echo $_GET["brand_color"]; ?>;
	}

	.woocommerce a.button:hover {
		border: 2px solid <?php echo $_GET["brand_color"]; ?>;
		color:  <?php echo $_GET["brand_color"]; ?> !important;
	}
	
	.woocommerce .star-rating span:before, .woocommerce-page .star-rating span:before {
		color: <?php echo $_GET["brand_color"]; ?>;
	}
	
	.count_pr{
		background: <?php echo $_GET["brand_color"]; ?>;
	}
	
	.woocommerce .woocommerce-message, .woocommerce-page .woocommerce-message {
		color: <?php echo $_GET["brand_color"]; ?> !important;
		border-color: <?php echo $_GET["brand_color"]; ?> !important;
	}
	
	.woocommerce .woocommerce-message:before, .woocommerce-page .woocommerce-message:before {
		background-color: <?php echo $_GET["brand_color"]; ?> !important;
	}
	
	.woocommerce table.cart td.actions .button.alt{
		background: <?php echo $_GET["brand_color"]; ?> !important;
	}
	
	.woocommerce .woocommerce-info, .woocommerce-page .woocommerce-info {
		color: <?php echo $_GET["brand_color"]; ?> !important;
		border-color: <?php echo $_GET["brand_color"]; ?> !important;
	}
	
	.woocommerce .woocommerce-info:before, .woocommerce-page .woocommerce-info:before {
		background-color: <?php echo $_GET["brand_color"]; ?> !important;
	}
	
	.slides-navigation a i:hover {
		background: <?php echo $_GET["brand_color"]; ?> !important;
	}
<?php endif; ?>

/*Font Headings*/
<?php if(isset($_GET["heading_1_font_size"]) && $_GET["heading_1_font_size"]): ?>
    h1{
        font-size: <?php echo $_GET["heading_1_font_size"]; ?>px;
    }
<?php endif; ?>
<?php if(isset($_GET["heading_2_font_size"]) && $_GET["heading_2_font_size"]): ?>
    h2{
    font-size: <?php echo $_GET["heading_2_font_size"]; ?>px;
    }
<?php endif; ?>
<?php if(isset($_GET["heading_3_font_size"]) && $_GET["heading_3_font_size"]): ?>
    h3{
    font-size: <?php echo $_GET["heading_3_font_size"]; ?>px;
    }
<?php endif; ?>
<?php if(isset($_GET["heading_4_font_size"]) && $_GET["heading_4_font_size"]): ?>
    h4{
    font-size: <?php echo $_GET["heading_4_font_size"]; ?>px;
    }
<?php endif; ?>
<?php if(isset($_GET["heading_5_font_size"]) && $_GET["heading_5_font_size"]): ?>
    h5{
    font-size: <?php echo $_GET["heading_5_font_size"]; ?>px;
    }
<?php endif; ?>
<?php if(isset($_GET["heading_6_font_size"]) && $_GET["heading_6_font_size"]): ?>
    h6{
    font-size: <?php echo $_GET["heading_6_font_size"]; ?>px;
    }
<?php endif; ?>
/*Font Headings*/

/*White Borders*/
<?php if(isset($_GET["white_borders"]) && $_GET["white_borders"]): ?>
    .right-border, .left-border, .top-border, .bottom-border {
        display:none !important;
    }
<?php endif; ?>
/*White Borders*/

/*Borders Color*/
<?php if(isset($_GET["border_color"]) && $_GET["border_color"]): ?>
.right-border, .left-border, .top-border, .bottom-border {
	background: <?php echo $_GET["border_color"]; ?> !important;
}
<?php endif; ?>
/*Borders Color*/

/*Background Image*/
<?php if(isset($_GET["bg"]) && $_GET["bg"]): ?>
body{
background-image: url("<?php echo $_GET["bg"]; ?>");
background-repeat: <?php echo $_GET["repeat"]; ?>;
background-position: center center;
background-attachment: fixed;
<?php if($_GET["repeat"] == "no-repeat"): ?>
-webkit-background-size: cover;
-moz-background-size: cover;
-o-background-size: cover;
background-size: cover;
<?php endif; ?>
}
<?php endif; ?>
/*Background Image*/