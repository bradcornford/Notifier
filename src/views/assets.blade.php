<link href="{{ asset('packages/cornford/notifier/assets/css/bootstrap.min.css') }}" rel="stylesheet">

<script type="text/javascript" src="{{ asset('packages/cornford/notifier/assets/js/jquery.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('packages/cornford/notifier/assets/js/bootstrap.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('packages/cornford/notifier/assets/js/notify.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('packages/cornford/notifier/assets/js/notifier.min.js') }}"></script>
<script type="text/javascript">

    $(function() {

        $(window).notifier({{ $options }});

    });

</script>