<?php
defined('ABSPATH') || exit;
$s = rema_get_settings();
$ramroma_logo = $s['header']['ramroma_logo_image'];
if (!$ramroma_logo || strpos($ramroma_logo, 'brand-ramroma-logo.png') !== false || strpos($ramroma_logo, 'babechic-logo.png') !== false) {
    $ramroma_logo = get_template_directory_uri() . '/assets/images/ramroma-logo.png';
}
?>
<!doctype html>
<html <?php language_attributes(); ?> dir="<?php echo is_rtl() ? 'rtl' : 'ltr'; ?>">
<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<?php wp_body_open(); ?>
<?php if (!empty($s['header']['show'])) : ?>
<header class="rema-header">
    <nav class="navbar navbar-expand-lg" aria-label="<?php esc_attr_e('Primary navigation', 'rima-ramroma'); ?>">
        <div class="container-fluid px-xl-5">
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#remaNavbar" aria-controls="remaNavbar" aria-expanded="false" aria-label="<?php esc_attr_e('Toggle navigation', 'rima-ramroma'); ?>"><span class="navbar-toggler-icon"></span></button>
            <div class="collapse navbar-collapse order-3 order-lg-1" id="remaNavbar">
                <ul class="navbar-nav gap-xl-3">
                    <li class="nav-item"><a class="nav-link" href="<?php echo esc_url($s['header']['about_url']); ?>"><?php echo wp_kses_post(rema_t($s['header']['about_label'])); ?></a></li>
                    <li class="nav-item"><a class="nav-link" href="<?php echo esc_url($s['header']['brands_url']); ?>"><?php echo wp_kses_post(rema_t($s['header']['brands_label'])); ?></a></li>
                    <li class="nav-item"><a class="nav-link" href="<?php echo esc_url($s['header']['shop_url']); ?>"><?php echo wp_kses_post(rema_t($s['header']['shop_label'])); ?></a></li>
                </ul>
            </div>
            <a class="rema-header-logos navbar-brand order-1 order-lg-2" href="<?php echo esc_url(home_url('/')); ?>" aria-label="<?php echo esc_attr(get_bloginfo('name')); ?>">
                <?php if ($s['header']['logo_image']) : ?><img src="<?php echo esc_url($s['header']['logo_image']); ?>" alt="Rima"><?php else : ?><span class="rema-rima-logo"><img src="<?php echo esc_url(get_template_directory_uri() . '/assets/images/rima-logo-mark.svg'); ?>" alt=""><img src="<?php echo esc_url(get_template_directory_uri() . '/assets/images/rima-logo-word.svg'); ?>" alt="Rima"></span><?php endif; ?>
                <span class="rema-logo-line"></span><img src="<?php echo esc_url($ramroma_logo); ?>" alt="Ramroma">
            </a>
            <div class="rema-header-actions order-2 order-lg-3">
                <a href="<?php echo esc_url($s['header']['search_url']); ?>" aria-label="<?php esc_attr_e('Search', 'rima-ramroma'); ?>"><img src="<?php echo esc_url(get_template_directory_uri() . '/assets/images/icon-search.svg'); ?>" alt=""></a>
                <a class="rema-cart" href="<?php echo esc_url($s['header']['cart_url']); ?>" aria-label="<?php esc_attr_e('Cart', 'rima-ramroma'); ?>"><img src="<?php echo esc_url(get_template_directory_uri() . '/assets/images/icon-bag.svg'); ?>" alt=""><span><?php echo function_exists('WC') && WC()->cart ? esc_html(WC()->cart->get_cart_contents_count()) : '0'; ?></span></a>
                <a class="rema-account" href="<?php echo esc_url($s['header']['account_url']); ?>"><img src="<?php echo esc_url(get_template_directory_uri() . '/assets/images/icon-user.svg'); ?>" alt=""><small><?php echo wp_kses_post(rema_t($s['header']['account_label'])); ?></small></a>
                <?php echo rema_language_switcher(); ?>
            </div>
        </div>
    </nav>
</header>
<?php endif; ?>
