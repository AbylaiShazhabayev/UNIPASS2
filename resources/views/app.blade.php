<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8"/>
    <title>{{ config('app.name')  }}</title>
    <meta name="description" content=""/>
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1"/>

    <link rel="icon" href="{{ asset($assets . '/images/logo/favicon.ico?') . $version }}"/>

    <!-- CSS -->
    <link rel="stylesheet" href="{{ asset($assets . '/css/font-awesome.css?') . $version }}" type="text/css"/>
    <link rel="stylesheet" href="{{ asset($assets . '/css/jquery.fileuploader.css?') . $version }}" type="text/css"/>
    <link rel="stylesheet" href="{{ asset($assets . '/css/animate.css?') . $version }}" type="text/css"/>
    <link rel="stylesheet" href="{{ asset($assets . '/css/selectize.css?') . $version }}" type="text/css"/>
    <link rel="stylesheet" href="{{ asset($assets . '/css/base.css?') . $version }}" type="text/css"/>
    <link rel="stylesheet" href="{{ asset($assets . '/css/main.css?') . $version }}" type="text/css"/>

    <!-- JS -->
    <script type="text/javascript" src="{{ asset($assets . '/js/jquery.js?') . $version }}"></script>
    <script type="text/javascript" src="{{ asset($assets . '/js/popper.js?') . $version }}"></script>
    <script type="text/javascript" src="{{ asset($assets . '/js/bootstrap.js?') . $version }}"></script>
    <script type="text/javascript" src="{{ asset($assets . '/js/jquery-ui.js?') . $version }}"></script>
    <script type="text/javascript" src="{{ asset($assets . '/js/jquery.pjax.js?') . $version }}"></script>
    <script type="text/javascript" src="{{ asset($assets . '/js/jquery.validate.js?') . $version }}"></script>
    <script type="text/javascript" src="{{ asset($assets . '/js/jquery.maskMoney.js?') . $version }}"></script>
    <script type="text/javascript" src="{{ asset($assets . '/js/jquery.mask.js?') . $version }}"></script>
    <script type="text/javascript" src="{{ asset($assets . '/js/form.js?') . $version }}"></script>
    <script type="text/javascript" src="{{ asset($assets . '/js/selectize.js?') . $version }}"></script>
    <script type="text/javascript" src="{{ asset($assets . '/js/request.js?') . $version }}"></script>
    <script type="text/javascript" src="{{ asset($assets . '/js/bootstrap-notify.js?') . $version }}"></script>
    <script type="text/javascript" src="{{ asset($assets . '/js/jquery.dataTables.js?') . $version }}"></script>
    <script type="text/javascript" src="{{ asset($assets . '/js/dataTables.bootstrap4.js?') . $version }}"></script>
    <script type="text/javascript" src="{{ asset($assets . '/js/dataTables.buttons.js?') . $version }}"></script>
    <script type="text/javascript" src="{{ asset($assets . '/js/dataTables.select.js?') . $version }}"></script>
    <script type="text/javascript" src="{{ asset($assets . '/js/buttons.print.js?') . $version }}"></script>
    <script type="text/javascript" src="{{ asset($assets . '/js/moment.js?') . $version }}"></script>
    <script type="text/javascript" src="{{ asset($assets . '/js/jquery.blockUI.js?') . $version }}"></script>
    <script type="text/javascript" src="{{ asset($assets . '/js/jstree.js?') . $version }}"></script>
    <script type="text/javascript" src="{{ asset($assets . '/js/jquery.treetable.js?') . $version }}"></script>
    <script type="text/javascript" src="{{ asset($assets . '/js/jquery.fileuploader.js?') . $version }}"></script>
    <script type="text/javascript" src="{{ asset($assets . '/js/printThis.js?') . $version }}"></script>
    <script type="text/javascript" src="{{ asset($assets . '/js/buttons.html5.js?') . $version }}"></script>
    <script type="text/javascript" src="{{ asset($assets . '/js/jquery.p-generator.js?') . $version }}"></script>
    <script type="text/javascript" src="{{ asset($assets . '/js/pwstrength-bootstrap.js?') . $version }}"></script>
    <script type="text/javascript" src="{{ asset($assets . '/js/main.js?') . $version }}"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" integrity="sha512-iecdLmaskl7CVkqkXNQ/ZH/XLlvWZOJyj7Yy7tcenmpD1ypASozpmT/E0iPtmFIB46ZmdtAc9eNBvH0H/ZpiBw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <script type="text/javascript">
        $.ajaxSetup({
            cache: ("{{ (config('app.env') === 'local' ? 'false' : 'true') }}" === "true")
        });
    </script>
</head>
<body class="antialiased">
<div class="page">

    @include('app_navbar')
    <div class="content">
        <div class="container-xl d-flex flex-column" id="content">

            @yield('content')
        </div>
    </div>
