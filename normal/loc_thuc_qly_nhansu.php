<?php
// Kết nối CSDL
// $db_host = "localhost"; // Ampps
// $db_user = "root"; // Ampps
// $db_pass = "mysql"; // Ampps
// $db_name = "ltweb"; // Ampps
$db_host = "172.30.35.70"; // Ltweb
$db_user = "user_c4"; // Ltweb
$db_pass = "puser_c4"; // Ltweb
$db_name = "db_c4"; // Ltweb
$conn = mysql_connect($db_host,$db_user,$db_pass) or die(mysql_error());
mysql_set_charset('utf8');
date_default_timezone_set('Asia/Ho_Chi_Minh');
mysql_select_db($db_name) or die("mysql can not find");
session_start();
?>
<!DOCTYPE html>
<html lang="vi" dir="ltr">
  <head>
    <meta charset="utf-8">
    <!-- Co giãn web theo tỉ lệ khung hình -->
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Quản lý nhân sự</title>
    <script type="text/javascript">
      // list fieldset id
      var fieldsetId = ['trang-chu','qly-nhan-vien','qly-don-vi','qly-chuc-vu','them-nvien','chinh-sua-nvien','chinh-sua-hinhanh-nvien'];

      // Hàm hiển thị vùng nội dung
      function showPage(id, prop, value) {
        for (i=0; i<fieldsetId.length; i++) {
          document.getElementById(fieldsetId[i]).style.display = 'none';
        }
        // show the table by id
        document.getElementById(id).style.display = 'block';
        // storage session page
        sessionStorage.setItem('page', id);
        // parameter transmission for property
        for (i=0; i<prop.length; i++) {
          if (value[i] === 'Nam') {
            document.getElementById('nam').checked = true;
            document.getElementById('nu').checked = false;
          } else if (value[i] === 'Nu') {
            document.getElementById('nam').checked = false;
            document.getElementById('nu').checked = true;
          } else document.getElementById(prop[i]).value = value[i];
        }
      }

      // Hàm hiển thị vùng nội dung được ghi nhớ trước đó trong phiên làm việc
      function showFieldsetSessions() {
        // hide the table
        for (i=0; i<fieldsetId.length; i++) {
          document.getElementById(fieldsetId[i]).style.display = 'none';
        }
        // show the table by id
        if (sessionStorage.getItem('page') === null) {
          document.getElementById('trang-chu').style.display = 'block';
        } else document.getElementById(sessionStorage.getItem('page')).style.display = 'block';
      }

      // Hàm checkall cho checkbox
      function toggle(source,name) {
        checkboxes = document.getElementsByName(name);
        for(var i=0, n=checkboxes.length;i<n;i++) {
          checkboxes[i].checked = source.checked;
        }
      }

      // Hàm truyền giá trị vào các text field
      function showHideElement(primary, second, value) {
          var x = document.getElementById(primary);
          if (x.style.display === "none") {
              x.style.display = "block";
              for (i=0; i<second.length; i++) {
                document.getElementById(second[i]).value = value[i];
              }
          } else {
              x.style.display = "none";
          }
      }

      // Hàm gọi menu-bar ở các thiết bị có kích thước khung hình nhỏ hơn mặc đinh - tính năng responsive
      function callMenuBar() {
          var x = document.getElementById("menu-bar");
          if (x.className === "menu-bar") {
              x.className += " responsive";
          } else {
              x.className = "menu-bar";
          }
      }

      // Hàm đóng menu-bar khi ấn vào bất kỳ vị trí nào trong page
      function closeMenuBar() {
          document.getElementById("menu-bar").className = "menu-bar";
      }
    </script>
    <style media="screen">
      /* CSS for HTML tag */
        /* thẻ body */
        body {
            width: 99%;
            height: 100%;
            background-color: rgba(85, 164, 246, 0.19);
        }

        /* thẻ header */
        header {
            height: 50px;
            float: left;
            position: fixed;
            left: 0;
            top: 0;
            width: 100%;
            color: white;
            text-align: center;
            background-color: rgb(29, 223, 72);
        }

        /* thẻ h2 trong header */
        header h2 {
            color: white;
            margin: 15px 0 0 20px;
            float: center;
            font-size: 1.8em;
        }

        /* thẻ footer */
        footer {
            height: 50px;
            float: left;
            position: fixed;
            left: 0;
            bottom: 0;
            width: 100%;
            color: white;
            text-align: center;
            background-color: rgb(29, 223, 72);
        }

        /* thẻ h3 trong footer */
        footer h3 {
            color: white;
            float: center;
        }

        /* thẻ table */
        table {
            float: left;
            width: 100%;
            text-align: center;
        }

        /* thẻ fieldset */
        fieldset {
            border: 0px;
        }

        /* thẻ input */
        input {
            background-color: white;
            color: black;
            padding: 5px;
            border: 1px solid black;
            border-radius: 10px;
        }

        /* các thẻ select và option */
        select, option {
            background-color: white;
            color: black;
            padding: 5px;
            border: 1px solid black;
            border-radius: 10px;
        }

      /* CSS for HTML class */
        /* lớp btn cho button */
        .btn {
            background-color: white;
            color: blue;
            font-weight: bold;
            padding: 5px 10px 5px 10px;
            border: 1px solid blue;
            border-radius: 10px;
        }

        /* lớp btn-primary cho thẻ button */
        .btn-primary {
            background-color: blue !important;
            color: white !important;
            border: 1px solid white !important;
        }

        /* lớp btn-danger cho thẻ button */
        .btn-danger {
            background-color: red !important;
            color: white !important;
            border: 1px solid white !important;
        }

        /* sự kiện hover cho các lớp btn */
        .btn:hover {
            background-color: blue;
            color: white;
            font-weight: bold;
            padding: 5px 10px 5px 10px;
            border: 1px solid white;
            border-radius: 10px;
        }

        .btn-primary:hover {
            background-color: white !important;
            color: blue !important;
            border: 1px solid blue !important;
        }

        .btn-danger:hover {
            background-color: white !important;
            color: red !important;
            border: 1px solid red !important;
        }

        /* lớp menu-bar */
        .menu-bar {
            overflow: hidden;
            background-color: rgb(29, 223, 72);
        }

        /* thẻ a trong lớp menu-bar */
        .menu-bar a {
            float: left;
            display: block;
            color: #FFF;
            text-align: center;
            padding: 14px 16px;
            text-decoration: none;
            font-size: 17px;
        }

        /* sự kiện hover của thẻ a trong lớp menu-bar */
        .menu-bar a:hover {
            background-color: #4CAF50;
            color: #FFF;
        }

        /* lớp icon hiển thị icon menu-bar ở giao diện responsive */
        .menu-bar .icon {
            display: none;
        }

        /* mẫu giao diện menu-bar kiểu cũ sử dụng thẻ ul-li */
        /* .menu-bar {
            width: 100%;
            height: 32px;
            float: left;
            background-color: rgb(29, 223, 72);
        }

        .menu-bar ul{
          	list-style: none;
            margin: 0px 0 0 0px;
            padding: 0px 0 0 0px;
        }

        .menu-bar ul li {
            font-weight: bold;
            float: left;
            background-color: rgb(29, 223, 72);
            margin-left: 15px;
            margin-right: 15px;
        }

        .menu-bar ul a, ul a:visited {
          	padding: 5px 5px 5px 15px;
          	display: block;
          	text-decoration: none;
        }

        .menu-bar ul a:hover, ul a:active, ul a:focus {
          	background-color: #4CAF50;
          	color: #FFF;
        }

        .menu-bar a {
            text-decoration: none;
            color: white;
        } */

        /* lớp main-content để hiển thị các nội dung chính của web */
        .main-content {
            width: 100%;
            height: 100%;
            float: left;
            margin-top: 80px;
            float: left;
            margin-bottom: 100px;
        }

        /* định nghĩa các thẻ button trong main-content */
        .main-content button {
            margin-right: 5px;
        }

        /* lớp list-nvien hiển thị danh sách nhân viên tại trang chủ */
        .list-nvien {
            width: 100%;
            text-align: center;
            margin-left: 15px;
            float: left;
        }

        /* lớp list-nvien-detail hiển thị từng cá nhân trong danh sách nhân viên */
        .list-nvien-detail {
            width: 205px;
            margin: 0 5px 10px 5px;
            border-radius: 10px;
            border: 1px solid #ddd;
            float: left;
        }

        /* thẻ img hiển thị hình ảnh của nhân viên trong lớp list-nvien-detail */
        .list-nvien-detail img {
            width: 100%;
            border-radius: 10px;
            height: 220px;
        }

        /* thẻ b để in đậm tên của nhân viên trong lớp list-nvien-detail */
        .list-nvien-detail b {
            color: blue;
        }

        /* thẻ span để trang trí ô mã số nhân viên trong lớp list-nvien-detail */
        .list-nvien-detail span {
            color: rgb(176, 177, 177);
        }

        /* định nghĩa các thẻ table, th, td trong lớp qly-nvien-tbl của bảng quản lý nhân viên */
        .qly-nvien-tbl table, th, td {
            border: 0px;
        }

        /* .qly-nvien-tbl table, th, td {
            border: 1px solid #ddd;
        } */

        /* định nghĩa màu sắc của dòng tên trường hiển thị th */
        .qly-nvien-tbl th {
            background-color: #4CAF50;
            color: white;
        }

        /* .qly-nvien-tbl tr:nth-child(even) {
            background-color: #f2f2f2;
        } */

        /* định nghĩa màu nền của mỗi dòng nội dung ở thẻ tr */
        .qly-nvien-tbl tr {
            background-color: #f2f2f2;
        }

        /* định nghĩa khoảng cách của các button trong danh sách quản lý nhân viên */
        .qly-nvien-tbl button {
            margin: 5px 0 5px 0;
        }

        /* định nghĩa bảng tại các trang chỉnh sửa nhân viên thuộc tính năng quản lý nhân viên */
        .tbl-nvien-not-qly table {
            text-align: left;
        }

        /* sự kiện hover khi đưa trỏ chuột vào vùng hiển thị của thẻ tr */
        .qly-don-vi tr:hover {
            background-color: #f5f5f5;
        }

        .qly-chuc-vu tr:hover {
            background-color: #f5f5f5;
        }

        /* định nghĩa nhãn tên bảng hiển thị với thẻ th */
        .qly-don-vi th {
            border-bottom: 1px solid #ddd;
            background: #4CAF50;
            color: white;
        }

        .qly-chuc-vu th {
            border-bottom: 1px solid #ddd;
            background: #4CAF50;
            color: white;
        }

        /* định nghĩa viền dưới của thẻ td */
        .qly-don-vi td {
            border-bottom: 1px solid #ddd;
        }

        .qly-chuc-vu td {
            border-bottom: 1px solid #ddd;
        }

        /* lớp hiển thị khi ở khung hình chuẩn */
        .full-screen {
            display: block;
        }

        .mobile-screen {
            display: none;
        }

        /* tùy biến thanh trượt dọc scrollbar khi có nội dung quá dài theo chiều dọc */
      /* Custom scrollbar - w3school */
        /* width */
        ::-webkit-scrollbar {
            width: 2px;
        }

        /* Track */
        ::-webkit-scrollbar-track {
            /* background: #f1f1f1; */
            background: rgb(29, 223, 72);
        }

        /* Handle */
        ::-webkit-scrollbar-thumb {
            /* background: #888; */
            background: rgb(29, 223, 72);
        }

        /* Handle on hover */
        ::-webkit-scrollbar-thumb:hover {
            background: #4CAF50;
        }

      /* CSS for HTML tag id */
        /* canh giữa nội dung trong các tag id liên quan */
        #trang-chu, #qly-nhan-vien, #qly-don-vi, #qly-chuc-vu {
            text-align: center;
        }

        /* mặc định ẩn các trang thuộc các tag id liên quan */
        #qly-nhan-vien, #qly-don-vi, #qly-chuc-vu {
            display: none;
        }

        /* quy định kích thước của các tag id liên quan */
        #them-nvien, #chinh-sua-nvien, #them-hinhanh-nvien, #chinh-sua-hinhanh-nvien {
            width: 97%;
            display: none;
            float: left;
        }

        /* đoạn code định nghĩa các thẻ - lớp - tag id cho tính năng responsive */
      /* Responsive */
      @media only screen and (max-width: 920px) {
        header {
            height: 100px;
            float: left;
            position: fixed;
            left: 0;
            top: 0;
            width: 100%;
            color: white;
            text-align: center;
            background-color: rgb(29, 223, 72);
        }

        footer {
            height: 60px;
            float: left;
            position: fixed;
            left: 0;
            bottom: 0;
            width: 100%;
            color: white;
            text-align: center;
            background-color: rgb(29, 223, 72);
        }

        .menu-bar a:not(:first-child) {
            display: none;
        }
        .menu-bar a.icon {
            float: right;
            display: block;
        }

        .menu-bar.responsive {
            position: relative;
        }
        .menu-bar.responsive .icon {
            position: absolute;
            right: 0;
            top: 0;
        }
        .menu-bar.responsive a {
            float: none;
            display: block;
            text-align: left;
        }

        .full-screen {
            display: none;
        }

        .mobile-screen {
            display: block;
        }
      }
    </style>
  </head>
  <body onload="showFieldsetSessions(); return false;">
    <header>
      <h2><strong>QUẢN LÝ NHÂN SỰ</strong></h2>
      <div class="menu-bar" id="menu-bar">
        <a onclick="showPage('trang-chu',[],[]); return false;">Trang chủ</a>
        <a onclick="showPage('qly-nhan-vien',[],[]); return false;">Quản lý nhân viên</a>
        <a onclick="showPage('qly-don-vi',[],[]); return false;">Quản lý đơn vị</a>
        <a onclick="showPage('qly-chuc-vu',[],[]); return false;">Quản lý chức vụ</a>
        <a onClick="window.location.reload()">Tải lại trang</a>
        <a style="font-size:15px;" class="icon" onclick="callMenuBar()">&#9776;</a>
      </div>
    </header>
    <div class="main-content" onclick="closeMenuBar()">
      <fieldset id="trang-chu">
        <legend><h2>TRANG CHỦ</h2></legend>
        <center>
          <div class="list-nvien">
          <?php
            $sql_qry_list_nvien = "SELECT * FROM loc_thuc_nhanvien a, loc_thuc_donvi b, loc_thuc_chucvu c WHERE a.madv = b.madv AND a.macv = c.macv ORDER BY manv ASC"; // Ltweb
            $qry_list_nvien = mysql_query($sql_qry_list_nvien);
            while ($row_list_nvien = mysql_fetch_array($qry_list_nvien)) {
              echo '<div class="list-nvien-detail">';
              echo '<img src="data:image/jpeg;base64,'.base64_encode( $row_list_nvien['hinhanh'] ).'" alt="Hình ảnh nhân viên"/>';
              echo "<br />";
              echo "<b>{$row_list_nvien['hoten']}</b>";
              echo "<br />";
              $sql_qry_chucvu_of_nvien = "SELECT chucvu FROM loc_thuc_chucvu WHERE macv = '{$row_list_nvien['macv']}'";
              $qry_chucvu_of_nvien = mysql_query($sql_qry_chucvu_of_nvien);
              $chucvu = mysql_fetch_array($qry_chucvu_of_nvien);
              echo $chucvu[0];
              echo "<br />";
              echo "<span>{$row_list_nvien['manv']}</span>";
              echo "<br />";
              echo "</div>";
            }
          ?>
          </div>
        </center>
      </fieldset>
      <fieldset id="qly-nhan-vien">
        <legend><h2>NHÂN VIÊN</h2></legend>
        <div>
          <!-- <legend>Quản lý nhân viên</legend> -->
          <form method="post">
            <p>
              <!-- Thuchanh_4 -->
              <button type="button" class="btn" onclick="showPage('them-nvien',[],[]); return false;">Thêm mới nhân viên</button>
              <!-- Thuchanh_5 -->
              <button type="submit" class="btn btn-danger" name="delete-nhieu-nvien">Xóa nhiều nhân viên</button>
            </p>
            <hr>
            <div style="width: 100%">
              <table class="qly-nvien-tbl">
                <thead>
                  <tr>
                    <th><input type="checkbox" onClick="toggle(this,'manv[]')" /></th>
                    <th>MANV</th>
                    <th>HÌNH ẢNH</th>
                    <th>HỌ TÊN</th>
                    <th>NGÀY SINH</th>
                    <th>GIỚI TÍNH</th>
                    <th>ĐƠN VỊ</th>
                    <th>CHỨC VỤ</th>
                    <th>LƯƠNG<br />(nghìn đồng)</th>
                    <th>THAO TÁC</th>
                  </tr>
                </thead>
                <tbody>
                  <?php
                    $sql_qry_list_nvien = "SELECT * FROM loc_thuc_nhanvien a, loc_thuc_donvi b, loc_thuc_chucvu c WHERE a.madv = b.madv AND a.macv = c.macv ORDER BY manv ASC"; // Ltweb
                    $qry_list_nvien = mysql_query($sql_qry_list_nvien);
                    while ($row_list_nvien = mysql_fetch_array($qry_list_nvien)) {
                      echo "<tr>";
                      echo '<td><input type="checkbox" name="manv[]" value="'.$row_list_nvien['manv'].'"</td>';
                      echo "<td>{$row_list_nvien['manv']}</td>";
                      echo '<td><img src="data:image/jpeg;base64,'.base64_encode( $row_list_nvien['hinhanh'] ).'" style="width: 100px; height: 150px" alt="Hình ảnh nhân viên"/></td>';
                      echo "<td>{$row_list_nvien['hoten']}</td>";
                      echo "<td>{$row_list_nvien['namsinh']}</td>";
                      echo "<td>{$row_list_nvien['gioitinh']}</td>";
                      echo "<td>{$row_list_nvien['donvi']}</td>";
                      echo "<td>{$row_list_nvien['chucvu']}</td>";
                      echo "<td>{$row_list_nvien['luong']}</td>";
                      echo '<td>';
                        // Thuchanh_5
                        echo '<button type="button" class="btn" onclick="showPage('."'chinh-sua-nvien', ['manv','hoten','namsinh','gioitinh','chucvu','donvi','luong'], ['".$row_list_nvien['manv']."','".$row_list_nvien['hoten']."','".$row_list_nvien['namsinh']."','".$row_list_nvien['gioitinh']."','".$row_list_nvien['macv']."','".$row_list_nvien['madv']."','".$row_list_nvien['luong']."']".'); return false;">
                            Sửa thông tin
                          </button>';
                        echo "<br />";
                        echo '<button type="button" class="btn" onclick="showPage('."'chinh-sua-hinhanh-nvien', ['manv_ha','hoten_ha'], ['".$row_list_nvien['manv']."','".$row_list_nvien['hoten']."']".'); return false;">
                            Sửa hình ảnh
                          </button>';
                        echo "<br />";
                        echo '<button type="submit" name="delete-nvien" value="'.$row_list_nvien['manv'].'" class="btn btn-danger">Xóa nhân viên</button>';
                      echo '</td>';
                      echo "</tr>";
                    }
                  ?>
                </tbody>
              </table>
            </div>
          </form>
        </div>
      </fieldset>
      <!-- Thuchanh_4 -->
      <fieldset id="them-nvien" class="tbl-nvien-not-qly">
        <legend><h2>THÊM MỚI NHÂN VIÊN</h2></legend>
        <button class="btn" onclick="showPage('qly-nhan-vien',[],[]); return false;">Quay lại</button>
        <hr>
        <form method="post" enctype="multipart/form-data">
          <table>
            <tr>
              <td><strong>MANV</strong></td>
              <td><input type="text" name="manv" value="<?php
              // Tự động sinh mã nhân viên
              $return_manv_end = mysql_fetch_array(mysql_query("SELECT manv FROM loc_thuc_nhanvien ORDER BY manv DESC "));
              $manv_next = $return_manv_end[0] + 1;
              if (($manv_next >= 100000) && ($manv_next >= 10000)) {
                  echo $manv_next;
              } else if ($manv_next >= 1000) {
                  echo '0'.$manv_next;
              } else if ($manv_next >= 100) {
                  echo '00'.$manv_next;
              } else if ($manv_next >= 10) {
                  echo '000'.$manv_next;
              } else if ($manv_next >= 1) {
                  echo '0000'.$manv_next;
              }
              ?>" placeholder="Nhập mã số nhân viên..." required /></td>
            </tr>
            <tr>
              <td><strong>HỌ TÊN</strong></td>
              <td><input type="text" name="hoten" placeholder="Nhập họ tên nhân viên..." required /></td>
            </tr>
            <tr>
              <td><strong>NGÀY SINH</strong></td>
              <td><input type="date" name="namsinh" value="<?php echo date('Y-m-d', time());?>" placeholder="Nhập họ tên nhân viên..." /></td>
            </tr>
            <tr>
              <td><strong>GIỚI TÍNH</strong></td>
              <td>
                Nam <input type="radio" name="gioitinh" value="Nam" checked/>
                Nữ <input type="radio" name="gioitinh" value="Nu" />
              </td>
            </tr>
            <tr>
              <td><strong>CHỨC VỤ</strong></td>
              <td>
                <select name="chucvu">
                  <?php
                  $sql_select_cv = "SELECT * FROM loc_thuc_chucvu";
                  $result_select_cv = mysql_query($sql_select_cv);
                  while ($row_cvu = mysql_fetch_array($result_select_cv)) {
                    echo '<option value="'.$row_cvu['macv'].'">'.$row_cvu['chucvu'].'</option>';
                  }
                  ?>
                </select>
              </td>
            </tr>
            <tr>
              <td><strong>ĐƠN VỊ</strong></td>
              <td>
                <select name="donvi">
                  <?php
                  $sql_select_cv = "SELECT * FROM loc_thuc_donvi";
                  $result_select_cv = mysql_query($sql_select_cv);
                  while ($row_cvu = mysql_fetch_array($result_select_cv)) {
                    echo '<option value="'.$row_cvu['madv'].'">'.$row_cvu['donvi'].'</option>';
                  }
                  ?>
                </select>
              </td>
            </tr>
            <tr>
              <td><strong>LƯƠNG</strong></td>
              <td><input type="number" min="1000" name="luong" placeholder="Nhập lương nhân viên..." required /> (nghìn đồng)</td>
            </tr>
            <tr>
				<td><strong>HÌNH ẢNH</strong></td>
				<td><input type="file" name="img_nv" style="margin-bottom: 10px;" /></td>
			</tr>
          </table>
          <hr>
          <button type="submit" class="btn btn-primary" name="them-nvien">Thêm mới</button>
        </form>
      </fieldset>
      <!-- Thuchanh_5 -->
      <fieldset id="chinh-sua-nvien" class="tbl-nvien-not-qly">
        <legend><h2>CHỈNH SỬA NHÂN VIÊN</h2></legend>
        <button class="btn" onclick="showPage('qly-nhan-vien',[],[]); return false;">Quay lại</button>
        <hr>
        <form method="post">
          <table>
            <tr>
              <td><strong>MANV</strong></td>
              <td><input type="text" name="manv" id="manv" value="" readonly /></td>
            </tr>
            <tr>
              <td><strong>HỌ TÊN</strong></td>
              <td><input type="text" name="hoten" id="hoten" placeholder="Nhập họ tên nhân viên..." required /></td>
            </tr>
            <tr>
              <td><strong>NGÀY SINH</strong></td>
              <td><input type="date" name="namsinh" id="namsinh" value="<?php echo date('Y-m-d', time());?>" placeholder="Nhập họ tên nhân viên..." /></td>
            </tr>
            <tr>
              <td><strong>GIỚI TÍNH</strong></td>
              <td>
                Nam <input type="radio" name="gioitinh" id="nam" value="Nam" checked/>
                Nữ <input type="radio" name="gioitinh" id="nu" value="Nu" />
              </td>
            </tr>
            <tr>
              <td><strong>CHỨC VỤ</strong></td>
              <td>
                <select name="chucvu" id="chucvu">
                  <?php
                  $sql_select_cv = "SELECT * FROM loc_thuc_chucvu";
                  $result_select_cv = mysql_query($sql_select_cv);
                  while ($row_cvu = mysql_fetch_array($result_select_cv)) {
                    echo '<option value="'.$row_cvu['macv'].'">'.$row_cvu['chucvu'].'</option>';
                  }
                  ?>
                </select>
              </td>
            </tr>
            <tr>
              <td><strong>ĐƠN VỊ</strong></td>
              <td>
                <select name="donvi" id="donvi">
                  <?php
                  $sql_select_dv = "SELECT * FROM loc_thuc_donvi";
                  $result_select_dv = mysql_query($sql_select_dv);
                  while ($row_dvi = mysql_fetch_array($result_select_dv)) {
                    echo '<option value="'.$row_dvi['madv'].'">'.$row_dvi['donvi'].'</option>';
                  }
                  ?>
                </select>
              </td>
            </tr>
            <tr>
              <td><strong>LƯƠNG</strong></td>
              <td><input type="number" min="1000" name="luong" id="luong" placeholder="Nhập lương nhân viên..." required /> (nghìn đồng)</td>
            </tr>
          </table>
          <hr>
          <button type="submit" class="btn btn-primary" name="sua-nvien">Lưu thay đổi</button>
        </form>
      </fieldset>
      <fieldset id="chinh-sua-hinhanh-nvien">
        <legend><h2>CHỈNH SỬA HÌNH ẢNH NHÂN VIÊN</h2></legend>
        <button class="btn" onclick="showPage('qly-nhan-vien',[],[]); return false;">Quay lại</button>
        <hr>
        <form method="post" enctype="multipart/form-data">
          <p>Thay đổi hình ảnh cho nhân viên:
            <input type="hidden" name="manv" id="manv_ha" value="" />
            <input type="text" id="hoten_ha" value="" disabled />
          </p>
          <input type="file" name="img_nv" style="margin-bottom: 10px;" /><br>
          <button type="submit" class="btn btn-primary" name="upload_img_nv">Cập nhật</button>
        </form>
      </fieldset>
      <fieldset id="qly-don-vi" class="qly-don-vi">
        <legend><h2>PHÒNG BAN/ĐƠN VỊ</h2></legend>
        <center>
          <div>
            <form method="post">
              <label>Thêm đơn vị</label>
              <input type="text" name="madv" value="<?php
              // Tự động sinh mã đơn vị
              $return_madv_end = mysql_fetch_array(mysql_query("SELECT madv FROM loc_thuc_donvi ORDER BY madv DESC "));
              $madv_next = $return_madv_end[0] + 1;
              if (($madv_next >= 1000) && ($madv_next >= 100)) {
                  echo $madv_next;
              } else if ($madv_next >= 10) {
                  echo '0'.$madv_next;
              } else if ($madv_next >= 1) {
                  echo '00'.$madv_next;
              }
              ?>" placeholder="Nhập mã đơn vị" required />
              <input type="text" name="dvi" placeholder="Nhập tên đơn vị" required />
              <button type="submit" class="btn btn-primary" name="add_dvi">Thêm</button>
            </form>
            <hr>
            <table>
              <thead>
                <tr>
                  <th>MADV</th>
                  <th>ĐƠN VỊ</th>
                </tr>
              </thead>
              <tbody>
                <?php
                  $sql_qry_list_nvien = "SELECT * FROM loc_thuc_donvi"; // Ltweb
                  $qry_list_nvien = mysql_query($sql_qry_list_nvien);
                  while ($row_list_nvien = mysql_fetch_array($qry_list_nvien)) {
                    echo "<tr>";
                    echo "<td>{$row_list_nvien['madv']}</td>";
                    echo "<td>{$row_list_nvien['donvi']}</td>";
                    echo "</tr>";
                  }
                ?>
              </tbody>
            </table>
          </div>
        </center>
      </fieldset>
      <fieldset id="qly-chuc-vu" class="qly-chuc-vu">
        <legend><h2>CHỨC VỤ</h2></legend>
        <center>
          <div>
            <form method="post">
              <label>Thêm chức vụ</label>
              <input type="text" name="macv" value="<?php
              // Tự động sinh mã chức vụ
              $return_macv_end = mysql_fetch_array(mysql_query("SELECT macv FROM loc_thuc_chucvu ORDER BY macv DESC "));
              $macv_next = $return_macv_end[0] + 1;
              if (($macv_next >= 1000) && ($macv_next >= 100)) {
                  echo $macv_next;
              } else if ($macv_next >= 10) {
                  echo '0'.$macv_next;
              } else if ($macv_next >= 1) {
                  echo '00'.$macv_next;
              }
              ?>" placeholder="Nhập mã chức vụ" required />
              <input type="text" name="cvu" placeholder="Nhập tên chức vụ" required />
              <button type="submit" class="btn btn-primary" name="add_cvu">Thêm</button>
            </form>
            <hr>
            <table>
              <thead>
                <tr>
                  <th>MACV</th>
                  <th>CHỨC VỤ</th>
                </tr>
              </thead>
              <tbody>
                <?php
                  $sql_qry_list_nvien = "SELECT * FROM loc_thuc_chucvu"; // Ltweb
                  $qry_list_nvien = mysql_query($sql_qry_list_nvien);
                  while ($row_list_nvien = mysql_fetch_array($qry_list_nvien)) {
                    echo '<tr>';
                    echo "<td>{$row_list_nvien['macv']}</td>";
                    echo "<td>{$row_list_nvien['chucvu']}</td>";
                    echo "</tr>";
                  }
                ?>
              </tbody>
            </table>
          </div>
        </center>
      </fieldset>
    </div>
    <footer>
      <h3 class="full-screen">VĂN LỘC B1400703 - NGUYÊN THỨC B1400731  | CT428 - LẬP TRÌNH WEB | PGS.TS ĐỖ THANH NGHỊ</h3>
      <h4 class="mobile-screen">Copyright @ 2018 <br> Nhóm Văn Lộc - Nguyên Thức</h4>
    </footer>
  </body>
