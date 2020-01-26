<link href="https://fonts.googleapis.com/css?family=Open+Sans:400,600" rel="stylesheet">
<link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
<link rel="stylesheet" href="lib/css/bootstrap.min.css">
<!--<script src="lib/js/jquery.min.js"></script>-->
<script src="lib/date/jquery-3.4.1.min.js"></script>
<script src="lib/js/bootstrap.min.js"></script>


<script type="text/javascript" src="lib/date/js/bootstrap-datepicker.js"></script>
<!-- thai extension -->
<script type="text/javascript" src="lib/date/js/bootstrap-datepicker-thai.js"></script>
<script type="text/javascript" src="lib/date/js/locales/bootstrap-datepicker.th.js"></script>
<link href="lib/date/css/datepicker.css" rel="stylesheet" />
<link rel="shortcut icon" href="favicon.ico" />

<script>
    // --------------------- Protect Coppy --------------------------
    document.onkeydown = function(e) {
        if (e.ctrlKey && (e.keyCode === 85 || e.keyCode === 117) || e.keyCode === 123) { // Key 123 = F12, Key 85 = U
            return false;
        }
    };
    $(this).bind("contextmenu", function(e) {
        e.preventDefault();
    });
    // --------------------------------------------------------------

    var endYear1 = new Date(new Date().getFullYear() - 18, 11, 32);
    var endYear_cus = new Date(new Date().getFullYear() - 12, 11, 32);
    var startYear = new Date(new Date().getFullYear() - 61, 11, 1);

    $(document).ready(function() {
        $('.datepicker1').datepicker({
            format: 'dd/mm/yyyy',
            todayBtn: false,
            clearBtn: true,
            closeBtn: false,
            endDate: endYear1,
            startDate: startYear,
            autoclose: true,
            language: 'th-th' //เปลี่ยน label ต่างของ ปฏิทิน ให้เป็น ภาษาไทย   (ต้องใช้ไฟล์ bootstrap-datepicker.th.min.js นี้ด้วย)
        }) //.datepicker();  //กำหนดเป็นวันปัจุบัน

        $('.datepicker-checkout').datepicker({
            language: 'th-th', //เปลี่ยน label ต่างของ ปฏิทิน ให้เป็น ภาษาไทย   (ต้องใช้ไฟล์ bootstrap-datepicker.th.min.js นี้ด้วย)
            format: 'dd/mm/yyyy',
            disableTouchKeyboard: true,
            todayBtn: false,
            clearBtn: true,
            closeBtn: false,
            daysOfWeekDisabled: [0],
            endDate: '+5d',
            startDate: 'now',
            autoclose: true, //Set เป็นปี พ.ศ.
            inline: true
        }) //กำหนดเป็นวันปัจุบัน       


        $('.datepicker-deliver').datepicker({
            language: 'th-th', //เปลี่ยน label ต่างของ ปฏิทิน ให้เป็น ภาษาไทย   (ต้องใช้ไฟล์ bootstrap-datepicker.th.min.js นี้ด้วย)
            format: 'dd/mm/yyyy',
            disableTouchKeyboard: true,
            todayBtn: false,
            clearBtn: true,
            closeBtn: false,
            daysOfWeekDisabled: [0],
            endDate: '+30d',
            startDate: 'now',
            autoclose: true, //Set เป็นปี พ.ศ.
            inline: true
        }) //กำหนดเป็นวันปัจุบัน       

        var start_report = new Date(2019, 4, 1);
        var end_report = new Date(start_report.getFullYear() + 10, 11, 32);
        // Report Selector
        $('.datepicker-start').datepicker({
            language: 'th-th', //เปลี่ยน label ต่างของ ปฏิทิน ให้เป็น ภาษาไทย   (ต้องใช้ไฟล์ bootstrap-datepicker.th.min.js นี้ด้วย)
            format: 'dd/mm/yyyy',
            disableTouchKeyboard: true,
            todayBtn: false,
            clearBtn: true,
            closeBtn: false,
            //daysOfWeekDisabled: [0],
            endDate: end_report,
            startDate: start_report,
            autoclose: true, //Set เป็นปี พ.ศ.
            inline: true
        }) //กำหนดเป็นวันปัจุบัน       
        $('.datepicker-end').datepicker({
            language: 'th-th', //เปลี่ยน label ต่างของ ปฏิทิน ให้เป็น ภาษาไทย   (ต้องใช้ไฟล์ bootstrap-datepicker.th.min.js นี้ด้วย)
            format: 'dd/mm/yyyy',
            disableTouchKeyboard: true,
            todayBtn: false,
            clearBtn: true,
            closeBtn: false,
            //daysOfWeekDisabled: [0],
            endDate: end_report,
            startDate: start_report,
            autoclose: true, //Set เป็นปี พ.ศ.
            inline: true
        }) //กำหนดเป็นวันปัจุบัน       

        $('.datepicker-cus').datepicker({
            format: 'dd/mm/yyyy',
            todayBtn: false,
            clearBtn: true,
            closeBtn: false,
            endDate: endYear_cus,
            startDate: startYear,
            autoclose: true,
            language: 'th-th' //เปลี่ยน label ต่างของ ปฏิทิน ให้เป็น ภาษาไทย   (ต้องใช้ไฟล์ bootstrap-datepicker.th.min.js นี้ด้วย)
        }) //.datepicker();  //กำหนดเป็นวันปัจุบัน


        $("#search_report_daily").click(function(e) {
            var start = $("#startdate").val().split("/");
            var end = $("#enddate").val().split("/");
            if (start != "" && end != "") {
                if ((end[2] == start[2])) { // ตรวจปี
                    if (!((end[1] >= start[1]) && (end[0] >= start[0]))) {
                        // Invalid date
                        $("#startdate").val("");
                        $("#enddate").val("");
                        alert("กรุณาตรวจสอบวันที่ให้ถูกต้อง");
                        e.preventDefault();
                    }
                } else if (end[2] > start[2]) {} else {
                    // Invalid date
                    $("#startdate").val("");
                    $("#enddate").val("");
                    alert("กรุณาตรวจสอบวันที่ให้ถูกต้อง");
                    e.preventDefault();
                }
            }
        });

    });

    function chq_order_get_reserv(a) { // Function ดึงค่า วัน/เวลาจอง
        //  alert(a);
        $.get("get_reserve_data1.php", {
            'orderid': a
        }, function(data) {
            $("#reserv_date_appointment").val(data.reserv_date_appointment);
            $("#reserv_time_appointment").val(data.reserv_time_appointment);
        }, "json");
    }

    function isNumberKey(evt) {
        var charCode = (evt.which) ? evt.which : evt.keyCode;
        if (charCode != 46 && charCode > 31 &&
            (charCode < 48 || charCode > 57))
            return false;
        return true;
    }


    function isNumericKey(evt) {
        var charCode = (evt.which) ? evt.which : evt.keyCode;
        if (charCode != 46 && charCode > 31 &&
            (charCode < 48 || charCode > 57))
            return true;
        return false;
    }

    function validate_delverytime() {
        delivery = document.getElementsByName("deliverydate")[0].value; // Input ที่เป็นวันที่
        d = delivery.slice(0, 2);

        m = delivery.slice(3, 5);
        y = delivery.slice(6, 10) - 543;
        var today = new Date();

        if (today.getMinutes() < 10) {
            today_minutes = "0" + today.getMinutes();
        } else {
            today_minutes = today.getMinutes();
        }

        timenow = (today.getHours()) + ":" + (today_minutes); // เซ็ทค่าสำหรับ H:m +1 ชั่วโมง จากเวลาตอนนี้
        if ((today.getDate()) < 10) {
            date_today = "0" + (today.getDate());
        } else {
            date_today = (today.getDate());
        }
        t_update = document.getElementsByName("deliverytime")[0]; // Input ที่เป็นเวลา

        if (d == (date_today) && m == (today.getMonth() + 1) && y == today.getFullYear()) { // กรณีวันนี้

            // เพิ่ม
            if (today.getHours() < 10) {
                new_time = "0" + today.getHours() + ":" + today.getMinutes();
            } else {
                new_time = timenow;
            } //
            // alert(new_time);
            t_update.value = '';
            t_update.setAttribute("min", new_time);
            //  t_update.setAttribute("max", "18:00");
            t_update.setAttribute("oninvalid", "this.setCustomValidity('โปรดกรอกในระยะเวลาทำการ และต้องไม่เป็นเวลาที่ผ่านมาแล้ว')");
        } else {
            //	alert("คนละวัน");
            t_update.value = '';
            t_update.setAttribute("min", "09:00");
            t_update.setAttribute("max", "19:00");
            t_update.setAttribute("oninvalid", "this.setCustomValidity('กรุณากรอกเวลาระหว่าง 09:00-19.00')");
        }
    }

    function validate_reservetime() {
        delivery = document.getElementsByName("reserv_date_appointment")[0].value; // Input ที่เป็นวันที่
        d = delivery.slice(0, 2);
        m = delivery.slice(3, 5);
        y = delivery.slice(6, 10) - 543;
        var today = new Date();

        if ((today.getDate()) < 10) {
            date_today = "0" + (today.getDate());
        } else {
            date_today = (today.getDate());
        }

        if (today.getMinutes() < 10) {
            today_minutes = "0" + today.getMinutes();
        } else {
            today_minutes = today.getMinutes();
        }

        timenow = (today.getHours()) + ":" + (today_minutes); // เซ็ทค่าสำหรับ H:m
        t_update = document.getElementsByName("reserv_time_appointment")[0]; // Input ที่เป็นเวลา

        if (d == (date_today) && m == (today.getMonth() + 1) && y == today.getFullYear()) {
            // เพิ่ม
            if (today.getHours() < 10) {
                new_time = "0" + today.getHours() + ":" + today.getMinutes();
            } else {
                new_time = timenow;
            } //
            t_update.setAttribute("min", new_time); // เซ็ทค่าสำหรับ เวลาขั้นต่ำ
            t_update.setAttribute("oninvalid", "this.setCustomValidity('โปรดกรอกในระยะเวลาทำการ และต้องไม่เป็นเวลาที่ผ่านมาแล้ว')");
            t_update.value = '';
        } else {
            //	alert("คนละวัน");
            t_update.setAttribute("min", "09:00");
            t_update.setAttribute("oninvalid", "this.setCustomValidity('กรุณากรอกเวลาระหว่าง 08:00 - 18.00')");
            t_update.value = '';
        }
    }
</script>