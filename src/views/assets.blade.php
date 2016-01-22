@foreach ($javascripts as $javascript)

    <script type="text/javascript" src="{!!  asset($javascript) !!}"></script>

@endforeach

<script type="text/javascript">

    $(function() {

        $(window).notifier({!! $options !!});

    });

</script>