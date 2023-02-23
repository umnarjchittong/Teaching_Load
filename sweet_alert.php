<!-- <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script> -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script type="text/javascript">
    <?php
    if (isset($_GET["alert"]) && isset($_GET["title"]) && isset($_GET["msg"])) {
        // echo 'swal("' . $_GET["title"] . '", "' . $_GET["msg"] . '", "' . $_GET["alert"] . '");';
        echo "swal.fire({
            position: 'center',
            icon: '" . $_GET["alert"] . "',
            title: '" . $_GET["title"] . "',
            text: '" . $_GET["msg"] . "',
            showConfirmButton: false,";
        if ($_GET["alert"] == "success") {
            echo "timer: 1500";
        } else {
        }
        echo "
          })";
    }
    ?>

    function ta_remove_confirmation(cap_cid, cap_id, cas_id) {
        Swal.fire({
            title: 'Are you sure ?',
            text: "คุณต้องการนำรายชื่อผู้สอนร่วมนี้ออก !",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            confirmButtonText: 'ยันยัน !',
            cancelButtonColor: '#666',
            cancelButtonText: 'ยกเลิก',
        }).then((result) => {
            if (result.isConfirmed) {
                Swal.fire(
                    'Remove Confirmed !',
                    'ระบบกำลังจะนำรายชื่อผู้สอนร่วมนี้ออก.',
                    'success'
                ).then(function() {
                    window.location = "../db_mgt.php?p=courseview&cap_cid=" + cap_cid + "&cap_id=" + cap_id + "&act=casdelete&cas_id=" + cas_id;
                });
            }
        })
    }

    function proceeding_delete_confirmation(pid) {
        Swal.fire({
            title: 'Are you sure ?',
            text: "คุณต้องการลบข้อมูล Proceeding นี้ !",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            confirmButtonText: 'ยันยัน !',
            cancelButtonColor: '#666',
            cancelButtonText: 'ยกเลิก',
        }).then((result) => {
            if (result.isConfirmed) {
                Swal.fire(
                    'Delete Confirmed !',
                    'กำลังดำเนินการลบ Proceeding.',
                    'success'
                ).then(function() {
                    window.location = "../db_mgt.php?p=proceeding&act=delete&pid=" + pid
                });
            }
        })
    }

    function proceeding_attachment_delete_confirmation(pid, att_id) {
        Swal.fire({
            title: 'Are you sure ?',
            text: "คุณต้องการลบไฟล์แนบนี้ออก !",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            confirmButtonText: 'ยันยัน !',
            cancelButtonColor: '#666',
            cancelButtonText: 'ยกเลิก',
        }).then((result) => {
            if (result.isConfirmed) {
                Swal.fire(
                    'Delete Confirmed !',
                    'กำลังดำเนินการลบไฟล์แนบนี้.',
                    'success'
                ).then(function() {
                    window.location = "../db_mgt.php?p=proceeding&act=deletefile&pid=" + pid + "&fid=" + att_id;
                });
            }
        })
    }

    function proceeding_coworker_delete_confirmation(pid, cowid) {
        Swal.fire({
            title: 'Are you sure ?',
            text: "คุณต้องการนำรายชื่อผู้ร่วมงานท่านนี้ออก !",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            confirmButtonText: 'ยันยัน !',
            cancelButtonColor: '#666',
            cancelButtonText: 'ยกเลิก',
        }).then((result) => {
            if (result.isConfirmed) {
                Swal.fire(
                    'Delete Confirmed !',
                    'กำลังนำผู้ร่วมงานท่านนี้ออก.',
                    'success'
                ).then(function() {
                    window.location = "../db_mgt.php?p=proceeding&act=coWorkerRemove&pid=" + pid + "&cowid=" + cowid;
                });
            }
        })
    }
</script>

<script>
    // * bootstrap tooltip
    //  data-bs-toggle="tooltip" data-bs-placement="top/bottom/left/right" title="ยกเลิกและกลับ"
    var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
    var tooltipList = tooltipTriggerList.map(function(tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl)
    })
</script>