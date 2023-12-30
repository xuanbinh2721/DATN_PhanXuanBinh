
$(document).ready(function () {
  $('#advsearch').click(function () {
    $('#advancedSearch').toggle(); // Hiển thị hoặc ẩn trường tìm kiếm nâng cao
  });

  // Xử lý sự kiện khi nhấn nút "Delete"
  $('#delete').click(function (e) {
    e.preventDefault();
    // Xóa nội dung các trường tìm kiếm nâng cao
    $('.input-select select').val('').trigger('change');
  });
});
