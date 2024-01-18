<div class="col-md-12 mt-4 mb-3 align-item-center text-center">
    <a class="btn btn-info text-light" style="background-color:  rgb(58, 160, 180);"  onclick="toggleFeedbackForm()">
        Đánh giá
    </a>
</div>
<div id="feedbackForm" style="display: none;">
    <div class="container-fluid w-50">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header ">
                        Đánh giá sân: {{ $fields->name }}
                    </div>
                    <div class="card-body">
                        <form action="{{ route('field.addfeedback',$fields->id) }}" method="post">
                            @csrf
                            @method('PUT')
                            <div class="star-rating">
                                <label for="rating">Điểm đánh giá:</label>
                                <span class="fa-regular fa-star fs-5" data-rating="1"></span>
                                <span class="fa-regular fa-star fs-5" data-rating="2"></span>
                                <span class="fa-regular fa-star fs-5" data-rating="3"></span>
                                <span class="fa-regular fa-star fs-5" data-rating="4"></span>
                                <span class="fa-regular fa-star fs-5" data-rating="5"></span>
                                <input type="hidden" name="rating" class="rating-value" id="rating" >
                              </div>
                            <div class="mb-3">
                                <label for="feedback">Nội dung đánh giá:</label>
                                <textarea class="form-control" id="feedback" name="feedback" rows="3"></textarea>
                            </div>
                            <button type="submit" class="btn btn-primary">Gửi đánh giá</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>