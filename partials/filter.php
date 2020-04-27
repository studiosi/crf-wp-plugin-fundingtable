<div id="crf-funding-table-filters" class="row">
    <div id="crf-funding-table-filters-inner" class="col">
        <form id="crf-funding-table-filters-form">

            <div class="form-group">
                <label id="crf-filter-who-can-apply-category-label" for="crf-filter-who-can-apply-category">Who is applying?</label>
                <select class="form-control" id="crf-filter-who-can-apply-category">
                    <option value="">---</option>
                    <?php foreach($table_data->filters->who_can_apply_category as $item): ?>
                        <option value="<?php echo $item; ?>"><?php echo $item; ?></option>
                    <?php endforeach; ?>
                </select>
            </div>

            <!--
            <div class="form-group">
                <label id="crf-filter-iso-countries-label" for="crf-filter-iso-countries">From which country?</label>
                <select class="form-control" id="crf-filter-iso-countries">
                    <option value="">---</option>                    
                </select>
            </div>
            -->

            <button id="crf-funding-table-filters-submit" type="submit" class="btn btn-primary btn-lg btn-block">Filter</button>

        </form>
    </div>
</div>

<script>
    $(document).ready(function() {
        $('#crf-funding-table-filters-submit').click(function(evt) {
            evt.preventDefault();
            if($('#crf-funding-table').length) {
                let ajaxurl = '<?php echo admin_url("admin-ajax.php"); ?>';
                let whoCanApplyCategory = $('#crf-filter-who-can-apply-category').val();
                let data = {
                    'action': 'crf_filter_results',
                    'filter-who-can-apply-category': whoCanApplyCategory,
                };
                $.post(ajaxurl, data, function(response) {
                    let r = JSON.parse(response);
                    if(r.success) {
                        $('#crf-funding-table').replaceWith(r.data);
                    }
                    else {
                        console.warn("Invalid values for filtering.");
                    }
                });
            }
            else {
                console.warn('The funding table does not exist on the current DOM. Using the filters has no effect.');
            }
        });
    });
</script>