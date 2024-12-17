<?php

// Enfileirar estilos e scripts
function meu_tema_scripts() {
    // Estilos do Bootstrap via CDN
    wp_enqueue_style('bootstrap-css', 'https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css');
    // Estilo principal do tema
    wp_enqueue_style('meu-tema-style', get_stylesheet_uri());
    // Scripts do Bootstrap via CDN
    wp_enqueue_script('bootstrap-js', 'https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js', array('jquery'), null, true);
}
add_action('wp_enqueue_scripts', 'meu_tema_scripts');

// Registrar e incluir o WP Bootstrap Navwalker para menus
function enqueue_font_awesome() {
    wp_enqueue_style('font-awesome', 'https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css');
}
add_action('wp_enqueue_scripts', 'enqueue_font_awesome');



// Registrar menus de navegação
function meu_tema_menus() {
    register_nav_menus(array(
        'primary' => __('Menu Principal', 'meu-tema'), // Nome amigável para o menu
    ));
}
add_action('after_setup_theme', 'meu_tema_menus');

// Ativar a Admin Bar para todos os usuários logados
add_filter('show_admin_bar', '__return_true');

add_action('init', function() {
    show_admin_bar(true);
});

// Configurações básicas do tema
function meu_tema_setup() {
    add_theme_support('post-thumbnails'); // Suporte a imagens destacadas
    add_theme_support('automatic-feed-links'); // Links automáticos para feeds
    add_theme_support('title-tag'); // Gerenciamento automático da tag <title>
    add_theme_support('html5', array('search-form', 'comment-form', 'gallery', 'caption')); // Suporte a HTML5
}
add_action('after_setup_theme', 'meu_tema_setup');

// Registrar widgets na barra lateral
function meu_tema_register_sidebar() {
    register_sidebar(array(
        'name'          => __('Sidebar Principal', 'meu-tema'),
        'id'            => 'sidebar-principal',
        'before_widget' => '<div class="widget">',
        'after_widget'  => '</div>',
        'before_title'  => '<h2 class="widget-title">',
        'after_title'   => '</h2>',
    ));
}
add_action('widgets_init', 'meu_tema_register_sidebar');

// Registrar widgets no rodapé
function register_footer_widgets() {
    for ($i = 1; $i <= 4; $i++) {
        register_sidebar(array(
            'name'          => "Footer Widget $i",
            'id'            => "footer-widget-$i",
            'before_widget' => '<div class="widget-item">',
            'after_widget'  => '</div>',
            'before_title'  => '<h4 class="widget-title">',
            'after_title'   => '</h4>',
        ));
    }
}
add_action('widgets_init', 'register_footer_widgets');

// Suporte ao WordPress Customizer
function meu_tema_customizer($wp_customize) {
    // Seção para upload de logo
    $wp_customize->add_section('meu_tema_logo_section', array(
        'title'    => __('Logo', 'meu-tema'),
        'priority' => 30,
    ));
    $wp_customize->add_setting('meu_tema_logo', array(
        'default'           => '',
        'sanitize_callback' => 'esc_url_raw',
    ));
    $wp_customize->add_control(new WP_Customize_Image_Control($wp_customize, 'meu_tema_logo_control', array(
        'label'    => __('Upload do Logo', 'meu-tema'),
        'section'  => 'meu_tema_logo_section',
        'settings' => 'meu_tema_logo',
    )));
}
add_action('customize_register', 'meu_tema_customizer');

// Registrar e incluir o WP Bootstrap Navwalker para menus
require_once get_template_directory() . '/inc/class-wp-bootstrap-navwalker.php';


// Widget "Sobre Mim"
class AuthorBioWidget extends WP_Widget {
    public function __construct() {
        parent::__construct(
            'author_bio_widget',
            __('Widget Sobre Mim', 'meu-tema'),
            array('description' => __('Exibe informações sobre o autor', 'meu-tema'))
        );
    }

    public function widget($args, $instance) {
        echo $args['before_widget']; ?>
        <section class="widget widget_author_bio">
            <h2 class="widget-title"><?php echo esc_html($instance['title']); ?></h2>
            <div>
                <div class="image-holder">
                    <img src="<?php echo esc_url($instance['image_url']); ?>" alt="<?php echo esc_attr($instance['title']); ?>" class="img-fluid rounded-circle">
                </div>
                <div class="title-holder">
                    <h3><?php echo esc_html($instance['author_name']); ?></h3>
                </div>
                <div class="author-bio-content">
                    <p><?php echo esc_html($instance['description']); ?></p>
                </div>
                <div class="author-bio-socicons">
                    <?php if (!empty($instance['facebook_url'])): ?>
                        <a href="<?php echo esc_url($instance['facebook_url']); ?>" class="author-socicons" target="_blank" rel="noopener noreferrer">
                            <i class="fab fa-facebook-f"></i>
                        </a>
                    <?php endif; ?>
                    <?php if (!empty($instance['twitter_url'])): ?>
                        <a href="<?php echo esc_url($instance['twitter_url']); ?>" class="author-socicons" target="_blank" rel="noopener noreferrer">
                            <i class="fab fa-twitter"></i>
                        </a>
                    <?php endif; ?>
                    <?php if (!empty($instance['linkedin_url'])): ?>
                        <a href="<?php echo esc_url($instance['linkedin_url']); ?>" class="author-socicons" target="_blank" rel="noopener noreferrer">
                            <i class="fab fa-linkedin-in"></i>
                        </a>
                    <?php endif; ?>
                </div>
            </div>
        </section>
        <?php
        echo $args['after_widget'];
    }

