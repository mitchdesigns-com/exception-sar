<?php
add_action('rest_api_init', function () {
    register_rest_route('api/v2', 'home', array(
        'methods' => 'GET',
        'callback' => 'get_home_callback',
        'permission_callback' => 'is_user_logged_in',
    ));
});
function get_category_slug_from_url($url) {
    $parsed_url = parse_url($url);
    $path = $parsed_url['path'];
    $path_parts = explode('/', trim($path, '/'));
    $index = array_search('product-category', $path_parts);
    if ($index !== false && isset($path_parts[$index + 1])) {
        return $path_parts[$index + 1];
    }

    return null;
}

function get_home_callback(WP_REST_Request $request) {

    $home_content_ar = get_field('home_group_ar', 13);
    $home_content_en = get_field('home_group_en', 13);

    $banners = [] ;
    foreach ($home_content_ar['hero_section']['images'] as $banner) {
        $banners [] = $banner['banner_mobile'] ;
    }

    $categories_ar = [];
    foreach ($home_content_ar['categories_content']as $cat) {
        $data = [
            "title" => $cat['category_title'],
            "subtitle" => $cat['category_subtitle'],
            "image" => $cat['category_image'],
            "slug" => get_category_slug_from_url( $cat['category_link']),
        ];
        $categories_ar[] = $data;
    }

    $categories_en = [];
    foreach ($home_content_en['categories_content']as $cat) {
        $data = [
            "title" => $cat['category_title'],
            "subtitle" => $cat['category_subtitle'],
            "image" => $cat['category_image'],
            "slug" =>  get_category_slug_from_url($cat['category_link']),
        ];
        $categories_en[] = $data;
    }

    $response = array(
        "banner" => $banners ,
        "categories_ar" => $categories_ar,
        "categories_en" => $categories_en,
    );


    return new WP_REST_Response($response);

}