<!-- latest jquery-->
    <script src="{{ asset('assets/js/jquery-3.5.1.min.js') }}"></script>
    <script src="{{ asset('assets/js/bootstrap/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('assets/js/icons/feather-icon/feather.min.js') }}"></script>
    <script src="{{ asset('assets/js/icons/feather-icon/feather-icon.js') }}"></script>
    <script src="{{ asset('assets/js/scrollbar/simplebar.js') }}"></script>
    <script src="{{ asset('assets/js/scrollbar/custom.js') }}"></script>
    <script src="{{ asset('assets/js/config.js') }}"></script>
    <script src="{{ asset('assets/js/sidebar-menu.js') }}"></script>
    <script src="{{ asset('assets/js/chart/chartist/chartist.js') }}"></script>
    <script src="{{ asset('assets/js/chart/chartist/chartist-plugin-tooltip.js') }}"></script>
    <script src="{{ asset('assets/js/chart/knob/knob.min.js') }}"></script>
    <script src="{{ asset('assets/js/chart/knob/knob-chart.js') }}"></script>
    <script src="{{ asset('assets/js/chart/apex-chart/apex-chart.js') }}"></script>
    <script src="{{ asset('assets/js/chart/apex-chart/stock-prices.js') }}"></script>
    <script src="{{ asset('assets/js/notify/bootstrap-notify.min.js') }}"></script>
    <script src="{{ asset('assets/js/dashboard/default.js') }}"></script>
    <script src="{{ asset('assets/js/datepicker/date-picker/datepicker.js') }}"></script>
    <script src="{{ asset('assets/js/datepicker/date-picker/datepicker.en.js') }}"></script>
    <script src="{{ asset('assets/js/typeahead/handlebars.js') }}"></script>
    <script src="{{ asset('assets/js/typeahead/typeahead.bundle.js') }}"></script>
    <script src="{{ asset('assets/js/typeahead/typeahead.custom.js') }}"></script>
    <script src="{{ asset('assets/js/typeahead-search/handlebars.js') }}"></script>
    <script src="{{ asset('assets/js/typeahead-search/typeahead-custom.js') }}"></script>
    <script src="{{ asset('assets/js/chart/google/google-chart-loader.js') }}"></script>
    <script src="{{ asset('assets/js/script.js') }}"></script>
    <script src="{{ asset('assets/js/datatable/datatables/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('assets/js/datatable/datatables/datatable.custom.js') }}"></script>
    <script src="{{ asset('assets/own_js/kendo.js') }}"></script>
    <script>
      $(window).on('load', function() {
          $('.loader-wrapper').fadeOut('slow', function() {
              $(this).remove();
          });
      });
    </script>
<!-- <script src="https://kendo.cdn.telerik.com/2022.2.621/js/kendo.all.min.js"></script> -->

<script src="https://code.highcharts.com/stock/highstock.js"></script>
<script src="https://code.highcharts.com/stock/modules/exporting.js"></script>
<script src="https://code.highcharts.com/stock/modules/export-data.js"></script>
<script src="https://code.highcharts.com/stock/modules/accessibility.js"></script>

<script>
function check_date(e) {
    var dt = isValidDate(e.target.value);
    var name = e.target.id;
    if (!dt) {
        //alert('invalida date formate'+e.target.value);
        $('#error_' + name).html('Invalida date formate');
        if (e.target.name == 'dob') {
            $('#lead_age').val(0);
        }
    } else {
        $('#error_' + name).html('');

        var dob = e.target.value;

        var bits = dob.split('-');

        var valid = bits[0] + '/' + bits[1] + '/' + bits[2];

        var years = new Date(new Date() - new Date(valid)).getFullYear() - 1970;

        if (e.target.name == 'dob') {
            $('#lead_age').val(years);
        }
    }
}



function isValidDate(s) {

    var bits = s.split('-');

    var valid = bits[2] + '/' + bits[1] + '/' + bits[0];

    var m = valid.match(/^(\d{1,2})\/(\d{1,2})\/(\d{4})$/);
    //return (m) ? new Date(m[3], m[2]-1, m[1]) : null;
    return m;

}
</script>
<script>
var dtToday = new Date();

var month = dtToday.getMonth() + 1;
var day = dtToday.getDate();
var year = dtToday.getFullYear();
if (month < 10)
    month = '0' + month.toString();
if (day < 10)
    day = '0' + day.toString();

var maxDate = year + '-' + month + '-' + day;

$('.futuredate_disable').attr('max', maxDate);
</script>
<!-- own js end -->

<!--//export xlsx library-->
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.13.1/xlsx.full.min.js"></script>