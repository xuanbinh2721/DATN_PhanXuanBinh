@if(auth()->user()->id == $feedback->user_id)
<div class="dropdown">
    <div id="advanced" class="float-right pe-3 fs-4" data-bs-toggle="dropdown">
        <i class="fa-solid fa-ellipsis-vertical"></i>
    </div>
    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="advanced">
        <a class="dropdown-item text-primary" data-bs-toggle="modal"
            data-bs-target="#modal-update-feedback{{ $feedback->id }}" style="cursor: pointer">Sửa</a>
        <div class="dropdown-divider"></div>
        <a class="dropdown-item text-danger" data-bs-toggle="modal"
            data-bs-target="#confirmDeleteModal{{ $feedback->id }}" style="cursor: pointer">Xóa</a>
    </div>
</div>


<!-- Modal sửa feedback -->
<div class="modal fade" id="modal-update-feedback{{ $feedback->id }}" tabindex="-1" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Sửa đánh giá</h5>
                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="{{ route('field.updatefeedback',$feedback->id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="star-rating-edit mb-3">
                        <label for="ratingEdit{{ $feedback->id }} small">Điểm đánh giá:</label>
                        <span class="fa-regular fa-star fs-5 star-rating-star" data-rating="1"></span>
                        <span class="fa-regular fa-star fs-5 star-rating-star" data-rating="2"></span>
                        <span class="fa-regular fa-star fs-5 star-rating-star" data-rating="3"></span>
                        <span class="fa-regular fa-star fs-5 star-rating-star" data-rating="4"></span>
                        <span class="fa-regular fa-star fs-5 star-rating-star" data-rating="5"></span>
                        <input type="hidden" name="rating" class="rating-value-edit"
                            data-feedback-id="{{ $feedback->id }}" value="{{ $feedback->rate }}">
                    </div>

                    <div class="mb-3 ">
                        <label class="small mb-1" for="inputDescription">Nội dung đánh giá</label>
                        <textarea class="form-control" name="feedbackedit" id="inputDescription" type="text"
                            placeholder="Nhập nội dung đánh giá">{{ $feedback->feedback }}</textarea>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Đóng</button>
                        <button type="submit" class="btn btn-primary">Lưu</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Modal xác nhận xóa feedback -->
<div class="modal fade" id="confirmDeleteModal{{ $feedback->id }}" tabindex="-1" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Xác nhận xóa</h5>
                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                Bạn có chắc chắn muốn xóa đánh giá này không?
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Đóng</button>
                <form action="{{ route('field.deletefeedback',$feedback->id) }}" method="GET">
                    @csrf
                    <button type="submit" class="btn btn-danger">Xóa</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endif