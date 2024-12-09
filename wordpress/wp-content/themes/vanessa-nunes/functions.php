<?php
// Registrar o estilo do tema
function meu_tema_styles() {
    wp_enqueue_style('meu-tema-style', get_stylesheet_uri());
}
add_action('wp_enqueue_scripts', 'meu_tema_styles');

// Registrar menus de navegação
function meu_tema_menus() {
    register_nav_menus(array(
        'primary' => __('Menu Principal', 'meu-tema'),
    ));
}
add_action('after_setup_theme', 'meu_tema_menus');

// Configurações do tema
function meu_tema_setup() {
    add_theme_support('post-thumbnails');
    add_theme_support('automatic-feed-links');
    add_theme_support('title-tag');
    add_theme_support('html5', array('search-form', 'comment-form', 'gallery', 'caption'));
}
add_action('after_setup_theme', 'meu_tema_setup');

require_once get_template_directory() . '/inc/class-wp-bootstrap-navwalker.php';

function meu_tema_scripts() {
    // Estilos do Bootstrap
    wp_enqueue_style('bootstrap-css', 'https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css');
    // Scripts do Bootstrap
    wp_enqueue_script('bootstrap-js', 'https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js', array('jquery'), null, true);
}
add_action('wp_enqueue_scripts', 'meu_tema_scripts');

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

comment_form( array(
    'title_reply' => 'Deixe um comentário', // Título do formulário
    'label_submit' => 'Enviar Comentário', // Texto do botão
    'comment_field' => '<textarea id="comment" name="comment" rows="5" placeholder="Seu comentário..."></textarea>',
) );



// Habilitar o suporte ao WordPress Customizer
function meu_tema_customizer($wp_customize) {
    // Exemplo de configuração para logo
    $wp_customize->add_section('meu_tema_logo_section', array(
        'title'    => __('Logo', 'meu-tema'),
        'priority' => 30,
    ));

    $wp_customize->add_setting('meu_tema_logo', array(
        'default' => '',
        'sanitize_callback' => 'esc_url_raw',
    ));

    $wp_customize->add_control(new WP_Customize_Image_Control($wp_customize, 'meu_tema_logo_control', array(
        'label'    => __('Upload do Logo', 'meu-tema'),
        'section'  => 'meu_tema_logo_section',
        'settings' => 'meu_tema_logo',
    )));
}

add_action('customize_register', 'meu_tema_customizer');



class AuthorBioWidget extends WP_Widget {

    public function __construct() {
        parent::__construct(
            'author_bio_widget', // ID do widget
            __('Widget Sobre Mim', 'text_domain'), // Nome do widget
            array('description' => __('Um widget para mostrar informações sobre o autor', 'text_domain'))
        );
    }

    public function widget($args, $instance) {
        echo $args['before_widget'];
        ?>
        <section id="author_bio_widget" class="widget widget_author_bio">
            <h2 class="widget-title"><?php echo esc_html($instance['title']); ?></h2>
            <div class="author-bio-holder">
                <div class="image-holder">
                    <img src="<?php echo esc_url($instance['image_url']); ?>" alt="<?php echo esc_attr($instance['title']); ?>" />
                </div>
                <div class="text-holder">
                    <div class="title-holder"><?php echo esc_html($instance['author_name']); ?></div>
                    <div class="author-bio-content">
                        <p><?php echo esc_html($instance['description']); ?></p>
                    </div>
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

        // Formulário no painel do WordPress
        ?>
        <p>
            <label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Título:'); ?></label>
            <input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo esc_attr($title); ?>" />
        </p>
        <p>
            <label for="<?php echo $this->get_field_id('author_name'); ?>"><?php _e('Nome do Autor:'); ?></label>
            <input class="widefat" id="<?php echo $this->get_field_id('author_name'); ?>" name="<?php echo $this->get_field_name('author_name'); ?>" type="text" value="<?php echo esc_attr($author_name); ?>" />
        </p>
        <p>
            <label for="<?php echo $this->get_field_id('description'); ?>"><?php _e('Descrição:'); ?></label>
            <textarea class="widefat" id="<?php echo $this->get_field_id('description'); ?>" name="<?php echo $this->get_field_name('description'); ?>"><?php echo esc_textarea($description); ?></textarea>
        </p>
        <p>
            <label for="<?php echo $this->get_field_id('image_url'); ?>"><?php _e('URL da Imagem:'); ?></label>
            <input class="widefat" id="<?php echo $this->get_field_id('image_url'); ?>" name="<?php echo $this->get_field_name('image_url'); ?>" type="text" value="<?php echo esc_attr($image_url); ?>" />
        </p>
        <?php
    }

    public function update($new_instance, $old_instance) {
        $instance = array();
        $instance['title'] = (!empty($new_instance['title'])) ? strip_tags($new_instance['title']) : '';
        $instance['author_name'] = (!empty($new_instance['author_name'])) ? strip_tags($new_instance['author_name']) : '';
        $instance['description'] = (!empty($new_instance['description'])) ? strip_tags($new_instance['description']) : '';
        $instance['image_url'] = (!empty($new_instance['image_url'])) ? strip_tags($new_instance['image_url']) : '';
        return $instance;
    }
}

// Registrar o widget
function register_author_bio_widget() {
    register_widget('AuthorBioWidget');
}
add_action('widgets_init', 'register_author_bio_widget');

function register_footer_widgets() {
    register_sidebar(array(
        'name' => 'Footer Widget 1',
        'id' => 'footer-widget-1',
        'before_widget' => '<div class="widget-item">',
        'after_widget' => '</div>',
        'before_title' => '<h4 class="widget-title">',
        'after_title' => '</h4>',
    ));
    register_sidebar(array(
        'name' => 'Footer Widget 2',
        'id' => 'footer-widget-2',
        'before_widget' => '<div class="widget-item">',
        'after_widget' => '</div>',
        'before_title' => '<h4 class="widget-title">',
        'after_title' => '</h4>',
    ));
    register_sidebar(array(
        'name' => 'Footer Widget 3',
        'id' => 'footer-widget-3',
        'before_widget' => '<div class="widget-item">',
        'after_widget' => '</div>',
        'before_title' => '<h4 class="widget-title">',
        'after_title' => '</h4>',
    ));
    register_sidebar(array(
        'name' => 'Footer Widget 4',
        'id' => 'footer-widget-4',
        'before_widget' => '<div class="widget-item">',
        'after_widget' => '</div>',
        'before_title' => '<h4 class="widget-title">',
        'after_title' => '</h4>',
    ));
}
add_action('widgets_init', 'register_footer_widgets');