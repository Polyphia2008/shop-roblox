<?php
/**
 * ==================================================================
 *  core/DB.php  -  ĐÃ SỬA LỖI
 * ------------------------------------------------------------------
 *  CÁC LỖI CỦA BẢN GỐC ĐÃ ĐƯỢC KHẮC PHỤC:
 *
 *  1. $dotenv->load() -> ném Exception làm chết site nếu thiếu .env.
 *     Nay dùng safeLoad() + bọc try/catch + có giá trị mặc định.
 *
 *  2. Từ PHP 8.1 trở lên, mysqli MẶC ĐỊNH ném Exception khi lỗi.
 *     Cú pháp "mysqli_connect(...) or die(...)" KHÔNG còn tác dụng,
 *     dẫn tới "Uncaught mysqli_sql_exception" -> lỗi 500 / trắng trang.
 *     Nay tắt chế độ báo lỗi exception và kiểm tra thủ công.
 *
 *  3. session_start() gọi vô điều kiện -> Warning "session already
 *     started" hoặc "headers already sent". Nay kiểm tra trước.
 *
 *  4. "set names 'utf8'" -> không hiển thị đúng emoji/tiếng Việt mở rộng.
 *     Nay dùng mysqli_set_charset(..., 'utf8mb4').
 *
 *  5. site() / getUser() gọi ->fetch_array() trực tiếp trên kết quả
 *     query. Nếu query lỗi, query() trả về false -> Fatal error
 *     "Call to a member function on bool". Nay kiểm tra null-safe.
 *
 *  6. update_quantity() THIẾU DẤU CÁCH: 'WHERE'.$where sinh ra SQL
 *     sai kiểu "WHERE`id`=1" -> câu lệnh luôn thất bại.
 *
 *  7. get_list/get_row/num_rows gọi die('Câu truy vấn bị sai') làm
 *     chết cả trang. Nay trả về giá trị rỗng để trang vẫn hiển thị.
 *
 *  8. Bổ sung hàm escape() để helpers.php dùng cho check_string().
 * ==================================================================
 */

include_once(__DIR__ . '/../vendor/autoload.php');

/* Nạp .env một cách an toàn: thiếu file cũng không làm sập site */
try {
    if (class_exists('Dotenv\Dotenv')) {
        $dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/../');
        $dotenv->safeLoad();
    }
} catch (Throwable $e) {
    /* Bỏ qua - sẽ dùng giá trị mặc định bên dưới */
}

/* Giá trị mặc định, tránh "Undefined array key" trên PHP 8 */
$_ENV['DB_HOST']     = $_ENV['DB_HOST']     ?? (getenv('DB_HOST')     ?: 'localhost');
$_ENV['DB_DATABASE'] = $_ENV['DB_DATABASE'] ?? (getenv('DB_DATABASE') ?: '');
$_ENV['DB_USERNAME'] = $_ENV['DB_USERNAME'] ?? (getenv('DB_USERNAME') ?: '');
$_ENV['DB_PASSWORD'] = $_ENV['DB_PASSWORD'] ?? (getenv('DB_PASSWORD') ?: '');

/* Chỉ khởi tạo session khi chưa có, và khi header chưa được gửi */
if (session_status() === PHP_SESSION_NONE && !headers_sent()) {
    session_start();
}

date_default_timezone_set('Asia/Ho_Chi_Minh');

class DB
{
    private $ketnoi;

    function connect()
    {
        if (!$this->ketnoi) {
            /* PHP >= 8.1: tắt chế độ ném exception để "or die" hoạt động */
            if (function_exists('mysqli_report')) {
                mysqli_report(MYSQLI_REPORT_OFF);
            }

            $this->ketnoi = @mysqli_connect(
                $_ENV['DB_HOST'],
                $_ENV['DB_USERNAME'],
                $_ENV['DB_PASSWORD'],
                $_ENV['DB_DATABASE']
            );

            if (!$this->ketnoi) {
                die('BẢO TRÌ HỆ THỐNG');
            }

            /* utf8mb4 để hiển thị đúng tiếng Việt + emoji */
            @mysqli_set_charset($this->ketnoi, 'utf8mb4');
        }
    }

    function dis_connect()
    {
        if ($this->ketnoi) {
            mysqli_close($this->ketnoi);
            $this->ketnoi = null;
        }
    }

    /** BỔ SUNG: escape chuỗi an toàn, dùng bởi helpers.php::check_string() */
    function escape($value)
    {
        $this->connect();
        return mysqli_real_escape_string($this->ketnoi, (string) $value);
    }

