<div class="container">
    <div class="row" role="main">
        <div class="col-md-8 offset-md-2">
            <div class="koi">
                <h1 class="geg">Guestbook</h1>
                <p class="geg">
                    <strong>
                        <a href="#add-entry">Add Entry</a>
                    </strong>
                </p>
                <p class="tio">
                    <?php
                    if ((isset($_SESSION['login_user']) && $_SESSION['login_user'] != '')) {
                        ?>
                        <a href="/signout">Hi <?php echo $_SESSION['login_user'] ?>, Sign Out</a>
                        <?php
                    } else {
                        ?>
                        <a href="/signin">Sign In</a>
                        <?php
                    }
                    ?>
                </p>
            </div>
            <div class="kao"></div>
            <div id="comments" class="kep">
                <ol class="cls">
                    <?php
                    foreach ($comments as $comment) {
                        ?>
                        <li class="lkh" id="li-cm-<?php echo $comment['comment_id'] ?>">
                            <div id="div-cm-<?php echo $comment['comment_id'] ?>">
                                <input type="hidden" name="comment_name" value="<?php echo $comment['comment_name'] ?>">
                                <textarea name="comment_body" style="display: none"><?php echo $comment['comment_body'] ?></textarea>
                                <p class="jkn">
                                    <?php echo $comment['comment_name'] ?> - <?php echo date('F j, Y, g:i a', strtotime($comment['update_at'])) ?>
                                </p>
                                <div class="yhk">
                                    <p class="cmbd"><?php echo nl2br(htmlspecialchars($comment['comment_body'])) ?></p>
                                    <?php
                                    if ((isset($_SESSION['login_user']) && $_SESSION['login_user'] != '')) {
                                        ?>
                                        <p class="thdrpy">
                                            [<a href="javascript:void(0)" onclick="fn_edit(<?php echo $comment['comment_id'] ?>)">Edit</a>]
                                            [<a href="javascript:void(0)" onclick="fn_delete(<?php echo $comment['comment_id'] ?>)">Delete</a>]
                                        </p>
                                        <?php
                                    }
                                    ?>
                                </div>
                            </div>
                        </li>
                        <?php
                    }
                    ?>
                </ol>
            </div>
            <div id="add-entry">
                <div id="comment-form">
                    <textarea id="fm_comment_body" cols="45" rows="8" maxlength="65525" required="required"
                              class="tuv"></textarea>
                    <input id="fm_comment_name" class="arx" type="text" maxlength="50" required="required"
                           placeholder="Name*" value="">
                    <p class="ijk">
                        <button type="button" class="btn btn-dark" onclick="fn_save()">Submit Guestbook Entry</button>
                        <input type="hidden" id="fm_comment_id" value="0">
                    </p>
                    <p class="ijk">
                    <div id="add-entry-cancel" style="display: none;">
                        <a href="javascript:void(0)" onclick="fn_cancel()" style="color:red;">Click to cancel</a>
                    </div>
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>