</html>

<?php
// Thuchanh_3: HTML, PHP, MySQL
// // Thêm đơn vị
if(isset($_POST['add_dvi'])) {
  $sql_insert_cvu = "INSERT INTO loc_thuc_donvi VALUES ('{$_POST['madv']}', '{$_POST['dvi']}')"; // Ltweb
  $qry_insert_cvu = mysql_query($sql_insert_cvu);

  if ($qry_insert_cvu) echo "<script>alert('Thêm mới thành công!')</script>";
  else echo "<script>alert('Thêm mới thất bại!')</script>";

  echo '<meta http-equiv="refresh" content="0">';
}

// // Thêm chức vụ
if(isset($_POST['add_cvu'])) {
  $sql_insert_cvu = "INSERT INTO loc_thuc_chucvu VALUES ('{$_POST['macv']}', '{$_POST['cvu']}')"; // Ltweb
  $qry_insert_cvu = mysql_query($sql_insert_cvu);

  if ($qry_insert_cvu) echo "<script>alert('Thêm mới thành công!')</script>";
  else echo "<script>alert('Thêm mới thất bại!')</script>";

  echo '<meta http-equiv="refresh" content="0">';
}

// Thuchanh_4: HTML, PHP, MySQL
// // Thêm nhân viên
if(isset($_POST['them-nvien'])) {
  // Upload ảnh
  if ($_FILES["img_nv"]["error"] > 0) {
      echo "Error: " . $_FILES["img_nv"]["error"] . "<br />";
  } else if (($_FILES["img_nv"]["size"] / 1024) <= 2048) { // Giới hạn kích thước nhỏ hơn 2MB
      // Tên file ảnh
      $img_tmp = addslashes(file_get_contents($_FILES['img_nv']['tmp_name']));
  }
  $sql_insert_nvien = "INSERT INTO loc_thuc_nhanvien VALUES ('{$_POST['manv']}', '{$img_tmp}', '{$_POST['hoten']}', '{$_POST['namsinh']}', '{$_POST['gioitinh']}', '{$_POST['donvi']}', '{$_POST['chucvu']}', '{$_POST['luong']}')"; // Ltweb
  $qry_insert_nvien = mysql_query($sql_insert_nvien);

  if ($qry_insert_nvien) echo "<script>
  sessionStorage.setItem('page', 'qly-nhan-vien');
  alert('Thêm mới thành công!');</script>";
  else echo "<script>alert('Thêm mới thất bại!')</script>";

  echo '<meta http-equiv="refresh" content="0">';
}

