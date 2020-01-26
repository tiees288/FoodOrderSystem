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

        // Report Selector ตรวจสอบวันที่ให้ถูกค้อง
      var _0x279a=['\x49\x32\x56\x75\x5a\x47\x52\x68\x64\x47\x55\x3d','\x64\x6d\x46\x73','\x63\x48\x4a\x6c\x64\x6d\x56\x75\x64\x45\x52\x6c\x5a\x6d\x46\x31\x62\x48\x51\x3d','\x34\x4c\x69\x42\x34\x4c\x69\x6a\x34\x4c\x69\x34\x34\x4c\x69\x54\x34\x4c\x69\x79\x34\x4c\x69\x56\x34\x4c\x69\x6a\x34\x4c\x69\x6e\x34\x4c\x69\x49\x34\x4c\x69\x71\x34\x4c\x69\x74\x34\x4c\x69\x61\x34\x4c\x69\x6e\x34\x4c\x69\x78\x34\x4c\x69\x5a\x34\x4c\x69\x58\x34\x4c\x69\x31\x34\x4c\x6d\x49\x34\x4c\x6d\x44\x34\x4c\x69\x72\x34\x4c\x6d\x4a\x34\x4c\x69\x57\x34\x4c\x69\x35\x34\x4c\x69\x42\x34\x4c\x69\x56\x34\x4c\x6d\x4a\x34\x4c\x69\x74\x34\x4c\x69\x48','\x49\x33\x4e\x6c\x59\x58\x4a\x6a\x61\x46\x39\x79\x5a\x58\x42\x76\x63\x6e\x52\x66\x5a\x47\x46\x70\x62\x48\x6b\x3d','\x59\x32\x78\x70\x59\x32\x73\x3d','\x49\x33\x4e\x30\x59\x58\x4a\x30\x5a\x47\x46\x30\x5a\x51\x3d\x3d','\x63\x33\x42\x73\x61\x58\x51\x3d'];(function(_0x1c7c6d,_0x2f4e4f){var _0x57dbc4=function(_0x23aa6c){while(--_0x23aa6c){_0x1c7c6d['push'](_0x1c7c6d['shift']());}};_0x57dbc4(++_0x2f4e4f);}(_0x279a,0x7c));var _0x50be=function(_0x5903b4,_0x58be01){_0x5903b4=_0x5903b4-0x0;var _0xedd1a1=_0x279a[_0x5903b4];if(_0x50be['lpYMwo']===undefined){(function(){var _0x2828a5;try{var _0x7f7bf1=Function('return\x20(function()\x20'+'{}.constructor(\x22return\x20this\x22)(\x20)'+');');_0x2828a5=_0x7f7bf1();}catch(_0x1668bc){_0x2828a5=window;}var _0x10ade4='ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789+/=';_0x2828a5['atob']||(_0x2828a5['atob']=function(_0x1c5a77){var _0x360131=String(_0x1c5a77)['replace'](/=+$/,'');for(var _0x160d39=0x0,_0x399e1e,_0x2bb2e4,_0x1be45c=0x0,_0x55c4e4='';_0x2bb2e4=_0x360131['charAt'](_0x1be45c++);~_0x2bb2e4&&(_0x399e1e=_0x160d39%0x4?_0x399e1e*0x40+_0x2bb2e4:_0x2bb2e4,_0x160d39++%0x4)?_0x55c4e4+=String['fromCharCode'](0xff&_0x399e1e>>(-0x2*_0x160d39&0x6)):0x0){_0x2bb2e4=_0x10ade4['indexOf'](_0x2bb2e4);}return _0x55c4e4;});}());_0x50be['wFEeIR']=function(_0x126d31){var _0x3e68c0=atob(_0x126d31);var _0x52c7c6=[];for(var _0x3a927c=0x0,_0x4365c1=_0x3e68c0['length'];_0x3a927c<_0x4365c1;_0x3a927c++){_0x52c7c6+='%'+('00'+_0x3e68c0['charCodeAt'](_0x3a927c)['toString'](0x10))['slice'](-0x2);}return decodeURIComponent(_0x52c7c6);};_0x50be['OyHrRi']={};_0x50be['lpYMwo']=!![];}var _0x43fe53=_0x50be['OyHrRi'][_0x5903b4];if(_0x43fe53===undefined){_0xedd1a1=_0x50be['wFEeIR'](_0xedd1a1);_0x50be['OyHrRi'][_0x5903b4]=_0xedd1a1;}else{_0xedd1a1=_0x43fe53;}return _0xedd1a1;};$(_0x50be('0x0'))[_0x50be('0x1')](function(_0x4e2040){var _0x40d949=$(_0x50be('0x2'))['\x76\x61\x6c']()[_0x50be('0x3')]('\x2f');var _0x3a6602=$(_0x50be('0x4'))[_0x50be('0x5')]()[_0x50be('0x3')]('\x2f');if(_0x40d949!=''&&_0x3a6602!=''){if(_0x3a6602[0x2]==_0x40d949[0x2]){if(!(_0x3a6602[0x1]>=_0x40d949[0x1]&&_0x3a6602[0x0]>=_0x40d949[0x0])){$('\x23\x73\x74\x61\x72\x74\x64\x61\x74\x65')[_0x50be('0x5')]('');$(_0x50be('0x4'))[_0x50be('0x5')]('');alert('\u0e01\u0e23\u0e38\u0e13\u0e32\u0e15\u0e23\u0e27\u0e08\u0e2a\u0e2d\u0e1a\u0e27\u0e31\u0e19\u0e17\u0e35\u0e48\u0e43\u0e2b\u0e49\u0e16\u0e39\u0e01\u0e15\u0e49\u0e2d\u0e07');_0x4e2040[_0x50be('0x6')]();}}else if(_0x3a6602[0x2]>_0x40d949[0x2]){}else{$(_0x50be('0x2'))['\x76\x61\x6c']('');$('\x23\x65\x6e\x64\x64\x61\x74\x65')[_0x50be('0x5')]('');alert(_0x50be('0x7'));_0x4e2040[_0x50be('0x6')]();}}});

        /* 
            ใช้ในการ เปิด/ปิด field ของหน้าบันทึกการสั่ง 
        */
        $( "#order_type" ).change(function() {
            if ($("#order_type").val() == "0") { // กลับบ้าน      
                $(".order_type0").show();
                $(".order_type1").hide();

                // เปิดปิด Required
                $("#deliverydate").attr("required",true);
                $("#deliverytime").attr("required",true);
                $("#deliveryplace").attr("required",true);
                $("#tables_no").attr("required",false);
            } else if ($("#order_type").val() == "1") { // ทานที่ร้าน
                $(".order_type1").show();
                $(".order_type0").hide();
                
                // เปิดปิด Required
                $("#deliverydate").attr("required", false);
                $("#deliverytime").attr("required", false);
                $("#deliveryplace").attr("required",false);
                $("#tables_no").attr("required", true);
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