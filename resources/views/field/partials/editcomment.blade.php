@if(auth()->user()->id == $comment->user_id)
<div class="dropdown">
    <div id="advanced" class="float-right pe-3 fs-4" data-bs-toggle="dropdown">
        <i class="fa-solid fa-ellipsis-vertical"></i>
    </div>
    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="advanced">
        <a class="dropdown-item text-primary" data-bs-toggle="modal"
            data-bs-target="#modal-update-comment{{ $comment->id }}" style="cursor: pointer">Sửa</a>
        <div class="dropdown-divider"></div>
        <a class="dropdown-item text-danger" data-bs-toggle="modal"
            data-bs-target="#confirmDeleteCommentModal{{ $comment->id }}" style="cursor: pointer">Xóa</a>
    </div>
</div>


<!-- Modal sửa feedback -->
<div class="modal fade" id="modal-update-comment{{ $comment->id }}" tabindex="-1" aria-labelledby="exampleModalLabel"
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
                <form action="{{ route('field.updatecomment',$comment->id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="mb-3 ">
                        <label class="small mb-1" for="inputComment">Nội dung đánh giá</label>
                        <textarea class="form-control" name="commentedit" id="inputComment" type="text"
                            placeholder="Nhập nội dung bình luận">{{ $comment->comment }}</textarea>
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
<div class="modal fade" id="confirmDeleteCommentModal{{ $comment->id }}" tabindex="-1" aria-labelledby="exampleModalLabel"
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
                <form action="{{ route('field.deletecomment',$comment->id) }}" method="GET">
                    @csrf
                    <button type="submit" class="btn btn-danger">Xóa</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endif