    public function form($instance) {
        $title = !empty($instance['title']) ? $instance['title'] : '';
        $author_name = !empty($instance['author_name']) ? $instance['author_name'] : '';
        $description = !empty($instance['description']) ? $instance['description'] : '';
        $image_url = !empty($instance['image_url']) ? $instance['image_url'] : '';
        $facebook_url = !empty($instance['facebook_url']) ? $instance['facebook_url'] : '';
        $twitter_url = !empty($instance['twitter_url']) ? $instance['twitter_url'] : '';
        $linkedin_url = !empty($instance['linkedin_url']) ? $instance['linkedin_url'] : '';
        ?>
        <p>
            <label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Título:'); ?></label>
            <input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo esc_attr($title); ?>">
        </p>
        <p>
            <label for="<?php echo $this->get_field_id('author_name'); ?>"><?php _e('Nome do Autor:'); ?></label>
            <input class="widefat" id="<?php echo $this->get_field_id('author_name'); ?>" name="<?php echo $this->get_field_name('author_name'); ?>" type="text" value="<?php echo esc_attr($author_name); ?>">
        </p>
        <p>
            <label for="<?php echo $this->get_field_id('description'); ?>"><?php _e('Descrição:'); ?></label>
            <textarea class="widefat" id="<?php echo $this->get_field_id('description'); ?>" name="<?php echo $this->get_field_name('description'); ?>"><?php echo esc_textarea($description); ?></textarea>
        </p>
        <p>
            <label for="<?php echo $this->get_field_id('image_url'); ?>"><?php _e('URL da Imagem:'); ?></label>
            <input class="widefat" id="<?php echo $this->get_field_id('image_url'); ?>" name="<?php echo $this->get_field_name('image_url'); ?>" type="text" value="<?php echo esc_attr($image_url); ?>">
        </p>
        <p>
            <label for="<?php echo $this->get_field_id('facebook_url'); ?>"><?php _e('URL do Facebook:'); ?></label>
            <input class="widefat" id="<?php echo $this->get_field_id('facebook_url'); ?>" name="<?php echo $this->get_field_name('facebook_url'); ?>" type="text" value="<?php echo esc_attr($facebook_url); ?>">
        </p>
        <p>
            <label for="<?php echo $this->get_field_id('twitter_url'); ?>"><?php _e('URL do Twitter:'); ?></label>
            <input class="widefat" id="<?php echo $this->get_field_id('twitter_url'); ?>" name="<?php echo $this->get_field_name('twitter_url'); ?>" type="text" value="<?php echo esc_attr($twitter_url); ?>">
        </p>
        <p>
            <label for="<?php echo $this->get_field_id('linkedin_url'); ?>"><?php _e('URL do LinkedIn:'); ?></label>
            <input class="widefat" id="<?php echo $this->get_field_id('linkedin_url'); ?>" name="<?php echo $this->get_field_name('linkedin_url'); ?>" type="text" value="<?php echo esc_attr($linkedin_url); ?>">
        </p>
        <?php
    }

    public function update($new_instance, $old_instance) {
        $instance = array();
        $instance['title'] = !empty($new_instance['title']) ? strip_tags($new_instance['title']) : '';
        $instance['author_name'] = !empty($new_instance['author_name']) ? strip_tags($new_instance['author_name']) : '';
        $instance['description'] = !empty($new_instance['description']) ? strip_tags($new_instance['description']) : '';
        $instance['image_url'] = !empty($new_instance['image_url']) ? strip_tags($new_instance['image_url']) : '';
        $instance['facebook_url'] = !empty($new_instance['facebook_url']) ? esc_url_raw($new_instance['facebook_url']) : '';
        $instance['twitter_url'] = !empty($new_instance['twitter_url']) ? esc_url_raw($new_instance['twitter_url']) : '';
        $instance['linkedin_url'] = !empty($new_instance['linkedin_url']) ? esc_url_raw($new_instance['linkedin_url']) : '';
        return $instance;
    }
}

// Registrar o widget
function register_author_bio_widget() {
    register_widget('AuthorBioWidget');
}
add_action('widgets_init', 'register_author_bio_widget');


?>
