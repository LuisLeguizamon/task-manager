<script>
    $(function() {
        $("#sortable").sortable({
            axis: "y",
            update: function(event, ui) {
                var data = $(this).sortable('toArray', {
                    attribute: 'data-task-id'
                });
                $.ajax({
                    type: "PUT",
                    url: "{{ route('priority.update') }}",
                    data: {
                        order: data,
                        _token: '{{ csrf_token() }}'
                    },
                    success: function(response) {
                        location.reload();
                    }
                });
            }
        });
        $("#sortable").disableSelection();
    });
</script>
