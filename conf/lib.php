<link href="https://fonts.googleapis.com/css?family=Open+Sans:400,600" rel="stylesheet">
<link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
<link rel="stylesheet" href="lib/css/bootstrap.min.css">
<!-- <script src="lib/js/jquery.min.js"></script> -->
<script src="lib/date/jquery-3.4.1.min.js"></script>
<script src="lib/js/bootstrap.min.js"></script>

<script type="text/javascript" src="lib/date/js/bootstrap-datepicker.js"></script>
<!-- thai extension -->
<script type="text/javascript" src="lib/date/js/bootstrap-datepicker-thai.js"></script>
<script type="text/javascript" src="lib/date/js/locales/bootstrap-datepicker.th.js"></script>
<link href="lib/date/css/datepicker.css" rel="stylesheet" />


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

    var endYear = new Date(new Date().getFullYear() - 12, 11, 32);
    var startYear = new Date(new Date().getFullYear() - 61, 11, 1);

    $(document).ready(function() {
        $('.datepicker').datepicker({
            language: 'th-th', //เปลี่ยน label ต่างของ ปฏิทิน ให้เป็น ภาษาไทย   (ต้องใช้ไฟล์ bootstrap-datepicker.th.min.js นี้ด้วย)
            format: 'dd/mm/yyyy',
            // disableTouchKeyboard: true,
            todayBtn: false,
            clearBtn: true,
            closeBtn: false,
            startView: 0,
            endDate: endYear, // สมัครได้ เมื่ออายุมากกว่า 10ปี
            startDate: startYear,
            autoclose: true, //Set เป็นปี พ.ศ.
            inline: true
        }) //กำหนดเป็นวันปัจุบัน
    });

    $(document).ready(function() {
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
        }); //กำหนดเป็นวันปัจุบัน       
    });
</script>

<script type="text/javascript">
    function check_place() {
        var place = new RegExp('10120');
        var delivery_input = document.getElementById("postnum").value

        if (place.test(delivery_input)) {
            return true;
        } else {
            alert('กรุณาระบุรหัสไปรษณีย์ให้ถูกต้อง');
          //  e.preventDefault();
            return false;
        }
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
    // Number
    var _0x40fa = ['keyCode', 'which'];
    (function(_0x51077a, _0x33e7f0) {
        var _0x166b57 = function(_0x2de604) {
            while (--_0x2de604) {
                _0x51077a['push'](_0x51077a['shift']());
            }
        };
        _0x166b57(++_0x33e7f0);
    }(_0x40fa, 0x1cb));
    var _0x1003 = function(_0x2c445b, _0x76e190) {
        _0x2c445b = _0x2c445b - 0x0;
        var _0x238e28 = _0x40fa[_0x2c445b];
        return _0x238e28;
    };

    function isNumberKey(_0x4e6df2) {
        var _0x13b267 = _0x4e6df2['which'] ? _0x4e6df2[_0x1003('0x0')] : _0x4e6df2[_0x1003('0x1')];
        if (_0x13b267 != 0x2e && _0x13b267 > 0x1f && (_0x13b267 < 0x30 || _0x13b267 > 0x39)) return ![];
        return !![];
    }

    function isNumericKey(_0x1a792f) {
        var _0x5bb84e = _0x1a792f[_0x1003('0x0')] ? _0x1a792f[_0x1003('0x0')] : _0x1a792f[_0x1003('0x1')];
        if (_0x5bb84e != 0x2e && _0x5bb84e > 0x1f && (_0x5bb84e < 0x30 || _0x5bb84e > 0x39)) return !![];
        return ![];
    }
</script>