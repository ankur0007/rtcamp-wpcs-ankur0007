<script type="text/html" id="tmpl-rtca-single-author-search-result-template">
    <li id="{{ data.result.id }}">
        <input style="display:none" type="checkbox" name="rtca_contributors[]" value="{{ data.result.id }}">
        <a href="">
            <img alt="" src="{{ data.result.avatar }}" srcset="{{ data.result.avatar_2x }} 2x" class="avatar avatar-30 photo" height="30" width="30" loading="lazy" decoding="async">
            <label>{{ data.result.name }}</label>
            <span id="{{ data.result.id }}" class="rtca-remove-contributor dashicons dashicons-no-alt"></span>
        </a>
    </li>
</script>