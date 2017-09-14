<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Development Assignment</title>

    <!-- STYLESHEETS -->
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.6.0/css/font-awesome.min.css">
    <!-- Bootstrap core CSS -->
    <link href="public/assets/bootstrap/bootstrap.min.css" rel="stylesheet">
    <!-- Material Design Bootstrap -->
    <link href="public/assets/mdb/mdb.min.css" rel="stylesheet">
    <!-- Select2 -->
    <link href="public/assets/select2/select2.min.css" rel="stylesheet">
    <!-- Custom styles -->
    <link href="public/css/style.css" rel="stylesheet">
</head>
<body>

    <!-- Start your project here-->
    <div style="height: 100vh">
        <div class="flex-center flex-column">
            <h1 class="animated fadeIn mb-4">Development Assignment</h1>

            <h5 class="animated fadeIn mb-4">Select a server:</h5>
            <div  class="animated fadeIn">
                <label class="hidden" for="server_list"></label>
                <select class="animated fadeIn mb-4" id="server_list"></select>
            </div>

            <!-- Chart -->
            <div class="animated fadeIn text-muted">
                <canvas id="lineChart"></canvas>
            </div>
            <!-- /Chart -->
        </div>
    </div>
    <!-- /Start your project here-->


    <!-- SCRIPTS -->
    <!-- JQuery -->
    <script type="text/javascript" src="public/assets/jquery/jquery-3.2.1.min.js"></script>
    <!-- Bootstrap tooltips -->
    <script type="text/javascript" src="public/assets/mdb/popper.min.js"></script>
    <!-- Bootstrap core JavaScript -->
    <script type="text/javascript" src="public/assets/bootstrap/bootstrap.min.js"></script>
    <!-- MDB core JavaScript -->
    <script type="text/javascript" src="public/assets/mdb/mdb.min.js"></script>
    <!-- Select2 JavaScript -->
    <script type="text/javascript" src="public/assets/select2/select2.min.js"></script>
    <!-- Custom Scripts -->
    <script type="application/javascript">

        function getServerList() {
            var select = $('#server_list');

            $.ajax({
                type: "POST",
                url: './extract.php',
                data: { method: 'server_list' },
                dataType:'JSON',
                success: function (result) {
                    if(parseInt(result.code) === 0) {
                        var str = '<option></option>';
                        $.each(result.data, function (index, value) {
                            str += '<option value="' + value.s_system + '" title="' + value.s_system + '"> Server: ' + value.s_system.split('.')[0] + '</option>';
                        });

                        select.html(str);
                        select.select2({
                            placeholder: 'Select a server...'
                        });
                    } else {
                        alert(result.msg.toString());
                    }
                }
            });
        }
        $(function () {
            getServerList();

            $('#server_list').on('change', function (e) {
                var select = $(this),
                    server = select.val(),
                    chart  = $('#lineChart');

                select.attr('disabled', true);
                chart.html('').fadeOut();

                $.ajax({
                    type: "POST",
                    url: './extract.php',
                    data: { method: 'server_info', name: server },
                    dataType:'JSON',
                    success: function (result) {
                        if(parseInt(result.code) === 0) {
                            var ctxL = document.getElementById("lineChart").getContext('2d');
                            var myLineChart = new Chart(ctxL, {
                                type: 'line',
                                data: {
                                    labels: result.data.label,
                                    datasets: [
                                        {
                                            label: "Server Stat",
                                            fillColor: "rgba(220,220,220,0.2)",
                                            strokeColor: "rgba(220,220,220,1)",
                                            pointColor: "rgba(220,220,220,1)",
                                            pointStrokeColor: "#fff",
                                            pointHighlightFill: "#fff",
                                            pointHighlightStroke: "rgba(220,220,220,1)",
                                            data: result.data.value
                                        }
                                    ]
                                },
                                options: {
                                    responsive: true
                                }
                            });
                            chart.fadeIn();
                            select.attr('disabled', false);
                        } else {
                            alert(result.msg.toString());
                        }
                    }
                });
            });
        });
    </script>
</body>
</html>