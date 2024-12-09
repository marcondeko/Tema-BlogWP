<?php get_header(); ?>

<div class="container">
    <header class="page-header">
        <h1 class="page-title">
            <?php
                if (is_category()) {
                    single_cat_title();
                } elseif (is_tag()) {
                    single_tag_title();
                } elseif (is_author()) {
                    the_archive_title();
                } elseif (is_date()) {
                    the_archive_title();
                } else {
                    echo 'Arquivo';
                }
            ?>
        </h1>
    </header>

    <?php if (have_posts()) : ?>
        <div class="row">
            <?php while (have_posts()) : the_post(); ?>
                <div class="col-md-4">
                    <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
                        <header class="entry-header">
                            <?php the_title('<h2 class="entry-title"><a href="' . esc_url(get_permalink()) . '" rel="bookmark">', '</a></h2>'); ?>
                        </header>
                        <div class="entry-summary">
                            <?php the_excerpt(); ?>
                        </div>
                    </article>
                </div>
            <?php endwhile; ?>
        </div>

        <div class="pagination">
            <?php
                the_posts_pagination(array(
                    'prev_text' => '&laquo;',
                    'next_text' => '&raquo;',
                ));
            ?>
        </div>
    <?php else : ?>
        <p><?php _e('Desculpe, não há posts para exibir.', 'meu-tema'); ?></p>
    <?php endif; ?>
</div>

<?php get_footer(); ?>
