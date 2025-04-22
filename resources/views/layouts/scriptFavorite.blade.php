<script>
    $(document).on('click', '.icon-love', function(e) {
        let ele = $(this);
        $.ajax({
            type: 'post',
            url: '{{ route('add.favorite') }}',
            data: {
                '_token': '{{ csrf_token() }}',
                'id': this.getAttribute('data'),
            },
            success: function(data) {
                @if(isset($jsToggle) && $jsToggle)
                    if(ele.hasClass('far')){
                        ele.removeClass('far');
                        ele.addClass('fas');
                    }else{
                        ele.addClass('far');
                        ele.removeClass('fas');
                    }
                @endif
            },
            error: function(reject) {

            },
        });
    });
</script>
