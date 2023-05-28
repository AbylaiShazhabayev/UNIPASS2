<label for="{{ $id ?? '' }}" class="form-label">{{ __($label ?? '') }}{!! isset($required) ? '<span class="text-danger"> *</span>' : '' !!}</label>
<select class="form-select" id="{{ $id ?? '' }}" name="{{ $name ?? '' }}" {{ isset($required) ? 'required' : '' }}>
</select>

<script type="text/javascript">
    $("#{{ $id ?? '' }}").selectize({
        valueField: "{{ $valueField ?? 'id' }}",
        labelField: "{{ $labelField ?? 'name' }}",
        searchField: "{{ $labelField ?? 'name' }}",
        preload: ("{{ $preload ?? 'true' }}" === 'true'),
        plugins: ['remove_button'],
        load: function (query, callback) {
            if (query.length) return callback();

            $.ajax({
                url: '{{ $url ?? "" }}',
                type: 'GET',
                dataType: 'JSON',
                error: function () {
                    callback();
                },
                success: function (data) {
                    callback(data);
                }
            });
        },
        render: {
            option: function (item) {
                let pl = item.depth * 12;
                return '<div class="py-1" style="padding-left: calc(12px + ' + pl + 'px)">' + item.name + '</div>';
            }
        }
    });
</script>
