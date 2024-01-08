<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header ">{{ __('Thêm khung giờ') }}</div>
                <div class="card-body">
                    <form action="{{ route('schedule.addTime',$field->id) }}" method="POST" enctype="multipart/form-data" class="w-100">
                        @csrf
                        @method('PUT')

                        <div class="row">
                            
                            <div class="col-md-3 mb-3">
                                <label class="small mb-1" for="inputName">Start</label>
                                <input class="form-control" name="start_time" id="inputStartTime" type="time" placeholder="Nhập thời gian bắt đầu" required>
                            </div>

                            <div class="col-md-3 mb-3">
                                <label class="small mb-1" for="inputPhoneNumber">End</label>                                    
                                <input class="form-control" name="end_time" id="inputEndTime" type="time" placeholder="Nhập thời gian kết thúc"  required>
                            </div>
                            <div class="col-md-3 mb-3">
                                <label class="small mb-1" for="inputDescription">Ngày</label>
                                <input class="form-control" name="date" id="inputAddress" type="date" placeholder="Nhập địa chỉ"  required>
                            </div>                       
                            <div class="col-md-3 mb-3">
                                <label class="small mb-1" for="inputAddress">Giá</label>
                                <input class="form-control" name="price" id="inputPrice" type="text" placeholder="Nhập giá tiền(VNĐ)"  required>
                            </div>

                            <div class="row third">
                                <div class="input-field mb-3">
                                    <button class="btn btn-outline-primary my-2 my-sm-0 me-3" type="submit">Thêm</button>
                                    @if (session('status') === 'add-time-frame')
                                        <p class="text text-success mt-3">
                                            {{ __('Thêm thành công.') }}
                                        </p>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>