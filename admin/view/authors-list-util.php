<script type="text/html" id="tmpl-rtca-authors-search-result-template">
    <# _.each(data.results, function(result) { #>
        <li id="{{ result.id }}">
            <input type="checkbox" name="rtca_contributors[]" value="{{ result.id }}" <# if (result.is_selected) { #> checked="checked" <# } #> >
                <a href="#">
                    <img alt="" src="{{ result.avatar }}" srcset="{{ result.avatar_2x }} 2x" class="avatar avatar-30 photo" height="30" width="30" loading="lazy" decoding="async">
                    <label>{{ result.name }}</label>
                </a>
        </li>
        <# }); #>
</script>