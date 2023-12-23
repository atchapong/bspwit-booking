<?php
require_once('api/booking.php');
require_once('api/item.php');
$booking = new Booking();
$item = new Item();
?>
<!DOCTYPE html>
<html lang='en'>

<head>
    <meta charset='utf-8' />
    <!-- <script defer src='https://static.cloudflareinsights.com/beacon.min.js' data-cf-beacon='{"token": "dc4641f860664c6e824b093274f50291"}'></script> -->
    <script src='https://cdn.jsdelivr.net/npm/fullcalendar@6.1.10/index.global.min.js'></script>

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.4.1/dist/css/bootstrap.min.css"
        integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">


    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js"
        integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n"
        crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"
        integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo"
        crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.4.1/dist/js/bootstrap.min.js"
        integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6"
        crossorigin="anonymous"></script>


    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>


    <script>
        var booking_data = getAllBooking();
        console.log(booking_data)
        console.log(getAllItem())
        document.addEventListener('DOMContentLoaded', () => {
            var calendarEl = document.getElementById('calendar');
            var calendar = new FullCalendar.Calendar(calendarEl, {
                headerToolbar: {
                    left: 'prev,next',
                    // right: 'dayGridMonth,list myCustomButton today',
                    right: 'myCustomButton today',
                    center: 'title',
                },
                buttonText: {
                    // prev: 'ก่อนหน้า',
                    // next: 'ถัดไป',
                    prevYear: 'ปีก่อนหน้า',
                    nextYear: 'ปีถัดไป',
                    year: 'ปี',
                    today: 'วันนี้',
                    month: 'เดือน',
                    week: 'สัปดาห์',
                    day: 'วัน',
                    list: 'กำหนดการ',
                },
                weekText: 'สัปดาห์',
                allDayText: 'ตลอดวัน',
                moreLinkText: 'เพิ่มเติม',
                noEventsText: 'ไม่มีการจองวันนี้',
                locale: 'th',
                events: getAllBooking().map((data) => {
                    return {
                        id: data.id,
                        title: data.name + " จองโดย: " + data.fullname,
                        start: data.date_start,
                        end: data.date_end,
                        // allDay: true,
                    }
                }),
                eventTimeFormat: { // like '14:30:00'
                    hour: '2-digit',
                    minute: '2-digit',
                    second: '2-digit',
                    hour12: false
                },


                // initialView: 'dayGridMonth',
                // dateClick: function () {
                //     alert('a day has been clicked!');
                // },
                selectable: true,
                select: () => {
                    // alert('select!')
                    $('#staticBackdrop').modal('toggle');
                    // $('#create-booking').prop('disabled', false);
                    // $('#cancel-booking').prop('disabled', false);
                },
                customButtons: {
                    myCustomButton: {
                        text: 'custom!',
                        click: function () {
                            alert('clicked the custom button!');
                        }
                    }
                },
            });
            // calendar.getOption('locale');
            // calendar.setOption('locale', 'th');
            calendar.render();

        });

        function getAllBooking() {
            return $.parseJSON('<?= json_encode($booking->getAllBooking()) ?>');
        }

        function getAllItem() {
            return $.parseJSON('<?= json_encode($item->getAllItem()) ?>');
        }
        // jqery event ===============================================

        $(document).ready(() => {
            const item = getAllItem()
            const booking = getAllBooking()
            

            //show data table all car
            if (item.length < 1) {
                setCellsNotData('all-item', '#tr-all-item', 'ไม่มีรถ')
            } else {
                item.forEach(element => {
                $('#select-create').append('<option value="' + element.id + '">' + element.name + '</option>')
                setRows('all-item', [element.name, element.type_name])
            });
            }

            //show data table reserv all
            if (booking.length < 1) {
                setCellsNotData('reserv-last', '#tr-reserv-last', 'ไม่มีการจองล่าสุด')
            } else {
                booking.forEach(element => {
                    // console.log('element',element)
                setRows('reserv-last', [element.name, element.fullname, `${element.date_start} ถึง ${element.date_end}` ])
            });
            }

            // show data table reserv today
            const ds = new Date()
            const de = new Date()
            ds.setHours(0,0,0,0)
            de.setHours(23,59,59,59)
            console.log( new Date(booking[0].date_start) >= ds)
            console.log(ds)

            console.log(de)
            const reserv_today = booking.filter(data => new Date(data.date_start) >= ds && new Date(data.date_start) <= de)
            if (reserv_today.length < 1) {
                setCellsNotData('reserv-today', '#tr-reserv-today', 'ไม่มีการจองในวันนี้')
            } else {
                reserv_today.forEach(element => {
                console.log('element',element)
                setRows('reserv-today', [element.name, element.fullname, `${element.date_start} ถึง ${element.date_end}` ])
            });
            }
            
            $('#form-create-booking').submit((e) => {
                //prevent Default functionality
                // console.log(e.target)
                e.preventDefault();


                var formData = {
                    fullname: $("#fullnanme").val(),
                    item_id: $("#select-create").val(),
                    date_start: new Date($("#date-start").val()),
                    date_end: new Date($("#date-end").val()),
                };


                const booking_all = getAllBooking();

                console.log(new Date(booking_all[0].date_start) < formData.date_start)
                console.log(new Date(booking_all[0].date_start));
                console.log(formData.date_start);
                const filter_date_start = booking_all.filter(data => new Date(data.date_start) <= formData.date_start && new Date(data.date_end) >= formData.date_start)
                console.log('filter_date_start',filter_date_start);
                const filter_date_end = booking_all.filter(data => new Date(data.date_start) <= formData.date_end && new Date(data.date_end) >= formData.date_end)
                console.log('filter_date_end',filter_date_end);
                
                if (filter_date_start.length > 0 || filter_date_end.length > 0) {
                    alert('จองไปแล้ว')
                    return
                }
                return




                setModalLoading(true);
                // $('#create-booking').prop('disabled', true);
                // $('#cancel-booking').prop('disabled', true);
                // $('#loadingBackdrop').modal('toggle');
                // if ($('#create-booking').attr('disabled') == true) {
                // console.log('c')
                // }
                setTimeout(async () => {
                    await setModalLoading(false);
                    await Swal.fire({
                        position: "top-end",
                        icon: "success",
                        title: "สำเร็จ",
                        showConfirmButton: false,
                        timer: 1500
                    });
                    // window.location.reload();
                }, 10000);
            })
        });
        const setModalLoading = (status) => {
            if (status) {
                console.log(true)
                $('#create-booking').prop('disabled', status);
                $('#cancel-booking').prop('disabled', status);
            } else {
                console.log(false)
                $('#create-booking').prop('disabled', status);
                $('#cancel-booking').prop('disabled', status);
            }
            return status
        }
        const setCellsNotData = (ele_id, tr_id, text) => {
            
            const table = document.getElementById(ele_id);
            var totalRowCellCount = table.rows[0].cells.length; // 5
            const tr = document.querySelector(tr_id);
            console.log(tr)
            tr.innerHTML += `<td colspan="${totalRowCellCount}" class="text-center">${text}</td>`;
            return
        }
        const setRows = (ele_id, data) => {
            var table = document.getElementById(ele_id);

            var totalRowCellCount = table.rows[0].cells.length; // 5
            var row = table.insertRow(-1);

            for (let i = 0; i < Number(totalRowCellCount); i++) {
                     var cell = row.insertCell(i);
                    cell.innerHTML = data[i];
            }

            return
        }
    </script>
