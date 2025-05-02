<?php

/**
 * @see https://github.com/WordPress/gutenberg/blob/trunk/docs/reference-guides/block-api/block-metadata.md#render
 */
$ncbd_news = get_posts(array("post_type" => 'post', 'posts_per_page' => 3));
?>

<div <?php echo get_block_wrapper_attributes(); ?>>
    <div class="marquee-wrapper">
        <div class="marquee-track">
            <?php foreach ($ncbd_news as $case_study): ?>
                <div class="marquee-item">
                    <a href="<?php echo get_permalink($case_study->ID); ?>">
                        <span><?php echo $case_study->post_title; ?></span>
                    </a>
                </div>
                <div class="separator">✮</div>
            <?php endforeach; ?>
        </div>
    </div>

    <!-- <div class="marquee">
        <div class="marquee__inner">
            <?php foreach ($ncbd_news as $case_study): ?>
                <a href="<?php echo get_permalink($case_study->ID); ?>">
                    <span><?php echo $case_study->post_title; ?></span>
                </a>
            <?php endforeach; ?>
        </div>
    </div> -->
</div>