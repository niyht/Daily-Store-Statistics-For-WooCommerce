<?php
/*
Plugin Name: Brikpanel - Modern WooCommerce Admin
Description: Modern admin panel for WooCommerce by Brksoft
Version: 1.0.0
Author: Brksoft
*/

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly
}

function brikpanelIncludeFiles() {
    wp_enqueue_style( 'brikpanel-admin', plugins_url('/assets/brikpanel-admin.css', __FILE__), array(), '1.0.0');
}
add_action( 'admin_enqueue_scripts', 'brikpanelIncludeFiles' );

function brikpanelAddMenu() {
    add_menu_page( 
        'Brik Panel',
        'Brik Panel',
        'manage_options',
        'brikpanel',
        'brikpanelMenuCallback',
        'dashicons-chart-line',
        1 
    );
}
add_action('admin_menu', 'brikpanelAddMenu');

function brikpanelAllVisitors() {

    if(!isset($_COOKIE['brikpanelAllVisitorsCookie'])) {
        // Optionu tanımla
        $allVisitors = get_option( 'brikpanelVisitorsOption', 0);
    
        // Option ekle ve 1 arttır
        update_option( 'brikpanelVisitorsOption', $allVisitors + 1);

    }

    setcookie(
        'brikpanelAllVisitorsCookie',
        '1',
        time() + 86400,
        '/',
        '',
        is_ssl(), // Sadece HTTPS üzerinde çerez ayarlanırsa true olur.
        true // HttpOnly bayrağı
    
    );

}
add_action( 'wp', 'brikpanelAllVisitors' );

function brikpanelAllProductVisitors() {

    if(is_product()) {
        if(!isset($_COOKIE['brikpanelProductVisitorsCookie'])) {
            $allProductVisitors = get_option( 'brikpanelProductVisitorsOption', 0);
        
            // Option ekle ve 1 arttır
            update_option( 'brikpanelProductVisitorsOption', $allProductVisitors + 1);
        
        }

        setcookie(
            'brikpanelProductVisitorsCookie',
            '1',
            time() + 86400,
            '/',
            '',
            is_ssl(), // Sadece HTTPS üzerinde çerez ayarlanırsa true olur.
            true // HttpOnly bayrağı
        
        );
    }
}
add_action( 'wp', 'brikpanelAllProductVisitors' );

function brikpanelAddtocartVisitors() {
    // Zaman bilgilerini al
    $last_reset = get_option('brikpanelAddtocartLastReset', 0);  // Son sıfırlanma zamanını al
    $current_time = time();  // Şu anki zamanı al (saniye cinsinden)

    // Eğer 24 saat geçmişse sayaç sıfırlanır
    if ( ($current_time - $last_reset) > 86400 ) {  // 86400 saniye = 24 saat
        update_option('brikpanelAddtocartVisitorsOption', 0);  // Sayaç sıfırlanır
        update_option('brikpanelAddtocartLastReset', $current_time);  // Yeni zaman kaydedilir
    }

    // Eğer sepete ekleme işlemi varsa, sayacı artır
    if (!empty($_POST['add-to-cart'])) {
        $allAddtocartVisitors = get_option('brikpanelAddtocartVisitorsOption', 0);  // Mevcut sayacı al
        update_option('brikpanelAddtocartVisitorsOption', $allAddtocartVisitors + 1);  // Sayacı artır
    }
}
add_action('wp', 'brikpanelAddtocartVisitors');

function brikpanelCartVisitors() {
    if(is_cart()) {
        if(!isset($_COOKIE['brikpanelCartVisitorsCookie'])) {
            $allCartVisitors = get_option( 'brikpanelCartVisitorsOption', 0);
        
            // Option ekle ve 1 arttır
            update_option( 'brikpanelCartVisitorsOption', $allCartVisitors + 1);
        
        }

        setcookie(
            'brikpanelCartVisitorsCookie',
            '1',
            time() + 86400,
            '/',
            '',
            is_ssl(), // Sadece HTTPS üzerinde çerez ayarlanırsa true olur.
            true // HttpOnly bayrağı
        
        );
    }
}
add_action('wp', 'brikpanelCartVisitors');

