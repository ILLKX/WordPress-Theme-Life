<header class="blog-post-page-title">
    <h4><?php the_title(); ?></h4>
    <time datetime="<?php the_time('Y-m-d'); ?>"><i class="fa fa-clock-o"></i><?php the_time('Y-m-d'); ?></time>
    <span>
        <i class="fa fa-eye"></i>
        <span class="views"><?php post_views(' ', ' '); ?></span>
    </span>
    <span><i class="fa fa-folder-o"></i>
      <?php the_category('<a>','</a>'); ?>
    </span>
</header>
<div class="blog-main-post blog-post-page-box">
    <article class="blog-post-block blog-post-page-content">
        <section>
            <?php the_content(); ?>
        </section>
        <footer class="blog-post-page-tags">
            <?php
            if(get_the_tag_list()) {
                echo get_the_tag_list();
            }
            ?>
        </footer>
    </article>
    <article class="blog-post-page-readmore">
        <?php
            $prev_post = get_previous_post();
            $next_post = get_next_post();
        ?>
        <?php if(get_previous_post()){ ?>
            <a href="<?php echo get_permalink($prev_post->ID);?>" class="blog-post-page-readmore-prev" data-toggle="tooltip" data-placement="top" title="<?php echo $prev_post->post_title;?>" data-original-title="">上一篇</a>
        <?php } ?>
        <?php if(get_next_post()){ ?>
            <a href="<?php echo get_permalink($next_post->ID);?>" class="blog-post-page-readmore-next" data-toggle="tooltip" data-placement="top" title="<?php echo $next_post->post_title;?>" data-original-title="">下一篇</a>
        <?php } ?>
        <div style="clear: both;"></div>
    </article>

    <article class="blog-post-block blog-post-page-content">
        <div class="row">
            <div class="col-md-4 col-sm-4 post-page-more-btn">
                <span class="post-comments-btn btn btn-info btn-block" data-toggle="tooltip" data-placement="top" title="目前没有找到较好的与Pjax插件兼容的方法，所以只能刷新页面后才能评论">点我评论</span>
            </div>
            <script>
                $(".post-comments-btn").click(function(){
                    history.go(0) ;
                })
            </script>
            <div class="col-md-4 col-sm-4 post-page-more-btn">
                    <span  data-toggle="modal" data-target="#post-donate-content">
                        <span id="post-donate-btn" class="btn btn-danger btn-block" data-toggle="tooltip" data-placement="top" title="如果您觉得本文还不错或者对您有帮助，可以考虑打赏一下作者哦">打赏本文</span>
                    </span>
            </div>
            <div class="col-md-4 col-sm-4 post-page-more-btn">
                    <span  data-toggle="modal" data-target="#post-qrcode-content">
                        <span><span id="post-qrcode-btn" class="btn btn-success btn-block" data-toggle="tooltip" data-placement="top" title="微信扫描二维码手机端查看本文及分享本文">二维码</span></span>
                    </span>
            </div>
        </div>
        <div class="post-more-function-br"></div>
        <script>
            $(".post-comments-btn").click(function(){
                $(".post-comments").toggle();
            })
        </script>

        <div class="modal fade" id="post-donate-content" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">打赏本文</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="row post-donate-content">
                            <div class="col-md-4">
                                <p>支付宝</p>
                                <img class="post-donate-content-img no-lightbox" src="<?php echo get_option('life-alipay'); ?>" alt="">
                            </div>
                            <div class="col-md-4">
                                <p>微信</p>
                                <img class="post-donate-content-img no-lightbox" src="<?php echo get_option('life-wechatpay'); ?>" alt="">
                            </div>
                            <div class="col-md-4">
                                <p>财付通</p>
                                <img class="post-donate-content-img no-lightbox" src="<?php echo get_option('life-qqpay'); ?>" alt="">
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">关闭</button>
                    </div>
                </div>
            </div>
        </div>
        <!-- 文章二维码模态框 -->
        <div class="modal fade" id="post-qrcode-content" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-sm" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">文章二维码</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="row post-qrcode-content">
                            <span class="post-qrcode-content-canvas"></span>
                            <img class="post-qrcode-content-img no-lightbox" src=""/>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">关闭</button>
                    </div>
                </div>
            </div>
        </div>
        <!-- 文章页二维码生成脚本 -->
        <script>
            // post QRcode
            // 中文转码
            function toUtf8(str) {
                var out, i, len, c;
                out = "";
                len = str.length;
                for (i = 0; i < len; i++) {
                    c = str.charCodeAt(i);
                    if ((c >= 0x0001) && (c <= 0x007F)) {
                        out += str.charAt(i);
                    } else if (c > 0x07FF) {
                        out += String.fromCharCode(0xE0 | ((c >> 12) & 0x0F));
                        out += String.fromCharCode(0x80 | ((c >> 6) & 0x3F));
                        out += String.fromCharCode(0x80 | ((c >> 0) & 0x3F));
                    } else {
                        out += String.fromCharCode(0xC0 | ((c >> 6) & 0x1F));
                        out += String.fromCharCode(0x80 | ((c >> 0) & 0x3F));
                    }
                }
                return out;
            }
            // 生成
            var qrcode= $('.post-qrcode-content-canvas').qrcode({width: 150,height: 150,text: toUtf8("<?php the_permalink(); ?>")}).hide();
            var canvas=qrcode.find('canvas').get(0);
            $('.post-qrcode-content-img').attr('src',canvas.toDataURL('image/jpg'));
        </script>

    </article>

    <article class="blog-post-block blog-post-page-content" style="margin-top:2em;">
        <br>
        <?php
        // If comments are open or we have at least one comment, load up the comment template.
        if ( comments_open() || get_comments_number() ) :
            comments_template();
        endif;
        ?>
    </article>
</div>










