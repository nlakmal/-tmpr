<!DOCTYPE HTML>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Highcharts Example</title>

    <style type="text/css">
        #container {
            min-width: 310px;
            max-width: 800px;
            height: 400px;
            margin: 0 auto
        }
    </style>
</head>
<body>
<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
<script src="assets/highcharts/code/highcharts.js"></script>

<div id="container"></div>

<script type="text/javascript">
    $(function () {
        var processed_json = new Array();
        $.getJSON('http://localhost:8000/api/public/api/weekly', function(data) {
            Highcharts.chart('container', {

                title: {
                    text: 'Retention curve chart that'
                },

                subtitle: {
                    text: 'Tmpr onboarding Flow'
                },
                xAxis: {
                    categories: [
                        'Create account(0%)',
                        'Activate account(20%)',
                        'Provide profile information(40%)',
                        'What jobs are you interested in? (50%)',
                        'Do you have relevant experience in these jobs?(70%)'
                        ,'Are you a freelancer?(90%)',
                        'Waiting for approval (99%)',
                        'Approval(100%)']
                },
                yAxis: {
                    title: {
                        text: 'Percentage of users'
                    }
                },
                legend: {
                    layout: 'vertical',
                    align: 'right',
                    verticalAlign: 'middle'
                },

                series: data,

                responsive: {
                    rules: [{
                        condition: {
                            maxWidth: 500
                        },
                        chartOptions: {
                            legend: {
                                layout: 'horizontal',
                                align: 'center',
                                verticalAlign: 'bottom'
                            }
                        }
                    }]
                }

            });
        });
    });
</script>
</body>
</html>