// // Thêm ảnh nhân viên
if(isset($_POST['upload_img_nv'])) {
  $manv = $_POST['manv'];

  // Upload ảnh
  if ($_FILES["img_nv"]["error"] > 0) {
      echo "Error: " . $_FILES["img_nv"]["error"] . "<br />";
  } else if (($_FILES["img_nv"]["size"] / 1024) <= 2048) { // Giới hạn kích thước nhỏ hơn 2MB
      // Tên file ảnh
      $img_tmp = addslashes(file_get_contents($_FILES['img_nv']['tmp_name']));

      // // Chèn nội dung file ảnh vào table loc_thuc_nhanvien
      $sql_upload_img_nvien = "UPDATE loc_thuc_nhanvien SET hinhanh = '{$img_tmp}' WHERE manv = '{$manv}'";
      $qry_upload_img_nvien = mysql_query($sql_upload_img_nvien);

      if ($qry_upload_img_nvien) echo "<script>
      sessionStorage.setItem('page', 'qly-nhan-vien');
      alert('Thao tác thành công!');</script>";
      else echo "<script>
      sessionStorage.setItem('page', 'qly-nhan-vien');
      alert('Thao tác thất bại!')</script>";
  }
  else {
      echo "<script>sessionStorage.setItem('page', 'qly-nhan-vien');
      alert('Thao tác thất bại!')</script>";
  }

  echo '<meta http-equiv="refresh" content="0">';
}