</div>

@include('app_my_user')

@if(Auth::user() && Auth::user()->admin)
    @include('app_my_plan')
@endif

<script type="text/javascript">
    var urlLogin = "{{ url('/login') }}";

    $(function () {

        $(document).ajaxError(function (event, jqxhr) {
            if (jqxhr.status === 401) {
                location.href = urlLogin;
            }
        });

        $('#ulMenu .nav-link').click(function () {
            $('.nav-item').removeClass('active');
            $(this).parent().addClass('active');
        });

        initPlugins();

        $(document).find('.navbar-nav').pjax('a:not(.ignore-pjax)', '#content');

        if ($.support.pjax) {
            $.pjax.defaults.timeout = 2000; // time in milliseconds
            $.pjax.maxCacheLength = 0;

            $(document).on('pjax:beforeSend', function (pjax) {
                if (pjax.currentTarget.URL === pjax.relatedTarget.href) {
                    return false;
                }
                $('.page-main').block();
            });

            $(document).on('pjax:end', function () {
                initPlugins();
                $('.page-main').unblock();

                return true;
            });
        }

        $('.dropdown')
            .on('mouseover', function () {
                if (!$(this).hasClass('show')) {
                    $(this).find('a:first').click().blur();
                }
            })
            .on('mouseleave', function () {
                if ($(this).hasClass('show')) {
                    $(this).find('a:first').click();
                }
            });
    });

    let countModals = 0;
    $(document)
        .on('show.bs.modal', '.modal', function () {
            countModals++;

            var zIndex = 1040 + (10 * countModals);

            $(this).css('z-index', zIndex);
            setTimeout(function () {
                $('.modal-backdrop').not('.modal-stack').css('z-index', zIndex - 1).addClass('modal-stack');
            }, 0);
        })
        .on('hide.bs.modal', '.modal', function () {
            countModals--;
        });

    function initPlugins() {
        let hexToRgba = function (hex, opacity) {
            let result = /^#?([a-f\d]{2})([a-f\d]{2})([a-f\d]{2})$/i.exec(hex);
            let rgb = result ? {
                r: parseInt(result[1], 16),
                g: parseInt(result[2], 16),
                b: parseInt(result[3], 16)
            } : null;

            return 'rgba(' + rgb.r + ', ' + rgb.g + ', ' + rgb.b + ', ' + opacity + ')';
        };

        /** Constant div card */
        const DIV_CARD = 'div.card';

        /** Initialize tooltips */
        $('[data-toggle="tooltip"]').tooltip();

        // Initialize popovers
        $('[data-toggle="popover"]').popover({
            html: true
        });

        // Function for remove card
        $('[data-toggle="card-remove"]').on('click', function (e) {
            let $card = $(this).closest(DIV_CARD);

            $card.remove();

            e.preventDefault();
            return false;
        });

        // Function for collapse card
        $('[data-toggle="card-collapse"]').on('click', function (e) {
            let $card = $(this).closest(DIV_CARD);

            $card.toggleClass('card-collapsed');

            e.preventDefault();
            return false;
        });

        // Function for fullscreen card
        $('[data-toggle="card-fullscreen"]').on('click', function (e) {
            let $card = $(this).closest(DIV_CARD);

            $card.toggleClass('card-fullscreen').removeClass('card-collapsed');

            e.preventDefault();
            return false;
        });

        if ($('[data-sparkline]').length) {
            let generateSparkline = function ($elem, data, params) {
                $elem.sparkline(data, {
                    type: $elem.attr('data-sparkline-type'),
                    height: '100%',
                    barColor: params.color,
                    lineColor: params.color,
                    fillColor: 'transparent',
                    spotColor: params.color,
                    spotRadius: 0,
                    lineWidth: 2,
                    highlightColor: hexToRgba(params.color, .6),
                    highlightLineColor: '#666',
                    defaultPixelsPerValue: 5
                });
            };

            require(['sparkline'], function () {
                $('[data-sparkline]').each(function () {
                    let $chart = $(this);

                    generateSparkline($chart, JSON.parse($chart.attr('data-sparkline')), {
                        color: $chart.attr('data-sparkline-color')
                    });
                });
            });
        }

        if ($('.chart-circle').length) {
            require(['circle-progress'], function () {
                $('.chart-circle').each(function () {
                    let $this = $(this);

                    $this.circleProgress({
                        fill: {
                            color: tabler.colors[$this.attr('data-color')] || tabler.colors.blue
                        },
                        size: $this.height(),
                        startAngle: -Math.PI / 4 * 2,
                        emptyFill: '#F4F4F4',
                        lineCap: 'round'
                    });
                });
            });
        }
    }
</script>

</body>
</html>