function brikpanelCheckoutVisitors() {
    if(is_checkout()) {
        if(!isset($_COOKIE['brikpanelCheckoutVisitorsCookie'])) {
            $allCheckoutVisitors = get_option( 'brikpanelCheckoutVisitorsOption', 0);
        
            // Option ekle ve 1 arttır
            update_option( 'brikpanelCheckoutVisitorsOption', $allCheckoutVisitors + 1);
        
        }

        setcookie(
            'brikpanelCheckoutVisitorsCookie',
            '1',
            time() + 86400,
            '/',
            '',
            is_ssl(), // Sadece HTTPS üzerinde çerez ayarlanırsa true olur.
            true // HttpOnly bayrağı
        
        );
    }
}
add_action('wp', 'brikpanelCheckoutVisitors');

function brikpanelMenuCallback() {
    // Optionları tanımla
    $allVisitors = get_option( 'brikpanelVisitorsOption', 0);
    $allProductVisitors = get_option( 'brikpanelProductVisitorsOption', 0);
    $allAddtocartVisitors = get_option( 'brikpanelAddtocartVisitorsOption', 0);
    $allCartVisitors = get_option( 'brikpanelCartVisitorsOption', 0);
    $allCheckoutVisitors = get_option( 'brikpanelCheckoutVisitorsOption', 0);

    ?>

    <div id="brikpanelDiv">
        <h2 id="brikpanelTitle" class="brikpanelTitle">Brik Panel - Today's data</h2>

        <!-- Visitors Kartı -->
        <div class="outer">
            <div class="dot"></div>
            <div class="card">
                <div class="ray"></div>
                <div class="text"><?php echo esc_html($allVisitors); ?></div>
                <div>Visitors</div>
                <div class="line topl"></div>
                <div class="line leftl"></div>
                <div class="line bottoml"></div>
                <div class="line rightl"></div>
            </div>
        </div>

        <!-- Product Views Kartı -->
        <div class="outer">
            <div class="dot"></div>
            <div class="card">
                <div class="ray"></div>
                <div class="text"><?php echo esc_html($allProductVisitors); ?></div>
                <div>Product Views</div>
                <div class="line topl"></div>
                <div class="line leftl"></div>
                <div class="line bottoml"></div>
                <div class="line rightl"></div>
            </div>
        </div>

        <!-- Add to Cart Kartı -->
        <div class="outer">
            <div class="dot"></div>
            <div class="card">
                <div class="ray"></div>
                <div class="text"><?php echo esc_html($allAddtocartVisitors); ?></div>
                <div>Add to Cart</div>
                <div class="line topl"></div>
                <div class="line leftl"></div>
                <div class="line bottoml"></div>
                <div class="line rightl"></div>
            </div>
        </div>

        <!-- Cart Visitors Kartı -->
        <div class="outer">
            <div class="dot"></div>
            <div class="card">
                <div class="ray"></div>
                <div class="text"><?php echo esc_html($allCartVisitors); ?></div>
                <div>Cart Visitors</div>
                <div class="line topl"></div>
                <div class="line leftl"></div>
                <div class="line bottoml"></div>
                <div class="line rightl"></div>
            </div>
        </div>

        <!-- Checkout Visitors Kartı -->
        <div class="outer">
            <div class="dot"></div>
            <div class="card">
                <div class="ray"></div>
                <div class="text"><?php echo esc_html($allCheckoutVisitors); ?></div>
                <div>Checkout Visitors</div>
                <div class="line topl"></div>
                <div class="line leftl"></div>
                <div class="line bottoml"></div>
                <div class="line rightl"></div>
            </div>
        </div>

    </div>

    <?php
}

function brikpanel_redirect_to_custom_dashboard() {
    global $pagenow;

    // Eğer yönetici paneli ana sayfasındaysanız ve yöneticiyseniz yönlendirme yapın
    if ('index.php' == $pagenow && current_user_can('manage_options')) {
        wp_redirect(admin_url('admin.php?page=brikpanel'));
        exit;
    }
}
add_action('admin_init', 'brikpanel_redirect_to_custom_dashboard');

