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
                <img src="<?php echo esc_url($instance['image_url']); ?>" alt="<?php echo esc_attr($instance['title']); ?>">
                <h3><?php echo esc_html($instance['author_name']); ?></h3>
                <p><?php echo esc_html($instance['description']); ?></p>
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
        <?php
    }

    public function update($new_instance, $old_instance) {
        $instance = array();
        $instance['title'] = !empty($new_instance['title']) ? strip_tags($new_instance['title']) : '';
        $instance['author_name'] = !empty($new_instance['author_name']) ? strip_tags($new_instance['author_name']) : '';
        $instance['description'] = !empty($new_instance['description']) ? strip_tags($new_instance['description']) : '';
        $instance['image_url'] = !empty($new_instance['image_url']) ? strip_tags($new_instance['image_url']) : '';
        return $instance;
    }
}

// Registrar o widget
function register_author_bio_widget() {
    register_widget('AuthorBioWidget');
}
add_action('widgets_init', 'register_author_bio_widget');

?>
