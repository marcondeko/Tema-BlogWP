<?php get_header(); ?>

<div class="container mt-4">
    <div class="row">
        <!-- Carrossel de posts em destaque -->
        <div id="featuredPostsCarousel" class="carousel slide col-12 mb-4" data-bs-ride="carousel">
            <div class="carousel-inner">
                <?php
                $args_destaque = array(
                    'posts_per_page' => 5,
                    'category_name' => 'destaques',
                );
                $query_destaque = new WP_Query($args_destaque);
                $active_class = 'active';
                if ($query_destaque->have_posts()) :
                    while ($query_destaque->have_posts()) : $query_destaque->the_post();
                ?>
                        <div class="carousel-item <?php echo $active_class; ?>">
                            <?php if (has_post_thumbnail()) : ?>
                                <img src="<?php the_post_thumbnail_url('large'); ?>" 
                                    class="d-block w-100 carousel-image" 
                                    alt="<?php the_title_attribute(); ?>">
                            <?php endif; ?>
                            <div class="carousel-caption d-none d-md-block bg-dark bg-opacity-50 p-3">
                                <h5><a href="<?php the_permalink(); ?>" class="text-light text-decoration-none"><?php the_title(); ?></a></h5>
                                <p><?php echo wp_trim_words(get_the_content(), 15, '...'); ?></p>
                            </div>
                        </div>
                <?php
                        $active_class = '';
                    endwhile;
                    wp_reset_postdata();
                endif;
                ?>
            </div>
            <button class="carousel-control-prev" type="button" data-bs-target="#featuredPostsCarousel" data-bs-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Anterior</span>
            </button>
            <button class="carousel-control-next" type="button" data-bs-target="#featuredPostsCarousel" data-bs-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Próximo</span>
            </button>
        </div>


        <!-- Lista de posts -->
        <main class="col-lg-8 col-md-7">
            <?php if (have_posts()) : ?>
                <div class="row">
                    <?php while (have_posts()) : the_post(); ?>
                        <div class="col-md-6 mb-4">
                            <article class="card h-100">
                                <?php if (has_post_thumbnail()) : ?>
                                    <a href="<?php the_permalink(); ?>">
                                        <img src="<?php the_post_thumbnail_url('medium'); ?>" class="card-img-top" alt="<?php the_title_attribute(); ?>">
                                    </a>
                                <?php endif; ?>
                                <div class="card-body">
                                    <h5 class="card-title">
                                        <a href="<?php the_permalink(); ?>" class="text-decoration-none text-dark"><?php the_title(); ?></a>
                                    </h5>
                                    <p class="card-text text-muted">
                                        Publicado em <?php echo get_the_date(); ?> por <?php the_author(); ?>
                                    </p>
                                    <p class="card-text">
                                        <?php echo wp_trim_words(get_the_content(), 20, '...'); ?>
                                    </p>
                                    <a href="<?php the_permalink(); ?>" class="btn btn-primary btn-sm">Leia mais</a>
                                </div>
                            </article>
                        </div>
                    <?php endwhile; ?>
                </div>

                <nav class="mt-4">
                    <?php
                    the_posts_pagination(array(
                        'prev_text' => '<span class="btn btn-outline-primary btn-sm">&laquo; Anterior</span>',
                        'next_text' => '<span class="btn btn-outline-primary btn-sm">Próximo &raquo;</span>',
                        'before_page_number' => '<span class="btn btn-outline-secondary btn-sm">',
                        'after_page_number' => '</span>',
                    ));
                    ?>
                </nav>
            <?php else : ?>
                <div class="alert alert-info text-center">
                    <p>Não há posts disponíveis no momento. Por favor, volte mais tarde!</p>
                </div>
            <?php endif; ?>
        </main>

        <!-- Sidebar -->
        <aside class="col-lg-4 col-md-5">
            <div class="p-3 pt-0">
                <?php get_sidebar(); ?>
            </div>
        </aside>
    </div>
</div>

<?php get_footer(); ?>
