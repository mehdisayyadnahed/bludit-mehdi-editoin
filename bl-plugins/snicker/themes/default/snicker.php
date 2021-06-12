<?php
/*
 |  Snicker     The first native FlatFile Comment Plugin 4 Bludit
 |  @file       ./system/themes/default/snicker.php
 |  @author     SamBrishes <sam@pytes.net>
 |  @version    0.1.2 [0.1.0] - Alpha
 |
 |  @website    https://github.com/pytesNET/snicker
 |  @license    X11 / MIT License
 |  @copyright  Copyright © 2019 SamBrishes, pytesNET <info@pytes.net>
 */
    if(!defined("BLUDIT")){ die("Go directly to Jail. Do not pass Go. Do not collect 200 Cookies!"); }

    class Default_SnickerTemplate extends CommentsTheme{
        const SNICKER_NAME = "Default Theme";
        const SNICKER_JS = "snicker.js";
        const SNICKER_CSS = "snicker.css";

        /*
         |  RENDER :: COMMENT FORM
         |  @since  0.1.0
         |  @update 0.1.1
         */
        public function form($username = "", $email = "a@b.c", $title = "", $message = ""){
            global $comments, $login, $page, $security, $Snicker;

            // User Logged In
            if(!is_a($login, "Login")){
                $login = new Login;
            }
            $user = $login->isLogged();

            // Get Data
            if(empty($security->getTokenCSRF())){
                $security->generateTokenCSRF();
            }
            $captcha = ($user)? "disabled": sn_config("frontend_captcha");
            $terms = ($user)? "disabled": sn_config("frontend_terms");

            // Is Reply
            $reply = isset($_GET["snicker"]) && $_GET["snicker"] == "reply";
            if($reply && isset($_GET["uid"]) && $comments->exists($_GET["uid"])){
                $reply = new Comment($_GET["uid"], $page->uuid());
            }
            ?>
                <form class="comment-form" method="post" action="<?php echo $page->permalink(); ?>?snicker=comment#snicker">
                    <h4 style="padding: 1rem 1rem 0 0 ;"><?php sn_e("Comments"); ?></h4>
                    <?php if(is_array($username)){ ?>
                        <div class="comment-header" style="padding-top: 0px;">
                            <input type="hidden" id="comment-user" name="comment[user]" value="<?php echo $username[0]; ?>" />
                            <input type="hidden" id="comment-token" name="comment[token]" value="<?php echo $username[1]; ?>" />
                            <div class="inner">
                                <?php sn_e("Logged in as %s (%s)", array( $username[2] , "")); ?>
                            </div>
                        </div>
                    <?php } else { ?>
                        <div class="comment-header" style="padding-top: 0px;">
                            <div class="table">
                                <div class="table-cell align-left">
                                    <input type="text" id="comment-user" name="comment[username]" value="<?php echo $username; ?>" placeholder="<?php sn_e("Your Username"); ?>" />
                                </div>
                               <!-- &nbsp;
                                    <div class="table-cell align-right"> -->
                                    <input type="hidden" id="comment-mail" name="comment[email]" value="<?php $email="a@b.c"; echo $email; ?>" placeholder="<?php #sn_e("Your eMail address"); ?>" />
                                <!-- </div> -->
                            </div>
                        </div>
                    <?php } ?>

                    <div class="comment-article">
                        <?php if(Alert::get("snicker-alert") !== false){ ?>
                            <div class="comment-alert alert-error">
                                <?php Alert::p("snicker-alert"); ?>
                            </div>
                        <?php } else if(Alert::get("snicker-success") !== false){ ?>
                            <div class="comment-alert alert-success">
                                <?php Alert::p("snicker-success"); ?>
                            </div>
                        <?php } ?>

                        <?php if($title !== false){ ?>
                            <p>
                                <input type="text" id="comment-title" name="comment[title]" value="<?php echo $title; ?>" placeholder="<?php sn_e("Comment Title"); ?>" />
                            </p>
                        <?php } ?>
                        <p style="margin-bottom: 0">
                            <textarea id="comment-text" name="comment[comment]" placeholder="<?php sn_e("Your Comment..."); ?>"><?php echo $message; ?></textarea>
                        </p>
                    </div>
                    <div class="comment-footer">
                        <div class="table">


                        <div class="container" style="padding: 0px">
                        <div class="row">
                        <div class="col-sm-4 ">
                            <div class="table-cell float-right">
                                <?php if($captcha !== "disabled"){ ?>
                                <div class="comment-captcha">

                                    <a href="<?php echo $page->permalink(); ?>#snicker-comment-form" data-captcha="reload">
                                        <?php echo $Snicker->generateCaptcha();  ?>
                                    </a>
                                
                                    <input type="text" name="comment[captcha]" style="text-align: right" value="" placeholder="<?php sn_e("Answer"); ?>" />
                                </div>
                                <?php } ?>
                                <?php if(is_a($reply, "Comment")){ ?>
                                    <div class="comment-reply">
                                        <a href="<?php echo $page->permalink(); ?>#snicker-comment-form" class="reply-cancel"></a>
                                        <div class="reply-title">
                                            <?php echo $reply->username(); ?> <?php sn_e("wrote"); ?>:
                                        </div>
                                        <div class="reply-content">
                                            <?php echo $reply->comment(); ?>
                                        </div>
                                    </div>
                                <?php } ?>
                            </div>
                            </div>
                            <div class="col-sm-4">
                            <div class="table-cell">
                                <?php if($terms === "default"){ ?>
                                    <div class="custom-checkbox">
                                        <input class="custom-control-input" type="checkbox" id="comment-terms" name="comment[terms]" value="1" />
                                        <label class="custom-control-label" for="comment-terms">
                                            <span style="margin-right: 1.5rem;"><?php echo sn_config("string_terms_of_use"); ?></span>
                                        </label>
                                    </div>
                                <?php } else if($terms !== "disabled"){ ?>
                                    <div class="custom-checkbox">
                                        <input class="custom-control-input" type="checkbox" id="comment-terms" name="comment[terms]" value="1" />
                                        <label class="custom-control-input" for="comment-terms">
                                            <span style="margin-right: 1.5rem;"><?php sn_e("I agree the %s!", array('<a href="" target="_blank">'.sn__("Terms of Use").'</a>')); ?></span>
                                        </label>
                                    </div>
                                <?php } ?>
                            </div>
                            </div>
                            <div class="col-sm-4">
                            <div class="table-cell float-left">
                                <input type="hidden" name="tokenCSRF" value="<?php echo $security->getTokenCSRF(); ?>" />
                                    <input type="hidden" name="comment[page_uuid]" value="<?php echo $page->uuid(); ?>" />
                                    <input type="hidden" name="action" value="snicker" />
                                    <?php if(is_a($reply, "Comment")){ ?>
                                        <input type="hidden" name="comment[parent_uid]" value="<?php echo $reply->uid(); ?>" />
                                        <button name="snicker" value="reply" class="btn btn-primary" data-string="<?php sn_e("Comment"); ?>"><?php sn_e("Reply"); ?></button>
                                    <?php } else { ?>
                                        <button name="snicker" value="comment" class="btn btn-primary" data-string="<?php sn_e("Reply"); ?>"><?php sn_e("Comment"); ?></button>
                                    <?php } ?>
                            </div>
                            </div>
                            </div>
                            </div>
                        </div>
                    </div>
                </form>
            <?php
            unset($_SESSION["s_snicker-alert"]);        // Remove Snicker Alerts
            unset($_SESSION["s_snicker-success"]);      // Remove Snicker Success
        }

        /*
         |  RENDER :: PAGINATION
         |  @since  0.1.0
         */
        public function pagination($location, $cpage, $limit, $count){
            global $url;

            // Data
            $link = DOMAIN . $url->uri() . "?cpage=%d#snicker-comments-list";
            $maxpages = (int) ceil($count / $limit);
            $prev = ($cpage === 1)? false: $cpage - 1;
            $next = ($cpage === $maxpages)? false: $cpage + 1;

            // Top Position
            if($location === "top"){
                ?>
                    <div class="pagination pagination-top">
                        <?php if($cpage === 1){ ?>
                            <span class="pagination-button disabled"><?php sn_e("Previous Comments"); ?></span>
                        <?php } else { ?>
                            <a href="<?php printf($link, $prev); ?>" class="pagination-button"><?php sn_e("Previous Comments"); ?></a>
                        <?php } ?>

                        <?php if($cpage < $maxpages){ ?>
                            <a href="<?php printf($link, $next); ?>" class="pagination-button"><?php sn_e("Next Comments"); ?></a>
                        <?php } else { ?>
                            <span class="pagination-button disabled"><?php sn_e("Next Comments"); ?></span>
                        <?php } ?>
                    </div>
                <?php
            }

            // Bottom Position
            if($location === "bottom"){
                ?>
                    <div class="pagination pagination-bottom">
                        <div class="pagination-inner">
                            <?php if($prev === false){ ?>
                                <span class="pagination-button disabled">&laquo;</span>
                                <span class="pagination-button disabled">&lsaquo;</span>
                            <?php } else { ?>
                                <a href="<?php printf($link, 1); ?>" class="pagination-button">&laquo;</a>
                                <a href="<?php printf($link, $prev); ?>" class="pagination-button">&lsaquo;</a>
                            <?php } ?>

                            <?php
                                if($maxpages < 6){
                                    $start = 1;
                                    $stop = $maxpages;
                                } else {
                                    $start = ($cpage > 3)? $cpage - 3: $cpage;
                                    $stop = ($cpage + 3 < $maxpages)? $cpage + 3: $maxpages;
                                }

                                if($start > 1){
                                    ?><span class="pagination-button disabled">...</span><?php
                                }
                                for($i = $start; $i <= $stop; $i++){
                                    $active = ($i == $cpage)? "active": "";
                                    ?>
                                        <a href="<?php printf($link, $i); ?>" class="pagination-button <?php echo $active; ?>"><?php echo $i; ?></a>
                                    <?php
                                }
                                if($stop < $maxpages){
                                    ?><span class="pagination-button disabled">...</span><?php
                                }
                            ?>

                            <?php if($next !== false){ ?>
                                <a href="<?php printf($link, $next); ?>" class="pagination-button">&rsaquo;</a>
                                <a href="<?php printf($link, $maxpages); ?>" class="pagination-button">&raquo;</a>
                            <?php } else { ?>
                                <span class="pagination-button disabled">&rsaquo;</span>
                                <span class="pagination-button disabled">&raquo;</span>
                            <?php } ?>
                        </div>
                    </div>
                <?php
            }
        }

        /*
         |  RENDER :: COMMENT
         |  @since  0.1.0
         */
        public function comment($comment, $uid, $depth){
            global $users, $security, $Snicker, $SnickerUsers;

            // Get Page
            $page = new Page($comment->page_key());
            $user = $SnickerUsers->getByString($comment->getValue("author"));

            // Render
            $token = $security->getTokenCSRF();
            $maxdepth = (int) sn_config("comment_depth");
            $url = $page->permalink() . "?action=snicker&snicker=rate&&uid=%s&tokenCSRF=%s";
            $url = sprintf($url, $comment->uid(), $token);
            ?>
                <div id="comment-<?php echo $comment->uid(); ?>" class="counter" >
                    <div class="comment" style="margin-left: <?php echo (15 * ($depth - 1)); ?>px;">
                    <div class="table" style="border-radius: 0.20rem 0.20rem 0 0;">
                        <!-- <div class="table-cell comment-avatar">
                            <?php # echo $comment->avatar(64); ?>
                            <?php
                                #if(isset($user["role"]) && $user["username"] === $page->username()){
                                #    echo '<span class="avatar-role">'.sn_e("Author").'</span>';
                                #} else if(isset($user["role"]) && $user["role"] === "admin"){
                                #    echo '<span class="avatar-role">Admin</span>';
                                #}
                            ?>
                        </div> -->
                        <div class="table-cell comment-content">
                            <?php if($comment->status() === "pending"){ ?>
                                <span class="comment-moderation"><?php sn_e("This comment hasn't been moderated yet!"); ?></span>
                            <?php  echo "<br>"; } ?>
                            <span class="meta-author">
                            <?php sn_e("Written by %s", array('<span class="author-username">'.$user["username"].'</span>')); ?>
                            </span>
                            <?php
                                if(isset($user["role"]) && $user["username"] === $page->username()){
                                    echo '<!-- Author --><span class="admin-author-star"> * </span>';
                                } else if(isset($user["role"]) && $user["role"] === "admin"){
                                    echo '<!-- Admin --><span class="admin-author-star"> * </span>';
                                }
                            ?>
                            <div class="comment-title">
                            <?php if(sn_config("comment_title") !== "disabled" and !empty($comment->title())){ ?>
                                    <?php sn_e("Comment Title"); ?>: <?php echo $comment->title(); ?> 
                            <?php } else if(sn_config("comment_title") === "disabled" and !empty($comment->title())){ ?>
                                    <?php sn_e("Comment Title"); ?>: <?php echo $comment->title(); ?> 
                            <?php } ?>

                            </div>
                            <div class="comment-meta">
                                <span class="meta-date">
                                    <?php sn_e("on %s", array($comment->date())); ?>
                                </span>
                            </div>
                            <div class="comment-comment">
                                <?php echo $comment->comment(); ?>
                            </div>
                        </div>
                    </div>
                    <div class="comment-action align-left" style="padding: 0 10px; border-radius: 0 0 0.20rem 0.20rem;">
                        <?php if(sn_config("comment_enable_like")){ ?>
                            <a href="<?php echo $url; ?>&type=like" class="action-like <?php echo ($Snicker->hasLiked($comment->uid())? "active": ""); ?>">
                                <?php sn_e("Like"); ?> <span data-snicker="like"><?php echo $comment->like(); ?></span>
                            </a>
                        <?php } ?>
                        <?php if(sn_config("comment_enable_dislike")){ ?>
                            <a href="<?php echo $url; ?>&type=dislike" class="action-dislike <?php echo ($Snicker->hasDisliked($comment->uid())? "active": ""); ?>">
                                <?php sn_e("Dislike"); ?> <span data-snicker="dislike"><?php echo $comment->dislike(); ?></span>
                            </a>
                        <?php } ?>
                    

                        <?php if($maxdepth === 0 || $maxdepth > $comment->depth()){ ?>
                            <a class="action-reply" href="<?php echo $page->permalink(); ?>?snicker=reply&uid=<?php echo $comment->key(); ?>#snicker-comments-form">
                                <?php sn_e("Reply"); ?>
                            </a>
                        <?php } ?>
                    </div>
                    </div>
                </div>
            <?php
        }
    }

