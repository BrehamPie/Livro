// Save Users Plan
$(function() {
    var someDate = new Date();
    var numberOfDaysToAdd = 7;
    someDate.setDate(someDate.getDate() + numberOfDaysToAdd);
    var dd = someDate.getUTCDate();
    var mm = someDate.getMonth() + 1;
    var y = someDate.getFullYear();
    var someFormattedDate = someDate.toISOString().slice(0, 10);
    var dtp = $('#datetimepicker1');
    dtp.datetimepicker({
        format: 'YYYY-MM-DD',
        minDate: someFormattedDate
    });
    $('#pay').on('click', function() {
        var tnx = $('#tnxid').val();
        if (tnx == '') {
            alert("Please Fill The Tnx ID");
            return;
        }
        var uid = window.user_id;
        var plan = window.plan;
        var date = $("#datetimepicker1").find("input").val();
        $.ajax({
            url: './ajax/payment.ajax.php',
            type: 'post',
            data: {
                id: uid,
                tnx: tnx,
                plan: plan,
                date: date
            },
            success: function(response) {
                document.getElementById('payment').innerHTML = response;
                window.setTimeout(function() {
                    window.location.href = "./index.php";

                }, 2000);
            },
        });
    })
});