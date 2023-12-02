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
        document.addEventListener('DOMContentLoaded', () => {
            var calendarEl = document.getElementById('calendar');
            var calendar = new FullCalendar.Calendar(calendarEl, {
                headerToolbar: {
                    left: 'prev,next today',
                    right: 'dayGridMonth,list',
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
                }
            });
            // calendar.getOption('locale');
            // calendar.setOption('locale', 'th');
            calendar.render();

        });

        // jqery event ================================================
        function c() {
            $('#staticBackdrop').modal('toggle');
        }
        $(document).ready(() => {
            $('#create-booking').click(async () => {
                await setModalLoading(true);
                // $('#create-booking').prop('disabled', true);
                // $('#cancel-booking').prop('disabled', true);
                // $('#loadingBackdrop').modal('toggle');
                // if ($('#create-booking').attr('disabled') == true) {
                // console.log('c')
                // }
                await setTimeout(async () => {
                    await setModalLoading(false);
                    await Swal.fire({
                        position: "top-end",
                        icon: "success",
                        title: "Your work has been saved",
                        showConfirmButton: false,
                        timer: 1500
                    });
                    window.location.reload();
                }, 10000);
                await console.log($('#create-booking'));





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
    #create-booking {
        background-color: #FFDEAD;
        border-color: #FFDEAD;
        text-emphasis-color: #0000;
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
        <div class="container border border-2 p-3 rounded-lg shadow">
            <div id='calendar'></div>
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
                    <form>
                        <div class="form-group">
                            <label for="recipient-name" class="col-form-label">Recipient:</label>
                            <input type="text" class="form-control" id="recipient-name">
                        </div>
                        <div class="form-group">
                            <label for="message-text" class="col-form-label">Message:</label>
                            <input type="text" class="form-control" id="recipient-name">
                        </div>
                    </form>
                </div>
                <div class="modal-footer text-center">
                    <button class="btn btn-primary" type="button" id="create-booking">
                        <span class="spinner-grow spinner-grow-sm d-none" role="status" aria-hidden="true"></span>
                        ยืนยัน
                    </button>
                    <button type="button" class="btn btn-waning border border-2" id="cancel-booking"
                        data-dismiss="modal"><span class="spinner-grow spinner-grow-sm d-none" role="status"
                            aria-hidden="true"></span>
                        ยกเลิก</button>

                </div>
            </div>
        </div>
    </div>
</body>

</html>