    function getUser($email)
    {
        $this->connect();
        $result = @mysqli_query($this->ketnoi, "SELECT * FROM `users` WHERE `email` = '" . $this->escape($email) . "' ");
        if (!$result) {
            return false;
        }
        $row = mysqli_fetch_assoc($result);
        mysqli_free_result($result);
        return $row ? $row : false;
    }

    function site($data)
    {
        $this->connect();
        $result = @mysqli_query($this->ketnoi, "SELECT * FROM `settings` WHERE `name` = '" . $this->escape($data) . "' ");
        if (!$result) {
            return '';
        }
        $row = mysqli_fetch_assoc($result);
        mysqli_free_result($result);
        return (is_array($row) && isset($row['value'])) ? $row['value'] : '';
    }

    function query($sql)
    {
        $this->connect();
        return @mysqli_query($this->ketnoi, $sql);
    }

    function cong($table, $data, $sotien, $where)
    {
        $this->connect();
        return @mysqli_query($this->ketnoi, "UPDATE `$table` SET `$data` = `$data` + '$sotien' WHERE $where ");
    }

    function tru($table, $data, $sotien, $where)
    {
        $this->connect();
        return @mysqli_query($this->ketnoi, "UPDATE `$table` SET `$data` = `$data` - '$sotien' WHERE $where ");
    }

    function insert($table, $data)
    {
        $this->connect();
        $field_list = '';
        $value_list = '';
        foreach ($data as $key => $value) {
            $field_list .= ",$key";
            $value_list .= ",'" . mysqli_real_escape_string($this->ketnoi, (string) $value) . "'";
        }
        $sql = 'INSERT INTO ' . $table . '(' . trim($field_list, ',') . ') VALUES (' . trim($value_list, ',') . ')';
        return @mysqli_query($this->ketnoi, $sql);
    }

    function update($table, $data, $where)
    {
        $this->connect();
        $sql = '';
        foreach ($data as $key => $value) {
            $sql .= "$key = '" . mysqli_real_escape_string($this->ketnoi, (string) $value) . "',";
        }
        $sql = 'UPDATE ' . $table . ' SET ' . trim($sql, ',') . ' WHERE ' . $where;
        return @mysqli_query($this->ketnoi, $sql);
    }

    function update_quantity($table, $where)
    {
        $this->connect();
        /* SỬA LỖI: bản gốc thiếu dấu cách -> "WHERE`id`=1" (SQL sai) */
        $sql = 'UPDATE ' . $table . ' SET `soluong`=`soluong`-1 WHERE ' . $where;
        return @mysqli_query($this->ketnoi, $sql);
    }

    function update_value($table, $data, $where, $value1)
    {
        $this->connect();
        $sql = '';
        foreach ($data as $key => $value) {
            $sql .= "$key = '" . mysqli_real_escape_string($this->ketnoi, (string) $value) . "',";
        }
        $sql = 'UPDATE ' . $table . ' SET ' . trim($sql, ',') . ' WHERE ' . $where . ' LIMIT ' . $value1;
        return @mysqli_query($this->ketnoi, $sql);
    }

    function remove($table, $where)
    {
        $this->connect();
        return @mysqli_query($this->ketnoi, "DELETE FROM $table WHERE $where");
    }

    function remove_favorite($table, $where, $where1)
    {
        $this->connect();
        return @mysqli_query($this->ketnoi, "DELETE FROM $table WHERE $where and $where1");
    }

    function get_list($sql)
    {
        $this->connect();
        $result = @mysqli_query($this->ketnoi, $sql);
        if (!$result) {
            /* SỬA LỖI: bản gốc die() làm chết cả trang */
            return array();
        }
        $return = array();
        while ($row = mysqli_fetch_assoc($result)) {
            $return[] = $row;
        }
        mysqli_free_result($result);
        return $return;
    }

    function get_row($sql)
    {
        $this->connect();
        $result = @mysqli_query($this->ketnoi, $sql);
        if (!$result) {
            return false;
        }
        $row = mysqli_fetch_assoc($result);
        mysqli_free_result($result);
        return $row ? $row : false;
    }

    function num_rows($sql)
    {
        $this->connect();
        $result = @mysqli_query($this->ketnoi, $sql);
        if (!$result) {
            return false;
        }
        $row = mysqli_num_rows($result);
        mysqli_free_result($result);
        return $row ? $row : false;
    }
}
