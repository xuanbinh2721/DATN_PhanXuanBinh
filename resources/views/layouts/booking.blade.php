<button type="button" class="btn btn-info text-light  fs-5" data-toggle="modal" data-target="#modal-booking" style="background-color:  rgb(58, 160, 180);">
    Đặt sân
</button>

<div class="modal fade " id="modal-booking" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true" >
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Đặt sân</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <div class="modal-body">
                <form action="{{ route('field.booking',['id'=> $fields->id]) }}" enctype="multipart/form-data" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="form-floating mb-3">
                        <input class="form-control" name="name"  type="text" placeholder="Nhập username của bạn" required value="{{ auth()->user()->name }}">
                        <label class="small mb-1 d-flex" for="inputUsername">Tên người đặt</label>
                    </div>
                    <div class="form-floating mb-3">
                        <input class="form-control" name="email" type="email" placeholder="Nhập email của bạn" required value="{{ auth()->user()->email }}">
                        <label class="small mb-1 d-flex" for="inputEmailAddress">Email</label>
                    </div>
                    <div class="form-floating mb-3">
                        <input class="form-control" name="phone_number" type="tel" placeholder="Nhập số điện thoại của bạn" required value="{{ auth()->user()->phone_number }}">
                        <label class="small mb-1 d-flex" for="inputPhoneNumber">Số Điện Thoại</label>                                    
                    </div>
                    <div class="form-floating mb-3">
                        <input class="form-control" name="field_name"  type="text"  readonly required value="{{ $fields->name }}">
                        <label class="small mb-1 d-flex" for="inputFieldName">Sân đặt</label>
                    </div>
                    <div class="form-floating mb-3">
                        <input type="date" name="date" id="inputDate" class="form-control mb-3"  required>
                        <label class="small mb-1 d-flex" for="inputDate">Ngày đặt</label>
                    </div>
                    <div class="form-floating mb-3">
                        <select name="time_frame" class="form-select" id="inputTimeFrame" required>
                        </select>
                        <label class="small mb-1 d-flex" for="inputTimeFrame">Khung giờ</label>
                    </div>                    
                    <div class="form-floating mb-3">
                        <input type="number" name="price" class="form-control mb-3" readonly required >
                        <label class="small mb-1 d-flex" for="inputPrice">Giá</label>
                    </div>
                    <div class="form-floating mb-3">
                        <textarea class="form-control" name="note" id="inputNote" ></textarea>
                        <label for="inputNote">Lời nhắn</label>
                    </div>
                    <div class="form-floating mb-3">
                        <select name="payment_method" class="form-select" required>
                            <option value="0">Thanh toán tại sân</option>
                            {{-- <option value="1">Thẻ tín dụng</option>
                            <option value="2">Thẻ ngân hàng</option> --}}
                        </select>
                        <label class="small mb-1 d-flex" for="payment_method">Phương thức thanh toán</label>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Đóng</button>
                        <button type="submit" class="btn btn-primary">Đặt sân</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>

<script>
$(document).ready(function () {
    // Lắng nghe sự kiện khi thay đổi ngày
    $('#inputDate').on('change', function () {
        // Làm trống khung giờ khi ngày thay đổi
        $('#inputTimeFrame').val('');
        // Xóa giá trị trong trường giá
        $('input[name="price"]').val('');

        // Lấy giá trị ngày và thời gian hiện tại
        var selectedDate = $(this).val();
        var currentTime = new Date();
        var currentHour = currentTime.getHours();
        var currentMinutes = currentTime.getMinutes();

        // Lấy ID của sân từ URL (đã được truyền từ Controller)
        var fieldId = '{{ $fields->id }}';

        // Gọi Ajax để lấy danh sách khung giờ
        $.ajax({
            url: '{{ route("field.time-frames", ["id" => $fields->id]) }}',
            method: 'GET',
            data: {
                date: selectedDate,
            },
            success: function (data) {
                // Xóa các option cũ trong dropdown
                $('#inputTimeFrame').empty();
                $('#inputTimeFrame').append('<option value="">Chọn khung giờ</option>');
                // Thêm option mới dựa trên danh sách khung giờ từ Ajax
                data.forEach(function (timeFrame) {
                    // Tính toán thời gian kết thúc của khung giờ
                    var endTime = new Date(selectedDate + ' ' + timeFrame.end_time);
                    
                    // Kiểm tra nếu thời gian kết thúc của khung giờ lớn hơn thời gian hiện tại
                    // và thời gian bắt đầu của khung giờ lớn hơn hoặc bằng thời gian hiện tại
                    if (endTime > currentTime && new Date(selectedDate + ' ' + timeFrame.start_time) >= currentTime) {
                        // Nếu thỏa mãn điều kiện, thêm vào dropdown
                        $('#inputTimeFrame').append('<option value="' + timeFrame.id + '">' + timeFrame.start_time + ' - ' + timeFrame.end_time + '</option>');
                    }
                    else{
                        $('#inputTimeFrame').append('<option value="">Không có khung giờ nào</option>');
                    }
                });
            },
            error: function (error) {
                console.log('Error:', error);
            }
        });
    });

    // Lắng nghe sự kiện khi thay đổi khung giờ
    $('#inputTimeFrame').on('change', function () {
        // Lấy giá trị ngày và khung giờ
        var selectedDate = $('#inputDate').val();
        var selectedTimeFrame = $(this).val();

        // Kiểm tra xem khung giờ đã được chọn chưa
        if (selectedTimeFrame !== '') {
            // Gọi Ajax để lấy giá tiền từ máy chủ
            $.ajax({
                url: '{{ route("field.get-price", ["id" => $fields->id]) }}',
                method: 'GET',
                data: {
                    date: selectedDate,
                    timeFrame: selectedTimeFrame,
                },
                success: function (data) {
                    // Cập nhật giá tiền trong trường input
                    $('input[name="price"]').val(data.price);
                },
                error: function (error) {
                    console.log('Error:', error);
                }
            });
        }
    });
});

    </script>
    