</head>
<style>
    :root {
        --fc-small-font-size: .85em;
        --fc-page-bg-color: #fff;
        --fc-neutral-bg-color: rgba(208, 208, 208, 0.3);
        --fc-neutral-text-color: #808080;
        --fc-border-color: #FFDEAD;

        --fc-button-text-color: #000000;
        --fc-button-bg-color: #FFF8DC;
        --fc-button-border-color: #FFF8DC;
        --fc-button-hover-bg-color: #FFDEAD;
        --fc-button-hover-border-color: #FFDEAD;
        --fc-button-active-bg-color: #FFDEAD;
        --fc-button-active-border-color: #FFDEAD;

        --fc-event-bg-color: #FFDEAD;
        --fc-event-border-color: #FFDEAD;
        --fc-event-text-color: #fff;
        --fc-event-selected-overlay-color: rgba(255, 255, 240, 0.25);

        --fc-more-link-bg-color: #d0d0d0;
        --fc-more-link-text-color: inherit;

        --fc-event-resizer-thickness: 8px;
        --fc-event-resizer-dot-total-width: 8px;
        --fc-event-resizer-dot-border-width: 1px;

        --fc-non-business-color: rgba(215, 215, 215, 0.3);
        --fc-bg-event-color: rgb(143, 223, 130);
        --fc-bg-event-opacity: 0.3;
        --fc-highlight-color: rgba(188, 232, 241, 0.3);
        --fc-today-bg-color: rgba(255, 220, 100, 0.15);
        --fc-now-indicator-color: green;
    }
