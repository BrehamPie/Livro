<!-- List of Books Donatad By Others.Verify Donation From Here. -->
<?php
include './includes/sidebar.inc.php';
?>
<div class="container" style="display: flex;justify-content:center;flex-direction:column;align-items:center">
    <h3>Recent Donations From User</h3>
    <table class=" table table-bordered table-hover" id='table'>
        <thead class="bg-info">
            <tr>
                <th>#</th>
                <th>User Id</th>
                <th>Book Name</th>
                <th>Author Name</th>
                <th>Image</th>
                <th>Donation Date</th>
                <th>Status</th>
                <th>Accept</th>
                <th>Reject</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $query = "SELECT * from donation ORDER BY donation_date DESC";
            $result = myquery($query);
            $rowno = 1;
            while ($row = mysqli_fetch_row($result)) {
                $status = $row[6];
                $disabled = '';
                if ($status != 0) $disabled = 'disabled';
                if ($status == '0') $status = 'Pending';
                if ($status == '1') $status = 'Approved';
                if ($status == '-1') $status = 'Rejected';
                $imglink = '../assets/img/donations/' . $row[4];
                echo "<tr class='adminTableTr'><td>" . $row[0] .
                    "</td><td>" . $row[1] .
                    "</td><td>" . $row[2] .
                    "</td><td>" . $row[3] .
                    "</td><td><a href='$imglink' id='imga'><img src='$imglink'>" .
                    "</td><td>" . $row[5] .
                    "</td><td>" . $status .
                    "</td><td><button name='edit' " . $disabled . " onclick=" . '"location.href=' . "'./donation.php?d_id=" . $row[0] . "'" . '"' . " class='btn btn-success'>Accept</button> 
                    </td><td><button name='edit' " . $disabled . " onclick='reject(" . $row[0] . ',' . $rowno . ")' class='btn btn-danger'>Reject</button> 
                    </td></tr>";
                $rowno++;
            }
            ?>
        </tbody>
    </table>
    <?php
    ?>
</div>


</body>
<script>
    $(document).ready(function() {
        $('.adminTableTr').magnificPopup({
            type: 'image',
            delegate: 'a#imga',
            mainClass: 'mfp-with-zoom', // this class is for CSS animation below
            zoom: {
                enabled: true, // By default it's false, so don't forget to enable it

                duration: 300, // duration of the effect, in milliseconds
                easing: 'ease-in-out', // CSS transition easing function
            }
        });


    });

    function reject(id, rowIndex) {
        $.ajax({
            url: "donationreject.ajax.php",
            type: "POST",
            data: {
                d_id: id,
            },
            cache: false,
            success: function(result) {
                document.getElementById('table').rows[rowIndex].cells[6].innerHTML = 'rejected';
                document.getElementById('table').rows[rowIndex].cells[7].childNodes[0].disabled = true;
                document.getElementById('table').rows[rowIndex].cells[8].childNodes[0].disabled = true;
            }
        });
    }
</script>