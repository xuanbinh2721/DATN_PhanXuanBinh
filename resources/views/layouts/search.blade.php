<div class="container-fluid">
    <div class="row justify-content-center bg-gradient">
        <div class="col-md-8 mt-3 mb-3">
            <div class="card">
                <div class="card-header">{{ __('Tìm Sân: ') }}</div>
                <div class="card-body">
                    <form action="{{ route('searchresults') }}" method="GET" enctype="multipart/form-data" class="w-100">
                    <div class="inner-form">
                    <div class="basic-search">
                        <div class="container">
                        <div class="row align-item-center">
                            <div class="col-md-10">
                            <div class="input-field">
                                <div class="icon-wrap">
                                <i class="fas fa-search"></i>
                                </div>
                                <input id="search" name="search" class="form-control mr-sm-2" type="search" aria-label="Search"
                                placeholder="Search...">
                                
                                <div class="result-count" id="advsearch" style="cursor: pointer">
                                <i class="fa-solid fa-caret-down"></i>
                                <span>Advanced Search</span>
                                </div>

                            </div>
                            </div>
                            <div class="col-md-2 d-inline-flex align-items-center justify-content-center">

                            <button class="btn btn-outline-primary my-2 my-sm-0 w-100" type="submit">Search</button>
                            </div>
                        </div>
                        </div>
                    </div>
                    <div class="advance-search" id="advancedSearch" style="display: none;">
                        <span class="desc">Advanced Search</span>
                        <div class="row">
                        <div class="input-field mb-3">
                            <div class="input-select">
                            <select data-trigger=""  name="sporttype" class="form-select" >
                                <option value="">Chọn loại sân thể thao</option>
                                @foreach($sportTypes as $sportType)
                                <option value="{{ $sportType->id  }}"> Sân {{ $sportType->name }}</option>
                                @endforeach
                            </select>
                            </div>
                        </div>
                        <div class="input-field mb-3">
                            <div class="input-select">
                            <select data-trigger="" name="province" class="form-select" id="province">
                                <option value="">Chọn tỉnh/thành phố</option>
                                @foreach($provinces as $province)
                                <option value="{{ $province->id }}">{{ $province->name }}</option>
                                @endforeach
                            </select>
                            </div>
                        </div>
                        <div class="input-field mb-3">
                            <div class="input-select">
                            <select data-trigger=""  name="district" class="form-select" id="district">
                                <option value="">Chọn quận/huyện</option>
                            </select>
                            </div>
                        </div>
                        <div class="input-field mb-3">
                            <div class="input-select">
                            <select data-trigger=""  name="ward" class="form-select" id="ward">
                                <option value="">Chọn phường/xã</option>
                            </select>
                            </div>
                        </div>
                        <div class="row third">
                            <div class="input-field mb-3">
                            <button class="btn btn-delete mt-3 btn-outline-danger" id="delete">Delete</button>
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