</style>

<body>
    <div class="modal fade" id="loadingBackdrop" data-backdrop="static" tabindex="0" role="dialog"
        aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="spinner-grow text-warning" role="status">
            <span class="sr-only">Loading...</span>
        </div>

    </div>

    <div class=".container-fluid p-3">
        <div class="row justify-content-md-center">
            <div class="col-9">
                <div class="container-fluid border border-2 p-3 rounded-lg shadow">
                    <div id='calendar'></div>
                </div>
            </div>
            <div class="col-3">
                <div class="container-fluid border border-2 rounded-lg shadow p-2">
                    <H1 class="text-warning text-center">รายการจองวันนี้</H1>
                    <table class="table" id="reserv-today">
                        <thead>
                            <tr>
                                <th scope="col">รถ</th>
                                <th scope="col">ผู้จอง</th>
                                <th scope="col">วันที่</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr id="tr-reserv-today"></tr>
                        </tbody>
                    </table>
                </div>

                <div class="container py-3">
                </div>

                <div class="container-fluid border border-2 rounded-lg shadow p-2">
                <H1 class="text-warning text-center">รายการจองล่าสุด</H1>
                <table class="table" id="reserv-last">
                        <thead>
                            <tr>
                                <th scope="col">รถ</th>
                                <th scope="col">ผู้จอง</th>
                                <th scope="col">วันที่</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr id="tr-reserv-last">
                            </tr>
                        </tbody>
                    </table>
                </div>

                <div class="container py-3">
                </div>

                <div class="container-fluid border border-2 rounded-lg shadow p-2">
                <H1 class="text-warning text-center">รถทั้งหมด</H1>
                <table class="table" id="all-item">
                        <thead>
                            <tr>
                                <th scope="col">ชื่อ</th>
                                <th scope="col">ประเภท</th>
                            </tr>
                        </thead>
                            <tr id="tr-all-item">
                            </tr>
                        <tbody>
                        </tbody>
                    </table>
                </div>

            </div>
        </div>


    </div>

    <!-- ==============================Modal===================== -->
    <div class="modal fade" id="staticBackdrop" data-backdrop="static" tabindex="-1" role="dialog"
        aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header justify-content-center">
                    <h5 class="modal-title" id="staticBackdropLabel">ข้อมูลจอง</h5>
                    <!-- <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button> -->
                </div>
                <div class="modal-body">
                    <form id="form-create-booking">
                        <div class="form-group">
                            <label for="fullanme" class="col-form-label">ชื่อ - สกุล :</label>
                            <input type="text" class="form-control" id="fullnanme" name="fullnanme" required>
                        </div>
                        <div class="form-group">
                            <label for="select-create" class="col-form-label">จอง :</label>
                            <select class="custom-select" id="select-create" required>
                                <option value="0" selected>โปรดเลือก</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="date-start" class="col-form-label">เริ่ม :</label>
                            <input type="datetime-local" class="form-control" id="date-start" required>
                        </div>
                        <div class="form-group">
                            <label for="date-end" class="col-form-label">สิ้นสุด :</label>
                            <input type="datetime-local" class="form-control" id="date-end" required>
                        </div>

                </div>
                <div class="modal-footer text-center">
                    <button class="btn btn-primary" type="summit" id="create-booking">
                        <span class="spinner-grow spinner-grow-sm d-none" role="status" aria-hidden="true"></span>
                        ยืนยัน
                    </button>
                    <button type="button" class="btn btn-waning border border-2" id="cancel-booking"
                        data-dismiss="modal"><span class="spinner-grow spinner-grow-sm d-none" role="status"
                            aria-hidden="true"></span>
                        ยกเลิก</button>

                </div>
                </form>
            </div>
        </div>
    </div>
</body>

</html>