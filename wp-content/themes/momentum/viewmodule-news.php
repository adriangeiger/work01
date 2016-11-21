<?php $t =& peTheme(); ?>
<?php $content =& $t->content; ?>
<?php list($data, $bid) = $t->template->data(); ?>
<?php $style = ''; ?>
<?php if (!empty($data->bgcolor)) $style .= 'background-color: ' . $data->bgcolor . ';'; ?>
<?php if (!empty($data->bgimage)) $style .= 'background-image: url(\'' . $data->bgimage . '\');'; ?>
<?php if (!empty($style)) $style = 'style="' . $style . '"'; ?>
<section
    class="padding-top-<?php echo $data->padding_top; ?> padding-bottom-<?php echo $data->padding_bottom; ?> <?php if ('light' === $data->typography) echo 'text-color-light'; ?> bg-image-cover section-type-recentwork uses-lightbox-<?php echo var_export($use_lightbox, false); ?>"
    id="section-<?php echo empty($data->name) ? $bid : $data->name; ?>" <?php echo $style; ?>>

    <?php if (!empty($data->title)) : ?>

        <div class="row title">
            <h2><?php echo $data->title; ?></h2>
            <hr>
        </div>

    <?php endif; ?>

    <?php if (!empty($data->content)) : ?>

        <div class="row section-content">
            <div class="eight col center text-center">
                <div class="section-content-wrap"><?php echo $data->content; ?></div>
            </div>
        </div>

    <?php endif; ?>

    <div class="row relative">
        <div class="owlcarousel work-slider">
            <?php
            $posts = get_posts(array(
                'offset' => 0,
                'orderby' => 'post_date',
                'order' => 'DESC',
                'post_status' => 'publish'
            ));
            foreach ($posts as $post) {
                setup_postdata($post); ?>
                <a href="/blog/">
                    <div class="grid-ms news-square">
                        <div class="title blue"><?php echo $post->post_title; ?></div>
                        <div class="content"><?php echo $post->post_content; ?></div>
                    </div>
                </a>
                <?php
            }
            wp_reset_postdata();
            ?>

        </div>
        <a class="work-prev oc-left"><i class="fa fa-angle-left"></i></a>
        <a class="work-next oc-right"><i class="fa fa-angle-right"></i></a>
    </div>


</section>