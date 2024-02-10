<?php
include_once './DB.class.php';
class EnrolmentController {
    
    final const STATUS = ['not started', 'in progress', 'completed'];

    static function generate_enrolments()
    {
        require_once './user.class.php';
        $users = (new UserController())->get_all();
        if (!$users) return;
        $user_ids = array_map(function ($user) {
            return $user->ID;
        }, $users);

        require_once './course.class.php';
        $courses = (new CourseController())->get_all();
        if (!$courses) return;
        $course_ids = array_map(function ($course) {
            return $course->ID;
        }, $courses);

        $sql = "insert into enrolments (userId, courseID, status) values";
        $values = [];

        for ($i = 0; $i < 100; $i += 1) {
            $random_user_id = array_rand($user_ids);
            $random_course_id = array_rand($course_ids);

            $random_status = array_rand(self::STATUS);

            $sql .= " (:user_$i, :course_$i, :status_$i),";
            $values += [":user_$i" => $user_ids[$random_user_id], ":course_$i" => $course_ids[$random_course_id], ":status_$i" => self::STATUS[$random_status]];
        }

        $stmt = DB::getInstance()->prepare(substr($sql, 0, strlen($sql) - 1));
        try {
            $stmt->execute($values);
        } catch (PDOException $e) {
            print_r($values);
        }
    }

    static function extract_condition()
    {

        $condition = "";
        $condition_values = array();
        if (isset($_GET['course'])) {
            $course_filter = $_GET['course'];
            if ($condition != '') $condition .= ' AND ';
            $condition .= "courseID=:course";
            $condition_values["course"] = intval($course_filter);
        }
        if (isset($_GET['user'])) {
            $user_filter = $_GET['user'];
            if ($condition != '') $condition .= ' AND ';
            $condition .= "userID=:user";
            $condition_values["user"] = intval($user_filter);
        }
        if (isset($_GET['search'])) {
            $search = $_GET['search'];
            if ($condition != '') $condition .= ' AND ';
            $search_array = [];
            foreach (['firstname', 'surname', 'title', 'description'] as $index => $column) {
                $search_array[] = "$column LIKE :search_$index";
                $condition_values[":search_$index"] = "%$search%";
            }
            $condition .= '(' . implode(' OR ', $search_array) . ')';
        }

        if ($condition != '') $condition = 'WHERE ' . $condition;
        return [$condition, $condition_values];
    }

    static function get_record()
    {

        $page = intval($_GET['page'] ?? '0');
        $offset_unit = 20; // 20 rows each page

        [$condition, $condition_values] = self::extract_condition();

        $sql = "SELECT e.ID, firstname, surname, title, description, status
                    FROM Enrolments e 
                    JOIN Users u ON e.userID = u.ID
                    JOIN Courses c ON e.courseID = c.ID
                    $condition
                    ORDER BY e.ID
                    LIMIT :rows
                    OFFSET :offset";

        $stmt = DB::getInstance()->prepare($sql);
        $stmt->execute([
            ':rows' => $offset_unit,
            ':offset' => $offset_unit * $page
        ] + $condition_values);
        return $stmt->fetchAll();
    }

    static function get_record_counts()
    {
        [$condition, $condition_values] = self::extract_condition();
        $sql = "SELECT COUNT(*) as count                     
        FROM Enrolments e 
        JOIN Users u ON e.userID = u.ID
        JOIN Courses c ON e.courseID = c.ID 
        $condition";
        $stmt = DB::getInstance()->prepare($sql);
        $stmt->execute($condition_values);
        return $stmt->fetch();
    }

}