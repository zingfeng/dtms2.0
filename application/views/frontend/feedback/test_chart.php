<!DOCTYPE HTML>
<html>
<head>
    <base href="/">

</head>
<body>
<script>
    window.onload = function () {
        render_all_chart();
    };

    function render_chart_type_ruler(id_div ,data){

        var chart = new CanvasJS.Chart(id_div, {
            animationEnabled: true,
            title: {
                text: data['title']
            },
            data: [{
                type: "pie",
                startAngle: 240,
                yValueFormatString: "##0.00\"%\"",
                indexLabel: "{label} {y}",
                dataPoints: [
                    {y: data['1'], label: "Rất tốt"},
                    {y: data['2'], label: "Khá tốt"},
                    {y: data['3'], label: "Bình thường"},
                    {y: data['4'], label: "Khá kém"},
                    {y: data['5'], label: "Rất kém"}
                ]
            }]
        });
        chart.render();
    }

    function render_chart_type_radio(id_div ,data) {
        var chart = new CanvasJS.Chart(id_div, {
            animationEnabled: true,
            title: {
                text: data['title']
            },
            data: [{
                type: "pie",
                startAngle: -90,
                yValueFormatString: "##0.00\"%\"",
                indexLabel: "{label} {y}",
                dataPoints: [
                    {y: data['0'], label: "Không"},
                    {y: data['1'], label: "Có"},

                ]
            }]
        });
        chart.render();
    }

    function render_chart_type_select(id_div ,data) {
        var chart = new CanvasJS.Chart("chartContainer", {
            animationEnabled: true,
            theme: "light2", // "light1", "light2", "dark1", "dark2"
            title: {
                text: data['title']
            },
            axisY: {
                title: "Số lượng"
            },
            data: [{
                type: "column",
                showInLegend: true,
                legendMarkerColor: "grey",
                legendText: "Điểm",
                dataPoints: [
                    {y: data['1'], label: "1"},
                    {y: data['2'], label: "2"},
                    {y: data['3'], label: "3"},
                    {y: data['4'], label: "4"},
                    {y: data['5'], label: "5"},
                    {y: data['6'], label: "6"},
                    {y: data['7'], label: "7"},
                    {y: data['8'], label: "8"},
                    {y: data['9'], label: "9"},
                    {y: data['10'], label: "10"},
                ]
            }]
        });
        chart.render();
    }

    function render_all_chart() {
        $(".feedback_chart").each(function () {
            var id = $(this).attr('id');
            var data = $(this).attr('data');
            var type = $(this).attr('type');
            data = JSON.parse(data);

            switch (type) {
                case 'ruler':
                    render_chart_type_ruler(id,data);
                    break;
                case 'radio':
                    render_chart_type_radio(id,data);
                    break;
                case 'select':
                    render_chart_type_select(id,data);
                    break;
            }
        });
    }

</script>
<div id="chartContainer" style="height: 370px; width: 100%;"></div>



<div id="chartContainer2" style="height: 370px; width: 100%;"></div>
<!--<script src="https://canvasjs.com/assets/script/canvasjs.min.js"></script>-->
<script src="theme/frontend/default/lib/jquerycanvas/canvasjs.min.js"></script>
</body>
</html>