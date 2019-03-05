<?php

class Support
{

    public function themeCommentTemplate($comment, $args, $depth)
    {
        $GLOBALS['comment'] = $comment;
        extract($args, EXTR_SKIP);

        if ('div' == $args['style']) {
            $tag = 'div';
            $add_below = 'comment';
        } else {
            $tag = 'li';
            $add_below = 'div-comment';
        }
        ?>
<!-- heads up: starting < for the html tag (li or div) in the next line: -->
<<?php echo $tag ?> <?php comment_class(empty($args['has_children']) ? '' : 'parent')?>
    id="comment-<?php comment_ID()?>">
    <?php if ('div' != $args['style']): ?>
    <div id="div-comment-<?php comment_ID()?>" class="comment-body">
        <?php endif;?>
        <div class="comment-avatar">
            <?php if ($args['avatar_size'] != 0) {
            echo get_avatar($comment, ['180']);
        }
        ?>
        </div>
        <div class="comment-right">
            <div class="comment-meta">
                <div class="comment-author">
                    <?php echo get_comment_author_link(); ?>
                </div>
                <div class="comment-control">
                    <div class="comment-datetime">
                        <div class="comment-date">
                            <?php echo get_comment_date(); ?>
                        </div>
                        <div class="comment-time">
                            <?php echo get_comment_time(); ?>
                        </div>
                    </div>
                    <div class="comment-reply">
                        <?php comment_reply_link(array_merge($args, array('add_below' => $add_below, 'depth' => $depth, 'max_depth' => $args['max_depth'])))?>
                    </div>
                    <a href="<?php echo htmlspecialchars(get_comment_link($comment->comment_ID)) ?>"></a>

                    <?php edit_comment_link(__('Edit'), '  ', '');
        ?>
                </div>
            </div>
            <?php if ($comment->comment_approved == '0'): ?>
            <em class="comment-awaiting-moderation"><?php _e('Your comment is awaiting moderation.')?></em>
            <br />
            <?php endif;?>
            <div class="comment-content">
                <?php comment_text()?>
            </div>
        </div>

        <?php if ('div' != $args['style']): ?>
    </div>
    <?php endif;?>
    <?php
    }


}

?>