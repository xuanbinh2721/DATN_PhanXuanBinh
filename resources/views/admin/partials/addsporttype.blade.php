<div class="container-fluid ">
    <div class="row justify-content-center">
        <div class="col-md-12 w-75">
            <div class="card">
                <div class="card-header ">{{ __('Thêm loại sân') }}</div>
                <div class="card-body">
                    <form action="{{ route('sporttype.addtype') }}" method="POST" enctype="multipart/form-data" class="w-100">
                        @csrf
                        @method('PUT')

                        <div class="row">
                            <div class="col-md-8">
                                <div class="row">
                                    <div class="mb-3">
                                        <label class="small mb-1" for="inputName">Name</label>
                                        <input class="form-control" name="name" id="inputName" type="text" placeholder="Nhập tên loại thể thao" required>
                                    </div>
        
                                    <div class="mb-3">
                                        <label class="small mb-1" for="inputDescription">Mô tả</label>                                    
                                        <textarea class="form-control" name="description" id="inputDescription" type="text" placeholder="Nhập mô tả" ></textarea>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4 mt-4 align-item-center text-center">
                                <div class="row third">
                                    <div class="input-field mb-3">
                                        <button class="btn btn-outline-primary my-2 my-sm-0 me-3" type="submit">Thêm</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>