<?php
defined('ABSPATH') || exit;
get_header();
?>
<main class="rema-page rema-404-page">
    <section class="rema-404-section" aria-labelledby="rema-404-title">
        <div class="container">
            <div class="rema-404-card">
                <span class="rema-404-code" aria-hidden="true">404</span>
                <div class="rema-404-content">
                    <p class="rema-404-kicker"><?php esc_html_e('Page not found', 'rima-ramroma'); ?></p>
                    <h1 id="rema-404-title"><span class="rema-script"><?php esc_html_e('Lost', 'rima-ramroma'); ?></span> <?php esc_html_e('in Motion?', 'rima-ramroma'); ?></h1>
                    <p><?php esc_html_e('The page you are looking for may have moved or no longer exists. Let’s get you back on track.', 'rima-ramroma'); ?></p>
                    <?php echo rema_btn(__('Back to Home', 'rima-ramroma'), home_url('/')); ?>
                </div>
            </div>
        </div>
    </section>
</main>
<?php get_footer(); ?>