// Thuchanh_5: HTML, PHP, MySQL
// // Cập nhật thông tin nhân viên
if(isset($_POST['sua-nvien'])) {
  $sql_update_nvien = "UPDATE loc_thuc_nhanvien SET hoten = '".$_POST['hoten']."', namsinh = '".$_POST['namsinh']."', gioitinh = '".$_POST['gioitinh']."', madv = '".$_POST['donvi']."', macv = '".$_POST['chucvu']."', luong = ".$_POST['luong']." WHERE manv = '".$_POST['manv']."'"; // Ltweb
  $qry_update_nvien = mysql_query($sql_update_nvien);

  if ($qry_update_nvien) echo "<script>
  sessionStorage.setItem('page', 'qly-nhan-vien');
  alert('Chỉnh sửa thành công!');</script>";
  else echo "<script>alert('Chỉnh sửa thất bại!')</script>";

  echo '<meta http-equiv="refresh" content="0">';
}

// // Xóa nhân viên
if(isset($_POST['delete-nvien'])) {
  $sql_del_once_nvien = "DELETE FROM loc_thuc_nhanvien WHERE manv='{$_POST['delete-nvien']}'"; // Ltweb
  $qry_del_once_nvien = mysql_query($sql_del_once_nvien);

  if ($qry_del_once_nvien) echo "<script>
  sessionStorage.setItem('page', 'qly-nhan-vien');
  alert('Xóa thành công!');</script>";
  else echo "<script>alert('Xóa thất bại!')</script>";

  echo '<meta http-equiv="refresh" content="0">';
}

if(isset($_POST['delete-nhieu-nvien'])) {
  foreach ($_POST['manv'] as $key => $manv) {
    $sql_del_many_nvien = "DELETE FROM loc_thuc_nhanvien WHERE manv='{$manv}'"; // Ltweb
    $qry_del_many_nvien = mysql_query($sql_del_many_nvien);
  }

  if ($qry_del_many_nvien) echo "<script>
  sessionStorage.setItem('page', 'qly-nhan-vien');
  alert('Xóa thành công!');</script>";
  else echo "<script>alert('Xóa thất bại!')</script>";

  echo '<meta http-equiv="refresh" content="0">';
}

// Thuchanh_6: Hoàn chỉnh giao diện

?>
