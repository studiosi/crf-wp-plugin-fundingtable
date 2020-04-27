<?php
// Action for AJAX calls to filter results
// Action name: crf_filter_results

function crf_filter_results_generate_return($success, $data="") {
    $result = array();
    $result['success'] = $success;
    $result['data'] = $data;
    return json_encode($result);
}

function crf_filter_results_apply_filter_who_can_apply_category($table_data, $category) {
    $new_rows = array();
    foreach($table_data->rows as $row) {
        if(in_array($category, $row->who_can_apply_category)) {
            $new_rows[] = $row;
        }
    }
    return $new_rows;
}

function crf_filter_results() {
    // Load table data
    $table_data = crf_shortcode_funding_table_get_table_data();
    // Load filter values
    $who = $_POST['filter-who-can-apply-category'];
    // Validate filter values
    if(!in_array($who, $table_data->filters->who_can_apply_category) && !empty($who)) {        
        echo crf_filter_results_generate_return(false);
        wp_die();
    }
    // Filter table results
    if(!empty($who)) {
        $table_data->rows = crf_filter_results_apply_filter_who_can_apply_category($table_data, $who);
    }    
    // Generate table
    ob_start();
    include __DIR__ . "/partials/table.php";
    $table = ob_get_clean();
    // Echo response and die
    echo crf_filter_results_generate_return(true, $table);
    wp_die();
}
add_action('wp_ajax_crf_filter_results', 'crf_filter_results');
add_action('wp_ajax_nopriv_crf_filter_results', 'crf_filter_results');