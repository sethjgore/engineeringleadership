<?php
if ('open' == $post->comment_status) :
global $post;
    $comments = get_comments(array(
        'post_id' => $post->ID,
        'status' => 'approve'
    ));
    if ($comments):
        ?>
        <div class="comments_no_padding comments-list">
            <div class="col-sm-12 comments_no_padding">
                <div class="info_h">
                    <h5 class="section-title"><?php _e("Recent Comments", "um_lang"); ?></h5>
                </div>
            </div>
            <div class="col-sm-12 comments_no_padding">
                <?php wp_list_comments(array(), $comments); ?>
                <div class="comments_navigation">
                    <?php paginate_comments_links(); ?>
                </div>
            </div>
        </div>
    <?php endif; ?>
    <div class="comments-list">
        <div class="col-sm-12 comments_no_padding">
            <div class="info_h">
                <h5 class="section-title"><?php _e("Leave a comment", "um_lang"); ?></h5>
            </div>
        </div>
        <div class="">
            <?php
            $commenter = wp_get_current_commenter();
            $req = get_option('require_name_email');
            $req_str = $req ? " * " : "";
            $aria_req = ($req ? " aria-required='true'" : '');
            comment_form(array(
                "fields" => array(
                    'author' => '<p class="comment-form-author col-xs-12 col-sm-12 col-md-4 col-lg-4">' .
                        '<input id="author" placeholder="' . $req_str . __("Name", "um_lang") . '" name="author" type="text" value="' . esc_attr($commenter['comment_author']) .
                        '" size="30"' . $aria_req . ' /></p>',
                    'email' => '<p class="comment-form-email col-xs-12 col-sm-12 col-md-4 col-lg-4">' .
                        '<input id="email" placeholder="' . $req_str . __("Email", "um_lang") . '" name="email" type="text" value="' . esc_attr($commenter['comment_author_email']) .
                        '" size="30"' . $aria_req . ' /></p>',
                    'url' => '<p class="comment-form-url col-xs-12 col-sm-12 col-md-4 col-lg-4">' .
                        '<input id="url" placeholder="' . __("Website", "um_lang") . '" name="url" type="text" value="' . esc_attr($commenter['comment_author_url']) .
                        '" size="30" /></p>'
                ),
                'comment_field' => '<p class="comment-form-comment"><textarea id="comment" placeholder="' . __("Comment", "um_lang") . '" name="comment" cols="45" rows="8" aria-required="true"></textarea></p>'
            ));
            ?>
        </div>
    </div>
<?php endif; ?>